<?php
namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class SlackChannel
{
    /**
     * @param $notifiable
     * @param Notification $notification
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send ($notifiable, Notification $notification) {
        $data = $notification->toSlack($notifiable);
        $response = (new \GuzzleHttp\Client)
            ->post(config('slack.notification_url', 'SLACK_NOTIFICATION_ROMAN_URL'),
                ['json'=>['text' => $data]]);
    }
}














//    Tim Slack
//https://hooks.slack.com/services/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






//['json'=>['text' =>
//            ' Good Morning Tim, mail, with subject : ' .$data->subject.
//            ', was sent to : ' .$notifiable->name.
//            ' with e-mail : ' .$notifiable->email.
//            ' Content :' . $a. '   ',
//        ]]

//                ['json'=>['text' =>   json_encode([
//                    'Mail with subject : ' => $data->subject,
//                    'Was sent to : ' => $notifiable->name,
//                    'with e-mail : ' => $notifiable->email,
//                ])]]);
