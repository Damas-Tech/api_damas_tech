<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Services\AuthService;
use App\Http\Resources\UserResource;
use App\Support\ErrorMessages;

class AuthController extends Controller
{

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

        // Delegamos a criação e disparo de e-mail para o service
        $user = $this->authService->registerUser($request->only(['name', 'email', 'password']));

        return (new UserResource($user))
            ->additional(['message' => 'Usuário registrado com sucesso'])
            ->response()
            ->setStatusCode(201);
    }

    public function registerCompany(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'cnpj' => 'required|string|unique:companies,cnpj',
        ]);

        // Delegamos criação de usuário, empresa e e-mail de boas-vindas para o service
        $result = $this->authService->registerCompany($request->only(['name', 'email', 'password', 'cnpj']));

        return (new UserResource($result['user']))
            ->additional([
                'message' => 'Empresa registrada com sucesso',
                'company' => $result['company'],
            ])
            ->response()
            ->setStatusCode(201);
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
                'email' => [ErrorMessages::get('auth.invalid_credentials')],
            ]);
        }

        return (new UserResource($result['user']))
            ->additional([
                'message' => 'Login realizado com sucesso',
                'token' => $result['token'],
            ])
            ->response();
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

    public function me(Request $request)
    {
        return new UserResource($request->user());
    }
}
