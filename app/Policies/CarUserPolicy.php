<?php

namespace App\Policies;

use App\Models\CarUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CarUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user has higher-privileged ability.
     *
     * @param User $user
     * @return Response|bool
     */
    public function before(User $user): Response|bool
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
     * @param CarUser $carUser
     * @return Response|bool
     */
    public function view(User $user, CarUser $carUser): Response|bool
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
        return $user->isSuper;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param CarUser $carUser
     * @return Response|bool
     */
    public function update(User $user, CarUser $carUser): Response|bool
    {
        return $user->isSuper;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param CarUser $carUser
     * @return Response|bool
     */
    public function save(User $user, CarUser $carUser): Response|bool
    {
        return $user->isSuper;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param CarUser $carUser
     * @return Response|bool
     */
    public function delete(User $user, CarUser $carUser): Response|bool
    {
        return $user->isSuper;
    }
}
