<?php

namespace App\Models;

use App\Traits\HasPaymentType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory, HasPaymentType;

    protected $guarded = false;
    protected $casts = [
        'payment_for_date' => 'datetime'
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getStatusName(): string
    {
        $paymentForDate = Carbon::parse($this->payment_for_date);
        $createdAt = Carbon::parse($this->created_at);

        if ($paymentForDate->lessThan($createdAt)) {
            $daysLate = $createdAt->diffInDays($paymentForDate);
            return "{$daysLate} kunga kechikkan"; // late for 'n' days
        } elseif ($paymentForDate->greaterThan($createdAt)) {
            $daysEarlier = $paymentForDate->diffInDays($createdAt);
            return "{$daysEarlier} kun oldin"; // earlier for 'n' days
        } else {
            return 'vaqtida'; // on time
        }
    }

    public function getStatusClass(): string
    {
        $paymentForDate = Carbon::parse($this->payment_for_date);
        $createdAt = Carbon::parse($this->created_at);

        if ($paymentForDate->lessThan($createdAt)) {
            return 'bg-danger'; // late
        } else {
            return 'bg-success'; // on time or earlier
        }
    }
}
