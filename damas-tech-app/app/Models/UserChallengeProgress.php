<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChallengeProgress extends Model
{
    use HasFactory;

    protected $table = 'user_challenge_progress';

    protected $fillable = [
        'challenge_id',
        'user_id',
        'status',
        'submitted_code',
        'attempts',
    ];

    public function challenge()
    {
        return $this->belongsTo(CodeChallenge::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
