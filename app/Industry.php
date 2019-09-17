<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    public function company_industry(){
        return $this->hasMany('App\Company');
    }
}
