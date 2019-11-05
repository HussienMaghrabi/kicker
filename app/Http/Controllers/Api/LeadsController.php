<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Company;
use App\Address;
use App\Lead;
use DB;

class LeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $leads = Company::getIndex();
        return $this->successResponse($leads);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Company::getDestroy($id);
        $message = "Deleted Successfully";
        return $this->successResponse(null, $message);
    }
}
