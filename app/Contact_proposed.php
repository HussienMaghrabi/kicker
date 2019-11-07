<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact_proposed extends Model
{
    protected $table = 'contacts_proposed';
   
     public function proposedContact_phones()
    {
        return $this->hasMany('App\ProposedContact_phone','contact_id');
    }

    public function proposedContact_faxes()
    {
        return $this->hasMany('App\ProposedContact_fax','contact_id');
    }
    public function proposedContact_emails()
    {
        return $this->hasMany('App\ProposedContact_email','contact_id');
    }

    public function nationality(){
         return $this->belongsTo('App\Nationality');
    }
    
}
