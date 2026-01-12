<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthToken extends Model
{
    protected $fillable = ['users_id', 'token', 'type', 'expires_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
