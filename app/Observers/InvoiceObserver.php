<?php

namespace App\Observers;

use App\Helpers\LogTypeHelper;
use App\Models\Invoice;
use App\Traits\HasLoggableUpdates;

class InvoiceObserver
{
    use HasLoggableUpdates;

    protected $groupName = 'Shartnoma';
    protected $groupType = Invoice::class;

    public function created(Invoice $invoice)
    {
        $this->logEvent($this->groupName. ' ID: '.$invoice->id. ' yaratildi', $invoice, LogTypeHelper::TYPE_SUCCESS);
    }

    public function updated(Invoice $invoice)
    {
        $this->logEvent($this->groupName. ' ID: '.$invoice->id. ' tahrirlandi', $invoice, LogTypeHelper::TYPE_WARNING, true);
    }
}
