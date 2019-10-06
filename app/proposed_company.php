<?php

namespace App;
use App\Contact_proposed;
use Illuminate\Database\Eloquent\Model;

class proposed_company extends Model
{
    protected $table = 'proposed_company';

    public function proposalContacts(){
        return $this->hasMany('App\Contact_proposed')->with('proposedContact_phones')->with('proposedContact_faxes')->with('proposedContact_emails');
    }
     public function proposalAddress()
    {
        return $this->hasMany('App\ProposedCompany_address','proposed_company_id');
    }
}
