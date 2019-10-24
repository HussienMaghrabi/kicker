<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\employee_attendance;

class employee_attendance_controller extends Controller
{
    public function saveemployeeattendance(Request $request){
        // dd($request->all());
        $employeeAttendance = new employee_attendance;
        $employeeAttendance->employee_id = $request->employee_id;
        $employeeAttendance->from_time = $request->date;
        $employeeAttendance->save();
        return response()->json("Attendance Added");
    }
}
