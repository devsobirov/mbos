<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = false;

    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class, 'project_id');
    }

    public static function getOrNew($id): self
    {
        return is_numeric($id)
            ? self::findOrFail($id)
            : new self();
    }

    public function logoUrl(): string
    {
        return asset($this->logo ?: 'logo.png');
    }
}
