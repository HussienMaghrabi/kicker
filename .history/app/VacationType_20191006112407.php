<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VacationType extends Model
{
    protected $table = "vacation_type";
    protected $fillable = ['name'];
}
