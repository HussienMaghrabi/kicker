<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee_attendance extends Model
{
    protected $table = "attendance";
    protected $fileablle = ['employee_id','from_time','too_time','location'];
}
