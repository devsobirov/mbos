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
        'cancelled_at' => 'datetime',
        'deactivated_at' => 'datetime',
    ];


    public function getLeftDaysForHumanAttribute(): string
    {
        if ($this->status != Plan::STATUS_ACTIVE) return '';

        $daysLeft = $this->days_left;
        switch (true) {
            case $this->isOnGoing():
                return "$daysLeft kundan so'ng";
            case $this->isExpired():
                return "$daysLeft kun oldin";
            case $this->isExpiresToday():
                return "Bugun tugaydi";
            default:
                return "";
        }
    }

    public function getLeftDaysClassAttribute(): string
    {
        if ($this->status != Plan::STATUS_ACTIVE) return '';

        switch (true) {
            case $this->isOnGoing():
                return "bg-success";
            case $this->isExpired():
                return "bg-danger";
            case $this->isExpiresToday():
                return "bg-warning";
            default:
                return "";
        }
    }

    public function getDaysLeftAttribute(): ?int
    {
        $daysLeft = null;
        if (isset($this->expire_date)) {
            $daysLeft = Carbon::now()->diffInDays($this->expire_date, false);
        }
        return $daysLeft;

    }

    public function isExpired(): bool
    {
        return (in_array($this->status, [Plan::STATUS_ACTIVE, Plan::STATUS_DEACTIVE])) && $this->days_left && $this->days_left < 0;
    }

    public function isOnGoing(): bool
    {
        return $this->days_left && $this->days_left > 0;
    }

    public function isExpiresToday(): bool
    {
        return $this->days_left === 0;
    }

    public function canContinue(): bool
    {
        return in_array($this->status, [Plan::STATUS_ACTIVE, Plan::STATUS_DEACTIVE]);
    }
}
