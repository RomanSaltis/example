<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Collection<int, User> $users
 */
class Company extends Model
{
    use HasFactory;

//    protected $fillable = [
//        'name',
//        'user_id',
//    ];
    protected $guarded = [];
    protected $hidden = ['id'];
    public $timestamps = false;


    /**
     * @return BelongsToMany<User>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(CompanyUser::class)
            ->withPivot(['job_title_id', 'salary', 'holiday', 'company_office_id']);
    }

    /**
     * @return HasMany<CompanyOffice>
     */
    public function companyOffices(): HasMany
    {
        return $this->hasMany(CompanyOffice::class, 'company_id', 'id');
    }

    /**
     * @return HasMany<Car>
     */
    public function cars(): HasMany{
        return $this->hasMany(Car::class);
    }
}
