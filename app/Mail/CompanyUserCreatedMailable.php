<?php

namespace App\Mail;

use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\JobTitle;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyUserCreatedMailable extends Mailable
{
    use Queueable, SerializesModels;

    public CompanyUser $companyUser;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CompanyUser $companyUser)
    {
        $this->companyUser = $companyUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.company_user.created')
                    ->subject("User ".$this->companyUser->user->name." joined company ".$this->companyUser->company->name);
    }
}
