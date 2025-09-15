<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleMaterial extends Model
{
    protected $fillable = ['module_id', 'type', 'url'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
