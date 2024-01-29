<?php

namespace App\Models;

use App\Traits\HasUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory, HasUnit, SoftDeletes;

    protected $guarded = false;
    protected $casts = [
        'status' => 'boolean',
        'is_expirable' => 'boolean',
        'base_price' => 'integer',
        'base_amount' => 'integer',
        'per_extra_price' => 'integer',
        'per_extra_amount' => 'integer',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public static function getOrNew($plan_id = null): self
    {
        return $plan_id
            ? self::findOrFail($plan_id)
            : new self();
    }

}
