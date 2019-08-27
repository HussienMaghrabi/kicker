<?php

namespace App\Http\Controllers;

use App\OutCat;
use App\OutSubCat;
use Illuminate\Http\Request;
use Validator;
use Auth ;
use DB ;

class OutSubCatController extends Controller
{
    public function index()
    {
        $subs = OutSubCat::get();
        $title = __('admin.out_sub_cats');
        // return response()->json([
        //     "subs"=>$subs ,
        //     "title"=>$title
        // ]);     
        // return view('admin.out_sub_cats.index', compact('subs', 'title'));
        $subs = DB::table('out_sub_cats')
        ->leftjoin('out_cats','out_sub_cats.out_cat_id','=','out_cats.id')
        ->select('out_sub_cats.id','out_sub_cats.name','out_cats.name as outcome','out_cats.id as out_cat_id')
        ->paginate(100);
        return response()->json($subs);

    }

    public function create()
    {
        $title = __('admin.out_sub_cats');
        $cats = OutCat::get();
        return view('admin.out_sub_cats.create', compact('title', 'cats'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'out_cat_id' => 'required',
            'due_date' => 'required|min:1|max:31',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'name' => trans('admin.name'),
            'due_date' => trans('admin.due_date'),
            'out_cat_id' => trans('admin.out_cat'),
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $sub = new OutSubCat();
            $sub->name = $request->name;
            $sub->due_date = $request->due_date;
            $sub->notes = $request->notes;
            $sub->out_cat_id = $request->out_cat_id;
            $sub->save();

            $old_data = json_encode($sub);
            LogController::add_log(
                __('admin.created', [], 'ar') . ' ' . $sub->name,
                __('admin.created', [], 'en') . ' ' . $sub->name,
                'out_sub_cats',
                $sub->id,
                'create',
                auth()->id(),
                $old_data
            );

            session()->flash('success', __('admin.created'));
            // return redirect(adminPath() . '/out_sub_cats');
            return response()->json([ "status" => "Added"],200);

        }
    }

    public function show(OutSubCat $outSubCat)
    {
        $outSubCat = DB::table('out_sub_cats')
        ->join('out_cats','out_sub_cats.out_cat_id','=','out_cats.id')
        ->select('out_sub_cats.name','out_cats.name as outcome','out_sub_cats.due_date','out_sub_cats.notes','out_cats.id as out_cat_id')
        ->where('out_sub_cats.id',$outSubCat->id)
        ->first(100);
        // dd($outSubCat);
        return response()->json($outSubCat);

        // return view('admin.out_sub_cats.show', ['sub' => $outSubCat, 'title' => __('admin.out_sub_cats')]);
    }

    public function edit(OutSubCat $outSubCat)
    {
        $cats = OutCat::get();
        return view('admin.out_sub_cats.edit', ['sub' => $outSubCat, 'title' => __('admin.out_sub_cats'), 'cats' => $cats]);
    }

    public function update(Request $request, OutSubCat $outSubCat)
    {
        // return $request;
        $rules = [
            'name' => 'required',
            'due_date' => 'required|min:1|max:31',
            'out_cat_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'name' => trans('admin.name'),
            'due_date' => trans('admin.due_date'),
            'out_cat_id' => trans('admin.out_cat'),
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $old_data = json_encode($outSubCat);

            $outSubCat->name = $request->name;
            $outSubCat->due_date = $request->due_date;
            $outSubCat->notes = $request->notes;
            $outSubCat->out_cat_id = $request->out_cat_id;
            $outSubCat->save();

            $new_data = json_encode($outSubCat);

            LogController::add_log(
                __('admin.updated', [], 'ar') . ' ' . $outSubCat->name,
                __('admin.updated', [], 'en') . ' ' . $outSubCat->name,
                'out_sub_cats',
                $outSubCat->id,
                'update',
                auth()->id(),
                $old_data,
                $new_data
            );

            session()->flash('success', __('admin.updated'));
            // return redirect(adminPath() . '/out_sub_cats');
            return response()->json([ "status" => "updated"],200);


        }
    }

    public function destroy(OutSubCat $outSubCat)
    {
        $old_data = json_encode($outSubCat);

        LogController::add_log(
            __('admin.deleted', [], 'ar') . ' ' . $outSubCat->name,
            __('admin.deleted', [], 'en') . ' ' . $outSubCat->name,
            'out_sub_cats',
            $outSubCat->id,
            'delete',
            auth()->id(),
            $old_data
        );

        $outSubCat->delete();

        // session()->flash('success', __('admin.deleted'));
        // return redirect(adminPath() . '/out_sub_cats');
    return response()->json([ "status" => "done"],200);

    }

    public function searchSubCat(Request $request){
        $search = $request->searchInput;
        if (Auth::user()->type === 'admin' ) {
            $SubCat = DB::table('out_sub_cats')
            ->leftjoin('out_cats','out_sub_cats.out_cat_id','=','out_cats.id')

			->where('out_sub_cats.id', 'LIKE', '%' . $search . '%')
            ->orWhere('out_sub_cats.name', 'LIKE', '%' . $search . '%')    
            ->select('out_sub_cats.id','out_sub_cats.name','out_cats.name as outcome')
            ->get();
            return $SubCat;
        }

    }

}
