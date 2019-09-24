<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee_request extends Model
{
    protected $table = "employee_request";
    protected $fillable = ['employee_id','request_status_id','request_type_id','note'];

    static function AllEmpRequest(){
        return employee_request::all();
    }
    public function employee(){
        return $this->belongsTo('App\Employee');
    }
}
