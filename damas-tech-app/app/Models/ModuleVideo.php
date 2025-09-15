<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleVideo extends Model
{
    protected $fillable = ['module_id', 'title', 'url', 'duration'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
