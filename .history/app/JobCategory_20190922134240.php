<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    protected $table = "job_categories";
    protected $fileable = ['en_name','ar_name','en_descraption','ar_descraption'];

    static function all_Categories(){
        dd(JobCategory::all());
    }
    public function job_title(){
        return $this->hasMany('App\JobTitle','job_category_id');
    }
    public function applications(){
        return $this->hasMany('App\Application','job_category_id');
    }

}
