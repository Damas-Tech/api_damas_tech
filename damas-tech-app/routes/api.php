<?php
use App\Http\Controllers\AuthController;

Route::prefix('auth')->group(function () {
    Route::post('/register/user', [AuthController::class, 'registerUser']);
    Route::post('/register/company', [AuthController::class, 'registerCompany']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
    Route::middleware(['auth:sanctum', 'role:company'])->group(function () {
        Route::get('/company/dashboard', [CompanyController::class, 'dashboard']);
    });

    Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
        Route::post('/courses/{courseId}/start', [CourseProgressController::class, 'startCourse']);
        Route::post('/modules/{moduleId}/complete', [CourseProgressController::class, 'completeModule']);
        Route::get('/courses/{courseId}/progress', [CourseProgressController::class, 'viewCourseProgress']);
    });


});
