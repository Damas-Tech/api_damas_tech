<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\CompanyWelcomeMail;
use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendCompanyWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function handle(): void
    {
        $email = $this->company->email;

        if ($email) {
            Mail::to($email)->send(new CompanyWelcomeMail($this->company));
        }
    }
}
