<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseProgressService;
use App\Models\UserCourseProgress;
use App\Models\UserModuleProgress;
use App\Support\ErrorMessages;

class CourseProgressController extends Controller
{
    protected $service;

    public function __construct(CourseProgressService $service)
    {
        $this->service = $service;
    }

    public function startCourse(Request $request, $courseId)
    {
        try {
            $progress = $this->service->startCourse($request->user()->id, $courseId);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => ErrorMessages::get('generic.unexpected_error'),
            ], 500);
        }

        return response()->json($progress);
    }

    public function completeModule(Request $request, $moduleId)
    {
        try {
            $moduleProgress = $this->service->completeModule($request->user()->id, $moduleId);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => ErrorMessages::get('generic.unexpected_error'),
            ], 500);
        }

        return response()->json($moduleProgress);
    }

    public function viewCourseProgress(Request $request, $courseId)
    {
        $progress = UserCourseProgress::where('users_id', $request->user()->id)
            ->where('course_id', $courseId)
            ->first();

        if (! $progress) {
            return response()->json([
                'message' => ErrorMessages::get('course.not_found'),
            ], 404);
        }

        return response()->json($progress);
    }
}
