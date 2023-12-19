<?php

namespace App\Listeners;
use App\Models\Company;
use App\Models\User;
use App\Events\CompanyUserCreatedEvent;
use App\Mail\CompanyUserCreatedMailable;
use App\Notifications\CompanyUserCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CompanyUserCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CompanyUserCreatedEvent $event
     * @return void
     */
//    public $user = User::find($event->companyUser->user_id);

    public function handle(CompanyUserCreatedEvent $event)
    {
//        $user = User::find($event->companyUser->user_id);
        $event->companyUser->user->notify(new CompanyUserCreatedNotification());
//        Mail::to($event->companyUser->user->email)->send(new CompanyUserCreatedMailable($event->companyUser));
        Log::info(" CompanyUserCreatedMailer Listener info: User ".$event->companyUser->user->name. " joined Company Id ". $event->companyUser->company->name);
    }
}
