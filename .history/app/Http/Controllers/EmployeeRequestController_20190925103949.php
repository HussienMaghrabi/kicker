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
    public function destroyReq($id){
        $removeRequest = employee_request::find($id);
        $removeRequest->delete();
        return "deleted";
    }
}
