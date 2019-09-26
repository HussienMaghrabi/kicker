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
}
