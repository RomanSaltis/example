<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Carbon\Carbon;

class CarUser extends Pivot
{
    use HasFactory;

//    public $timestamps = false;

    protected $guarded = [];

    public function setStartAttribute() : string           //mutator
    {
       return $this->attributes['start'] = Carbon::now();
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
