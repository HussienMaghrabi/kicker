<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\employee_attendance;

class employee_attendance_controller extends Controller
{
    public function store(Request $request){
        dd($request->all());
    }
}
