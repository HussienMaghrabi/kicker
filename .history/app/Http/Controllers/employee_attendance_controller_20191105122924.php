<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\employee_attendance;
use \App\hrSettings;
use \App\attendaceReport;
use \App\Setting;
use \App\Employee;
use \App\work_info;
use DB;
use Excel;
use \Carbon\Carbon;

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
        $data = array();
        $countEmployee = '';
        $countDate = '';
        $employee = Employee::select('id','en_first_name','en_middle_name','en_last_name')->get()->toArray();
        $countEmployee = count($employee);
        // Specify the start date. This date can be any English textual format  
        $date_from = $request->From;
        $date_from = strtotime($date_from); // Convert date to a UNIX timestamp  
        
        // Specify the end date. This date can be any English textual format  
        $date_to = $request->To;  
        $date_to = strtotime($date_to); // Convert date to a UNIX timestamp  
        
        // Loop from the start date to end date and output all dates inbetween  
        for ($i=$date_from; $i<=$date_to; $i+=86400) {  
            // echo date("Y-m-d", $i).'<br />';
            $data[] = date("Y-m-d", $i);
        }
        // dd($data);
        foreach ($data as $date) {
            $command[$date] = $employee;
        }
        $countDate = count($data);
        dd($command);
        Excel::create('Attendance_Cheet', function ($excel) use ($command,$data,$employee,$countDate,$countEmployee) {
            $excel->sheet('Attendance', function ($sheet) use ($command,$data,$employee,$countDate,$countEmployee) {
                $sheet->loadView('admin.employee.attendance_cheet',['AllData'=>$command,'dateArray' => $data,'employees' => $employee , 'countDate' => $countDate , 'countEmployee' => $countEmployee]);
            });
        })->export('xls');
    }
}
