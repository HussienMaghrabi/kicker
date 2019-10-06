<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    public function listCards(){
        return $this->hasMany('App\Card');
    }
}
