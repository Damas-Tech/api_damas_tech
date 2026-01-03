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

    public function test_usuario_pode_criar_um_topico()
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

    public function test_lista_topicos_retorna_paginacao()
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

    public function test_usuario_pode_responder_topico()
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
}
