<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisibilityAssignment extends Model
{
    public $table = 'visibility_assignments';

    protected $fillable = ['items_id','items_type','visibility_level_id'];

    public function items()
    {
        return $this->morphTo();
    }

    public function visibilitylevel()
    {
        return $this->belongsTo(VisibilityLevel::class,'visibility_level_id');
    }
}
