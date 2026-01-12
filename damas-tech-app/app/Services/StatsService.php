<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\JobOpportunity;
use App\Models\User;
use Carbon\Carbon;

class StatsService
{
    public function getCompanyStats(int $companyId): array
    {
        $totalJobs = JobOpportunity::where('company_id', $companyId)->count();
        $activeJobs = JobOpportunity::where('company_id', $companyId)->where('status', 'open')->count();

        $viewsHistory = $this->getMockViewsHistory();

        $topSkills = $this->getTopSkillsRequested($companyId);

        return [
            'total_jobs' => $totalJobs,
            'active_jobs' => $activeJobs,
            'views_history' => $viewsHistory,
            'top_skills_requested' => $topSkills,
        ];
    }

    public function getUserStats(int $userId): array
    {
        $user = User::with(['courses'])->find($userId);

        $completedCourses = $user->courses()->wherePivotNotNull('completed_at')->count();
        $inProgressCourses = $user->courses()->wherePivotNull('completed_at')->wherePivotNotNull('started_at')->count();

        $weeklyProgress = [
            'Mon' => 45,
            'Tue' => 60,
            'Wed' => 30,
            'Thu' => 0,
            'Fri' => 90,
            'Sat' => 120,
            'Sun' => 15,
        ];

        return [
            'completed_courses' => $completedCourses,
            'in_progress_courses' => $inProgressCourses,
            'weekly_minutes' => $weeklyProgress,
            'total_certificates' => $completedCourses,
        ];
    }

    private function getMockViewsHistory(): array
    {
        $data = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('d/m');
            $data[$date] = rand(5, 50);
        }
        return $data;
    }

    private function getTopSkillsRequested(int $companyId): array
    {
        $jobs = JobOpportunity::where('company_id', $companyId)->get();
        $skillCounts = [];

        foreach ($jobs as $job) {
            $stack = $job->tech_stack ?? [];
            if (is_string($stack)) {
                $stack = json_decode($stack, true) ?? [];
            }

            foreach ($stack as $skill) {
                if (! isset($skillCounts[$skill])) {
                    $skillCounts[$skill] = 0;
                }
                $skillCounts[$skill]++;
            }
        }

        arsort($skillCounts);
        return array_slice($skillCounts, 0, 5);
    }
}
