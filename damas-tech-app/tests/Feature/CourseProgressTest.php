<?php

use App\Models\User;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function authenticatedUser(): User
{
    $user = User::factory()->create([
        'role' => 'user',
    ]);

    return $user;
}

it('permite iniciar um curso', function () {
    /** @var \Tests\TestCase $this */
    $user = authenticatedUser();
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
});

it('permite marcar módulo como completo', function () {
    /** @var \Tests\TestCase $this */
    $user = authenticatedUser();
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
});
