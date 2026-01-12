<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function build()
    {
        return $this->subject('Bem-vindo(a) à Damas Tech Empresas')
            ->view('emails.company_welcome')
            ->with(['company' => $this->company]);
    }
}
