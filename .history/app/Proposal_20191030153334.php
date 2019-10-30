<?php

namespace App;
use App\Item;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable=[];

    static function storeData($request)
    {
        // dd($request->all());
        $newprop = new Proposal;
        if($request->introduction == 1){
            $newprop->introduction = 1;
        }
        if ($request->closing == 1){
            $newprop->closing = 1;
        }
        $newprop->policy = $request->policy;
        $newprop->proposed_company_id = $request->companyId;
        $newprop->company_id = $request->leadId;
        $newprop->contact_id = $request->leadcontactid;
        $newprop->currency_id = $request->currency_id;
        $newprop->payment = $request->payment;
        $newprop->save();
    }

    public function items()
    {
          return $this->hasMany('App\Item','proposal_id');
    }
    static function allProposal(){
        $allProposal=Proposal::all();
        return response()->json([
            'status'=>'Success',
            'data'=>$allProposal
        ]);
    }

}
