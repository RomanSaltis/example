<?php

namespace App\Observers;

use App\Exceptions\CarPriceException;
use App\Exceptions\CarUserException;
use App\Exceptions\ExistsRelationException;
use App\Exceptions\InvalidInputException;
use App\Jobs\SendDailyLeaseMail;
use App\Models\Car;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CarObserver
{
    /**
     * Handle the Car "created" event.
     *
     * @param  \App\Models\Car  $car
     * @return void
     */


    public function creating(Car $car):void
    {
        if (Auth::user()->cannot('create', $car)) {
            abort(403);
        }
    }

//    public function created(Car $car)
//    {
//    }

    /**
     * Handle the Car "saving" event
     *
     * @param Car $car
     * @return void
     */
    public function saving(Car $car): void
    {
        if (Auth::user()->cannot('save', $car)) {
            abort(403);
        }
    }

    /**
     * Handle the Car "updated" event.
     *
     * @param  \App\Models\Car  $car
     * @return void
     */

    public function updating(Car $car): void
    {
        if (Auth::user()->cannot('update', $car)) {
            abort(403);
        }
    }

//    public function updated(Car $car)
//    {
//
//    }

    /**
     * Handle the Car "deleted" event.
     *
     * @param  \App\Models\Car  $car
     * @return void
     */

    public function deleting (Car $car): void
    {
        if (Auth::user()->cannot('delete', $car)) {
            abort(403);
        }
        if ($car->user()->exists() || $car->company()->exists())
        {
            throw new ExistsRelationException('The car cannot be deleted due to existence of related resources');
        }
    }


//    public function deleted(Car $car)
//    {
//        //
//    }

    /**
     * Handle the Car "restored" event.
     *
     * @param  \App\Models\Car  $car
     * @return void
     */
//    public function restored(Car $car)
//    {
//        //
//    }

    /**
     * Handle the Car "force deleted" event.
     *
     * @param  \App\Models\Car  $car
     * @return void
     */
//    public function forceDeleted(Car $car)
//    {
//        //
//    }
}
