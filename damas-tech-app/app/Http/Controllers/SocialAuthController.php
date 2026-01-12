<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ExternalAuth;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    use ApiResponse;

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Check if user already exists
            $user = User::where('email', $googleUser->getEmail())->first();

            if (! $user) {
                // Register new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(Str::random(24)), // Random password
                    'role' => 'user',
                    'email_verified_at' => now(),
                ]);
            }

            // Update or Create External Auth record
            ExternalAuth::updateOrCreate(
                [
                    'users_id' => $user->id,
                    'provider' => 'google',
                ],
                [
                    'provider_id' => $googleUser->getId(),
                    'provider_token' => $googleUser->token,
                    'provider_refresh_token' => $googleUser->refreshToken,
                    'avatar_url' => $googleUser->getAvatar(),
                ]
            );

            // Generate Token
            $token = $user->createToken('google-token')->plainTextToken;

            // In a real SPA, we would probably redirect to a frontend URL with the token
            // For this API test, we return the JSON.
            // But since this is a callback from browser, returning JSON might be awkward.
            // Usually we assume frontend handles the popup/redirect.
            // If frontend is separate, this callback URL should actually be the frontend URL which then calls API with code.
            // For simplicity here in backend-only dev:

            return $this->success([
                'user' => $user,
                'token' => $token,
            ], 'messages.success.login_success');
        } catch (\Exception $e) {
            return $this->error('messages.error.unexpected', 500);
        }
    }
}
