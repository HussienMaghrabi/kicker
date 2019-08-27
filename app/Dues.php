<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dues extends Model
{
    protected $fillable = ['value','date','collected'];
}
