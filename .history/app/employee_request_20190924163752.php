<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee_request extends Model
{
    protected $table = "employee_request";
    protected $fillable = ['employee_id','request_status_id','request_type_id','note'];

    static function AllEmpRequest(){
        $requests = DB::table('employee_request as emp_request')
        ->leftJoin('employees as employee','emp_request.employee_id','=','employee.id')
        ->leftJoin('request_status as req_status','emp_request.request_status_id','=','req_status.id')
        ->leftJoin('request_type as req_type','emp_request.request_type_id','=','req_type.id')
        ->select('emp_request.id as id','employee.en_first_name as first_name','employee.en_last_name as last_name','employee.email','req_status.name as status_name','req_type.name as type_name')
        ->get();
        // return employee_request::all();
    }
    public function employee(){
        return $this->belongsTo('App\Employee');
    }
}
