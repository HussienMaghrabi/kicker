<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class deduction extends Model
{
    protected $table = "deductions"; 
    protected $fillable = ['employee_id','details','date','deductions','order_by']; 
}
