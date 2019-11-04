<?php

namespace App;
use App\Item;
use App\propsal_item;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable=[];

    static function allProposal(){
        $allProposal = DB::table('proposals as prop')
        ->leftJoin('companies as company','prop.company_id','=','company.id')
        ->leftJoin('contacts as contact','prop.contact_id','=','contact.id')
        ->leftJoin('currencies as currency','prop.currency_id','=','currency.id')
        ->leftJoin('proposed_company as prop_company','prop.proposed_company_id','=','prop_company.id')
        ->select('prop.id as id','company.name as company_name','contact.first_name as contact_first_name','contact.last_name as contact_last_name')
        ->get();
        return response()->json([
            'status'=>'Success',
            'data'=>$allProposal
        ]);
    }

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
        $newprop->date = $request->valid_until;
        $newprop->currency_id = $request->currency_id;
        $newprop->payment = $request->payment;
        $newprop->save();

        if($newprop->id > 0){
            if($request->items){
                $items = json_decode($request->items);
                foreach ($items as $item) {
                    $saveItem = new propsal_item;
                    $saveItem->proposal_id = $newprop->id;
                    $saveItem->item_id = $item->itemId;
                    $saveItem->quantity = $item->itemQuantity;
                    $saveItem->line_total = $item->subTotal;
                    $saveItem->final_total = $item->total;
                    $saveItem->discaount = $item->discountValue;
                    $saveItem->payment = 'Any';
                    $saveItem->save();
                }
            }
        }
        return response()->json([
            'data' => 'success'
        ],200);
    }

    public function items()
    {
          return $this->hasMany('App\Item','proposal_id');
    }
}
