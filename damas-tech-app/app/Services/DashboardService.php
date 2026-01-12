<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Company;
use App\Models\Course;
use App\Models\Module;
use App\Models\ModuleMaterial;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getStats(): array
    {
        return [
            'users_count' => User::count(),
            'companies_count' => Company::count(),
            'courses_count' => Course::count(),
            'modules_count' => Module::count(),
            'materials_count' => ModuleMaterial::count(),
        ];
    }

    public function getTopCourses(int $limit = 5)
    {
        return DB::table('user_courses')
            ->select('course_id', DB::raw('COUNT(user_id) as total'))
            ->groupBy('course_id')
            ->orderByDesc('total')
            ->limit($limit)
            ->get();
    }

    public function getAverageProgress()
    {
        return DB::table('user_courses')->avg('progress');
    }
}
