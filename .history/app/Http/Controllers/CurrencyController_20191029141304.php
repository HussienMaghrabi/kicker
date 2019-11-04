<?php

namespace App\Http\Controllers;

use App\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function create(Request $r){
    	$currency = new Currency;
    	$currency->ar_name= $r->ar_name;
    	$currency->en_name= $r->en_name;
    	$currency->save();
    	return back();
	}
	public function delete_currency($id){
		Currency::find($id)->delete();
		return back();

	}
	public function edit_currency(Request $request, $id){
		$currency = Currency::find($id);
		$currency->ar_name= $request->ar_name;
		$currency->en_name= $request->en_name;
		$currency->save();
		return back();
	}

	 public function getAllCurrency()
	{
		$allcurrency=Currency::all();
		return response()->json([
			'status'=>'success',
			'data'=>$allcurrency
		]);
	}
	public function getAllCurrencyCo($id)
	{
		$currCompany = DB::table('proposedCurrency_companies as propCurrncyC')
		->leftJoin('proposed_company as p_company','propCurrncyC.proposed_company_id','=','p_company.id')
		->leftJoin('currencies as currency','propCurrncyC.currency_id','=','currency.id')
		->where('proposed_company.id',$id)
		->select('currency.id as id','currency.name as currName')
		->get();
		return response()->json([
			'status'=>'success',
			'data'=>$currCompany
		]);
	}
}
