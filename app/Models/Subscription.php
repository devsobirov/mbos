<?php

namespace App\Models;

use App\Traits\SubscriptionItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Subscription extends Model
{
    use HasFactory, SubscriptionItem;

    protected $guarded = false;
    protected $with = ['plan:id,name,unit_id'];
    protected $casts = [
        'start_date' => 'datetime',
        'expire_date' => 'datetime',
        'cancelled_at' => 'datetime'
    ];

    public function getLeftDaysAttribute(): string
    {
        $daysLeft = null;
        if ($this->status != Plan::STATUS_ACTIVE) return '';

        if (!$this->lifetime && isset($this->expire_date)) {
            // Calculate the difference in days
            $daysLeft = Carbon::now()->diffInDays($this->expire_date);
        }

        switch (true) {
            case $daysLeft > 0:
                return "$daysLeft kundan so'ng";
            case $daysLeft < 0:
                return "$daysLeft kun oldin";
            case $daysLeft === 0:
                return "Bugun tugaydi";
            default:
                return "";
        }
    }
}
