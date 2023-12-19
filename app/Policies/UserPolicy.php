<?php

namespace App\Policies;

use App\Exceptions\DeleteProtectException;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user has higher-privileged ability.
     *
     * @param User $user
     * @return mixed
     */
    public function before(User $user): mixed
    {
        return $user->isSuper;
    }

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view the model
     *
     * @param User $user
     * @param User $targetUser
     * @return mixed
     */
    public function view(User $user, User $targetUser): mixed
    {
        return $user->isSuper;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user): mixed
    {
        return $user->isSuper;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @param User $targetUser
     * @return mixed
     */
    public function create(User $user, User $targetUser ): mixed
    {

        return $user->isSuper;
//
//        if (!$targetUser->isDirty('admin')) {
//            return true;
//        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $targetUser
     * @return mixed
     */
    public function update(User $user, User $targetUser ): mixed
    {
        return $user->isSuper;
//            return Auth::user()->is($targetUser);
        }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $targetUser
     * @return bool
     */
    public function delete(User $user, User $targetUser ): bool
    {
        if ($targetUser->isSuper){
            return false;
        }
        return Auth::user()->is($targetUser);
    }
}
