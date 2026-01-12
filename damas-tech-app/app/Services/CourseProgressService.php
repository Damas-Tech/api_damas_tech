<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\SendCourseCompletedEmail;
use App\Jobs\UpdateTalentPoolStatus;
use App\Models\Module;
use App\Models\UserCourseProgress;
use App\Models\UserModuleProgress;
use Carbon\Carbon;

class CourseProgressService
{
    public function startCourse($userId, $courseId): UserCourseProgress
    {
        return UserCourseProgress::create([
            'users_id' => $userId,
            'course_id' => $courseId,
            'started_at' => Carbon::now(),
        ]);
    }

    public function completeModule($userId, $moduleId): UserModuleProgress
    {
        $progress = UserModuleProgress::updateOrCreate(
            ['users_id' => $userId, 'module_id' => $moduleId],
            ['completed' => true, 'completed_at' => Carbon::now()]
        );

        $module = Module::findOrFail($moduleId);
        $this->handleCourseCompletionSideEffects($userId, $module->course_id);

        return $progress;
    }

    public function isCourseCompleted($userId, $courseId): bool
    {
        $modules = Module::where('course_id', $courseId)->count();
        $completedModules = UserModuleProgress::where('users_id', $userId)
            ->whereHas('module', function ($q) use ($courseId): void {
                $q->where('course_id', $courseId);
            })->where('completed', true)
            ->count();

        return $modules > 0 && $modules === $completedModules;
    }

    protected function handleCourseCompletionSideEffects($userId, $courseId): void
    {
        if (! $this->isCourseCompleted($userId, $courseId)) {
            return;
        }

        $progress = UserCourseProgress::firstOrCreate([
            'users_id' => $userId,
            'course_id' => $courseId,
        ], [
            'started_at' => Carbon::now(),
        ]);

        UpdateTalentPoolStatus::dispatch($progress);
        SendCourseCompletedEmail::dispatch($progress->user, $courseId);
    }
}
