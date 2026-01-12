<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Company;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        if (!Auth::check()) {
            return $this->error('auth.unauthenticated', 401);
        }

        $query = Company::query();

        $techStack = $request->input('tech_stack');
        if (is_string($techStack)) {
            $techStack = array_filter(array_map('trim', explode(',', $techStack)));
        }
        if (is_array($techStack) && count($techStack) > 0) {
            foreach ($techStack as $tag) {
                $query->whereJsonContains('tech_stack', $tag);
            }
        }

        $cultureTags = $request->input('culture_tags');
        if (is_string($cultureTags)) {
            $cultureTags = array_filter(array_map('trim', explode(',', $cultureTags)));
        }
        if (is_array($cultureTags) && count($cultureTags) > 0) {
            foreach ($cultureTags as $tag) {
                $query->whereJsonContains('culture_tags', $tag);
            }
        }

        $companies = $query->paginate(15);

        return $this->success($companies);
    }

    public function store(Request $request)
    {
        $authUser = Auth::user();

        // Ensure user is authenticated
        if (!$authUser) {
            return $this->error('auth.unauthenticated', 401);
        }

        $validated = $request->validate([
            'cnpj' => ['required', 'string', 'max:20', 'unique:companies'],
            'tech_stack' => ['sometimes', 'array'],
            'tech_stack.*' => ['string', 'max:255'],
            'culture_tags' => ['sometimes', 'array'],
            'culture_tags.*' => ['string', 'max:255'],
        ]);

        // Link company to the authenticated user? Or create a new user for it?
        // Usually "Company" model belongsTo User (users_id).
        // If creating a company via API, we assume the CURRENT user becomes the owner?
        // Or we pass a user_id?
        // Let's assume current user for now, or validate 'users_id' if admin.
        // Simplified: Current user owns the new company profile.

        // Check if user already has a company?
        if (Company::where('users_id', $authUser->id)->exists()) {
            return $this->error('companies.already_exists', 400);
        }

        $company = new Company($validated);
        $company->users_id = $authUser->id;
        $company->save();

        return $this->success($company, 'messages.success.saved', 201);
    }

    public function show(Company $company)
    {
        if (!Auth::check()) {
            return $this->error('auth.unauthenticated', 401);
        }

        return $this->success($company);
    }

    public function update(Request $request, Company $company)
    {
        $authUser = Auth::user();

        if (!$authUser || $authUser->id !== $company->users_id) {
            return $this->error('companies.forbidden', 403);
        }

        $validated = $request->validate([
            'tech_stack' => ['sometimes', 'array'],
            'tech_stack.*' => ['string', 'max:255'],
            'culture_tags' => ['sometimes', 'array'],
            'culture_tags.*' => ['string', 'max:255'],
        ]);

        $company->fill($validated);
        $company->save();

        return $this->success($company);
    }

    public function destroy(Company $company)
    {
        $authUser = Auth::user();

        if (!$authUser || $authUser->id !== $company->users_id) {
            return $this->error('companies.forbidden', 403);
        }

        $company->delete();

        return $this->success(null, 'messages.success.deleted', 204);
    }
}
