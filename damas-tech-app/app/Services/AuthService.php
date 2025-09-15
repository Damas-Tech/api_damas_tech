<?php
namespace App\Services;

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendWelcomeEmail;

class AuthService
{
    /**
     * Cadastra um usuário comum
     */
    public function registerUser(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);

        // Dispara e-mail de boas-vindas
        SendWelcomeEmail::dispatch($user);

        return $user;
    }

    /**
     * Cadastra uma empresa
     */
    public function registerCompany(array $data): array
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'company',
        ]);

        $company = Company::create([
            'users_id' => $user->id,
            'cnpj' => $data['cnpj'],
        ]);

        SendWelcomeEmail::dispatch($user);

        return ['user' => $user, 'company' => $company];
    }

    /**
     * Login de usuário ou empresa
     */
    public function login(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new \Exception('Credenciais inválidas');
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }
}
