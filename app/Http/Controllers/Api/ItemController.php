<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Item;
use App\propsal_item;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    public function itemCompany($id){
        $data = propsal_item::getItem($id);
        return $this->successResponse($data);

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        Item::getDestroy($id);
        $message = "Deleted Successfully";
        return $this->successResponse(null, $message);
    }
}