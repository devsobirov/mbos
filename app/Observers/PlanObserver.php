<?php

namespace App\Observers;

use App\Helpers\LogTypeHelper;
use App\Models\Plan;
use App\Traits\HasLoggableUpdates;

class PlanObserver
{
    use HasLoggableUpdates;

    protected $groupName = 'Tarif';
    protected $groupType = Plan::class;

    public function created(Plan $plan)
    {
        $this->logEvent($this->groupName. ' ID:'.$plan->id. ' yaratildi', $plan, LogTypeHelper::TYPE_SUCCESS);
    }

    public function updated(Plan $plan)
    {
        $this->logEvent($this->groupName. ' ID:'.$plan->id. ' tahrirlandi', $plan, LogTypeHelper::TYPE_WARNING, true);
    }

    public function deleted(Plan $plan)
    {
        $this->logEvent($this->groupName. ' ID:'.$plan->id. ' o\'chirildi', $plan, LogTypeHelper::TYPE_DANGER);
    }

    public function restored(Plan $plan)
    {
        $this->logEvent($this->groupName. ' ID:'.$plan->id. ' qayta tiklandi', $plan, LogTypeHelper::TYPE_DANGER);
    }

    public function forceDeleted(Plan $plan)
    {
        //
    }
}
