<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_own_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->putJson("/api/auth/users/{$user->id}", [
            'name' => 'Updated Name',
            'tech_stack' => ['php', 'laravel'],
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_user_cannot_update_other_users_profile()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->putJson("/api/auth/users/{$otherUser->id}", [
            'name' => 'Hacked Name',
        ]);

        $response->assertForbidden();
    }

    public function test_user_can_delete_account()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/auth/users/{$user->id}");

        $response->assertNoContent(); // Or 200/204 depending on controller
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
