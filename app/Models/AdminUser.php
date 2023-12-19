<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_admin',
    ];

//    protected $guarded = [];
//    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

//    public function scopeFindAdmin($query, User $user){
//        return $query->where('user_id', $user->id);
//    }

}
