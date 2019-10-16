<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\gross_salary;

class grossSalaryController extends Controller
{
    public function store(Request $request)
    {
        $store = gross_salary::create($request->all());
        if($store){
            return "Groos salary add";
        }
    }
    public function GrossReport()
    {
        return gross_salary::report();
    }
}
