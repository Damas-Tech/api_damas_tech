<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOpportunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'title',
        'description',
        'tech_stack',
        'culture_tags',
        'location_type',
        'seniority',
        'status',
    ];

    protected $casts = [
        'tech_stack' => 'array',
        'culture_tags' => 'array',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
