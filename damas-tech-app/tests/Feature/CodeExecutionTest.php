<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\CodeExecutionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class CodeExecutionTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_runtimes()
    {
        $user = User::factory()->create();

        $this->mock(CodeExecutionService::class, function (MockInterface $mock) {
            $mock->shouldReceive('getRuntimes')
                ->once()
                ->andReturn([
                    ['language' => 'python', 'version' => '3.10', 'aliases' => ['py']],
                    ['language' => 'javascript', 'version' => '18.15', 'aliases' => ['js']],
                ]);
        });

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/auth/code/runtimes');

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => ['language', 'version', 'aliases']
            ]
        ]);
    }
}
