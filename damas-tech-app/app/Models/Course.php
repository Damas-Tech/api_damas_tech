<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'duration', 'description'];

    public function modules()
    {
        return $this->hasMany(Module::class, 'course_id');
    }

    public function userProgress()
    {
        return $this->hasMany(UserCourseProgress::class, 'course_id');
    }
}
