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
        // dd($request->all());
        // $saved = employee_request::create($request->all());
        $saved = new employee_request;
        $saved->employee_id = $request->employee_id;
        $saved->days = $request->days;
        $saved->request_status_id = 1;
        $saved->request_type_id = $request->request_type_id;
        $saved->note = $request->note;
        $saved->date_from = $request->date_from;
        $saved->date_too = $request->date_too;
        $saved->save();
        if($saved->id > 0){
            return "Add new request";
        }
    }
    public function getAllForEmployee($id)
    {
        return employee_request::SingleEmployeeRequest($id);
    }
    public function employeeRequestdata($id)
    {
        return employee_request::getemployeereqest($id);
    }
    public function updateRequestdata(Request $request,$id)
    {
        return employee_request::updateRequestFromProfile($request,$id);
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
