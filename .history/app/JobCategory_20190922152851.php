<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    protected $table = "job_categories";
    protected $fileable = ['_token','en_name','ar_name','en_descraption','ar_descraption'];

    static function All_Categories(){
        return JobCategory::paginate(100);
    }
    public function job_title(){
        return $this->hasMany('App\JobTitle','job_category_id');
    }
    public function applications(){
        return $this->hasMany('App\Application','job_category_id');
    }

}
