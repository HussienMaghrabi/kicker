<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Invoices extends Model
{
    public function invoice_Colletions(){
        return $this->hasMany('App\Collection');
    }

    static function getIndex(){
        $data= Invoices::orderBy("id")->get();
        return $data;
    }

    static function getShow($id){
        $data= Invoices::orderBy("id")->where('id',$id)->get();
        return $data;
    }

    static function getStore(Request $request){
        dd($request->all());

        $add=new Invoices;
        $add->proposed_company_id  =$request->proposedCompanyId;
        $add->proposal_id  =$request->proposal_id;
        $add->company_id           =$request->company_id;
        $add->contact_id      =$request->contactPersonId;
        $add->invoice_date  =$request->invoice_date;
        $add->due_date =$request->due_date;
        $add->currency_id       =$request->currencyId;
        $add->discount        =$request->discount;
        $add->total        =$request->total;
        $add->save();
    }

    static function getUpdate(Request $request,$id)
    {
dd($request);
        DB::table("companies")
            ->where('id', $id)
            ->update([
                'proposed_company_id' => $request->proposedCompanyId,
                'proposal_id' => $request->proposal_id,
                'company_id' => $request->company_id,
                'contact_id' => $request->contactPersonId,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'currency_id' => $request->currencyId,
                'discount' => $request->discount,
                'total' => $request->total,
            ]);
    }

    static function getDestroy($id){
        Invoices::findOrFail($id)->delete();
    }


}
