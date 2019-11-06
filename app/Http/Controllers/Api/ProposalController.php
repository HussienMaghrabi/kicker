<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Proposal;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Auth;
use Validator;
use DB;

class ProposalController extends Controller
{
    public function all_proposal_by_id($id){
       $data = Proposal::getProposalCompany($id);
        return $this->successResponse($data);
    }
}