<?php

namespace App\Http\Controllers;

use App\ProjectRequest;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;

class ProjectRequestController extends Controller
{
    public function index()
    {
        $projectRequests = DB::table('project_requests')
        ->select('id','name','location','developer','updated_at')
        ->paginate(100);
        return response()->json($projectRequests);
    }
    public function create(Request $request){
		
	}
	public function destroy(ProjectRequest $projectRequest)
    {
        $projectRequest->delete();
        return response()->json([
            'status' => 'done'
        ],200);
    }

	public function edit(Request $request, $id){
	
    }
    
    public function searchProjectRequest(Request $request){
        $search = $request->searchInput;
        if (Auth::user()->type === 'admin' ) {
            $projectRequest = DB::table('project_requests')
			->where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('location', 'LIKE', '%' . $search . '%')            
			->orWhere('developer', 'LIKE', '%' . $search . '%')        
            ->orWhere('updated_at', 'LIKE', '%' . $search . '%')        
            ->select('id','name','location','developer','updated_at')
            ->get();
            return $projectRequest;
        }

    }
}
