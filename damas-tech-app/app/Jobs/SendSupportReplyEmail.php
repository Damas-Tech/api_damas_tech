<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\SupportReplyMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSupportReplyEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $data;

    public function __construct(string $email, array $data)
    {
        $this->email = $email;
        $this->data = $data;
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(new SupportReplyMail($this->data));
    }
}
