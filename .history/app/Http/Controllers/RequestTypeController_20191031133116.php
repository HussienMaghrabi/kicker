<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\request_type;
use Validator;

class RequestTypeController extends Controller
{
    public function AllTypes()
    {
        return request_type::getAll();
    }
    public function AllTypesAPI()
    {
        return request_type::all();
    }
    public function store(Request $request)
    {
        $checkOnName = request_type::where('name',$request->name)->first();
        if ($checkOnName) {
            return response()->json([
                'data' => 'bad request',
                'massege' => 'NameTaken'
            ],200);
        }
        request_type::create($request->all());
    }
    public function edit($id){
        return request_type::find($id);
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
            request_type::whereId($id)->update($request->all());
            return response()->json("Type up to date");
        }
    }
    public function destroy($id)
    {
        $type = request_type::find($id);
        $type->delete();
        return "type is deleted";
    }
}
