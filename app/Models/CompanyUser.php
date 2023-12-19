<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Notifications\Notifiable;

class CompanyUser extends Pivot
{
    use Notifiable;
    public $timestamps = false;

//    public function car()
//    {
//        return $this->belongsToMany(Car::class, 'car_company_user', 'company_user_id', 'car_id')
//            ->using(CarCompanyUser::class)
//            ->withPivot(['start', 'end']);
//    }

    /**
     * @return BelongsTo<JobTitle, CompanyUser>
     */
    public function jobTitle(): BelongsTo{
        return $this->belongsTo(JobTitle::class);
    }

    /**
     * @return BelongsTo<User, CompanyUser>
     */
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Company, CompanyUser>
     */
    public function company(): BelongsTo{
        return $this->belongsTo(Company::class);
    }

//    public function scopeFindUser($query, User $user){
//        return $query->where('user_id', $user->id);
//    }

//    public function scopeFindCompany($query, Company $company){
//        return $query->where('company_id', '=', $company->id);
//    }

}
