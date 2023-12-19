<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class UserCreatedNotification extends Notification
{
    use Queueable;
    public User $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */


    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(mixed $notifiable)
    {
        return [ 'log', 'mail', 'slack', ];
    }

    public function toLog (mixed $notifiable):array {
        return [
            'from'          => 'to-lognotification',
            'full info'     => $this->user->name,
        ];
    }

    /**
     * @param mixed $notifiable
     * @return string
     */
    public function toSlack(mixed $notifiable): string
    {
        $content = implode($this->toMail($notifiable)->introLines);
        return 'Good Morning Tim, mail, with subject  ' .$this->toMail($notifiable)->subject.
            ', was sent to : ' .$notifiable->name.
            ', e-mail : ' .$notifiable->email.
            ', with Content : ' .$content;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New user '.$this->user->name.' created ')
            ->line('Hi ' .$notifiable->name.' Your account was created successfully. Please confirm your e-mail address: ')
            ->action('E-mail verification link', url('/api/user/verify?email='.$notifiable->email.'&activation_code='.$notifiable->activation_code))
            ->line('Thank you for using our application!');

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray(mixed $notifiable): array
    {
        return [
            'from'          => 'to-array',
            'notifiable-id' => $notifiable->id,
        ];
    }
}
