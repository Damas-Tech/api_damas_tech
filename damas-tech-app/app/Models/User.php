<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles, HasFactory;

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'users_id');
    }

    public function courseProgress()
    {
        return $this->hasMany(UserCourseProgress::class, 'users_id');
    }

    public function moduleProgress()
    {
        return $this->hasMany(UserModuleProgress::class, 'users_id');
    }

    public function talentPool()
    {
        return $this->hasMany(TalentPool::class, 'users_id');
    }

    public function authTokens()
    {
        return $this->hasMany(AuthToken::class, 'users_id');
    }

    public function loginAttempts()
    {
        return $this->hasMany(LoginAttempt::class, 'users_id');
    }

    public function passwordResets()
    {
        return $this->hasMany(PasswordReset::class, 'users_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'users_id');
    }

    public function externalAuth()
    {
        return $this->hasMany(ExternalAuth::class, 'users_id');
    }
}
