<?php

namespace App\Http\Controllers\Api;

use App\Currency;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CurrenciesController extends Controller
{
    public function getCurrency($id){
        $data = Currency::currencyByCompany($id);
        return $this->successResponse($data);
    }
}
