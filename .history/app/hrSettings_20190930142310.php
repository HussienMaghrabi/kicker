<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class hrSettings extends Model
{
    protected $table = "hr_new_settings";
    
    public function getAll(){
        $HRData = DB::table('work_information')
        ->leftJoin('hr_setting','work_information.id','=','hr_setting.work_info_id')
        ->select('hr_setting.id as id','hr_setting.annual_vacation','work_information.days','work_information.hours','work_information.work_start','work_information.work_end')
        ->get();
        return response()->json($HRData);
    }
}
