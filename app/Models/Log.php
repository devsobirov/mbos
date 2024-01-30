<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeByType(Builder $query, $type)
    {
        if (is_numeric($type)) {
            $query->where('log_type', $type);
        }
    }

    public function scopeByGroup(Builder $query, $group)
    {
        if ($group) {
            $query->where('group_type', $group);
        }
    }

    public function scopeByUser(Builder $query, $userId)
    {
        if (is_numeric($userId)) {
            $userId = $userId ?: null;
            $query->where('user_id', $userId);
        }
    }

    public function scopeFromDate(Builder $query, $date)
    {
        if ($date) {
            $query->whereDate('created_at', '>=', $date);
        }
    }

    public function scopeToDate(Builder $query, $date)
    {
        if ($date) {
            $query->whereDate('created_at', '<=', $date);
        }
    }
}
