<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\workDays;

class DaysController extends Controller
{
    public function index()
    {
        $allDays = workDays::all();
        return response()->json($allDays);
    }
    public function update(Request $request)
    {
        // for update
        dd($request->all());
    }
}
