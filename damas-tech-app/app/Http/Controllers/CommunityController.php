<?php

namespace App\Http\Controllers;

use App\Models\ForumThread;
use App\Models\ForumReply;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = ForumThread::with(['user:id,name,avatar', 'replies.user:id,name,avatar'])
            ->withCount('replies')
            ->latest();

        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        $threads = $query->paginate(15);

        return $this->success($threads);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $thread = ForumThread::create([
            'user_id' => $request->user()->id,
            'course_id' => $request->input('course_id'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        return $this->success($thread, 'messages.success.saved', 201);
    }

    public function show($id)
    {
        $thread = ForumThread::with(['user:id,name,avatar', 'replies.user:id,name,avatar'])->findOrFail($id);
        return $this->success($thread);
    }

    public function reply(Request $request, $id)
    {
        $request->validate(['content' => 'required|string']);

        $thread = ForumThread::findOrFail($id);

        $reply = ForumReply::create([
            'thread_id' => $thread->id,
            'user_id' => $request->user()->id,
            'content' => $request->input('content'),
        ]);

        return $this->success($reply, 'messages.success.saved', 201);
    }
}
