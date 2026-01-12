<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\PasswordResetMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPasswordResetEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $url;

    public function __construct(string $email, string $url)
    {
        $this->email = $email;
        $this->url = $url;
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(new PasswordResetMail($this->url));
    }
}
