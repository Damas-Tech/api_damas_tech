<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModuleMaterialController;
use App\Http\Controllers\CourseProgressController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobOpportunityController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;

// Health-check simples para monitoramento / load balancer
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
});

// Documentação OpenAPI (Swagger) em YAML
Route::get('/docs/openapi', function () {
    $path = base_path('docs/openapi.yaml');

    abort_unless(file_exists($path), 404);

    return response()->file($path, [
        'Content-Type' => 'application/x-yaml',
    ]);
});

Route::prefix('auth')->group(function () {
    Route::post('/register/user', [AuthController::class, 'registerUser']);
    Route::post('/register/company', [AuthController::class, 'registerCompany']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
    Route::middleware(['auth:sanctum', 'role:company'])->group(function () {
        // Dashboard da empresa
        // Route::get('/company/dashboard', [CompanyController::class, 'dashboard']);

        // Vagas e match para empresas
        Route::get('/company/jobs', [JobOpportunityController::class, 'index']);
        Route::post('/company/jobs', [JobOpportunityController::class, 'store']);
        Route::get('/company/jobs/{jobId}/matches', [MatchController::class, 'jobCandidates']);

        // Lista de usuárias (candidatas) com filtros por tecnologias e cultura
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{user}', [UserController::class, 'show']);
    });

    Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
        Route::post('/courses/{courseId}/start', [CourseProgressController::class, 'startCourse']);
        Route::post('/modules/{moduleId}/complete', [CourseProgressController::class, 'completeModule']);
        Route::get('/courses/{courseId}/progress', [CourseProgressController::class, 'viewCourseProgress']);
    });

    Route::middleware(['auth:sanctum', 'role:company'])->get('/dashboard/company', [DashboardController::class, 'companyDashboard']);
    Route::middleware(['auth:sanctum', 'role:user'])->get('/dashboard/user', [DashboardController::class, 'userDashboard']);

    // Listagem e detalhes de empresas (para qualquer usuária autenticada)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/companies', [CompanyController::class, 'index']);
        Route::get('/companies/{company}', [CompanyController::class, 'show']);

        // Atualização e exclusão de perfil da própria usuária e empresa
        Route::match(['put', 'patch'], '/users/{user}', [UserController::class, 'update']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);

        Route::match(['put', 'patch'], '/companies/{company}', [CompanyController::class, 'update']);
        Route::delete('/companies/{company}', [CompanyController::class, 'destroy']);
    });

    // Vagas recomendadas para a usuária
    Route::middleware(['auth:sanctum', 'role:user'])->get('/user/matches/jobs', [MatchController::class, 'userJobs']);

    Route::middleware(['auth:sanctum', 'role:user'])->post('/progress/{type}/{id}/complete', function ($type, $id, \App\Services\UserProgressService $service) {
        $class = $type === 'video' ? \App\Models\ModuleVideo::class : \App\Models\ModuleMaterial::class;
        $progressable = $class::findOrFail($id);
        $progress = $service->markAsCompleted($progressable);

        return response()->json($progress);
    });

    // Materiais de módulo: leitura para usuários autenticados, escrita para empresas
    Route::prefix('modules/{moduleId}/materials')->group(function () {
        Route::middleware('auth:sanctum')->get('/', [ModuleMaterialController::class, 'index']);
        Route::middleware(['auth:sanctum', 'role:company'])->post('/', [ModuleMaterialController::class, 'store']);
        Route::middleware(['auth:sanctum', 'role:company'])->delete('/{id}', [ModuleMaterialController::class, 'destroy']);
    });
});
