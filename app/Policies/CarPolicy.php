<?php

namespace App\Policies;

use App\Exceptions\CarPriceException;
use App\Exceptions\CarUserException;
use App\Models\Car;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;

class CarPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user):Response|bool
    {
        return $user->isSuper;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Car $car
     * @return Response|bool
     */
    public function view(User $user, Car $car):Response|bool
    {
        return $user->isSuper;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user):Response|bool
    {
        return $user->isSuper;
    }

    /**
     * Determine whether the user can save models.
     *
     * @param User $user
     * @param Car $car
     * @return Response|bool
     */
    public function save(User $user, Car $car):Response|bool
    {
        return $user->isSuper;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Car $car
     * @return Response|bool
     */
    public function update(User $user, Car $car):Response|bool
    {
        return $user->isSuper;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Car $car
     * @return Response|bool
     */
    public function delete(User $user, Car $car):Response|bool
    {
            return $user->isSuper;
    }

}
