<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class nationalVication extends Model
{
    protected $table = "national_vacation";
    protected $fillable = ['en_name','ar_name','days','natoial_vacation_type_id','from','to'];

    public function GetAll()
    {
        $Nationalvacation = DB::table('national_vacation as n_vacation')
        ->leftJoin('vacation_type as v_tayeb','n_vacation.natoial_vacation_type_id','=','v_tayeb.id')
        ->orderBy('n_vacation.id','DESC')
        ->get();
        return $Nationalvacation;
    }
}
