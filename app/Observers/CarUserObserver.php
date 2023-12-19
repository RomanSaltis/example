<?php

namespace App\Observers;

use App\Console\Kernel;
use App\Jobs\SendCarUserLeasingNotification;
use App\Models\CarUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CarUserObserver
{
    /**
     * Handle the CarUser "created" event.
     *
     * @param  \App\Models\CarUser  $carUser
     * @return void
     */
    public function creating(CarUser $carUser){
        if (Auth::user()->cannot('create', $carUser)) {
            abort(403);
        }
    }

//    public function created(CarUser $carUser)
//    {
////        $carUsers = CarUser::whereDate('created_at', Carbon::yesterday())->get();
////        print_r($carUsers);
//        $carUserId = CarUser::where(['car_id'=>$carUser->car_id, 'user_id'=>$carUser->user_id])->first();
////        SendCarUserLeasingNotification::dispatch($carUserId);
////            ->delay(now()->addMinute());
//
//    }

    /**
     * Handle the CarUser "updated" event.
     *
     * @param  \App\Models\CarUser  $carUser
     * @return void
     */
    public function updating(CarUser $carUser){
        if (Auth::user()->cannot('update', $carUser)) {
            abort(403);
        }
    }

//    public function updated(CarUser $carUser)
//    {
//        //
//    }

    /**
     * Handle the CarUser "saving" event.
     *
     * @param CarUser $carUser
     * @return bool
     */
    public function saving(CarUser $carUser): bool
    {
        if (Auth::user()->cannot('save', $carUser)) {
            abort(403);
        }
        return $carUser->user->companies()->sum('salary') > $carUser->car->price;
    }

    /**
     * Handle the CarUser "deleted" event.
     *
     * @param  \App\Models\CarUser  $carUser
     * @return void
     */
    public function deleting(CarUser $carUser){
        if (Auth::user()->cannot('delete', $carUser)) {
            abort(403);
        }
    }

//    public function deleted(CarUser $carUser)
//    {
//        //
//    }

    /**
     * Handle the CarUser "restored" event.
     *
     * @param  \App\Models\CarUser  $carUser
     * @return void
     */
//    public function restored(CarUser $carUser)
//    {
//        //
//    }

    /**
     * Handle the CarUser "force deleted" event.
     *
     * @param  \App\Models\CarUser  $carUser
     * @return void
     */
//    public function forceDeleted(CarUser $carUser)
//    {
//        //
//    }
}
