<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\proposedCompany_items;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Auth;
use Validator;
use DB;

class ItemsControler extends Controller
{
    public function itemCompany($id){
        $data = proposedCompany_items::getItem($id);
        return $this->successResponse($data);

    }
}