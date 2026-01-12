<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\CourseCompletedMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendCourseCompletedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $courseId;

    public function __construct(User $user, $courseId)
    {
        $this->user = $user;
        $this->courseId = $courseId;
    }

    public function handle(): void
    {
        Mail::to($this->user->email)
            ->send(new CourseCompletedMail($this->user, $this->courseId));
    }
}
