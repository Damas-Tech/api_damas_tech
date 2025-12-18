<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('registra um usuário e retorna resource padronizado', function () {
    /** @var \Tests\TestCase $this */
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

    expect(User::where('email', 'teste@example.com')->exists())->toBeTrue();
});

it('faz login com credenciais válidas', function () {
    /** @var \Tests\TestCase $this */
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
            'id',
            'name',
            'email',
        ],
        'message',
        'token',
    ]);
});
