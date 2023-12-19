<?php
namespace App\Channels;

use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Notifications\Notification;

class LogChannel
{
    public function send (Builder $notifiable, Notification $notification): bool {
//        dd($notifiable);
//        if (method_exists($notifiable, 'routeNotificationForLog')) {
//            $id = $notifiable->routeNotificationForLog($notifiable);
//        } else {
//            $id = $notifiable->getKey();
//        }
        $data = $notification->toMail($notifiable);
//        $data = method_exists($notification, 'toMail')
//            ? $notification->toMail($notifiable)
//            : $notification->toArray($notifiable);
//        if (empty($data)) {
//            return;
//        }
        app('log')->info(json_encode([
//            'id'   => $id,
            'Mail with subject : ' => $data->subject,
            ' Content : ' => $data,
            'Was sent to : ' => $notifiable->name,
            'with e-mail : ' => $notifiable->email,
        ]));
        return true;
    }
}
