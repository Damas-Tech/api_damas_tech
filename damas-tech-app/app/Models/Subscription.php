<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['users_id', 'company_id', 'plan_id', 'status', 'start_date', 'end_date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'subscription_id');
    }
}
