<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nationality;
class NationalityController extends Controller
{
    public function getAllNationality(){
        $nationalities=Nationality::all();
        return response()->json([
			'status'=>'success',
			'data'=>$nationalities
		]);
    }
}
