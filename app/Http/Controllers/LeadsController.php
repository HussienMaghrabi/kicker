<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Address;
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
        $leads = DB::table('companies as company')
            ->leftjoin('phones as phone','company.id','=','phone.company_id')
            ->leftjoin('emails as email','company.id','=','email.company_id')
            ->leftjoin('contacts as contact','company.id','=','contact.company_id')
            ->select('company.id','company.name','company.lead_type','phone.phone','phone.mobile','email.email','contact.leadstatus')
            ->paginate(100);

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
                    'company_id' => $request->company_id
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
          ]);
        }
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
