<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gross_salary extends Model
{
    protected $table = "create_gross_salary";
    protected $fillable = ['employee_id','details','date','allowanes','order_by'];
}
