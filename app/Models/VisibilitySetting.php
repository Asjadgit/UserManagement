<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lead; // Add this
use App\Models\Deal; // Add this

class VisibilitySetting extends Model
{
    protected $fillable = ['user_id', 'visibility_group_id', 'item_type', 'visibility','item_id'];

    protected $casts = [
        'user_id' => 'integer',
        'visibility_group_id' => 'integer',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Visibility Group
    public function visibilityGroup()
    {
        return $this->belongsTo(VisibilityGroup::class);
    }

    public function item()
    {
        return $this->morphTo();
    }
}
