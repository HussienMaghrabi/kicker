<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\gross_salary;

class grossSalaryController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all());
        $store = gross_salary::create($request->all());
    }
}
