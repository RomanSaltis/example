<?php

namespace App\Listeners;

use App\Events\Authenticated;
use App\Models\User;
use App\Notifications\UserEmailVerifiedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class CheckUserVerified
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
     * @param  \App\Events\Authenticated  $event
     * @return void
     */
    public function handle(Authenticated $event): void
    {
        $users=User::get();
        foreach ($users as $admin){
            if (optional($admin -> adminUser) -> is_admin){
                Notification::send($admin, new UserEmailVerifiedNotification($event->user));
            }
        }
             Log::info(" User ". $event->user->name. " Verified his e-mail address: ".$event->user->email);
    }
}
