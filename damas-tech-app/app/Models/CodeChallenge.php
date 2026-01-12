<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeChallenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'title',
        'description',
        'language',
        'initial_code',
        'expected_output',
        'test_cases',
        'difficulty',
    ];

    protected $casts = [
        'test_cases' => 'array',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function progress()
    {
        return $this->hasMany(UserChallengeProgress::class, 'challenge_id');
    }
}
