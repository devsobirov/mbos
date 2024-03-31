<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Models\Service;
use App\Traits\HasLoggableUpdates;

class ServiceObserver
{
    use HasLoggableUpdates;

    protected $groupName = 'Xizmat';
    protected $groupType = Invoice::class;

    public function created(Service $service)
    {
        $this->setGroupTypeId($service->invoice_id);
    }

    public function updated(Service $service)
    {
        $this->setGroupTypeId($service->invoice_id);
    }
}
