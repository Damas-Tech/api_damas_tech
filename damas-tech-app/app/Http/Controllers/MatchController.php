<?php

namespace App\Http\Controllers;

use App\Http\Resources\MatchResultResource;
use App\Models\JobOpportunity;
use App\Services\MatchService;
use Illuminate\Support\Facades\Auth;
use App\Support\ErrorMessages;

class MatchController extends Controller
{
    public function __construct(protected MatchService $matchService) {}

    public function jobCandidates($jobId)
    {
        $company = Auth::user()->company;
        if (! $company) {
            return response()->json([
                'message' => ErrorMessages::get('jobs.forbidden'),
            ], 403);
        }

        $job = JobOpportunity::where('company_id', $company->id)->findOrFail($jobId);

        try {
            $matches = $this->matchService->rankCandidatesForJob($job);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => ErrorMessages::get('match.unexpected_error'),
            ], 500);
        }

        return MatchResultResource::collection(collect($matches));
    }

    public function userJobs()
    {
        $user = Auth::user();
        try {
            $matches = $this->matchService->rankJobsForUser($user);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => ErrorMessages::get('match.unexpected_error'),
            ], 500);
        }

        return MatchResultResource::collection(collect($matches));
    }
}
