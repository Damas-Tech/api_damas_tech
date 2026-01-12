<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\SendPasswordResetEmail;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{
    use ApiResponse;

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        // Security: We don't want to reveal if a user exists or not, so we just return success
        if (! $user) {
            return $this->success([], 'messages.success.email_sent');
        }

        // Generate real secure token
        /** @var \Illuminate\Auth\Passwords\PasswordBroker $broker */
        $broker = Password::broker();
        $token = $broker->createToken($user);

        // Construct the reset URL (assuming frontend is at localhost:3000)
        $url = 'http://localhost:3000/reset-password?token=' . $token . '&email=' . urlencode($user->email);

        SendPasswordResetEmail::dispatch($user->email, $url);

        return $this->success([], 'messages.success.email_sent');
    }
}
