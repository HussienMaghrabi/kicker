<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\employee_request;

class EmployeeRequestController extends Controller
{
    public function index(){
        return employee_request::AllEmpRequest();
    }
    public function ChangeRequestStatus($id){
        return employee_request::getSingleRequest($id);
    }
    public function Store(Request $request){
        dd($request->all());
        // $saved = employee_request::create($request->all());
        $saved = new employee_request;
        $save->employee_id = $request->employee_id;
        $save->request_status_id = $request->request_status_id;
        $save->request_type_id = $request->request_type_id;
        $save->note = $request->note;
        $save->date_from = $request->date_from;
        $save->date_too = $request->date_too;
        $saved->save();
        if($saved->id > 0){
            return "Add new request";
        }
    }
    public function update(Request $request){
        $updateRequest = employee_request::where('id',$request->id)->first();
        $updateRequest->request_status_id = $request->status_id;
        $updateRequest->update();
        return 'Emp status is update';
    }
    public function destroyReq($id){
        $removeRequest = employee_request::find($id);
        $removeRequest->delete();
        return "deleted";
    }
}
