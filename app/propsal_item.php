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
}
