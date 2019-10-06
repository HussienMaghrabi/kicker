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
        ->get();
        return $EmployeeGross;
    }
}
