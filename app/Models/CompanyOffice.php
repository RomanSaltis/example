<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyOffice extends Model
{
    use HasFactory;

    protected $guarded = [];
//    public $timestamps = false;

public function company(): BelongsTo{
    return $this->belongsTo(Company::class);
}
//public function scopeFindOffice($query, Company $company){
//    return $query->where('company_id', '=', $company->id);
//}

}
