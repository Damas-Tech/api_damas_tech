<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ApiResponse;

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = $this->authService->registerUser($request->only(['name', 'email', 'password']));

        return $this->success(new UserResource($user), 'messages.success.user_registered', 201);
    }

    public function registerCompany(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'cnpj' => 'required|string|unique:companies,cnpj',
        ]);

        $result = $this->authService->registerCompany($request->only(['name', 'email', 'password', 'cnpj']));

        return $this->success([
            'user' => new UserResource($result['user']),
            'company' => $result['company'],
        ], 'messages.success.company_registered', 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $result = $this->authService->login($request->only(['email', 'password']));
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'email' => [__('messages.error.invalid_credentials')],
            ]);
        }

        return $this->success([
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
        ], 'messages.success.login_success');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success([], 'messages.success.logout_success');
    }

    public function me(Request $request)
    {
        return $this->success(new UserResource($request->user()));
    }
}
