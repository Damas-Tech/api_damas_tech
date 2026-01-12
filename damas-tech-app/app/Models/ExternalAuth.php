<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalAuth extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'provider',
        'provider_id',
        'provider_token',
        'provider_refresh_token',
        'avatar_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
