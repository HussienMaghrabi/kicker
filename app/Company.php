<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

}
