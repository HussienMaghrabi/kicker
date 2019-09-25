<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\proposed_company;
use App\Contact_proposed;
use App\ProposedContact_phone;
use App\ProposedContact_mobile;
use App\ProposedContact_fax;
use App\ProposedContact_email;
use App\ProposedCompany_address;
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
        dd($request);
        //static Data Of Proposed Company
         $proposedCompany=new proposed_company;
         $proposedCompany->name=$request->companyName;
         $proposedCompany->currency_id=$request->currencyId;
         $proposedCompany->activity=$request->activity;
         $proposedCompany->introduction=$request->introduction;
         $proposedCompany->closing=$request->closing;
         $proposedCompany->policy=$request->policy;
         if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = md5($image->getClientOriginalName() . time()) . "." . $image->getClientOriginalExtension();
            $destinationPath = public_path('/img');
            $image->move($destinationPath, $name);
             $proposedCompany->image   = $name;  
           
        }
        $proposedCompany->save();
        //Save Contact_proposed
        $contactsProposed=new Contact_proposed;
        $contactsProposed->first_name=$request->firstName;
        $contactsProposed->last_name=$request->lastName;
        $contactsProposed->website=$request->webSite;
        $contactsProposed->position=$request->position;
        $contactsProposed->nationality_id=$request->nationlityId;
        $contactsProposed->save();
        //save ProposedContact_phone
        $pArray = json_decode($request->phones);

           if(sizeof($pArray)>0){
               
            foreach($pArray as $item){
                // dd($phones);
                if($item !=null){
                    $ProposedContact_phone= new ProposedContact_phone;
                    $ProposedContact_phone->phone=$item;
                    $ProposedContact_phone->contact_id=$contactsProposed->id;
                    $ProposedContact_phone->save();
                }
                
            }
        }
        //save ProposedContact_mobile
            $mArray=json_decode($request->mobiles);
            // dd($mArray);
            if(sizeof($mArray)>0){
                foreach($mArray as $mobile){
                
                    if($mobile !=null){
                        $proposedContact_mobile= new ProposedContact_mobile;
                        $proposedContact_mobile->mobile=$mobile;
                        $proposedContact_mobile->contact_id=$contactsProposed->id;
                        $proposedContact_mobile->save();
                    }
                
                }
               
            }
            //save ProposedContact_fax
            $fArray=json_decode($request->faxies);
            // dd($mArray);
            if(sizeof($fArray)>0){
                foreach($fArray as $fax){
                
                    if($fax !=null){
                        $proposedContact_fax= new ProposedContact_fax;
                        $proposedContact_fax->fax=$fax;
                        $proposedContact_fax->contact_id=$contactsProposed->id;
                        $proposedContact_fax->save();
                    }
                
                }
               
            }
            //save ProposedContact_email
            $eArray=json_decode($request->emails);
            if(sizeof($eArray)>0){
                foreach($eArray as $email){
                
                    if($email !=null){
                        $proposedContact_email= new ProposedContact_email;
                        $proposedContact_email->email=$email;
                        $proposedContact_email->contact_id=$contactsProposed->id;
                        $proposedContact_email->save();
                    }
                
                }
               
            }

            //save Address for Proposed Company
            //save street 
            $o=0;
            $streetArray=json_decode($request->street);
            $stateArray=json_decode($request->state);
            $zipCodeArray=json_decode($request->zipCode);
            $cityIdArray=json_decode($request->city);
            $countryIdArray=json_decode($request->countryId);
            foreach($stateArray as $item){
                $proposedCompanyAddress=new ProposedCompany_address;
                $proposedCompanyAddress->street=$streetArray[$o];
                $proposedCompanyAddress->state=$stateArray[$o];
                $proposedCompanyAddress->zip_code=$zipCodeArray[$o];
                $proposedCompanyAddress->city_id=$cityIdArray[$o];
                $proposedCompanyAddress->country_id=$countryIdArray[$o];
                $proposedCompanyAddress->proposed_company_id=$contactsProposed->id;
                $proposedCompanyAddress->save();
                $o++;
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

    public function getProposedCompany(){
          $allProposedCompany=proposed_company::all();
          return response()->json([
              'status'=>'Success',
              'data'=>$allProposedCompany
          ]);
    }
}
