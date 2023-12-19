<?php

namespace App\Observers;

use App\Exceptions\InvalidInputException;
use App\Models\CompanyOffice;
use Illuminate\Support\Facades\Auth;

class CompanyOfficeObserver
{
    /**
     * Handle the CompanyOffice "created" event.
     *
     * @param  \App\Models\CompanyOffice  $companyOffice
     * @return void
     */

    public function creating(CompanyOffice $companyOffice){
        if (!isset($companyOffice ['name']) ){
            $companyOffice ['name'] = $companyOffice ['city'];

            if(CompanyOffice::where('name', '=', $companyOffice->name)->exists() ) {
                $companyOffice['name'] = $companyOffice['name'] . ' ' . $companyOffice['street'];

                if(CompanyOffice::where('name', '=', $companyOffice->name)->first() ) {
                    $companyOffice['name'] = $companyOffice['name'] . ' ' . $companyOffice['nr'];

                    if(CompanyOffice::where('name', '=', $companyOffice->name)->first()) {
                        throw new InvalidInputException("Please insert the name of the Company Office");
                    }
                }
            }
        }
        elseif (CompanyOffice::where(['name'=>$companyOffice->name, 'city' => $companyOffice->city, 'street' => $companyOffice->street, 'nr' => $companyOffice->nr, 'company_id' => $companyOffice->company_id])->exists()){
            throw new InvalidInputException(
                "The Office ".$companyOffice->name." with the address " .$companyOffice->street. " street, nr: " .$companyOffice->nr. " already exists, please enter a new unique value");
        }

    }

//    public function created(CompanyOffice $companyOffice)
//    {
//        //
//    }

    /**
     * Handle the CompanyOffice "updated" event.
     *
     * @param  \App\Models\CompanyOffice  $companyOffice
     * @return void
     */

    public function updating(CompanyOffice $companyOffice){
        if (Auth::user()->cannot('update', $companyOffice)){
            abort(404);
        }
    }

//    public function updated(CompanyOffice $companyOffice)
//    {
//        //
//    }

    /**
     * Handle the CompanyOffice "deleted" event.
     *
     * @param  \App\Models\CompanyOffice  $companyOffice
     * @return void
     */
//    public function deleted(CompanyOffice $companyOffice)
//    {
//        //
//    }

    /**
     * Handle the CompanyOffice "restored" event.
     *
     * @param  \App\Models\CompanyOffice  $companyOffice
     * @return void
     */
//    public function restored(CompanyOffice $companyOffice)
//    {
//        //
//    }

    /**
     * Handle the CompanyOffice "force deleted" event.
     *
     * @param  \App\Models\CompanyOffice  $companyOffice
     * @return void
     */
//    public function forceDeleted(CompanyOffice $companyOffice)
//    {
//        //
//    }
}
