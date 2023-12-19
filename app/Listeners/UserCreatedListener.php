<?php

namespace App\Listeners;
use App\Events\UserCreatedEvent;
use App\Models\User;
use App\Notifications\UserCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class UserCreatedListener
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
     * @param UserCreatedEvent $event
     * @return void
     */
    public function handle(UserCreatedEvent $event)
    {
        $event->user->notify(new UserCreatedNotification($event->user));
//        $users = User::except($event->user)->get();
//        Notification::send($users, new UserCreatedNotification($event->user));
//        $event->user->notify(new UserCreatedNotification());
//        Mail::to($event->user)->send(new \App\Mail\UserCreatedMailable($event->user));
       Log::info(" UserCreatedMailer Listener info: ".$event->user->name."  was created");
    }
}
