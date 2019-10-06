<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\request_type;

class RequestTypeController extends Controller
{
    public function AllTypes()
    {
        return request_type::getAll();
    }
    public function store(Request $request)
    {
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
}
