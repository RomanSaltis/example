<?php

namespace App\Policies;

use App\Models\CompanyOffice;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CompanyOfficePolicy
{
    use HandlesAuthorization;

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
     * @param  \App\Models\CompanyOffice  $companyOffice
     * @return Response|bool
     */
    public function view(User $user, CompanyOffice $companyOffice): Response|bool
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
     * @param  \App\Models\CompanyOffice  $companyOffice
     * @return Response|bool
     */
    public function update(User $user, CompanyOffice $companyOffice): Response|bool
    {
        return $user->adminUser->is_admin;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param  \App\Models\CompanyOffice  $companyOffice
     * @return Response|bool
     */
    public function delete(User $user, CompanyOffice $companyOffice): Response|bool
    {
        return $user->isSuper;
    }
}
