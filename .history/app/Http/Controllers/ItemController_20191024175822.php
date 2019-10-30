<?php

namespace App\Http\Controllers;

use App\Item;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    //
    public function getAllItem($id)
    {
        $allitem=Item::where('company_id',$id)->all();
        return response()->json([
            'status'=>'success',
            'data'=>$allitem
        ]);
    }
}
