<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dues;
use App\Outcome;
use DB;
use App\Quotation;


class DuesController extends Controller
{
    public function index()
    {
        $dues = Dues::all();
        return view('dues.index',compact('dues'));
    }

    public function create()
    {
        return view('dues.create');
    }

    public function store(Request $request)
    {
        $dues = Dues::create([
            'value'=> $request->value,
            'date'=> $request->date,
            'collected'=> $request->collected,
        ]);
        return redirect('/admin/dues');
    }

    public function show($id)
    {
       $Selected_id =  DB::table('dues')->where('id',$id)->first();
       return view('dues.show',compact('Selected_id'));
    }

    public function edit($id)
    {
        $Selected_id =  DB::table('dues')->where('id',$id)->first();
        return view('dues.edit',compact('Selected_id'));
    }

    public function update(Request $request,$id)
    {
        $dues = Dues::find($id);
        $dues->value = $request->value;
        $dues->date = $request->date;
        $dues->collected = $request->collected;
        $dues->save();
        return redirect('/admin/dues');
    }

    public function destroy($id)
    {
        $dues = Dues::find($id);
        $dues->delete();
        return redirect('/admin/dues');

    }

    public function confirmDues($id)
    {
        $collection = Outcome::find($id);
        $collection->status = 'paid';
        $collection->save();
        return response()->json(["status"=>"paid"],200);

    }


    
}
