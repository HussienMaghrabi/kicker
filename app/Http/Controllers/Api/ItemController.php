<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Item;
use App\propsal_item;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    public function index(){
        //
    }

    public function itemCompany($id){
        $data = propsal_item::getItem($id);
        return $this->successResponse($data);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company $Company
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Item::getShow($id);
        return $this->successResponse($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $Company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        Item::getUpdate($request,$id);
        $message ='updated';
        return $this->successResponse(null,$message);
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

    public function Search(Request $request){

        $data = Item::getSearch($request);
        return $this->successResponse($data);

    }
}