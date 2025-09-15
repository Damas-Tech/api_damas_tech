<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class CourseCompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $courseId;

    public function __construct(User $user, $courseId)
    {
        $this->user = $user;
        $this->courseId = $courseId;
    }

    public function build()
    {
        return $this->subject('Curso Concluído!')
                    ->markdown('emails.course_completed');
    }
}
