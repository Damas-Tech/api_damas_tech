<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobOpportunityResource;
use App\Models\JobOpportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Support\ErrorMessages;

class JobOpportunityController extends Controller
{
    public function index()
    {
        $company = Auth::user()->company;

        if (!$company) {
            return response()->json([
                'message' => ErrorMessages::get('jobs.forbidden'),
            ], 403);
        }

        $jobs = JobOpportunity::where('company_id', $company->id)->get();

        return JobOpportunityResource::collection($jobs);
    }

    public function store(Request $request)
    {
        $company = Auth::user()->company;

        if (!$company) {
            return response()->json([
                'message' => ErrorMessages::get('jobs.forbidden'),
            ], 403);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tech_stack' => 'nullable|array',
            'tech_stack.*' => 'string',
            'culture_tags' => 'nullable|array',
            'culture_tags.*' => 'string',
            'location_type' => 'nullable|string|max:50',
            'seniority' => 'nullable|string|max:50',
            'status' => 'nullable|string|in:open,closed,draft',
        ]);

        try {
            $data['company_id'] = $company->id;
            $job = JobOpportunity::create($data);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => ErrorMessages::get('jobs.create_failed'),
            ], 500);
        }

        return (new JobOpportunityResource($job))
            ->additional(['message' => __('messages.success.job_created')])
            ->response()
            ->setStatusCode(201);
    }
}
