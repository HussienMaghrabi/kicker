<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded = [];

    public function city(){
        return $this->belongsTo('App\City' , 'city_id');
    }

    public function country(){
        return $this->belongsTo('App\Country' , "country_id");
    }

    public function company(){
        return $this->belongsTo('App\Company' , 'company_id');
    }
    
}
