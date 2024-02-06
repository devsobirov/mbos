<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = false;

    protected $casts = [
        'start_date' => 'datetime',
        'expire_date' => 'datetime',
        'next_payment_date' => 'datetime',
    ];

    const STATUS_DRAFT = 1;
    const STATUS_PENDING = 3;
    const STATUS_ACTIVE = 5;
    const STATUS_ARCHIVE = 10;

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id')->withTrashed();
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id')->withTrashed();
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'invoice_id');
    }

    public function getLeftDaysAttribute(): string
    {
        $daysLeft = null;
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
