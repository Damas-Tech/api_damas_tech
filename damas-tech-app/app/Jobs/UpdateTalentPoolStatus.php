<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\TalentPool;
use App\Models\UserCourseProgress;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateTalentPoolStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $progress;

    public function __construct(UserCourseProgress $progress)
    {
        $this->progress = $progress;
    }

    public function handle(): void
    {
        $talentPool = TalentPool::where('users_id', $this->progress->users_id)
            ->where('status', 'in_training')
            ->first();

        if ($talentPool) {
            $talentPool->status = 'highlighted';
            $talentPool->evaluation_notes .= "\nCurso {$this->progress->course_id} concluído em " . now();
            $talentPool->save();
        }
    }
}
