<?php

namespace Tests\Feature;

use App\Models\Module;
use App\Models\ModuleMaterial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_submit_project()
    {
        $user = User::factory()->create();
        $module = Module::factory()->create();
        $material = ModuleMaterial::factory()->create([
            'module_id' => $module->id,
            'type' => 'project',
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson("/api/auth/projects/{$material->id}/submit", [
                'submission_url' => 'https://github.com/my/project',
            ]);

        $response->assertOk();
        $this->assertDatabaseHas('project_submissions', [
            'user_id' => $user->id,
            'module_material_id' => $material->id,
            'submission_url' => 'https://github.com/my/project',
            'status' => 'pending',
        ]);
    }
}
