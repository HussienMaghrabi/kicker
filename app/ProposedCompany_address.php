<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProposedCompany_address extends Model
{
    protected $table='proposedCompany_addresses';

    public function city(){
        return $this->belongsTo('App\City');
    }

    public function country(){
        return $this->belongsTo('App\Country');
    }
}
