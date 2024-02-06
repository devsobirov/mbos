<?php

namespace App\Observers;

use App\Helpers\LogTypeHelper;
use App\Models\Payment;
use App\Traits\HasLoggableUpdates;
use Illuminate\Support\Str;

class PaymentObserver
{
    use HasLoggableUpdates;

    protected $groupName = 'To\'lov';
    protected $groupType = Payment::class;


    public function created(Payment $payment)
    {
        $this->logEvent($this->groupName. ' ID: '.$payment->id. ', #'. $payment->number.' yaratildi', $payment, LogTypeHelper::TYPE_SUCCESS);
    }

    public function updated(Payment $payment)
    {
        $this->logEvent($this->groupName. ' ID: '.$payment->id.', #'. $payment->number.' tahrirlandi', $payment, LogTypeHelper::TYPE_WARNING, true);
    }
}
