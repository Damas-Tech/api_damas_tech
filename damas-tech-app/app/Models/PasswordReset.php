<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $fillable = ['users_id', 'reset_token', 'expires_at', 'used'];

    protected $casts = [
        'used' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
