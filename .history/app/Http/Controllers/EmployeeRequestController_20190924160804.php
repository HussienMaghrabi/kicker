<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\employee_request;

class EmployeeRequestController extends Controller
{
    public function index(){
        return employee_request::AllEmpRequest();
    }
}
