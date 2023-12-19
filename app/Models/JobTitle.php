<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JobTitle extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    /**
     * @return BelongsToMany<User>
     */
    public function users(): BelongsToMany
    {
        return $this->BelongsToMany(User::class);
    }
}
