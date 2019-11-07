<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Company;
use App\Address;
use App\Lead;
use Validator;
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

    public function leads_by_id($id){
        $data = Company::getLeadByProposal($id);
        return $this->successResponse($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company $Company
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $leads = Company::getShow($id);
        return $this->successResponse($leads);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $Company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
       $data = Company::getEditCompany($request,$id);
        $message ='updated';
        return $this->successResponse(null,$message);
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

    public function Search(Request $request){

       $data = Company::getSearch($request);
       return $this->successResponse($data);

    }
}
