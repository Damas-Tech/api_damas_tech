<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Services\UserProgressService;

class DashboardController extends Controller
{
    protected $progressService;

    public function __construct(UserProgressService $progressService)
    {
        $this->progressService = $progressService;
        $this->middleware('auth:sanctum');
    }

    // 📊 Dashboard da empresa/admin
    public function companyDashboard()
    {
        $courses = Course::with('modules.materials', 'modules.videos')->get();
        $users = User::count();

        return response()->json([
            'total_courses' => $courses->count(),
            'total_users' => $users,
        ]);
    }

    // 📊 Dashboard do usuário (progresso em cada curso)
    public function userDashboard()
    {
        $courses = Course::with('modules.materials', 'modules.videos')->get();

        $progress = $courses->map(function ($course) {
            return [
                'course' => $course->title,
                'progress' => $this->progressService->getProgressForCourse($course),
            ];
        });

        return response()->json($progress);
    }
}
