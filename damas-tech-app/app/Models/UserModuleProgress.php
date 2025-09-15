<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModuleProgress extends Model
{
    protected $fillable = ['users_id', 'module_id', 'completed', 'completed_at'];

    protected $casts = [
        'completed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }
}
