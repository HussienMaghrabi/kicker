<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Excel;

class Cil extends Model
{
    //
    public function lead()
    {
        return $this->belongsTo('App\Lead');
    }
    public function developer()
    {
        return $this->belongsTo('App\Developer');
    }
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getCilInfoXls($cil,$broker_name){
        $user = auth()->user();
        if($cil != null && $cil->developer != null){
            Excel::create($cil->id.'', function ($excel) use ($cil, $broker_name,$user) {
                $excel->sheet('campaign', function ($sheet) use ($cil, $broker_name,$user) {
                    $sheet->loadView('admin.cils.cil_info_xls', [
                        'cil' => $cil, 'broker_name' => $broker_name,'user' => $user
                    ]);
                });
            })->store('xls','uploads/cils_info_xls');
            $cilInfoXlsPath = 'uploads/cils_info_xls/'. $cil->id . '.xls';
            return $cilInfoXlsPath;
        }
        else{
            return '';
        }
    }

}
