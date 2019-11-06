<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contact;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Auth;
use Validator;
use DB;

class contactsController extends Controller
{
    public function contact_by_id($id){
        $data = Contact::contactsPerson($id);
        return $this->successResponse($data);

    }
}