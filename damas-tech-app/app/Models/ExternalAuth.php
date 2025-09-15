<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalAuth extends Model
{
    protected $fillable = ['users_id', 'provider', 'provider_user_id', 'access_token', 'refresh_token', 'expires_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
