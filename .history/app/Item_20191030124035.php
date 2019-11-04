<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Item extends Model
{
    protected $table = "items";

    static function GetItemsByCompany($CId)
    {
        $c_items = DB::table('proposedcompany_item as c_item')
        ->leftjoin('items as item','c_item.item_id','=','item.id')
        ->select('item.id as id','item.name')
        ->where('c_item.proposed_company_id',$CId)
        ->get();
        return response()->json([
            'status'=>'success',
            'data'=>$c_items
        ]);
    }
}
