<?php

namespace App\Http\Controllers;

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
    public function index()
    {
            $leads = DB::table('leads as lead')
            ->leftjoin('companies as company','company.id','=','lead.company')
                ->leftjoin('contacts as contact','company.id','=','contact.company_id')
                ->select('lead.id','lead.first_name','lead.last_name','company.name','company.lead_type','contact.phone','contact.mobile','contact.email','contact.leadstatus')
                ->get();
        return response()->json($leads);
        
    }

//     public function index()
//     {
//         $leads = DB::table('companies as company')
//             ->leftjoin('phones as phone','company.id','=','phone.company_id')
//             ->leftjoin('emails as email','company.id','=','email.company_id')
//             ->leftjoin('contacts as contact','company.id','=','contact.company_id')
//             ->select('company.id','company.name','company.lead_type','phone.phone','phone.mobile','email.email','contact.leadstatus')
//             ->paginate(100);
// echo dd($leads);
//         return response()->json($leads);
        
//     }

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
        return Company::getStore($request);
    }
    public function edit_company_data(Request $request)
    {
        return Company::getEditCompany($request);
    }

    public function edit_address(Request $request)
    {
       return Company::getEditAddress($request);
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
}
