<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Mail\CourseCompletedMail;
use Illuminate\Support\Facades\Mail;

class SendCourseCompletedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $courseId;

    public function __construct(User $user, $courseId)
    {
        $this->user = $user;
        $this->courseId = $courseId;
    }

    public function handle()
    {
        Mail::to($this->user->email)
            ->send(new CourseCompletedMail($this->user, $this->courseId));
    }
}

