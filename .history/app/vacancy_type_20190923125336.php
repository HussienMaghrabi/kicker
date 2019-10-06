<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vacancy_type extends Model
{
    protected $table = "vacation_type";
    protected $fillable = ['name'];
}
