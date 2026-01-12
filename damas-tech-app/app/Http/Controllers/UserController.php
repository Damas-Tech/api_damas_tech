<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use \App\Traits\ApiResponse;

    public function index(Request $request)
    {
        $authUser = Auth::user();

        if (! $authUser || $authUser->role !== 'company') {
            return $this->error('users.forbidden', 403);
        }

        $query = User::query()->where('role', 'user');

        $this->applyArrayFilter($query, 'tech_stack', $request->input('tech_stack'));
        $this->applyArrayFilter($query, 'culture_tags', $request->input('culture_tags'));

        $users = $query->paginate(15);

        return $this->success($users);
    }

    public function show(User $user)
    {
        $authUser = Auth::user();

        if (! $authUser || $authUser->role !== 'company') {
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

        if (! $authUser || $authUser->id !== $user->id) {
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

        if (! $authUser || $authUser->id !== $user->id) {
            return $this->error('users.forbidden', 403);
        }

        $user->delete();

        return $this->success(null, 'messages.success.deleted', 204);
    }

    private function applyArrayFilter(\Illuminate\Database\Eloquent\Builder $query, string $column, mixed $values): void
    {
        if (is_string($values)) {
            $values = array_filter(array_map('trim', explode(',', $values)));
        }

        if (is_array($values) && count($values) > 0) {
            foreach ($values as $tag) {
                $query->whereJsonContains($column, $tag);
            }
        }
    }
}
