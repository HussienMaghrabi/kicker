<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vacancy extends Model
{
    protected $table = "";
    protected $fillable = ['en_name','ar_name','en_description','ar_description','status','job_title_id','vacancies_type_id'];
    static function vacancies(){
        return vacancy::paginate(100);
    }
    public function jobTitle(){
        return $this->belongsTo(JobTitle::class);
    }

    public function applications(){
        return $this->hasMany(Application::class);
    }

}
