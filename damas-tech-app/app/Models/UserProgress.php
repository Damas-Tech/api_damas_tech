<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    protected $fillable = ['user_id', 'progressable_id', 'progressable_type', 'completed'];

    public function progressable()
    {
        return $this->morphTo();
    }
}
