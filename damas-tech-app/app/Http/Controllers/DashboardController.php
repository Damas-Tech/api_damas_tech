<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Services\StatsService;
use App\Services\UserProgressService;

class DashboardController extends Controller
{
    protected $progressService;
    protected $statsService;

    public function __construct(UserProgressService $progressService, StatsService $statsService)
    {
        $this->progressService = $progressService;
        $this->statsService = $statsService;
        $this->middleware('auth:sanctum');
    }

    public function companyDashboard()
    {
        $user = auth()->user();

        $companyId = $user->company?->id;

        if (! $companyId) {
            $courses = Course::count();
            $users = User::count();
            return response()->json([
                'global_stats' => [
                    'total_courses' => $courses,
                    'total_users' => $users,
                ],
            ]);
        }

        $stats = $this->statsService->getCompanyStats($companyId);

        return response()->json([
            'stats' => $stats,
        ]);
    }

    public function userDashboard()
    {
        $user = auth()->user();
        $courses = Course::with('modules.materials', 'modules.videos')->get();

        $courseProgress = $courses->map(function ($course) {
            return [
                'course_id' => $course->id,
                'title' => $course->title,
                'progress_percentage' => $this->progressService->getProgressForCourse($course),
                'status' => 'active',
            ];
        });

        $userStats = $this->statsService->getUserStats($user->id);

        return response()->json([
            'overview' => $userStats,
            'my_courses' => $courseProgress,
        ]);
    }
}
