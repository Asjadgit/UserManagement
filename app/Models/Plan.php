<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'active',
        'name',
        'price',
        'currency',
        'frequency',
        'is_featured',
        'trial_days',
        'is_free',
        'stripe_product_id',
        'features',
        'type',
    ];

    protected $casts = [
        'features' => 'array',
    ];
}
