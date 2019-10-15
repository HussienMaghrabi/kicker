<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\nationalVication;

class NationalVicationController extends Controller
{
    public function index()
    {
        $n_vacation = new nationalVication;
        return $n_vacation->GetAll();
    }
    public function store(Request $request)
    {
        $saved = nationalVication::create($request->all());
        if ($saved) {
            return 'New national vacation';
        }
    }
    public function edit($id)
    {
        dd('asd');
        $n_vacation = new nationalVication;
        return $n_vacation->GetSingleVacation($id);
    }
    public function destroy($id)
    {
        $vacation = nationalVication::find($id);
        $vacation->delete();
        return "deleted";
        // dd($id);
    }
}
