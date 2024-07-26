<?php

namespace App\Models\Traits\User;

use App\Enums\CustomerPlansBoardLimit as CustorePlans;

trait PlanAuthorization
{
    public function hasReachedFreeBoardLimit():bool
    {
        return $this->boards()->count() >= CustorePlans::FREE_PLAN->value;

        // example of magic numbers 
        return $this->boards()->count() >= 3;
    }

    public function hasNotReachedFreeBoardLimit():bool
    {
        return ! $this->hasReachedFreeBoardLimit();
    }
}