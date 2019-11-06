<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable=[
        'name'
    ];

    static function currencyByCompany($id){
        $data = proposedCurrency_company::select('currency_id')->where('proposed_company_id',$id)->get();
        $data->map(function ($item)  {
            $item->currencies = $item->currency['name'];
            unset($item->currency_id);
            unset($item->currency);
        });
        return $data;
    }
}
