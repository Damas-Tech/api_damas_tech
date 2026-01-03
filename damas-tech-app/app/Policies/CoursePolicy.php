<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserCourseProgress;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    public function view(User $user, UserCourseProgress $progress)
    {
        return $user->id === $progress->users_id;
    }

    public function updateModule(User $user, $moduleProgress)
    {
        return $user->id === $moduleProgress->users_id;
    }

    public function startCourse(User $user, $courseId)
    {
        return $user->isUser() || $user->isCompany();
    }
}
