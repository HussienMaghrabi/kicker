<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class Company extends Model
{
   
     protected $table = 'companies';
     protected $primaryKey = 'id';
     public $incrementing = true;
     protected $keyType = 'integer';
     public $timestamps = true;
     protected $fillable = ['name','industry_id','employees_Number','rating','logo','description','annual_revenue','lead_source_id'];

     
//     protected $fillable = [
//         'name'
//     ];



    public function phones()
    {
         return $this->hasMany('App\Phone','company_id');
    }

    public function faxes()
    {
         return $this->hasMany('App\Fax','company_id');
    }
    public function items()
    {
         return $this->hasMany('App\Item','company_id');
    }
    public function emails()
    {
         return $this->hasMany('App\Email','company_id');
    }
    public function currencies ()
    {
         return $this->hasMany('App\currency','company_id');
    }
    public function proposals ()
    {
         return $this->hasMany('App\Proposal','company_id');
    }

     public function address()
     {
     return $this->hasMany(Address::class);
     //return $this->belongsTo('App\Note');
     }

     static function getIndex(){
         $leads= Company::select("id", "name", "lead_type", "phone", "mobile", "email", "lead_privacy as lead_status")->get();
         return $leads;
     }

     static function getStore(Request $request){

//        dd($request);
         $company = new Company;
         if($request->checkboxCompany == "true"){
             $company->lead_type = "company";
         }else{
             $company->lead_type = "individual";
         }
         $company->lead_privacy =       $request->lead_privacy;
         $company->name =               $request->companyName;
         $company->phone =              $request->phones;
         $company->mobile =             $request->mobiles;
         $company->email =              $request->emails;
         $company->fax =                $request->faxes;
         $company->lead_source_id =     $request->leadSourceId;
         $company->industry_id =        $request->industryId;
         $company->annual_revenue =     $request->annualRevenu;
         $company->employees_Number =   $request->employee;
         $company->rating =             $request->rating;
         $company->description =        $request->description;
         if ($request->hasFile('image')) {
             $image = $request->file('image');
             $name = md5($image->getClientOriginalName() . time()) . "." . $image->getClientOriginalExtension();
             $destinationPath = public_path('/img');
             $image->move($destinationPath, $name);
             $company->image   = $name;
         }
         $company->save();

         $address = new Address;
         $address->street =     $request->street;
         $address->state =      $request->state;
         $address->zip_code =   $request->zipCode;
         $address->company_id = $company->id;
         $address->city_id =    $request->CityId;
         $address->country_id = $request->CountryId;
         $address->save();

         $contact = new Contact;
         $contact->first_name = $request->firstName;
         $contact->last_name =  $request->lastName;
         $contact->title_id =   $request->titleId;
         $contact->phone =      $request->personalPhone;
         $contact->mobile =     $request->personalMobile;
         $contact->email =      $request->personalMail;
         $contact->position =   $request->position;
         $contact->company_id = $company->id;
         $contact->leadstatus = $request->leadStatus;
         $contact->save();



     }

     static function getEditCompany(Request $request){
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
         //echo dd($request->lead_source);
     }

     static function getEditAddress(Request $request){
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

     static function getDestroy($id){
        Company::findOrFail($id)->delete();
     }

}
