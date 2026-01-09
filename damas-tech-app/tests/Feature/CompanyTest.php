<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    private function createCompanyWithUser(): array
    {
        $user = User::factory()->create(['role' => 'company']);
        $company = Company::create([
            'users_id' => $user->id,
            'cnpj' => '99999999000199',
            'tech_stack' => ['java'],
            'culture_tags' => ['presencial'],
        ]);
        return [$user, $company];
    }

    public function test_authenticated_user_can_list_companies()
    {
        $user = User::factory()->create();
        Company::create([
            'users_id' => User::factory()->create()->id,
            'cnpj' => '11111111000111',
            'tech_stack' => ['php', 'laravel'],
            'culture_tags' => ['remote'],
        ]);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/auth/companies');

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'data' => [
                    '*' => ['id', 'cnpj', 'tech_stack', 'culture_tags']
                ]
            ]
        ]);
    }

    public function test_company_owner_can_update_company_data()
    {
        [$user, $company] = $this->createCompanyWithUser();

        $response = $this->actingAs($user, 'sanctum')->putJson("/api/auth/companies/{$company->id}", [
            'tech_stack' => ['python', 'django'],
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'tech_stack' => json_encode(['python', 'django']),
        ]);
    }

    public function test_non_owner_cannot_update_company()
    {
        [$owner, $company] = $this->createCompanyWithUser();
        $otherUser = User::factory()->create();

        $response = $this->actingAs($otherUser, 'sanctum')->putJson("/api/auth/companies/{$company->id}", [
            'tech_stack' => ['hacked'],
        ]);

        $response->assertForbidden();
    }
}
