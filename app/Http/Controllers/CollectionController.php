<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Collection;
use App\Income;
use DB;
use Carbon\Carbon;

use App\Quotation;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::all();
        return view('collections.index',compact('collections'));
    }

    public function create()
    {
        return view('collections.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // $collection = new Collection;
        // $collection->name = $request->name;
        // $collection->description = $request->description;
        // $collection->value = $request->value;
        // $collection->created_at = $request->created_at;
        // $collection->due_date = $request->due_date;
        // $collection->status = $request->status;

        // $collection->save();

        $Collection = Collection::create([
            'name'=> $request->name,
            'description'=> $request->description,
            'value'=> $request->value,
            'created_at'=> $request->created_at,
            'due_date'=> $request->due_date,
            'status'=> $request->status,
        ]);

        return response()->json([
            "Status"=>"Added"
        ],200);
        // return redirect('/admin/collection');
    }


    public function show(Collection $Collection)
    {
       $Selected_id =  DB::table('collections')->where('id',$Collection->id)->first();
       return view('collections.show',compact('Selected_id'));
    }

    public function edit(Collection $Collection)
    {
        $Selected_id =  DB::table('collections')->where('id',$Collection->id)->first();
        return view('collections.edit',compact('Selected_id'));
    }

    public function update(Request $request,$id)
    {
        $Collection = Collection::find($id);
        $Collection->value = $request->value;
        $Collection->date = $request->date;
        $Collection->collected = $request->collected;
        $Collection->save();
        return redirect('/admin/collection');
    }

    public function destroy($id)
    {
        $Collection = Collection::find($id);
        $Collection->delete();
         
        return redirect('/admin/collection');

    }
    
    public function confirmCollection($id)
    {
        $collection = Income::find($id);
        $collection->status = 'collected';
        $collection->save();
        return response()->json(["status"=>"Collected"],200);

    }

}
