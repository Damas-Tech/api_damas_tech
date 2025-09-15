<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserCourseProgress;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Verifica se o usuário pode visualizar o progresso de um curso
     */
    public function view(User $user, UserCourseProgress $progress)
    {
        return $user->id === $progress->users_id;
    }

    /**
     * Verifica se o usuário pode atualizar um módulo
     */
    public function updateModule(User $user, $moduleProgress)
    {
        return $user->id === $moduleProgress->users_id;
    }

    /**
     * Se necessário, você pode adicionar política para iniciar curso
     */
    public function startCourse(User $user, $courseId)
    {
        // Por exemplo, qualquer usuário pode iniciar cursos
        return $user->isUser() || $user->isCompany();
    }
}

