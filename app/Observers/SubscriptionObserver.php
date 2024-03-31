<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Models\Subscription;
use App\Traits\HasLoggableUpdates;

class SubscriptionObserver
{
    use HasLoggableUpdates;

    protected $groupName = 'Xizmat';
    protected $groupType = Invoice::class;

    public function created(Subscription $subscription)
    {
        $this->setGroupTypeId($subscription->invoice_id);
    }

    public function updated(Subscription $subscription)
    {
        $this->setGroupTypeId($subscription->invoice_id);
    }
}
