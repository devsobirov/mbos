<?php

namespace App\Observers;

use App\Helpers\LogTypeHelper;
use App\Models\Invoice;
use App\Traits\HasLoggableUpdates;
use Illuminate\Support\Str;

class InvoiceObserver
{
    use HasLoggableUpdates;

    protected $groupName = 'Shartnoma';
    protected $groupType = Invoice::class;

    public function creating(Invoice $invoice)
    {
        $invoice->number = strtoupper(Str::random(6));
    }

    public function created(Invoice $invoice)
    {
        $this->logEvent($this->groupName. ' ID: '.$invoice->id. ', #'. $invoice->number.' yaratildi', $invoice, LogTypeHelper::TYPE_SUCCESS);
    }

    public function updated(Invoice $invoice)
    {
        $this->logEvent($this->groupName. ' ID: '.$invoice->id.', #'. $invoice->number.' tahrirlandi', $invoice, LogTypeHelper::TYPE_WARNING, true);
    }
}
