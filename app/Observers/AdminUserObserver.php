<?php

namespace App\Observers;

use App\Models\AdminUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminUserObserver
{
    /**
     * Handle the AdminUser "created" event.
     *
     * @param  \App\Models\AdminUser  $adminUser
     * @return void
     */

    public function creating(AdminUser $adminUser)
    {
        if (Auth::user()->cannot('create', $adminUser)) {
            abort(403);
        }
    }

//    public function created(AdminUser $adminUser)
//    {
//        //
//    }

    /**
     * Handle the AdminUser "updated" event.
     *
     * @param  \App\Models\AdminUser  $adminUser
     * @return void
     */

    public function updating(AdminUser $adminUser)
    {
        if (Auth::user()->cannot('update', $adminUser)) {
            abort(403);
        }
    }

//    public function updated(AdminUser $adminUser)
//    {
//        //
//    }

    /**
     * Handle the AdminUser "deleted" event.
     *
     * @param  \App\Models\AdminUser  $adminUser
     * @return void
     */

    public function deleting(AdminUser $adminUser)
    {
        if (Auth::user()->cannot('delete', $adminUser)) {
            abort(403);
        }
    }


//    public function deleted(AdminUser $adminUser)
//    {
//        //
//    }

    /**
     * Handle the AdminUser "restored" event.
     *
     * @param  \App\Models\AdminUser  $adminUser
     * @return void
     */
//    public function restored(AdminUser $adminUser)
//    {
//        //
//    }

    /**
     * Handle the AdminUser "force deleted" event.
     *
     * @param  \App\Models\AdminUser  $adminUser
     * @return void
     */
//    public function forceDeleted(AdminUser $adminUser)
//    {
//        //
//    }
}
