<?php

namespace App\Http\Controllers;

use App\Item;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    //
    public function getAllItem($CId)
    {
        return Item::GetItemsByCompany($CId);
    }

    public function addNewItems(Request $request){
        return Item::getStore($request);
    }

    public function getMyItem(){
        return Item::getItem();
    }


}
