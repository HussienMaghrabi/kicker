<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class proposed_company extends Model
{
    protected $table = 'proposed_company';

    public function Contact(){
        return $this->hasMany('App\Contact_proposed');
    }
     public function proposalAddress()
    {
        return $this->hasMany('App\ProposedCompany_address','proposed_company_id');
    }

    public function currencies(){
        return $this->hasMany('App\proposedCurrency_company');
    }

    public function phone(){
        return $this->hasMany('App\proposedContact_phone');
    }

    public function email(){
        return $this->hasMany('App\ProposedContact_email');
    }

    public function fax(){
        return $this->hasMany('App\ProposedContact_fax');
    }

    public function address(){
        return $this->hasMany('App\ProposedCompany_address');
    }


    static function getIndex(){

        $data= proposed_company::select("id", "name")->get();
        return $data;
    }

     static function gitStore(Request $request){
//
//dd($request);
        //static Data Of Proposed Company
        $proposedCompany=new proposed_company;
        $proposedCompany->name          =$request->companyName;
        $proposedCompany->activity      =$request->activity;
        $proposedCompany->introduction  =$request->introduction;
        $proposedCompany->closing       =$request->closing;
        $proposedCompany->policy        =$request->policy;

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
        $contactsProposed->first_name           =$request->firstName;
        $contactsProposed->last_name            =$request->lastName;
        $contactsProposed->website              =$request->webSite;
        $contactsProposed->position             =$request->position;
        $contactsProposed->nationality_id       =$request->nationalityId;
        $contactsProposed->proposed_company_id  =$proposedCompany->id;
        $contactsProposed->save();

        //save Currency_company

         $cArray=$request->currencyId;
         if($cArray > 0){
             foreach($cArray as $currencyId){
                 if($currencyId !=null){
                     $Currency_company =new proposedCurrency_company;
                     $Currency_company->currency_id =$currencyId;
                     $Currency_company->proposed_company_id =$proposedCompany->id;
                     $Currency_company->save();
                 }
             }
         }


        //save ProposedContact_phone
        $pArray = json_decode($request->phones);

        if(sizeof($pArray)>0){
            foreach($pArray as $item){
                if($item !=null){
                    $ProposedContact_phone= new ProposedContact_phone;
                    $ProposedContact_phone->phone=$item;
                    $ProposedContact_phone->proposed_company_id  =$proposedCompany->id;
                    $ProposedContact_phone->contact_id=$contactsProposed->id;
                    $ProposedContact_phone->save();
                }
            }
        }
        //save ProposedContact_fax
        $fArray=json_decode($request->faxies);
        if(sizeof($fArray)>0){
            foreach($fArray as $fax){
                if($fax !=null){
                    $proposedContact_fax= new ProposedContact_fax;
                    $proposedContact_fax->fax=$fax;
                    $proposedContact_fax->proposed_company_id  =$proposedCompany->id;
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
                    $proposedContact_email->proposed_company_id  =$proposedCompany->id;
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
            $proposedCompanyAddress->state=$item[$o];
            $proposedCompanyAddress->zip_code=$zipCodeArray[$o];
            $proposedCompanyAddress->city_id=$cityIdArray[$o];
            $proposedCompanyAddress->country_id=$countryIdArray[$o];
            $proposedCompanyAddress->proposed_company_id=$proposedCompany->id;
            $proposedCompanyAddress->save();
            $o++;
        }
     }

     static function getUpdate(Request $request){

         $id = $request->id;
         DB::table('proposed_company')
         ->where('id',$id)
         ->update([
             'name' => $request->companyName,
             'activity' =>  $request->activity,
             'currency_id' =>  $request->currencyId,
             'introduction' =>  $request->introduction,
             'closing' =>  $request->closing,
             'policy' =>  $request->policy,
         ]);
         DB::table('contacts_proposed')
         ->where('proposed_company_id',$id)
         ->update([
             'first_name' => $request->first_name,
             'last_name' =>  $request->last_name,
             'website' =>  $request->website,
             'position' =>  $request->position,
             'nationality_id' =>  $request->nationality_id,
             'proposed_company_id' =>  $id,
         ]);

         DB::table('proposed_contact_phones')
         ->where('proposed_company_id',$id)
         ->update([
             'phone' => $request->phone,
             'proposed_company_id' =>  $id,
         ]);
         DB::table('proposedContact_emails')
         ->where('proposed_company_id',$id)
         ->update([
             'email' => $request->email,
             'proposed_company_id' =>  $id,
         ]);
         DB::table('proposedContact_faxes')
         ->where('proposed_company_id',$id)
         ->update([
             'fax' => $request->faxies,
             'proposed_company_id' =>  $id,
         ]);
         DB::table('proposedCompany_addresses')
         ->where('proposed_company_id',$id)
         ->update([
             'street' => $request->street,
             'state' => $request->state,
             'zip_code' => $request->zip_code,
             'city_id' => $request->city_id,
             'country_id' => $request->country_id,
             'proposed_company_id' =>  $id,
         ]);
     }

     static function getShow($id){
         $data = proposed_company::select("id", 'name as Company Name', 'activity', "introduction",'closing', 'policy', 'image')
             ->where('id', $id)
             ->get();
         $data->map(function ($item) {
             $item->first_name = $item->Contact[0]['first_name'];
             $item->last_name = $item->Contact[0]['last_name'];
             $item->website = $item->Contact[0]['website'];
             $item->position = $item->Contact[0]['position'];
             $item->nationality = $item->Contact[0]->nationality['nationality'];
             $item->personal_phone = $item->phone[0]['phone'];
             $item->personal_mail = $item->email[0]['email'];
             $item->personal_fax = $item->fax[0]['fax'];
             $item->street = $item->address[0]['street'];
             $item->state = $item->address[0]['state'];
             $item->zip_code = $item->address[0]['zip_code'];
             $item->city = $item->address[0]->city['name'];
             $item->country = $item->address[0]->country['name'];
             unset($item->Contact);
             unset($item->phone);
             unset($item->email);
             unset($item->fax);
             unset($item->address);
         });
         return $data ;
     }

     static function getDestroy($id){

         proposed_company::findOrFail($id)->delete();
     }

     static function getSearch(Request $request){
         $search = $request->searchInput;
         if (Auth::user()->type === 'admin' ) {
             $company = DB::table('proposed_company')
             ->where('name', 'LIKE', '%' . $search . '%')
             ->get();
             return $company;

         }
     }

}
