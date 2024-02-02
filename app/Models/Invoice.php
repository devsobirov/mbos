<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = false;

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
}
