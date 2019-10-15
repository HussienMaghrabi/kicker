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
        $n_vacation = new nationalVication;
        return $n_vacation->GetSingleVacation($id);
    }
    public function update(Request $request)
    {
        $updateVication = nationalVication::find($request->id);
        $updateVication->en_name = $request->en_name;
        $updateVication->ar_name = $request->ar_name;
        $updateVication->days = $request->days;
        $updateVication->natoial_vacation_type_id = $request->natoial_vacation_type_id;
        $updateVication->from = $request->from;
        $updateVication->to = $request->to;
        $updateVication->update();
        return response()->json("National vacation Up to date");
    }
    public function destroy($id)
    {
        $vacation = nationalVication::find($id);
        $vacation->delete();
        return "deleted";
        // dd($id);
    }
}
