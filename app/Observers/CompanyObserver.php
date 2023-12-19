<?php

namespace App\Observers;

use App\Events\CompanyCreated;
use App\Events\CompanyUpdated;
use App\Exceptions\ExistsRelationException;
use App\Models\Company;
use App\Models\CompanyOffice;
use App\Models\CompanyUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CompanyObserver
{
    public function creating(Company $company): void
    {
        Log::info("creating company {$company->name}");
    }

    public function created(Company $company): void
    {
        Log::info("created company {$company->name}, id {$company->id}");
//        CompanyCreated::dispatch($company);
    }

    /**
     * Handle the Company "updated" event.
     *
     * @param Company $company
     * @return void
     */
    public function updated(Company $company): void
    {
        if (Auth::user()->cannot('update', $company)) {
            abort(403);
        }
        Log::info("Updated company {$company->name}, id {$company->id}");
//        CompanyUpdated::dispatch($company);
    }

    /**
     * Handle
     *
     * @param Company $company
     * @return void
     */
    public function saved(Company $company): void
    {
        Log::info("Saved company {$company->name}, id {$company->id}");
    }

    /**
     * @param Company $company
     * @return void
     */
    public function restored(Company $company): void
    {
        Log::info("Restored company {$company->name}");
    }

    /**
     * Handle the Company "deleting" event.
     *
     * @param Company $company
     * @return void
     * @throws ExistsRelationException
     */
    public function deleting(Company $company): void
    {
        if (Auth::user()->cannot('delete', $company)) {
            abort(403);
        }

        if ($company->users()->exists() || $company->companyOffices()->exists())
        {
            throw new ExistsRelationException('The Company cannot be deleted due to existence of related resources');
        }
//
//        \DB::transaction(function () use ($company){
//            CompanyUser::findCompany($company)->each(function ($companyUser){$companyUser->delete();});
//            CompanyOffice::findOffice($company)->each(function ($office){$office->delete();});
//        });
//dd($company);
        Log::info("Deleted user {$company->name}, id {$company->id}" );
    }

    /**
     * Handle the Company ""deleted" event
     *
     * @param Company $company
     * @return void
     */
    public function deleted(Company $company){
        Log::info("Deleted company {$company->name}, id {$company->id}" );
    }
}
