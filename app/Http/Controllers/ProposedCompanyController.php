<?php

namespace App\Http\Controllers;

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
        $allData=proposed_company::all();
        return response()->json([
            'status'=>'success',
            'data'=>$allData
        ]);
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
        return proposed_company::gitStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proposalCompany = proposed_company::where('id',$id)->with('proposalContacts')->with('proposalAddress')->get();

        foreach($proposalCompany as $item){
//
            $arr['name']=$item['name'];
            $arr['image']=$item['image'];
            $arr['activity']=$item->activity;
            $arr['currencyId']=$item->currency_id;
            $arr['introduction']=$item->introduction;
            $arr['closing']=$item->closing;
            $arr['policy']=$item->policy;
            $arr['proposalContacts']=$item->proposalContacts;
            $arr['proposalAddress']=$item->proposalAddress;
        }

        return response()->json([
            'status'=>'Success',
            'data'=>$arr
        ]);


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
    public function update(Request $request)
    {
        //
        return proposed_company::getUpdate($request);
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
        return proposed_company::getDestroy($id);

    }

    public function getProposedCompany(){
        $allProposedCompany=proposed_company::all();
        return response()->json([
            'status'=>'Success',
            'data'=>$allProposedCompany
        ]);
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

    public function searchForCompany(Request $request){

        return proposed_company::getSearch($request);

    }






}
