<?php

namespace App\Policies;

use App\Models\JobTitle;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobTitlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->isSuper;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobTitle  $jobTitle
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, JobTitle $jobTitle)
    {
        return $user->isSuper;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->isSuper;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobTitle  $jobTitle
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, JobTitle $jobTitle)
    {
        return $user->isSuper;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\JobTitle  $jobTitle
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, JobTitle $jobTitle)
    {
        return $user->isSuper;
    }
}
