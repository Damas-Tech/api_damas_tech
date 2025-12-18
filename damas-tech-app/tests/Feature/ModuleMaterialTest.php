<?php

use App\Models\User;
use App\Models\Module;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('permite empresa criar material de módulo', function () {
    /** @var \Tests\TestCase $this */
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
});

it('impede usuário comum de criar material de módulo', function () {
    /** @var \Tests\TestCase $this */
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
});
