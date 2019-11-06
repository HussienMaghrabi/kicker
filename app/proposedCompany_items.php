<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class proposedCompany_items extends Model
{
    protected $table = "proposedcompany_item";

    public function company(){
        return $this->belongsTo('App\proposed_company' , 'proposed_company_id');
    }

    public function items(){
        return $this->belongsTo('App\Item' , 'item_id');
    }

    static function getItem($id){
        $data = proposedCompany_items::select('item_id')->where('proposed_company_id', $id)->get();
        $data->map(function ($item)  {
            $item->item = $item->items['name'];
            unset($item->item_id);
            unset($item->items);
        });
        return $data ;
    }
}
