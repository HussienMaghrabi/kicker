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
    // public function index()
    // {
    //     $leads = DB::table('leads') 
    //     ->select('id','first_name','prefix_name','phone','email')
    //     ->paginate(100);
    //     // $leadds = DB::table('leads') 
    //     // ->select('id','first_name','prefix_name','phone','email')
    //     // ->get();
        
    //     // foreach($leadds as $lead){
    //     //     $comlead = DB::table('companies as company')->where('lead_id',$lead->id)
    //     //         ->leftjoin('phones as phone','company.id','=','phone.company_id')
    //     //         ->leftjoin('emails as email','company.id','=','email.company_id')
    //     //         ->leftjoin('contacts as contact','company.id','=','contact.company_id')
    //     //         ->select('company.id','company.name','company.lead_type','contact.phone','contact.mobile','contact.email','contact.leadstatus')
    //     //         ->get();
    //     //         $leads[]=$comlead;
    //     // }
    //    // echo dd($leads);
    //     return response()->json($leads);
        
    // }

    public function index()
    {
        $leads = DB::table('companies as company')
            ->leftjoin('phones as phone','company.id','=','phone.company_id')
            ->leftjoin('emails as email','company.id','=','email.company_id')
            ->leftjoin('contacts as contact','company.id','=','contact.company_id')
            ->leftjoin('leads as lead','company.id','=','lead.company')
            ->select('company.id','company.name','company.lead_type','phone.phone','phone.mobile','email.email','contact.leadstatus')
            ->paginate(100);
//echo dd($leads);
        return response()->json($leads);
        
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
    //    echo dd($request->first_name[0]);
    dd($request->all());
        $company = new Company;
        // return ($request->all());
         $saved = Company::create($request->all());

        // if($saved > 0){
        //     $address = new Address;
        //     $address->street = $request->street;
        //     $address->state = $request->state;
        //     $address->country_id = $request->country_id;
        //     $address->city_id = $request->city_id;
        //     $address->zip_code = $request->zip_code;
        //     $address->company_id = $request->company_id;
        //     $address->save();
        // }

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

    // public function store(Request $request)
    // {
    //       echo dd($request);
    //       return ($request->all());
    //      $saved = Company::create($request->all());
    //     if($saved){
    //         $address = new Address;
    //         $address->street = $request->street;
    //         $address->state = $request->state;
    //         $address->country_id = $request->country_id;
    //         $address->city_id = $request->city_id;
    //         $address->zip_code = $request->zip_code;
    //         $address->company_id = $saved->id;
    //         $address->save();
    //     }
    //     if ($saved) {
    //         $address = array(
    //                 'street' => $request->street,
    //                 'state' => $request->state,
    //                 'country_id' => $request->country_id,
    //                 'zip_code' => $request->zip_code,
    //                 'city_id' => $request->id_city,
    //                 'company_id' => $saved->id
    //             );

    //     foreach($address as $ad){
    //         $company->Address()->create([$ad]);
    //         }
    //     }
    //       $lead = new Lead;  
    //       $lead->prefix_name = 'mr';
    //       $lead->first_name = $request->first_name;
    //       $lead->last_name = $request->last_name;
    //       $lead->ar_first_name = $request->ar_first_name;
    //       $lead->ar_last_name = $request->ar_last_name;
    //       $lead->email = $request->email;
    //       $lead->phone = $request->phone;
    //       $lead->lead_source_id = $request->lead_source_id;
    //       $lead->company= $saved->id;
    //       $lead->status = 'new';
    //       $lead->notes = $request->notes;
    //       $lead->user_id = auth()->user()->id;
    //       if (auth()->user()->residential_commercial == "residential" and auth()->user()->type != 'admin') {
    //           $lead->agent_id = auth()->user()->id;
    //       } elseif (auth()->user()->residential_commercial == "commercial" and auth()->user()->type != 'admin') {
    //           $lead->commercial_agent_id = auth()->user()->id;
    //       }
    //       if ($request->has('agent_id')) {
    //           $lead->agent_id = $request->agent_id;
    //       } else {
    //           $lead->agent_id = 0;
    //       }
    //       if ($request->has('commercial_agent_id')) {
    //           $lead->commercial_agent_id = $request->commercial_agent_id;
    //       } else {
    //           $lead->commercial_agent_id = 0;
    //       }
    //       if ($request->hasFile('image')) {
    //           $lead->image = uploads($request, 'image');
    //       } else {
    //           $lead->image = 'image.jpg';
    //       }
    //       if (!$request->has('agent_id') and !$request->has('commercial_agent_id')) {
    //           if (auth()->user()->residential_commercial == 'commercial') {
    //               $lead->commercial_agent_id = auth()->user()->id;
    //           } else {
    //               $lead->agent_id = auth()->user()->id;
    //           }
    //       }
    //       $lead->save();
    //       DB::table('contacts')->insert([
    //         'first_name' => $request->first_name,
    //         'last_name' => $request->last_name,
    //         'title_id' => $request->title_id,
    //         'email' => $request->email,
    //         'nationality' => $request->nationality,
    //         'phone' => $request->phone,
    //         'mobile' => $request->mobile,
    //         'position' => $request->position,
    //         'leadstatus' => $request->leadstatus,
    //         'company_id' => $saved->id,
    //         'name' => $request->first_name,
    //         'lead_id' => $lead->id
    //       ]);

    // }


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


        // return ($request->all());
        // if ($saved) {
        //     $address = array(
        //             'street' => $request->street,
        //             'state' => $request->state,
        //             'country_id' => $request->country_id,
        //             'zip_code' => $request->zip_code,
        //             'city_id' => $request->id_city,
        //             'company_id' => $saved->id
        //         );

        // foreach($address as $ad){
        //     $company->Address()->create([$ad]);
        //     }
        // }
