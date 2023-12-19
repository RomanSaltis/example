<?php

namespace App\Listeners;

use App\Events\UserUpdatedEvent;
use App\Mail\UserUpdatedMailable;
use App\Notifications\UserUpdatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserUpdatedListener
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
     * @param  \App\Events\UserUpdatedEvent  $event
     * @return void
     */
    public function handle(UserUpdatedEvent $event)
    {
        $event->user->notify(new UserUpdatedNotification());
        Mail::to($event->user->email)->send(new UserUpdatedMailable($event->user));
        Log::info($event->user->name. "  User was updated");
    }
}
