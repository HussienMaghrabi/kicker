<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\deduction;

class deductionController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all());
        $store = deduction::create($request->all());
        if($store){
            return "Groos salary add";
        }
    }
}
