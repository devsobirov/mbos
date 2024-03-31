<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = false;

    protected $casts = [
        'next_payment_date' => 'datetime',
    ];

    const STATUS_DRAFT = 1;
    const STATUS_PENDING = 3;
    const STATUS_ACTIVE = 5;
    const STATUS_CLOSED = 10;
    const STATUS_CANCELLED = 15;

    const STATUSES = [
        self::STATUS_ACTIVE => [
            'name' => 'aktiv',
            'style' => 'bg-success'
        ],
        self::STATUS_CLOSED => [
            'name' => 'yakunlangan',
            'style' => 'bg-secondary'
        ],
        self::STATUS_CANCELLED => [
            'name' => 'Bekor qilingan',
            'style' => 'bg-danger'
        ],
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id')->withTrashed();
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'invoice_id', 'id')->orderByDesc('id');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'invoice_id', 'id')->orderByDesc('id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'invoice_id');
    }

    public function lastPayment(): HasOne
    {
        return $this->hasOne(Payment::class, 'invoice_id')->latest();
    }

    public function calculateUnpaidAmount(): int
    {
        //return $this->lastPayment ? $this->lastPayment->left_amount : $this->total_cost;
        return  $this->total_cost - $this->payments()->sum('amount');
    }

    public function getStatusName(): string
    {
        if (array_key_exists($this->status, self::STATUSES)) {
            return ucfirst(self::STATUSES[$this->status]['name']);
        }

        return 'Noma\'lum';
    }

    public function getStatusClass(): string
    {
        if (array_key_exists($this->status, self::STATUSES)) {
            return self::STATUSES[$this->status]['style'];
        }
        return '';
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }
}
