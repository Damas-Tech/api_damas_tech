<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use App\Jobs\SendPasswordResetEmail;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_request_password_reset_link()
    {
        Queue::fake();

        $user = User::factory()->create(['email' => 'forgot@example.com']);

        $response = $this->postJson('/api/auth/forgot-password', [
            'email' => 'forgot@example.com',
        ]);

        $response->assertJson(['message' => __('messages.success.email_sent')]); // Literal key or mocked translation

        Queue::assertPushed(SendPasswordResetEmail::class);
    }

    public function test_cannot_request_reset_for_non_existent_email()
    {
        Queue::fake();

        $response = $this->postJson('/api/auth/forgot-password', [
            'email' => 'nonexistent@example.com',
        ]);

        // Security: Returns 200 to prevent enumeration
        $response->assertOk();
        $response->assertJson(['message' => __('messages.success.email_sent')]);

        // Use notPushed because no email should be sent for non-existent user
        Queue::assertNotPushed(SendPasswordResetEmail::class);
    }

    public function test_cannot_request_reset_with_invalid_email_format()
    {
        $response = $this->postJson('/api/auth/forgot-password', [
            'email' => 'not-an-email',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['email']);
    }
}
