<?php

namespace Tests\Feature;

use App\Models\ForumThread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommunityTest extends TestCase
{
    use RefreshDatabase;

    private function authenticatedUser(): User
    {
        return User::factory()->create();
    }

    public function test_user_can_create_a_thread()
    {
        $user = $this->authenticatedUser();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/auth/community/threads', [
            'title' => 'Dúvida sobre Laravel',
            'content' => 'Com ofaz testes?',
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('forum_threads', [
            'title' => 'Dúvida sobre Laravel',
            'user_id' => $user->id,
        ]);
    }

    public function test_threads_list_returns_pagination()
    {
        $user = $this->authenticatedUser();
        ForumThread::factory()->count(20)->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/auth/community/threads');

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'user',
                        'replies_count',
                    ]
                ],
                'links',
            ]
        ]);
    }

    public function test_user_can_reply_to_thread()
    {
        $user = $this->authenticatedUser();
        $thread = ForumThread::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson("/api/auth/community/threads/{$thread->id}/reply", [
            'content' => 'Minha resposta explicativa.',
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('forum_replies', [
            'content' => 'Minha resposta explicativa.',
            'thread_id' => $thread->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_cannot_create_thread_with_empty_data()
    {
        $user = $this->authenticatedUser();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/auth/community/threads', [
            'title' => '',
            'content' => '',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['title', 'content']);
    }

    public function test_cannot_reply_to_non_existent_thread()
    {
        $user = $this->authenticatedUser();

        $response = $this->actingAs($user, 'sanctum')->postJson("/api/auth/community/threads/99999/reply", [
            'content' => 'Resposta orfã',
        ]);

        $response->assertNotFound();
    }
}
