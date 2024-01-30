<?php

namespace App\Observers;

use App\Helpers\LogTypeHelper;
use App\Models\Customer;
use App\Traits\HasLoggableUpdates;

class CustomerObserver
{
    use HasLoggableUpdates;

    protected $groupName = 'Mijoz';
    protected $groupType = Customer::class;

    public function created(Customer $customer)
    {
        $this->logEvent($this->groupName. ' ID:'.$customer->id. ' yaratildi', $customer, LogTypeHelper::TYPE_SUCCESS);
    }

    public function updated(Customer $customer)
    {
        $this->logEvent($this->groupName. ' ID:'.$customer->id. ' tahrirlandi', $customer, LogTypeHelper::TYPE_WARNING, true);
    }

    public function deleted(Customer $customer)
    {
        $this->logEvent($this->groupName. ' ID:'.$customer->id. ' o\'chirildi', $customer, LogTypeHelper::TYPE_DANGER);
    }

    public function restored(Customer $customer)
    {
        $this->logEvent($this->groupName. ' ID:'.$customer->id. ' qayta tiklandi', $customer, LogTypeHelper::TYPE_DANGER);
    }
}
