<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use \App\Traits\ApiResponse;

    public function index(Request $request)
    {
        $authUser = Auth::user();

        if (!$authUser || $authUser->role !== 'company') {
            return $this->error('users.forbidden', 403);
        }

        $query = User::query()->where('role', 'user');

        $techStack = $request->input('tech_stack');
        if (is_string($techStack)) {
            $techStack = array_filter(array_map('trim', explode(',', $techStack)));
        }
        if (is_array($techStack) && count($techStack) > 0) {
            foreach ($techStack as $tag) {
                $query->whereJsonContains('tech_stack', $tag);
            }
        }

        $cultureTags = $request->input('culture_tags');
        if (is_string($cultureTags)) {
            $cultureTags = array_filter(array_map('trim', explode(',', $cultureTags)));
        }
        if (is_array($cultureTags) && count($cultureTags) > 0) {
            foreach ($cultureTags as $tag) {
                $query->whereJsonContains('culture_tags', $tag);
            }
        }

        $users = $query->paginate(15);

        return $this->success($users);
    }

    public function show(User $user)
    {
        $authUser = Auth::user();

        if (!$authUser || $authUser->role !== 'company') {
            return $this->error('users.forbidden', 403);
        }

        if ($user->role !== 'user') {
            return $this->error('users.not_found', 404);
        }

        return $this->success($user);
    }

    public function update(Request $request, User $user)
    {
        $authUser = Auth::user();

        if (!$authUser || $authUser->id !== $user->id) {
            return $this->error('users.forbidden', 403);
        }

        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'tech_stack' => ['sometimes', 'array'],
            'tech_stack.*' => ['string', 'max:255'],
            'culture_tags' => ['sometimes', 'array'],
            'culture_tags.*' => ['string', 'max:255'],
        ]);

        $user->fill($validated);
        $user->save();

        return $this->success($user);
    }

    public function destroy(User $user)
    {
        $authUser = Auth::user();

        if (!$authUser || $authUser->id !== $user->id) {
            return $this->error('users.forbidden', 403);
        }

        $user->delete();

        return $this->success(null, 'messages.success.deleted', 204);
    }
}
