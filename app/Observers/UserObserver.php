<?php

namespace App\Observers;

use App\Events\Authenticated;
use App\Events\UserCreatedEvent;
use App\Events\UserUpdatedEvent;
use App\Exceptions\DeleteProtectException;
use App\Exceptions\ExistsRelationException;
use App\Models\AdminUser;
use App\Models\Car;
use App\Models\CompanyUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    /**
     * Handle the User "creating" event.
     *
     * @param User $user
     * @return void
     */
    public function creating(User $user):void
    {
//        if (Auth::user()->cannot('create', $user)) {
//            abort(403);
//        }
        Log::info("creating user {$user->name}");
    }

    /**
     * Handle the User "created" event.
     *
     * @param User $user
     * @return void
     */
    public function created(User $user): void
    {
        Log::info("created user {$user->name}, id {$user->id}");
        UserCreatedEvent::dispatch($user);
    }

    /**
     * Handle the User "updating" event.
     *
     * @param User $user
     * @return void
     */
    public function updating(User $user): void
    {
//        if (Auth::user()->cannot('update', $user)) {
//            abort(403);
//        }
    }

    /**
     * Handle the User "updated" event.
     *
     * @param User $user
     * @return void
     */
    public function updated(User $user):void
    {
        Log::info("Updated user {$user->name}, id {$user->id}");
        UserUpdatedEvent::dispatch($user);
    }

    /**
     * Handle the User "saved" event.
     *
     * @param User $user
     * @return void
     */
    public function saved(User $user):void
    {
        Log::info("Saved user {$user->name}, id {$user->id}");
    }

    /**
     * Handle the User "restored" event.
     *
     * @param User $user
     * @return void
     */
    public function restored(User $user):void
    {
        Log::info("Restored user {$user->name}");
    }

    /**
     * Handle the User "deleting" event.
     *
     * @param User $user
     * @return void
     * @throws ExistsRelationException
     */
    public function deleting(User $user):void
    {
        if (Auth::user()->cannot('delete', $user)) {
            abort(403);
        }

        if ($user->companies()->exists() || $user->adminUser()->exists() || $user->cars()->exists())
        {
            throw new ExistsRelationException('The User cannot be deleted due to existence of related resources');
        }

//        \DB::transaction(function () use ($user){
//            AdminUser::findAdmin($user)->each(function ($admin){$admin->delete();});
//            CompanyUser::findUser($user)->each(function ($tempUser){$tempUser->delete();});
////            Car::findUser($user)->each(function ($tempUser){$tempUser->update(['user_id' => null]);});
//
//    });
        Log::info("Deleted user {$user->name}, id {$user->id}" );
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param User $user
     * @return void
     */
    public function deleted(User $user):void
    {
        Log::info("Deleted user {$user->name}, id {$user->id}" );
    }
}
