<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    //

    public function contact(){
        return $this->hasMany('App\DeveloperContact');
    }
    public function projects(){
        return $this->hasMany('App\Project');
    }

   
}
