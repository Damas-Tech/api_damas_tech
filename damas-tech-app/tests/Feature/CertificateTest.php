<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use App\Models\Module;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use App\Models\UserModuleProgress;
use App\Services\CourseProgressService;

class CertificateTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_download_certificate_for_completed_course()
    {
        Carbon::setTestNow('2024-01-01');

        $user = User::factory()->create(['role' => 'user']);
        $course = Course::factory()->create(['name' => 'Laravel Mastery']);
        $module = Module::factory()->create(['course_id' => $course->id]); // Course needs modules to calculate count

        // Mark module as completed (Service checks module completion)
        UserModuleProgress::create([
            'users_id' => $user->id,
            'module_id' => $module->id,
            'completed' => true,
            'completed_at' => now(),
        ]);

        // Also course progress just in case, though service ignores it for check
        $user->courses()->attach($course->id, [
            'started_at' => now()->subDays(10),
            'completed_at' => now(),
        ]);

        // Mock PDF
        Pdf::shouldReceive('loadView')
            ->once()
            ->with('certificates.course_certificate', \Mockery::on(function ($data) use ($user, $course) {
                return $data['user']->id === $user->id
                    && $data['courseTitle'] === $course->name;
            }))
            ->andReturnSelf();

        Pdf::shouldReceive('setPaper')
            ->andReturnSelf();

        Pdf::shouldReceive('download')
            ->andReturn(response('fake-pdf-content'));

        $response = $this->actingAs($user, 'sanctum')
            ->get("/api/auth/courses/{$course->id}/certificate/download");

        $response->assertOk();
    }

    public function test_cannot_download_certificate_if_course_incomplete()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        // Not completed (no pivot or no completed_at)
        $user->courses()->attach($course->id, [
            'started_at' => now(),
            'completed_at' => null,
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->get("/api/auth/courses/{$course->id}/certificate/download");

        $response->assertForbidden();
    }
}
