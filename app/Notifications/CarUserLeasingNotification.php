<?php

namespace App\Notifications;

use App\Models\CarUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CarUserLeasingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public CarUser $carUsers)
    {
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if ($this->carUsers->count() == 0){
            return (new MailMessage)
                ->line('Hi, ')
                ->line('no leases started today');
        }
        $msg = (new MailMessage)
            ->line('Hi, ')
            ->line('the following leases started today: ');

        $this->carUsers->each(function ($carUser) use (&$msg) {
            $msg->line($carUser->user->name." leased ".$carUser->car->brand);
        });
        return $msg;

        //        return (new MailMessage)
//            ->line('Hi ' .$this->carUsers->each(function ($carUser){return $carUser->user;})    )

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
