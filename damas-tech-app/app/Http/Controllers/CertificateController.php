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

            if (! $progressService->isCourseCompleted($user->id, $courseId)) {
                return response()->json([
                    'message' => ErrorMessages::get('course.not_found', 'Certificado disponível apenas após conclusão do curso.'),
                ], 403);
            }

            $course = Course::with('modules')->find($courseId);

            if (! $course) {
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
}
