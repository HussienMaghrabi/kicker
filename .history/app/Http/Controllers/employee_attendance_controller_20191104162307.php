<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\employee_attendance;
use \App\hrSettings;
use \App\attendaceReport;
use \App\Setting;
use \App\work_info;
use DB;

class employee_attendance_controller extends Controller
{
    public function saveemployeeattendance(Request $request){
        // dd($request->all());
        $employeeAttendance = new employee_attendance;
        $employeeAttendance->employee_id = $request->employee_id;
        $employeeAttendance->long = $request->long;
        $employeeAttendance->lat = $request->lat;
        $employeeAttendance->save();
        if($employeeAttendance->id > 0){
            $updatetime = employee_attendance::find($employeeAttendance->id); //to get last inserted id
            $updatetime->attend_time = date_format($employeeAttendance->created_at,'H:i:00');
            $updatetime->update();

            // compare time late or early or in time
            $getLocation = Setting::select('lat','lng')->first();
            $uperLat = $getLocation->lat = $getLocation->lat + 0.0000000000005;
            $downLat = $getLocation->lat = $getLocation->lat - 0.0000000000005;
            $uperlng = $getLocation->lng = $getLocation->lng + 0.0000000000005;
            $downlang = $getLocation->lng = $getLocation->lng - 0.000000000005;

            // dd($getLocation);
            $workInfo = work_info::first();
            $HRWorkStartTime = $workInfo->work_start;
            $storeReport = new attendaceReport;
            $storeReport->attendance_id = $employeeAttendance->id;
            if($updatetime->attend_time > $HRWorkStartTime){
                $storeReport->date_status = 'late';
            }elseif ($updatetime->attend_time = $HRWorkStartTime) {
                $storeReport->date_status = 'in_time';
            }else{
                $storeReport->date_status = 'early';
            }
            if($updatetime->lat > $downLat AND $updatetime->lat < $uperLat AND $updatetime->lng > $downlang AND $updatetime->lng < $uperlng){
                $storeReport->location == 'in';
            }else{
                $storeReport->location == 'out';
            }
            $storeReport->save();
        }
        return response()->json("Attendance Added");
    }
    public function reportAllAttendance()
    {
        $allAtendance = DB::table('attendance')
        ->leftJoin('employees as employee','attendance.employee_id','=','employee.id')
        ->leftJoin('attendance_report as report','report.attendance_id','=','attendance.id')
        ->select('attendance.id as id','attendance.attend_time as from_time','attendance.created_at','employee.en_first_name','employee.en_last_name','employee.email','report.location','report.date_status')
        ->get();
        return $allAtendance;
    }
    public function StoreByEx(Request $request)
    {
        // dd('sa');
        $getLocation = Setting::select('lat','lng')->first();        
        if($request->hasFile('Employee_Sheet')){
            $path = $request->file('Employee_Sheet')->getRealPath();
            $data = \Excel::load($path)->get();
            if($data->count()){
                // dd($data);
                foreach ($data as $key => $value) {
                    $arr[] = ['employee_id' => $value->employee_id, 'attend_time' => $value->time, 'date'=>$value->date, 'long'=> $getLocation->lng ,'lat'=> $getLocation->lat];
                }
                dd($arr);
                if(!empty($arr)){
                    \DB::table('attendance')->insert($arr);
                    // dd('Insert Record successfully.');
                    return response()->json('Insert Record successfully',200);
                }
            }
        }
    }
    public function export_xsl(Request $request)
    {
        dd($request->all());
    }
}
