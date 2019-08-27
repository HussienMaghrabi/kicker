<?php

namespace App\Http\Controllers;

use App\Income;
use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;

class IncomeController extends Controller
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
			'name'=>'required',
			'description'=>'required',
			'value'=>'required',
			'status'=>'required',
			'currency'=>'required',
			'payment_method'=>'required',
            'date'=>'required',
			];
		$validator = Validator::make($request->all(), $rules);
		$validator->SetAttributeNames([
			'name'=>trans('admin.name'),
			'description'=>trans('admin.description'),
			'value'=>trans('admin.value'),
			'status'=>trans('admin.status'),
			'currency'=>trans('admin.currency'),
			'payment_method'=>trans('admin.payment_method'),
			'date'=>trans('admin.date'),
			]);
		if ($validator->fails()) {
            // return 1;
			return back()->withInput()->withErrors($validator);
		}
		else {
            // return 2;
			$income = new Income;
			$income->name = $request->name;
			$income->description = $request->description;
			$income->value = $request->value;
			$income->currency_id = $request->currency;
			$income->status = $request->status;
			$income->payment_method = $request->payment_method;
			if($request->has('bank')){
				$income->bank_id = $request->bank;
			}
			if($request->has('safe')){
				$income->safe_id = $request->safe;
			}
			$income->source = 'manual';
			$income->date = $request->date;
			$income->save();

            $old_data = json_encode($income);
            LogController::add_log(
                __('admin.created', [], 'ar') . ' ' . $income->name,
                __('admin.created', [], 'en') . ' ' . $income->name,
                'income',
                $income->id,
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function collect($id)
    {
        $income = Income::find($id);
        $income->status = 'collected';
        $income->save();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function show(Income $income)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function edit(Income $income)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Income $income)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Income  $income
     * @return \Illuminate\Http\Response
     */
   
    public function destroy(Income $income)
    {
        $income->delete();
        return response()->json(["status" => "deleted"],200);
    }

    public function getCurrency()
    {
        $currencies = DB::table('currencies')
                    ->select('currencies.id','currencies.en_name')
                    ->get();
        
        return response()->json($currencies); 
    }
    
    public function getBanks()
    {
        $banks = DB::table('banks')
                    ->select('banks.id','banks.name')
                    ->get();
        
        return response()->json($banks); 
    }
    

}
