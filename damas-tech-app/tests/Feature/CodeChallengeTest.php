<?php

namespace Tests\Feature;

use App\Models\CodeChallenge;
use App\Models\Module;
use App\Models\User;
use App\Services\CodeExecutionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class CodeChallengeTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_pode_verificar_desafio_com_sucesso()
    {
        $user = User::factory()->create();
        $module = Module::factory()->create();
        $challenge = CodeChallenge::factory()->create([
            'module_id' => $module->id,
            'expected_output' => 'Hello World',
            'language' => 'python',
        ]);

        // Mock CodeExecutionService
        $this->mock(CodeExecutionService::class, function (MockInterface $mock) {
            $mock->shouldReceive('executeCode')
                ->once()
                ->andReturn([
                    'run' => [
                        'stdout' => 'Hello World',
                        'stderr' => '',
                        'code' => 0,
                    ]
                ]);
        });

        $response = $this->actingAs($user, 'sanctum')
            ->postJson("/api/auth/challenges/{$challenge->id}/check", [
                'code' => "print('Hello World')",
                'language' => 'python',
            ]);

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'passed' => true,
                'status' => 'completed',
                'actual_output' => 'Hello World',
            ]
        ]);

        $this->assertDatabaseHas('user_challenge_progress', [
            'user_id' => $user->id,
            'challenge_id' => $challenge->id,
            'status' => 'completed',
        ]);
    }

    public function test_usuario_falha_no_desafio_se_output_incorreto()
    {
        $user = User::factory()->create();
        $module = Module::factory()->create();
        $challenge = CodeChallenge::factory()->create([
            'module_id' => $module->id,
            'expected_output' => 'Hello World',
        ]);

        // Mock CodeExecutionService
        $this->mock(CodeExecutionService::class, function (MockInterface $mock) {
            $mock->shouldReceive('executeCode')
                ->once()
                ->andReturn([
                    'run' => [
                        'stdout' => 'Wrong Output',
                        'stderr' => '',
                        'code' => 0,
                    ]
                ]);
        });

        $response = $this->actingAs($user, 'sanctum')
            ->postJson("/api/auth/challenges/{$challenge->id}/check", [
                'code' => "print('Wrong Output')",
                'language' => 'python',
            ]);

        $response->assertOk(); // Request is OK, but challenge failed
        $response->assertJson([
            'data' => [
                'passed' => false,
                'status' => 'failed',
                'actual_output' => 'Wrong Output',
            ]
        ]);

        $this->assertDatabaseHas('user_challenge_progress', [
            'user_id' => $user->id,
            'challenge_id' => $challenge->id,
            'status' => 'failed',
        ]);
    }
}
