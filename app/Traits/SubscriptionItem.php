<?php


namespace App\Traits;


use App\Models\Invoice;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait SubscriptionItem
{
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    public function getStatusName(): string
    {
        if (array_key_exists($this->status, Plan::STATUSES)) {
            return ucfirst(Plan::STATUSES[$this->status]['name']);
        }

        return 'Noma\'lum';
    }

    public function getStatusClass(): string
    {
        if (array_key_exists($this->status, Plan::STATUSES)) {
            return Plan::STATUSES[$this->status]['style'];
        }
        return '';
    }
}
