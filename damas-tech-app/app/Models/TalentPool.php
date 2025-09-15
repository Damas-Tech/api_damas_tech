<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TalentPool extends Model
{
    protected $fillable = ['users_id', 'company_id', 'evaluation_notes', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
