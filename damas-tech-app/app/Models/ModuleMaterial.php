<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModuleMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'title',
        'type',
        'file_path',
        'external_link',
    ];


    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
