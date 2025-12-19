<?php

namespace App\Services;

use App\Models\User;
use App\Models\JobOpportunity;
use App\Models\TalentPool;

class MatchService
{
    public function calculateUserJobMatch(User $user, JobOpportunity $job): array
    {
        [$userSkills, $jobSkills] = [$this->normalizeTags($user->tech_stack), $this->normalizeTags($job->tech_stack)];
        [$userCulture, $jobCulture] = [$this->normalizeTags($user->culture_tags), $this->normalizeTags($job->culture_tags)];

        $skillsMatched = array_values(array_intersect($jobSkills, $userSkills));
        $skillsMissing = array_values(array_diff($jobSkills, $userSkills));
        $cultureMatched = array_values(array_intersect($jobCulture, $userCulture));
        $cultureMissing = array_values(array_diff($jobCulture, $userCulture));

        $skillScore = $this->scoreComponent($jobSkills, $skillsMatched);
        $cultureScore = $this->scoreComponent($jobCulture, $cultureMatched);
        $overallScore = $this->combineScores($skillScore, $cultureScore);

        return [
            'user_id' => $user->id,
            'job_id' => $job->id,
            'score' => $overallScore,
            'skill_score' => $skillScore,
            'culture_score' => $cultureScore,
            'skills_matched' => $skillsMatched,
            'skills_missing' => $skillsMissing,
            'culture_matched' => $cultureMatched,
            'culture_missing' => $cultureMissing,
        ];
    }

    public function rankCandidatesForJob(JobOpportunity $job, int $limit = 20): array
    {
        $userIds = TalentPool::where('company_id', $job->company_id)
            ->whereIn('status', ['in_training', 'highlighted'])
            ->pluck('users_id')
            ->unique()
            ->values()
            ->all();

        $users = User::whereIn('id', $userIds)->get();

        $matches = [];
        foreach ($users as $user) {
            $matches[] = $this->calculateUserJobMatch($user, $job);
        }

        usort($matches, function (array $a, array $b) {
            return $b['score'] <=> $a['score'];
        });

        return array_slice($matches, 0, $limit);
    }

    public function rankJobsForUser(User $user, int $limit = 20): array
    {
        $companyIds = TalentPool::where('users_id', $user->id)
            ->pluck('company_id')
            ->filter()
            ->unique()
            ->values()
            ->all();

        $jobsQuery = JobOpportunity::query()->where('status', 'open');

        if ($companyIds !== []) {
            $jobsQuery->whereIn('company_id', $companyIds);
        }

        $jobs = $jobsQuery->get();

        $matches = [];
        foreach ($jobs as $job) {
            $match = $this->calculateUserJobMatch($user, $job);

            if ($match['score'] > 0) {
                $matches[] = $match;
            }
        }

        usort($matches, function (array $a, array $b) {
            return $b['score'] <=> $a['score'];
        });

        return array_slice($matches, 0, $limit);
    }

    protected function normalizeTags($value): array
    {
        if (is_null($value)) {
            return [];
        }

        if (is_string($value)) {
            $value = preg_split('/[,;]+/', $value);
        }

        if (! is_array($value)) {
            return [];
        }

        $normalized = [];
        foreach ($value as $item) {
            $item = trim(mb_strtolower((string) $item));
            if ($item !== '') {
                $normalized[] = $item;
            }
        }

        return array_values(array_unique($normalized));
    }

    protected function scoreComponent(array $allRequired, array $matched): float
    {
        if (count($allRequired) === 0) {
            return 0.0;
        }

        return round((count($matched) / count($allRequired)) * 100, 2);
    }

    protected function combineScores(float $skillScore, float $cultureScore): float
    {
        if ($skillScore === 0.0 && $cultureScore === 0.0) {
            return 0.0;
        }

        if ($skillScore > 0 && $cultureScore === 0.0) {
            return $skillScore;
        }

        if ($cultureScore > 0 && $skillScore === 0.0) {
            return $cultureScore;
        }

        return round(($skillScore * 0.7) + ($cultureScore * 0.3), 2);
    }
}
