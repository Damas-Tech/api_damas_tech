<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $fillable = ['course_id', 'title', 'content', 'order_number'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function userProgress()
    {
        return $this->hasMany(UserModuleProgress::class, 'module_id');
    }

    public function materials()
    {
        return $this->hasMany(ModuleMaterial::class);
    }

    public function videos()
    {
        return $this->hasMany(ModuleVideo::class);
    }
}
