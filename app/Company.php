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



    public function contact()
    {
         return $this->hasMany('App\Contact','company_id');
    }
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
     return $this->hasMany('App\Address');
     //return $this->belongsTo('App\Note');
     }

     static function getIndex(){
         $leads= Company::select("id", "name", "lead_type", "phone", "mobile", "email", "lead_privacy as lead_status")->get();
         return $leads;
     }

     static function getShow($id){
         $data= Company::select("id", "name as company_name", "lead_type", "phone", "mobile", "email", "lead_privacy as lead_status")
             ->where('id',$id)
             ->get();
         $data->map(function ($item) {
             $item->street = $item->address[0]['street'];
             $item->state = $item->address[0]['state'];
             $item->zip_code = $item->address[0]['zip_code'];
             $item->country = $item->address[0]->country['name'];
             $item->city = $item->address[0]->city['name'];
             $item->first_name = $item->contact[0]['first_name'];
             $item->last_name = $item->contact[0]['last_name'];
             $item->title = $item->contact[0]->title['name'];
             $item->personal_phone = $item->contact[0]['phone'];
             $item->personal_mobile = $item->contact[0]['mobile'];
             $item->personal_mail = $item->contact[0]['email'];
             $item->position = $item->contact[0]['position'];
             $item->leadstatus = $item->contact[0]['leadstatus'];
             unset($item->address);
             unset($item->contact);
         });
         return $data;
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

     static function getEditCompany(Request $request,$id){

         DB::table("companies")
             ->where('id',$id)
             ->update([
                 'lead_privacy' => $request->lead_privacy,
                 'name' => $request->companyName,
                 'phone' => $request->phones,
                 'mobile' => $request->mobiles,
                 'fax' => $request->faxes,
                 'description' => $request->description,
                 'rating' => $request->rating,
                 'employees_Number' => $request->employees_Number,
                 'annual_revenue' => $request->annual_revenue,
                 'industry_id' => $request->industry,
                 'lead_source_id' => $request->lead_source,
             ]);

         DB::table("addresses")
             ->where('company_id',$id)
             ->update([
                 'street' => $request->street,
                 'state' => $request->state,
                 'zip_code' => $request->zip_code,
                 'city_id' => $request->city_id,
                 'country_id' => $request->country_id,
             ]);

         DB::table("contacts")
             ->where("company_id",$id)
             ->update([
                 'first_name' => $request->first_name,
                 'last_name' => $request->last_name,
                 'title_id' => $request->title_id,
                 'phone' => $request->personalPhone,
                 'mobile' => $request->personalMobile,
                 'email' => $request->personalMail,
                 'position' => $request->position,
                 'leadstatus' => $request->leadstatus,
             ]);
     }



     static function getLeadByProposal($id){
         $data = Proposal::select('company_id')->where('id', $id)->get();
         $data->map(function ($item) {
             $item->company_name = $item->company["name"];
             unset($item->company);
         });
         return $data;
     }

     static function getDestroy($id){
        Company::findOrFail($id)->delete();
     }

    static function getSearch(Request $request){

        $data = Company::where('name', 'LIKE', '%' . $request->searchInput . '%')
        ->orwhere('lead_type', 'LIKE', '%' . $request->searchInput . '%')
        ->orwhere('phone', 'LIKE', '%' . $request->searchInput . '%')
        ->orwhere('mobile', 'LIKE', '%' . $request->searchInput . '%')
        ->orwhere('mobile', 'LIKE', '%' . $request->searchInput . '%')
        ->orwhere('email', 'LIKE', '%' . $request->searchInput . '%')
        ->orwhere('lead_privacy', 'LIKE', '%' . $request->searchInput . '%')
        ->get();
        return $data;


    }

}
