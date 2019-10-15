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
        ->select('n_vacation.id as id','n_vacation.created_at','n_vacation.updated_at','n_vacation.en_name','n_vacation.ar_name','n_vacation.days','n_vacation.natoial_vacation_type_id','n_vacation.from','n_vacation.to','v_tayeb.name')
        ->orderBy('n_vacation.id','DESC')
        ->take(5)
        ->get();
        return $Nationalvacation;
    }
}
