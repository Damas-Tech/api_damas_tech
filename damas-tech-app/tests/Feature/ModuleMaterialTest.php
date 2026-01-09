<?php

namespace Tests\Feature;

use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModuleMaterialTest extends TestCase
{
    use RefreshDatabase;

    public function test_allows_company_to_create_module_material()
    {
        /** @var \App\Models\User $companyUser */
        $companyUser = User::factory()->create([
            'role' => 'company',
        ]);

        $module = Module::factory()->create();

        $response = $this->actingAs($companyUser, 'sanctum')
            ->postJson("/api/auth/modules/{$module->id}/materials", [
                'module_id' => $module->id,
                'title' => 'Material Teste',
                'type' => 'pdf',
            ]);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'module_id',
                'title',
                'type',
            ],
        ]);
    }

    public function test_prevents_regular_user_from_creating_module_material()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $module = Module::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson("/api/auth/modules/{$module->id}/materials", [
                'module_id' => $module->id,
                'title' => 'Material Teste',
                'type' => 'pdf',
            ]);

        $response->assertForbidden();
    }
}
