<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    Public function getProposedCompanies(){
        $proposedCompanies = DB::table('proposed_company')
                             ->select('id','name')
                             ->get();
        return response()->json($proposedCompanies);
    }

    Public function getNewLeads(){
        $leads = DB::table('companies')
                             ->select('id','name')
                             ->get();
        return response()->json($leads);
    }

    public function getleadContact($id){
        // dd('dd');
        // return $id;
        $leadContacts = DB::table('contacts')
        ->where('company_id',$id)
        ->select('id','first_name','last_name')
        ->get();
        return response()->json($leadContacts);
    }
    

    
}
