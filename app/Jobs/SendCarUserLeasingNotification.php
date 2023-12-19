<?php

namespace App\Jobs;

use App\Models\Car;
use App\Models\CarUser;
use App\Models\User;
use App\Notifications\CarUserLeasingNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendCarUserLeasingNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $carUsers = CarUser::whereDate('created_at', Carbon::yesterday())->get();
        User::get()->each(function ($tempUser) use ($carUsers){
            if ($tempUser->isSuper){
                Notification::send($tempUser, new CarUserLeasingNotification($carUsers));
            }});
    }
}
