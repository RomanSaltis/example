<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Car extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function user() : BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(CarUser::class)
            ->withPivot('start', 'end');
    }
}
