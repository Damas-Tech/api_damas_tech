<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CodeExecutionController;
use App\Http\Controllers\CodeChallengeController;
use App\Http\Controllers\CourseProgressController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobOpportunityController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\ModuleMaterialController;
use App\Http\Controllers\UserController;
use App\Models\ModuleMaterial;

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
});

Route::get('/docs/openapi', function () {
    $path = base_path('docs/openapi.yaml');

    abort_unless(file_exists($path), 404);

    return response()->file($path, [
        'Content-Type' => 'application/x-yaml',
    ]);
});

Route::middleware('throttle:6,1')->prefix('auth')->group(function () {
    Route::post('/register/user', [AuthController::class, 'registerUser']);
    Route::post('/register/company', [AuthController::class, 'registerCompany']);
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail']);
    Route::post('/support', [SupportController::class, 'store']);
    Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle']);
    Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
    Route::middleware(['auth:sanctum', 'role:company'])->group(function () {
        Route::get('/company/jobs', [JobOpportunityController::class, 'index']);
        Route::post('/company/jobs', [JobOpportunityController::class, 'store']);
        Route::get('/company/jobs/{jobId}/matches', [MatchController::class, 'jobCandidates']);

        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{user}', [UserController::class, 'show']);
    });

    Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
        Route::post('/courses/{courseId}/start', [CourseProgressController::class, 'startCourse']);
        Route::post('/modules/{moduleId}/complete', [CourseProgressController::class, 'completeModule']);
        Route::get('/courses/{courseId}/progress', [CourseProgressController::class, 'viewCourseProgress']);
        Route::get('/courses/{courseId}/certificate/download', [CertificateController::class, 'downloadCourseCertificate']);
    });

    Route::middleware(['auth:sanctum', 'role:company'])->get('/dashboard/company', [DashboardController::class, 'companyDashboard']);
    Route::middleware(['auth:sanctum', 'role:user'])->get('/dashboard/user', [DashboardController::class, 'userDashboard']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/companies', [CompanyController::class, 'index']);
        Route::get('/companies/{company}', [CompanyController::class, 'show']);

        Route::match(['put', 'patch'], '/users/{user}', [UserController::class, 'update']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);

        Route::match(['put', 'patch'], '/companies/{company}', [CompanyController::class, 'update']);
        Route::delete('/companies/{company}', [CompanyController::class, 'destroy']);
    });

    Route::middleware(['auth:sanctum', 'role:user'])->get('/user/matches/jobs', [MatchController::class, 'userJobs']);

    Route::middleware(['auth:sanctum', 'role:user'])->post('/progress/{type}/{id}/complete', function ($type, $id, \App\Services\UserProgressService $service) {
        $class = $type === 'video' ? \App\Models\ModuleVideo::class : ModuleMaterial::class;
        $progressable = $class::findOrFail($id);
        $progress = $service->markAsCompleted($progressable);

        return response()->json($progress);
    });

    Route::prefix('modules/{moduleId}/materials')->group(function () {
        Route::middleware('auth:sanctum')->get('/', [ModuleMaterialController::class, 'index']);
        Route::middleware(['auth:sanctum', 'role:company'])->post('/', [ModuleMaterialController::class, 'store']);
        Route::middleware(['auth:sanctum', 'role:company'])->delete('/{id}', [ModuleMaterialController::class, 'destroy']);
    });
    // Community / Forum
    Route::prefix('community')->group(function () {
        Route::get('/threads', [CommunityController::class, 'index']);
        Route::post('/threads', [CommunityController::class, 'store']);
        Route::get('/threads/{id}', [CommunityController::class, 'show']);
        Route::post('/threads/{id}/reply', [CommunityController::class, 'reply']);
    });

    // Projects
    Route::post('/projects/{materialId}/submit', [ProjectController::class, 'submit']);
    Route::get('/my-projects', [ProjectController::class, 'index']);
    Route::get('/projects/certificate/{submissionId}', [CertificateController::class, 'downloadProjectCertificate']);

    // Code Runner / Playground (Rate Limited)
    Route::middleware('throttle:10,1')->prefix('code')->group(function () {
        Route::get('/runtimes', [CodeExecutionController::class, 'runtimes']);
        Route::post('/execute', [CodeExecutionController::class, 'execute']);
    });

    // Code Challenges
    Route::get('/challenges', [CodeChallengeController::class, 'index']);
    Route::get('/challenges/{id}', [CodeChallengeController::class, 'show']);
    Route::post('/challenges/{id}/check', [CodeChallengeController::class, 'check']);
});
