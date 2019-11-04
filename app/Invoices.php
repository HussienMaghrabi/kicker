<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    public function invoice_Colletions(){
        return $this->hasMany('App\Collection');
    }

    static function getStore(Request $request){
        dd($request->all());

        $add=new Invoices;
        $add->proposed_company_id  =$request->proposedCompanyId;
//        $add->company_id           =$request->company_id;
//        $add->contact_id      =$request->contactPersonId;
//        $add->valid_until  =$request->validUntil;
//        $add->currency_id       =$request->currencyId;
//        $add->payment        =$request->payment;
//        $add->discount        =$request->discount;
//        $add->total        =$request->total;
        $add->save();
    }
}
