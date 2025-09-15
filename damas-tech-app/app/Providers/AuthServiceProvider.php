<?php

namespace App\Providers;

use App\Models\UserCourseProgress;
use App\Policies\CoursePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        UserCourseProgress::class => CoursePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
