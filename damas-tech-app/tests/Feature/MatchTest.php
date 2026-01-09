<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\JobOpportunity;
use App\Models\TalentPool;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatchTest extends TestCase
{
    use RefreshDatabase;

    private function createCompanyUser(array $userData = []): User
    {
        $user = User::factory()->create(array_merge([
            'role' => 'company',
        ], $userData));

        Company::create([
            'users_id' => $user->id,
            'cnpj' => '12345678000199',
            'tech_stack' => ['php', 'laravel'],
            'culture_tags' => ['diversidade', 'remoto'],
        ]);

        return $user;
    }

    public function test_ranks_candidates_for_job_based_on_tech_stack_and_culture()
    {
        /** @var \App\Models\User $companyUser */
        $companyUser = $this->createCompanyUser();
        $company = $companyUser->company;

        $job = JobOpportunity::create([
            'company_id' => $company->id,
            'title' => 'Desenvolvedora Backend',
            'tech_stack' => ['php', 'laravel', 'mysql'],
            'culture_tags' => ['diversidade', 'remoto'],
            'status' => 'open',
        ]);

        $candidate1 = User::factory()->create([
            'role' => 'user',
            'tech_stack' => ['php', 'laravel', 'mysql'],
            'culture_tags' => ['diversidade', 'remoto'],
        ]);

        $candidate2 = User::factory()->create([
            'role' => 'user',
            'tech_stack' => ['php'],
            'culture_tags' => ['remoto'],
        ]);

        TalentPool::create([
            'users_id' => $candidate1->id,
            'company_id' => $company->id,
            'status' => 'in_training',
        ]);

        TalentPool::create([
            'users_id' => $candidate2->id,
            'company_id' => $company->id,
            'status' => 'in_training',
        ]);

        $response = $this->actingAs($companyUser, 'sanctum')
            ->getJson("/api/auth/company/jobs/{$job->id}/matches");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                ['user_id', 'job_id', 'score', 'skills_matched', 'skills_missing', 'culture_matched', 'culture_missing'],
            ],
        ]);

        $data = $response->json('data');

        $this->assertEquals($candidate1->id, $data[0]['user_id']);
        $this->assertGreaterThan($data[1]['score'], $data[0]['score']);
    }

    public function test_returns_recommended_jobs_for_user()
    {
        $companyUser = $this->createCompanyUser();
        $company = $companyUser->company;

        $job1 = JobOpportunity::create([
            'company_id' => $company->id,
            'title' => 'Dev PHP',
            'tech_stack' => ['php', 'laravel'],
            'culture_tags' => ['diversidade'],
            'status' => 'open',
        ]);

        $job2 = JobOpportunity::create([
            'company_id' => $company->id,
            'title' => 'Dev Frontend',
            'tech_stack' => ['react'],
            'culture_tags' => ['presencial'],
            'status' => 'open',
        ]);

        /** @var \App\Models\User $user */
        $user = User::factory()->create([
            'role' => 'user',
            'tech_stack' => ['php', 'laravel'],
            'culture_tags' => ['diversidade'],
        ]);

        TalentPool::create([
            'users_id' => $user->id,
            'company_id' => $company->id,
            'status' => 'in_training',
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/auth/user/matches/jobs');

        $response->assertOk();

        $data = $response->json('data');
        $jobIds = collect($data)->pluck('job_id')->all();

        $this->assertContains($job1->id, $jobIds);
        $this->assertNotContains($job2->id, $jobIds);
    }
}
