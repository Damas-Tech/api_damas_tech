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
        if (! Auth::check()) {
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

    public function show(Company $company)
    {
        if (! Auth::check()) {
            return $this->error('auth.unauthenticated', 401);
        }

        return $this->success($company);
    }

    public function update(Request $request, Company $company)
    {
        $authUser = Auth::user();

        if (! $authUser || $authUser->id !== $company->users_id) {
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

        if (! $authUser || $authUser->id !== $company->users_id) {
            return $this->error('companies.forbidden', 403);
        }

        $company->delete();

        return $this->success(null, 'messages.success.deleted', 204);
    }
}
