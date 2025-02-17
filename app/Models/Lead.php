<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = ['name'];

    public function visibilityAssignments()
    {
        return $this->morphMany(VisibilityAssignment::class, 'items');
    }
}
