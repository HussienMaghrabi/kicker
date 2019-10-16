<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\deduction;

class deductionController extends Controller
{
    protected $deduction;
    public function __construct() {
        $this->deduction = new deduction;
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $store = deduction::create($request->all());
        if($store){
            return "Dedtction add";
        }
    }
    public function getAlldeduction()
    {
        return $this->deduction::getDeductionReport();
    }
}
