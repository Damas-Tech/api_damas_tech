<?php

namespace App\Services;

use App\Models\UserCourseProgress;
use App\Models\UserModuleProgress;
use App\Models\Module;
use Carbon\Carbon;
use App\Jobs\UpdateTalentPoolStatus;
use App\Jobs\SendCourseCompletedEmail;

class CourseProgressService
{
    /**
     * Inicia um curso para o usuário
     */
    public function startCourse($userId, $courseId): UserCourseProgress
    {
        return UserCourseProgress::create([
            'users_id' => $userId,
            'course_id' => $courseId,
            'started_at' => Carbon::now(),
        ]);
    }

    /**
     * Marca módulo como completo
     */
    public function completeModule($userId, $moduleId): UserModuleProgress
    {
        $progress = UserModuleProgress::updateOrCreate(
            ['users_id' => $userId, 'module_id' => $moduleId],
            ['completed' => true, 'completed_at' => Carbon::now()]
        );

        // Após completar um módulo, verificamos se o curso foi concluído
        $module = Module::findOrFail($moduleId);
        $this->handleCourseCompletionSideEffects($userId, $module->course_id);

        return $progress;
    }

    /**
     * Verifica se curso foi concluído
     */
    public function isCourseCompleted($userId, $courseId): bool
    {
        $modules = Module::where('course_id', $courseId)->count();
        $completedModules = UserModuleProgress::where('users_id', $userId)
            ->whereHas('module', function ($q) use ($courseId) {
                $q->where('course_id', $courseId);
            })->where('completed', true)
            ->count();

        return $modules > 0 && $modules === $completedModules;
    }

    /**
     * Dispara efeitos colaterais quando um curso é concluído
     */
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

        // Atualiza status do Talent Pool e envia e-mail de conclusão
        UpdateTalentPoolStatus::dispatch($progress);
        SendCourseCompletedEmail::dispatch($progress->user, $courseId);
    }
}
