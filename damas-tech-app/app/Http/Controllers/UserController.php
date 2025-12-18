<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Support\ErrorMessages;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Lista usuárias com filtros opcionais por tech_stack e culture_tags.
     * Visível apenas para contas com role "company".
     */
    public function index(Request $request)
    {
        try {
            $authUser = Auth::user();

            if (!$authUser || $authUser->role !== 'company') {
                return response()->json([
                    'message' => ErrorMessages::get('users.forbidden'),
                ], Response::HTTP_FORBIDDEN);
            }

            $query = User::query()->where('role', 'user');

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

            $users = $query->paginate(15);

            return UserResource::collection($users);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => ErrorMessages::get('generic.unexpected_error'),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Mostra detalhes de uma usuária específica (apenas para empresas).
     */
    public function show(User $user)
    {
        try {
            $authUser = Auth::user();

            if (!$authUser || $authUser->role !== 'company') {
                return response()->json([
                    'message' => ErrorMessages::get('users.forbidden'),
                ], Response::HTTP_FORBIDDEN);
            }

            if ($user->role !== 'user') {
                return response()->json([
                    'message' => ErrorMessages::get('users.not_found'),
                ], Response::HTTP_NOT_FOUND);
            }

            return new UserResource($user);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => ErrorMessages::get('generic.unexpected_error'),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Atualiza o perfil da própria usuária autenticada (PUT/PATCH).
     */
    public function update(Request $request, User $user)
    {
        try {
            $authUser = Auth::user();

            if (!$authUser || $authUser->id !== $user->id) {
                return response()->json([
                    'message' => ErrorMessages::get('users.forbidden'),
                ], Response::HTTP_FORBIDDEN);
            }

            $validated = $request->validate([
                'name' => ['sometimes', 'string', 'max:255'],
                'tech_stack' => ['sometimes', 'array'],
                'tech_stack.*' => ['string', 'max:255'],
                'culture_tags' => ['sometimes', 'array'],
                'culture_tags.*' => ['string', 'max:255'],
            ]);

            $user->fill($validated);
            $user->save();

            return new UserResource($user);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => ErrorMessages::get('generic.unexpected_error'),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
