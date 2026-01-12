<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Course;
use App\Models\ModuleMaterial;
use App\Models\ModuleVideo;
use App\Models\UserProgress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserProgressService
{
    public function markAsCompleted(Model $progressable): UserProgress
    {
        return UserProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'progressable_id' => $progressable->id,
                'progressable_type' => $progressable::class,
            ],
            ['completed' => true]
        );
    }

    public function getProgressForCourse(Course $course): array
    {
        $userId = Auth::id();
        $totalItems = $course->modules->sum(fn ($m) => $m->materials->count() + $m->videos->count());

        $completedItems = UserProgress::where('user_id', $userId)
            ->whereIn('progressable_type', [ModuleMaterial::class, ModuleVideo::class])
            ->where('completed', true)
            ->count();

        return [
            'completed' => $completedItems,
            'total' => $totalItems,
            'percentage' => $totalItems > 0 ? round($completedItems / $totalItems * 100, 2) : 0,
        ];
    }
}
