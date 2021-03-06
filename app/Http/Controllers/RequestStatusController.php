<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\request_status;
use Validator;

class RequestStatusController extends Controller
{
    public function AllStatus()
    {
        return request_status::paginate(100);
    }
    public function AllForApi(){
        return request_status::all();
    }
    public function store(Request $request){
        $rules = [
            'name' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'name' => trans('admin.en_name'),
        ]);
        if ($validator->fails()) {
            return 'have error in requirement';
            // return back()->withInput()->withErrors($validator);
        } else {
            request_status::create($request->all());
        }
    }
    public function edit($id){
        return request_status::find($id);
    }
    public function update(Request $request,$id){
        $rules = [
            'name' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'name' => trans('admin.en_name'),
        ]);
        if ($validator->fails()) {
            return 'have error in requirement';
            // return back()->withInput()->withErrors($validator);
        } else {
            request_status::whereId($id)->update($request->all());
            return response()->json("Type up to date");
        }
    }
    public function destroy($id)
    {
        $type = request_status::find($id);
        $type->delete();
        return "type is deleted";
    }
}
