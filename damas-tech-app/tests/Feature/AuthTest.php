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

    public function test_registers_a_user_and_returns_standardized_resource()
    {
        \Illuminate\Support\Facades\Queue::fake();

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
        \Illuminate\Support\Facades\Queue::assertPushed(\App\Jobs\SendWelcomeEmail::class);
    }

    public function test_logs_in_with_valid_credentials()
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

    public function test_cannot_register_with_invalid_data()
    {
        $response = $this->postJson('/api/auth/register/user', [
            'name' => '',
            'email' => 'not-an-email',
            'password' => 'short',
            'password_confirmation' => 'mismatch',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function test_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'login@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'login@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/auth/logout');

        $response->assertOk();
        $this->assertCount(0, $user->tokens);
    }
}
