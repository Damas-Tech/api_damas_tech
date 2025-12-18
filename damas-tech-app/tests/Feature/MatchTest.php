<?php

use App\Models\User;
use App\Models\Company;
use App\Models\JobOpportunity;
use App\Models\TalentPool;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function createCompanyUser(array $userData = []): User
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

it('ranqueia candidatas para uma vaga com base em tecnologias e cultura', function () {
    /** @var \Tests\TestCase $this */

    /** @var \App\Models\User $companyUser */
    $companyUser = createCompanyUser();
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

    expect($data[0]['user_id'])->toBe($candidate1->id);
    expect($data[0]['score'])->toBeGreaterThan($data[1]['score']);
});

it('retorna vagas recomendadas para a usuária', function () {
    /** @var \Tests\TestCase $this */

    $companyUser = createCompanyUser();
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

    expect(collect($data)->pluck('job_id')->all())
        ->toContain($job1->id)
        ->not->toContain($job2->id);
});
