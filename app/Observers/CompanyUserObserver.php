<?php

namespace App\Observers;
use App\Events\CompanyUserCreatedEvent;
use App\Exceptions\ExistsRelationException;
use App\Exceptions\InvalidInputException;
use App\Models\CompanyOffice;
use App\Models\CompanyUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CompanyUserObserver
{
    /**
     * Handle the CompanyUserObserver "creating" event
     *
     * @param CompanyUser $companyUser
     * @return void
     * @throws InvalidInputException
     */
    public function creating(CompanyUser $companyUser): void
    {
        if (CompanyUser:: where(['user_id' => $companyUser['user_id'], 'company_id' => $companyUser['company_id']])->exists()){
            throw new InvalidInputException(
                ' User ' .$companyUser->user->name. ' already works for company ' .$companyUser->company->name);
        }
        Log::info("CompanyUserObserver info: Creating User Id {$companyUser->user_id} joined Company Id {$companyUser->company_id}");
    }

    /**
     * Handle the CompanyUserObserver "creating" event
     *
     * @param CompanyUser $companyUser
     * @return void
     */
    public function created(CompanyUser $companyUser): void
    {
        Log::info("CompanyUserObserver info: Created User Id {$companyUser->user_id} joined Company Id {$companyUser->company_id}");
        CompanyUserCreatedEvent::dispatch($companyUser);
    }

//    public function updating(CompanyUser $companyUser){
//    }

    /**
     * Handle the CompanyUserObserver "updated" event
     *
     * @param CompanyUser $companyUser
     * @return void
     */
    public function updated(CompanyUser $companyUser): void
    {
        Log::info("CompanyUserObserver info: Updated User Id {$companyUser->user_id} joined Company Id {$companyUser->company_id}");
    }

    /**
     * Handle the CompanyUserObserver "saved" event
     *
     * @param CompanyUser $companyUser
     * @return void
     */
    public function saved(CompanyUser $companyUser):void
    {
        Log::info("CompanyUserObserver info: Saved User Id {$companyUser->user_id} joined Company Id {$companyUser->company_id}");
    }

    /**
     * Handle the CompanyUserObserver "restored" event
     *
     * @param CompanyUser $companyUser
     * @return void
     */
    public function restored(CompanyUser $companyUser):void
    {
        Log::info("CompanyUserObserver info: Restored User Id {$companyUser->user_id} joined Company Id {$companyUser->company_id}");
    }

    /**
     * Handle the CompanyUserObserver "deleting" event
     *
     * @param CompanyUser $companyUser
     * @return void
     * @throws ExistsRelationException
     */
//    public function deleting(CompanyUser $companyUser):void
//    {
//        if (Auth::user()->cannot('delete', $companyUser)) {
//            abort(403);
//        }
////        if ($companyUser->company()->users()->exists())
////        {
////            throw new ExistsRelationException('The CompanyUser cannot be deleted due to existence of related resources');
////        }
//    }

    /**
     * Handle the CompanyUserObserver "delete" event
     *
     * @param CompanyUser $companyUser
     * @return void
     */
    public function deleted(CompanyUser $companyUser): void
    {
        Log::info("CompanyUserObserver info: Deleted User Id {$companyUser->user_id} joined Company Id  {$companyUser->company_id}");
    }
}
