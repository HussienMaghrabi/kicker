<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class proposedCurrency_company extends Model
{
    protected $table = 'proposedCurrency_companies';


    public function company(){
        return $this->belongsTo('App\proposed_company', 'proposed_company_id');
    }

    public function currency(){
        return $this->belongsTo('App\currency' , 'currency_id');
    }

}
