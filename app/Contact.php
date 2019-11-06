<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table='contacts';

    static function contactsPerson($id){
        $data = Contact::select('id','first_name')->where('company_id',$id)->get();
        return $data;
    }
}
