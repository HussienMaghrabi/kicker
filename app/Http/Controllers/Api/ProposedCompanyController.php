<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\proposed_company;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Auth;
use Validator;
use DB;

class ProposedCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = proposed_company::getIndex();
        return $this->successResponse($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = proposed_company::getShow($id);
        return $this->successResponse($data);
    }


}