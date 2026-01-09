<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseProgressTest extends TestCase
{
    use RefreshDatabase;

    private function authenticatedUser(): User
    {
        return User::factory()->create([
            'role' => 'user',
        ]);
    }

    public function test_allows_starting_a_course()
    {
        $user = $this->authenticatedUser();
        $course = Course::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson("/api/auth/courses/{$course->id}/start");

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'users_id',
            'course_id',
            'started_at',
        ]);
    }

    public function test_allows_marking_module_as_complete()
    {
        $user = $this->authenticatedUser();
        $course = Course::factory()->create();
        $module = Module::factory()->create([
            'course_id' => $course->id,
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson("/api/auth/modules/{$module->id}/complete");

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'users_id',
            'module_id',
            'completed',
            'completed_at',
        ]);
    }
}
