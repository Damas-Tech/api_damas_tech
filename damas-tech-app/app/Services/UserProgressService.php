<?php
namespace App\Services;

use App\Models\UserProgress;
use Illuminate\Support\Facades\Auth;

class UserProgressService
{
    public function markAsCompleted($progressable)
    {
        return UserProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'progressable_id' => $progressable->id,
                'progressable_type' => get_class($progressable),
            ],
            ['completed' => true]
        );
    }

    public function getProgressForCourse($course)
    {
        $userId = Auth::id();
        $totalItems = $course->modules->sum(fn($m) => $m->materials->count() + $m->videos->count());

        $completedItems = UserProgress::where('user_id', $userId)
            ->whereIn('progressable_type', ['App\Models\ModuleMaterial', 'App\Models\ModuleVideo'])
            ->where('completed', true)
            ->count();

        return [
            'completed' => $completedItems,
            'total' => $totalItems,
            'percentage' => $totalItems > 0 ? round(($completedItems / $totalItems) * 100, 2) : 0,
        ];
    }
}
