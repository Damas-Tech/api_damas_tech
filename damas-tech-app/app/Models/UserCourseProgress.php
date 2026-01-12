<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCourseProgress extends Model
{
    protected $fillable = ['users_id', 'course_id', 'started_at', 'completed_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
