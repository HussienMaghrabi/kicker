<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vacancy extends Model
{
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
