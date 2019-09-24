<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vacancy_type extends Model
{
    protected $table = "vacation_type";
    protected $fillable = ['name'];

    static function vacancyType(){
        return vacancy_type::paginate(100);
    }
    static function All_types(){
        return vacancy_type::all();
    }
}
