<?php

namespace App;
use App\Item;
use App\propsal_item;
use DB;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable=[];

    public function company ()
    {
        return $this->belongsTo('App\Company','company_id');
    }

    public function currency ()
    {
        return $this->belongsTo('App\Currency','currency_id');
    }

    public function propsal_item ()
    {
        return $this->hasMany('App\propsal_item');
    }

    static function allProposal(){
        $allProposal = DB::table('proposals as prop')
        ->leftJoin('companies as company','prop.company_id','=','company.id')
        ->leftJoin('contacts as contact','prop.contact_id','=','contact.id')
        ->leftJoin('currencies as currency','prop.currency_id','=','currency.id')
        ->leftJoin('proposed_company as prop_company','prop.proposed_company_id','=','prop_company.id')
        ->select('prop.id as id','company.name as company_name','contact.first_name as contact_first_name','contact.last_name as contact_last_name','currency.name as currency_name','prop_company.name as MCompany_name','prop.valid_until')
        ->paginate(100);
        return response()->json($allProposal);
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
        $newprop->valid_until = $request->valid_until;
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

    static function ShowProposal($id)
    {
        // proposal
        // $items

        $propsal = DB::table('proposals as proposal')
        ->join('companies as company','proposal.company_id','=','company.id')
        ->join('contacts as contact','proposal.contact_id','=','contact.id')
        ->join('currencies as carrancy','proposal.currency_id','=','carrancy.id')
        ->join('proposed_company as p_company','proposal.proposed_company_id','=','p_company.id')
        ->select('proposal.id as id','company.id as lead_id','company.name as lead_name','contact.id as contact_id','contact.first_name as contact_first_name','contact.last_name as contact_last_name','carrancy.id as carrancy_id','carrancy.name as carrancy_name','p_company.id as company_id','p_company.name as company_name')
        ->where('proposal.id',$id)
        ->get();

        $items = DB::table('propsal_items as p_item')
        ->join('proposals as proposal','p_item.proposal_id','=','proposal.id')
        ->join('items as item','p_item.item_id','=','item.id')
        ->select('p_item.item_id as item_id','item.name as item_name','p_item.quantity','p_item.line_total','p_item.discaount','p_item.final_total')
        ->where('proposal.id',$id)
        ->get();
        return response()->json([
            'data' => 'success',
            'propsal' => $propsal,
            'items' => $items,
        ],200);
    }

    static function getProposalCompany($id){
        $data = Proposal::select('id as proposal', 'company_id','currency_id')->where('proposed_company_id', $id)->get();
        $data->map(function ($item)  {
            $item->company_name = $item->company["name"];
            $item->person = $item->company->contact;
            $item->contact_person = $item->person[0]['first_name'];
            $item->invoic_currency = $item->currency['name'];
            unset($item->company);
            unset($item->person);
            unset($item->currency);
            unset($item->company_id);
            unset($item->currency_id);
        });
        return $data ;
    }

    public function items()
    {
          return $this->hasMany('App\Item','proposal_id');
    }
}
