<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    public function invoice_Colletions(){
        return $this->hasMany('App\Collection');
    }
}
