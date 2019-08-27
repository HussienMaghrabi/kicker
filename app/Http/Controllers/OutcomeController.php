<?php

namespace App\Http\Controllers;

use App\Outcome;
use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;
class OutcomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (checkRole('finance') or @auth()->user()->type == 'admin') {
                return $next($request);
            } else {
                session()->flash('error', __('admin.you_dont_have_permission'));
                return back();
            }
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd($request->all());
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'value' => 'required',
            'currency' => 'required',
            'payment_method' => 'required',
            'date' => 'required',
            'sub_cat_id' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'name' => trans('admin.name'),
            'description' => trans('admin.description'),
            'value' => trans('admin.value'),
            'currency' => trans('admin.currency'),
            'payment_method' => trans('admin.payment_method'),
            'date' => trans('admin.date'),
            'sub_cat_id' => trans('admin.out_sub_cat'),
            'status' => trans('admin.status'),
        ]);
        if ($validator->fails()) {
            // return 1;
            return back()->withInput()->withErrors($validator);
        } else {
            // return 2;
            $outcome = new Outcome;
            $outcome->name = $request->name;
            $outcome->description = $request->description;
            $outcome->value = $request->value;
            $outcome->currency_id = $request->currency;
            $outcome->payment_method = $request->payment_method;
            $outcome->sub_cat_id = $request->sub_cat_id;
            $outcome->status = $request->status;
            $outcome->safe_id = $request->safe_id;
            $outcome->bank_id = $request->bank_id;
            $outcome->date = $request->date;
            $outcome->save();

            $old_data = json_encode($outcome);
            LogController::add_log(
                __('admin.created', [], 'ar') . ' ' . $outcome->name,
                __('admin.created', [], 'en') . ' ' . $outcome->name,
                'outcome',
                $outcome->id,
                'create',
                auth()->user()->id,
                $old_data
            );

            return response()->json([
                "status"=>"Added"
            ],200);

            // return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Outcome $outcome
     * @return \Illuminate\Http\Response
     */
    public function show(Outcome $outcome)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Outcome $outcome
     * @return \Illuminate\Http\Response
     */
    public function edit(Outcome $outcome)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Outcome $outcome
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Outcome $outcome)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Outcome $outcome
     * @return \Illuminate\Http\Response
     */
    public function destroy(Outcome $outcome)
    {
        $outcome->delete();
        return response()->json(["status" => "deleted"],200);
    }
    public function storee(Income $income)
    {
        return view('admin.finances.outcome');
    }

    public function getOutCats()
    {
        $out_cats = DB::table('out_cats')
                    ->select('out_cats.id','out_cats.name')
                    ->get();
        
        return response()->json($out_cats); 
    }
    
    
    
}
