<?php

namespace App\Models;

use App\Traits\SubscriptionItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory, SubscriptionItem;

    protected $guarded = false;
}
