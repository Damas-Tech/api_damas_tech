<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResourceCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_new_user()
    {
        $admin = User::factory()->create(['role' => 'company']); // Assuming 'company' or admin role

        $response = $this->actingAs($admin)
            ->postJson('/api/auth/users', [
                'name' => 'New User',
                'email' => 'newuser@example.com',
                'password' => 'password123',
                'role' => 'user'
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.email', 'newuser@example.com');

        $this->assertDatabaseHas('users', ['email' => 'newuser@example.com']);
    }

    public function test_authenticated_user_can_create_company_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/auth/companies', [
                'cnpj' => '12.345.678/0001-90',
                'tech_stack' => ['PHP', 'Laravel'],
                'culture_tags' => ['Remote', 'Flexible']
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.cnpj', '12.345.678/0001-90');

        $this->assertDatabaseHas('companies', ['cnpj' => '12.345.678/0001-90', 'users_id' => $user->id]);
    }

    public function test_cannot_create_company_if_already_exists_for_user()
    {
        $user = User::factory()->create();
        Company::create([
            'users_id' => $user->id,
            'cnpj' => '11.111.111/1111-11',
            'tech_stack' => [],
            'culture_tags' => []
        ]);

        $response = $this->actingAs($user)
            ->postJson('/api/auth/companies', [
                'cnpj' => '98.765.432/0001-00',
            ]);

        $response->assertStatus(400)
            ->assertJsonPath('message', 'companies.already_exists');
    }
}
