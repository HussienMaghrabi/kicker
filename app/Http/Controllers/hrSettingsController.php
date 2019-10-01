<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\hrSettings;
use \App\work_info;
use \App\weekends;

class hrSettingsController extends Controller
{
    public function index()
    {
        $hr = new hrSettings;
        return $hr->getAll();
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $hr = hrSettings::first();
        $hr->annual_vacation = $request->annual_vacation;
        $hr->update();
        $info = work_info::first();
        $info->days = $request->days;
        $info->hours = $request->hours;
        $info->work_start = $request->work_start;
        $info->work_end = $request->work_end;
        $info->update();

        foreach ($request->weeks as $week) {
            $days = json_decode($week);
            foreach ($days as $day) {
                $NewDay = weekends::find($day->id);
                $NewDay->day = $day->day;
                $NewDay->status = 1;
                $NewDay->status = $day->status;
                $NewDay->update();
            }
            return "Update my hr setting";
        }
    }
}
