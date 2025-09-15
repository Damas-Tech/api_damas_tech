<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseProgressService;
use App\Models\UserCourseProgress;
use App\Models\UserModuleProgress;

class CourseProgressController extends Controller
{
    protected $service;

    public function __construct(CourseProgressService $service)
    {
        $this->service = $service;
        $this->middleware('auth:sanctum');
    }

    public function startCourse(Request $request, $courseId)
    {
        $this->authorize('startCourse', [UserCourseProgress::class, $courseId]);

        $progress = $this->service->startCourse($request->user()->id, $courseId);
        return response()->json($progress);
    }

    public function completeModule(Request $request, $moduleId)
    {
        $moduleProgress = $this->service->completeModule($request->user()->id, $moduleId);

        $this->authorize('updateModule', $moduleProgress);

        return response()->json($moduleProgress);
    }

    public function viewCourseProgress(Request $request, $courseId)
    {
        $progress = UserCourseProgress::where('users_id', $request->user()->id)
            ->where('course_id', $courseId)
            ->firstOrFail();

        $this->authorize('view', $progress);

        return response()->json($progress);
    }
}
