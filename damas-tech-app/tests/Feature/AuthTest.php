<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        \Illuminate\Http\Resources\Json\JsonResource::withoutWrapping();
    }

    protected function tearDown(): void
    {
        \Illuminate\Http\Resources\Json\JsonResource::wrap('data');
        parent::tearDown();
    }

    public function test_registra_um_usuario_e_retorna_resource_padronizado()
    {
        $response = $this->postJson('/api/auth/register/user', [
            'name' => 'Teste',
            'email' => 'teste@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
            ],
            'message',
        ]);

        $this->assertTrue(User::where('email', 'teste@example.com')->exists());
    }

    public function test_faz_login_com_credenciais_validas()
    {
        $user = User::factory()->create([
            'email' => 'login@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'login@example.com',
            'password' => 'password',
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'user' => [
                    'id',
                    'name',
                    'email'
                ],
                'token',
            ],
            'message',
        ]);
    }
}
