<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisibilityGroup extends Model
{
    protected $fillable = ['name', 'description', 'parent_id'];

    protected $casts = [
        'parent_id' => 'integer',
    ];

    public function parent()
    {
        return $this->belongsTo(VisibilityGroup::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(VisibilityGroup::class, 'parent_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_visibility_group');
    }
}
