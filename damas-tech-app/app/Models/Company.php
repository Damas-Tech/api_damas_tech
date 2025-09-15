<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['users_id', 'cnpj'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function talentPool()
    {
        return $this->hasMany(TalentPool::class, 'company_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'company_id');
    }
}
