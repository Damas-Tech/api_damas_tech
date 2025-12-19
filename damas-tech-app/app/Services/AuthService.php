<?php

namespace App\Services;

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendWelcomeEmail;
use Illuminate\Support\Facades\DB;

class AuthService
{
    public function registerUser(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);

        SendWelcomeEmail::dispatch($user);

        return $user;
    }

    public function registerCompany(array $data): array
    {
        return DB::transaction(function () use ($data) {
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
        });
    }

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
