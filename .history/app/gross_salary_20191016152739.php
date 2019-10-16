<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class gross_salary extends Model
{
    protected $table = "create_gross_salary";
    protected $fillable = ['employee_id','details','date','allowanes','order_by'];

    static function report()
    {
        $EmployeeGross = DB::table('create_gross_salary as g_salary')
        ->leftjoin('employees as employee','g_salary.employee_id','=','employee.id')
        ->orderBy('g_salary.id','DESC')
        ->select('g_salary.id as id','g_salary.details','g_salary.date','g_salary.allowanes','g_salary.order_by','employee.en_first_name','employee.en_last_name','employee.email','employee.salary')
        ->get();
        return $EmployeeGross;
    }
    static function sDetails($id){
        $EmployeeGrossDetails = DB::table('create_gross_salary as g_salary')
        ->leftjoin('employees as employee','g_salary.employee_id','=','employee.id')
        ->orderBy('g_salary.id','DESC')
        ->where('g_salary.employee_id',$id)
        ->get();
        return $EmployeeGrossDetails;
    }
}
