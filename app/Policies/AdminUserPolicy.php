<?php

namespace App\Policies;

use App\Models\AdminUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AdminUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user has higher-privileged ability.
     *
     * @param User $user
     * @return Response| bool
     */
    public function before(User $user):Response|bool
    {
        return $user->isSuper;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->isSuper;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @return Response|bool
     */
    public function view(User $user): Response|bool
    {
        return $user->isSuper;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return (bool) $user->adminUser->is_admin;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @return Response|bool
     */
    public function update(User $user): Response|bool
    {
        return (bool) $user->adminUser->is_admin;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param AdminUser $adminUser
     * @return Response|bool
     */
    public function delete(User $user, AdminUser $adminUser): Response|bool
    {
        return (bool) $user->adminUser->is_admin;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param AdminUser $adminUser
     * @return Response|bool
     */
//    public function restore(User $user, AdminUser $adminUser)
//    {
//        //
//    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param AdminUser $adminUser
     * @return Response|bool
     */
//    public function forceDelete(User $user, AdminUser $adminUser)
//    {
//        //
//    }
}
