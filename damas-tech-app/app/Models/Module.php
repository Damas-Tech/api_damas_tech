<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
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
