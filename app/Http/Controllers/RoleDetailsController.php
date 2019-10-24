<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\RoleDetails;
class RoleDetailsController extends Controller
{
    public function index()
    {
        return RoleDetails::GetAllWithpaginate();
    }
    
    public function store(Request $request)
    {
        // dd($request->all());
        $store = RoleDetails::create($request->all());
        if($store->id > 0){
            return response()->json('Add new Role',200);
        }else{
            return response()->json('Bad Request From role',400);            
        }
    }

    public function edit($id)
    {
        return RoleDetails::getone($id);
    }
    public function update(Request $request,$id)
    {
        return RoleDetails::UpdateDRole($request,$id);
    }
    public function destroy($id)
    {
        // 
        $destroy = RoleDetails::find($id)->delete();
        if ($destroy) {
            return response()->json('Details is deleted',200);
        }
    }
    public function GetAllrolesDetailsApi()
    {
        return RoleDetails::aLL();
    }
}
