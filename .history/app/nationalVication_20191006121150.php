<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class nationalVication extends Model
{
    protected $table = "national_vacation";
    protected $fillable = ['en_name','ar_name','days','natoial_vacation_type_id','from','to'];
}
