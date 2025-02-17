<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public $timestamps =false;
    protected $fillable = ['country','currency','code','symbol','thousand_separator','decimal_separator'];
}
