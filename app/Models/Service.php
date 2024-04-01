<?php

namespace App\Models;

use App\Traits\SubscriptionItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory, SubscriptionItem;

    protected $with = ['plan:id,name,unit_id'];
    protected $guarded = false;
    protected $casts = ['cancelled_at' => 'datetime'];
}
