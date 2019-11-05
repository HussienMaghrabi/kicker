<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\proposed_company;
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
}