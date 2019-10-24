<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\employee_attendance;
use DB;

class employee_attendance_controller extends Controller
{
    public function saveemployeeattendance(Request $request){
        // dd($request->all());
        $employeeAttendance = new employee_attendance;
        $employeeAttendance->employee_id = $request->employee_id;
        // $employeeAttendance->from_time = $request->date;
        $employeeAttendance->long = $request->long;
        $employeeAttendance->lat = $request->lat;
        $saved = $employeeAttendance->save();
        if($employeeAttendance->id > 0){
            $updatetime = employee_attendance::find($employeeAttendance->id); //to get last inserted id
            // dd(date_format($updatetime->created_at,'H:i:s'));
            $updatetime->from_time = date_format($employeeAttendance->created_at,'H:i:s');
            $updatetime->update();
        }
        return response()->json("Attendance Added");
    }
    public function reportAllAttendance()
    {
        $allAtendance = DB::table('attendance')
        ->leftJoin('employees as employee','attendance.employee_id','=','employee.id')
        ->select('attendance.id as id','attendance.from_time','attendance.too_time','attendance.created_at','employee.en_first_name','employee.en_last_name','employee.email')
        ->get();
        return $allAtendance;
    }
}
