<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\Actionable;
use Laravel\Nova\Fields\Searchable;
use Laravel\Sanctum\HasApiTokens;

const LOGFILE = 'db.log';

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use \Illuminate\Auth\Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
    use HasApiTokens, HasFactory, Notifiable;
    use Actionable, Searchable;

    public function routeNotificationForLog (User $notifiable): string
    {
        return 'identifier-from-notification-for-log: User ID: ' . $this->name. ' was created';
    }
//    public function routeNotificationForSlack() : string
//    {
////        return 'https://hooks.slack.com/services/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';
//    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'activation_code',
        'email_verified',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
//    protected $casts = [
//        'email_verified_at' => 'datetime',
//        'admin' => 'bool',
//    ];

    public function findForPassport(string $email): User|null
    {
        return $this->where(['email' => $email, 'email_verified' => 'true'])->first();
    }

    public function validateForPassportPasswordGrant(string $password): bool
    {
        return Hash::check($password, $this->password);
    }

    /**
     * @param string $password
     * @return void
     */
    public function setPasswordAttribute(string $password): void       //mutator
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function getIsSuperAttribute(): bool
    {
        return in_array($this->email, config('app.superadmins'));
    }

    /**
     * @return BelongsToMany<Company>
     */
    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class)
            ->using(CompanyUser::class)
            ->withPivot(['job_title_id', 'salary', 'holiday', 'company_office_id']);
    }

    public function cars(): BelongsToMany
    {
        return $this->belongsToMany(Car::class)
            ->using(CarUser::class)
            ->withPivot(['start', 'end']);
    }

    public function adminUser(): HasOne {

        return $this->hasOne(AdminUser::class);
    }

    public function scopeExcept(Builder $query, User $user): Builder
    {
        return $query->where('id', '!=', $user->id);
    }

    public function scopeNameFilter(Builder $query, string $term): Builder{
        return $query->where('name', 'like', '%'.$term.'%');
    }

    public function scopeEmailFilter(Builder $query, string $email):Builder
    {
        return $query->where('email', 'like', '%' .$email. '%' );
    }

    public function scopeFindUser(Builder $query, string $userId): Builder
    {
        return $query->where('id', $userId);

    }

}
