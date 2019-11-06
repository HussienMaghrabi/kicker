<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class propsal_item extends Model
{
    protected $table = "propsal_items";

    public function proposal ()
    {
        return $this->belongsTo('App\Proposal','proposal_id');
    }

    public function item ()
    {
        return $this->belongsTo('App\Item','item_id');
    }

    static function getItem($id){
        $data = propsal_item::select('item_id','quantity','line_total','discaount','final_total','total','payment')->where('proposal_id', $id)->get();
        $data->map(function ($item)  {
            $item->items = $item->item['name'];
            unset($item->item_id);
            unset($item->item);
        });
        return $data ;
    }
}
