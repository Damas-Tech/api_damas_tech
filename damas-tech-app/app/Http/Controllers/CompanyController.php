<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Support\ErrorMessages;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Lista empresas com filtros opcionais por tech_stack e culture_tags.
     * Disponível para qualquer usuária autenticada.
     */
    public function index(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'message' => ErrorMessages::get('auth.unauthenticated'),
                ], Response::HTTP_UNAUTHORIZED);
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

            return CompanyResource::collection($companies);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => ErrorMessages::get('generic.unexpected_error'),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Mostra detalhes de uma empresa.
     */
    public function show(Company $company)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'message' => ErrorMessages::get('auth.unauthenticated'),
                ], Response::HTTP_UNAUTHORIZED);
            }

            return new CompanyResource($company);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => ErrorMessages::get('generic.unexpected_error'),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Atualiza a própria empresa (PUT/PATCH).
     */
    public function update(Request $request, Company $company)
    {
        try {
            $authUser = Auth::user();

            if (!$authUser || $authUser->id !== $company->users_id) {
                return response()->json([
                    'message' => ErrorMessages::get('companies.forbidden'),
                ], Response::HTTP_FORBIDDEN);
            }

            $validated = $request->validate([
                'tech_stack' => ['sometimes', 'array'],
                'tech_stack.*' => ['string', 'max:255'],
                'culture_tags' => ['sometimes', 'array'],
                'culture_tags.*' => ['string', 'max:255'],
            ]);

            $company->fill($validated);
            $company->save();

            return new CompanyResource($company);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => ErrorMessages::get('generic.unexpected_error'),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Exclui a própria empresa vinculada ao usuário autenticado.
     */
    public function destroy(Company $company)
    {
        try {
            $authUser = Auth::user();

            if (!$authUser || $authUser->id !== $company->users_id) {
                return response()->json([
                    'message' => ErrorMessages::get('companies.forbidden'),
                ], Response::HTTP_FORBIDDEN);
            }

            $company->delete();

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => ErrorMessages::get('generic.unexpected_error'),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
