<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable=[
        'name','description','quantity','unit_price','sub_total','discount_value',
        'discount_percentage','total','company_id' ,'proposal_id'   
    ];
    
}
