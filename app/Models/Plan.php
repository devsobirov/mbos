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

    const STATUS_ACTIVE = 1;
    const STATUS_CLOSED = 2;
    const STATUS_CANCELLED = 3;
    const STATUS_DEACTIVE = 4;

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
        self::STATUS_DEACTIVE => [
            'name' => 'Deaktiv',
            'style' => 'bg-warning text-white'
        ]
    ];

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

    public static function getOrNew($id = null): self
    {
        return $id
            ? self::findOrFail($id)
            : new self();
    }

}
