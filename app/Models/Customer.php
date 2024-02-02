<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function scopeSearch(Builder $query, $search = '')
    {
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('id', $search)
                    ->orWhere('name', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }
    }

    public static function getOrNew($id = null): self
    {
        return $id
            ? self::findOrFail($id)
            : new self();
    }
}
