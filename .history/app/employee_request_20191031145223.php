<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class employee_request extends Model
{
    protected $table = "employee_request";
    protected $fillable = ['employee_id','request_status_id','request_type_id','note'];

    static function AllEmpRequest(){
        $requests = DB::table('employee_request as emp_request')
        ->leftJoin('employees as employee','emp_request.employee_id','=','employee.id')
        ->leftJoin('request_status as req_status','emp_request.request_status_id','=','req_status.id')
        ->leftJoin('request_type as req_type','emp_request.request_type_id','=','req_type.id')
        ->select('emp_request.id as id','emp_request.note','employee.en_first_name as first_name','employee.en_last_name as last_name','employee.email','req_status.name as status_name','req_type.name as type_name','emp_request.date_from as from','emp_request.date_too as too','emp_request.created_at','emp_request.updated_at')
        ->orderBy('emp_request.id','DESC')
        ->get();
        return $requests;
    }

    static function getSingleRequest($id){
        $requests = DB::table('employee_request as emp_request')
        ->leftJoin('employees as employee','emp_request.employee_id','=','employee.id')
        ->leftJoin('request_status as req_status','emp_request.request_status_id','=','req_status.id')
        ->leftJoin('request_type as req_type','emp_request.request_type_id','=','req_type.id')
        ->select('emp_request.id as id','employee.en_first_name as first_name','employee.en_last_name as last_name','employee.email','req_status.name as status_name','req_type.name as type_name','emp_request.date_from as from','emp_request.date_too as too','emp_request.request_status_id as status_id')
        ->where('emp_request.id',$id)
        ->get();
        return $requests;
    }

    static function SingleEmployeeRequest($id)
    {
        $employeeRequest = DB::table('employee_request as emp_request')
        ->leftJoin('employees as employee','emp_request.employee_id','=','employee.id')
        ->leftJoin('request_status as req_status','emp_request.request_status_id','=','req_status.id')
        ->leftJoin('request_type as req_type','emp_request.request_type_id','=','req_type.id')
        ->select('emp_request.id as id','employee.en_first_name as first_name','employee.en_last_name as last_name','employee.email','req_status.name as status_name','req_type.name as type_name','emp_request.date_from as from','emp_request.date_too as too','emp_request.request_status_id as status_id','emp_request.note','emp_request.days')
        ->where('employee.id',$id)
        ->get();

        return $employeeRequest;
    }

    static function getemployeereqest($id)
    {
        $employee_request = employee_request::find($id);
        return response()->json([
            'messege' => 'success',
            'data' => $employee_request,
        ],200);
    }

    public function employee(){
        return $this->belongsTo('App\Employee');
    }
}
