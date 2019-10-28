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

     static function getStore(Request $request){

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

}
