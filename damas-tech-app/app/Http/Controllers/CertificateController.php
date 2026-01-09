<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\CourseProgressService;
use App\Support\ErrorMessages;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function downloadCourseCertificate(Request $request, int $courseId, CourseProgressService $progressService)
    {
        try {
            $user = $request->user();

            if (!$progressService->isCourseCompleted($user->id, $courseId)) {
                return response()->json([
                    'message' => ErrorMessages::get('course.certificate_unavailable'),
                ], 403);
            }

            $course = Course::with('modules')->find($courseId);

            if (!$course) {
                return response()->json([
                    'message' => ErrorMessages::get('course.not_found'),
                ], 404);
            }

            $modulesCount = $course->modules->count();

            $data = [
                'user' => $user,
                'courseTitle' => $course->name,
                'description' => $course->description,
                'completedAt' => now()->format('d/m/Y'),
                'hours' => $course->duration ?? '10 horas',
                'modules' => $modulesCount . ' módulo' . ($modulesCount === 1 ? '' : 's'),
                'weeks' => null,
                'certificateCode' => sprintf('DT-%d-%d', $courseId, $user->id),
            ];

            $pdf = Pdf::loadView('certificates.course_certificate', $data)
                ->setPaper('a4', 'landscape');

            $fileName = sprintf('certificado-%s-%s.pdf', $user->id, $courseId);

            return $pdf->download($fileName);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => ErrorMessages::get('generic.unexpected_error'),
            ], 500);
        }
    }
    public function downloadProjectCertificate(Request $request, int $submissionId)
    {
        try {
            $user = $request->user();
            $submission = \App\Models\ProjectSubmission::with('material.module.course')->find($submissionId);

            if (!$submission) {
                return response()->json(['message' => ErrorMessages::get('error.submission_not_found')], 404);
            }

            if ($submission->user_id !== $user->id) {
                return response()->json(['message' => ErrorMessages::get('error.forbidden')], 403);
            }

            if ($submission->status !== 'approved') {
                return response()->json(['message' => ErrorMessages::get('error.submission_not_approved')], 403);
            }

            $data = [
                'user' => $user,
                'projectTitle' => $submission->material->title,
                'courseName' => $submission->material->module->course->name ?? null,
                'completedAt' => $submission->updated_at->format('d/m/Y'),
                'certificateCode' => sprintf('DT-PRJ-%d-%d', $submission->id, $user->id),
            ];

            $pdf = Pdf::loadView('certificates.project_certificate', $data)
                ->setPaper('a4', 'landscape');

            $fileName = sprintf('certificado-projeto-%s-%s.pdf', $user->id, $submission->id);

            return $pdf->download($fileName);
        } catch (\Throwable $e) {
            report($e);
            return response()->json(['message' => ErrorMessages::get('generic.unexpected_error')], 500);
        }
    }
}
