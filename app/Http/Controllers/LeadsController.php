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

    dd($request->all());
        $company = new Company;
         $saved = Company::create($request->all());

        if ($saved) {
            $address = array(
                    'street' => $request->street,
                    'state' => $request->state,
                    'country_id' => $request->country_id,
                    'zip_code' => $request->zip_code,
                    'city_id' => $request->id_city,
                    'company_id' => $saved->id
                );

        foreach($address as $ad){
            $company->Address()->create([$ad]);
            }

        DB::table('contacts')->insert([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'title_id' => $request->title_id,
            'email' => $request->email,
            'nationality' => $request->nationality,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'position' => $request->position,
            'leadstatus' => $request->leadstatus,
            'company_id' => $saved->id,
            'lead_source_id' => $request->lead_source_id,
            // 'lead_id' => $request->lead_id,
          ]);
        }
    }
    public function edit_comapany_data(Request $request)
    {
       //echo dd($request->lead_source);
        DB::table('companies')
        ->where('id',$request['company_id'])
        ->update([
            'name' => $request->company_name,
            'rating' => $request->rating,
            'employees_Number' => $request->employees_Number,
            'annual_revenue' => $request->annual_revenue,
            'industry_id' => $request->industry,
            'lead_source_id' => $request->lead_source,
            'commercial_registration' => $request->commercial_registration,
            ]);
            DB::table('leads')
            ->where('id',$request['lead_id'])
            ->update([
                'email' => $request->email,
                'phone' => $request->phone,
                'mobile' => $request->mobile,
                'fax' => $request->fax,
                'website' => $request->website,
                'lead_source_id' => $request->lead_source,
                ]);     
                return response()->json([
                    'massege'=> 'success',
                ],200);     
          //  dd($request->all());
    }

    public function edit_address(Request $request)
    {
       //echo dd($request->lead_source);
        DB::table('companies')
        ->where('id',$request['company_id'])
        ->update([
            'name' => $request->company_name,
            'rating' => $request->rating,
            'employees_Number' => $request->employees_Number,
            'annual_revenue' => $request->annual_revenue,
            'industry_id' => $request->industry,
            'lead_source_id' => $request->lead_source,
            'commercial_registration' => $request->commercial_registration,
            ]);
            DB::table('leads')
            ->where('id',$request['lead_id'])
            ->update([
                'email' => $request->email,
                'phone' => $request->phone,
                'mobile' => $request->mobile,
                'fax' => $request->fax,
                'website' => $request->website,
                'lead_source_id' => $request->lead_source,
                ]);     
                return response()->json([
                    'massege'=> 'success',
                ],200);     
          //  dd($request->all());
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
