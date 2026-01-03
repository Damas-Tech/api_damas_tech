<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\TalentPool;
use App\Models\UserCourseProgress;

class UpdateTalentPoolStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $progress;

    public function __construct(UserCourseProgress $progress)
    {
        $this->progress = $progress;
    }

    public function handle()
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
