<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class deduction extends Model
{
    protected $table = "deductions"; 
    protected $fillable = ['employee_id','details','date','deduction','order_by'];

    static function getDeductionReport()
    {
        $report = DB::table('deductions as deduction')
        ->leftJoin('employees as employee','deduction.employee_id','=','employee.id')
        ->select('deduction.id as id','deduction.details','deduction.date','deduction.deduction','deduction.order_by','employee.en_first_name','employee.en_last_name','employee.email')
        ->get();
        return $report;
    }
}
