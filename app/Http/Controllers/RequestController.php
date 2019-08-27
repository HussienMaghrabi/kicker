<?php

namespace App\Http\Controllers;

use App\InterestedRequest;
use App\Project;
use App\RequestBroadcast;
use App\Request as Model;
use Auth;
use DB;
use Illuminate\Http\Request as Request;
use Validator;

class RequestController extends Controller {
	public function __construct() {
		$this->middleware(function ($request, $next) {
			if (checkRole('requests') or @auth()->user()->type == 'admin') {
				return $next($request);
			} else {
				session()->flash('error', __('admin.you_dont_have_permission'));
				return back();
			}
		});
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$user_id = auth()->user()->id;
		//$myRequests = Model::where('user_id',$user_id)->orderBy('created_at', 'desc')->paginate();
		$myRequests = DB::table('requests as request')
			->join('leads as lead',function($query){
				$query->on('request.lead_id','lead.id');
			})
			->where('request.user_id','=',$user_id)
			->select('request.id','lead.first_name','lead.last_name','request.unit_type','request.price_from','request.price_to','request.created_at','request.date')
			->orderBy('request.created_at', 'desc')
			->paginate(100);
		$groupMembers = DB::table('group_members AS members')
		->join('group_members AS user_group', function ($join) use ($user_id){
				$join
				->select('user_group.member_id', 'user_group.group_id')
				->on('user_group.group_id', '=', 'members.group_id')
				->where('user_group.member_id', $user_id);
		})
		->groupBy('members.member_id')
		->pluck('members.member_id');

		//$teamRequests = Model::whereIn('user_id',$groupMembers)->with('lead')->orderBy('created_at', 'desc')->paginate();
		$teamRequests = DB::table('requests as request')
			->join('leads as lead',function($query){
				$query->on('request.lead_id','lead.id');
			})
			->join('users as user','user.id','=','request.user_id')
			->whereIn('request.user_id',$groupMembers)
			->select('request.id','user.name as agent','lead.first_name','lead.last_name','request.unit_type','request.price_from','request.price_to','request.created_at','request.date')
			->orderBy('request.created_at', 'desc')
			->paginate(100);
			$broadcast = DB::table('requests_broadcast as requests')
			->join('users as user','requests.user_id','=','user.id')
            ->select('requests.id','user.name','requests.unit_type','requests.price_from','requests.price_to','requests.created_at','requests.date')
			->paginate(100);
		return response()->json([
			'myrequest' => $myRequests,
			'teamRequests' => $teamRequests,
			'broadcastRequests' => $broadcast
		]);
		// return view('admin.requests.index', ['title' => trans('admin.all_requests'), 'index' => $myRequests , 'teamRequests' => $teamRequests ,'broadcastRequests'=>$broadcastRequests]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('admin.requests.create', ['title' => trans('admin.add_request')]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		// return $request;
		if ('land' == $request->unit_type) {
			$rules = [
				'lead' => 'required|max:191',
				'location' => 'required|max:191',
				'down_payment' => 'required|max:191',
				// 'unit_type_id' => 'required|max:191',
				'unit_type' => 'required|max:191',
				'request_type' => 'required|max:191',
				'area_from' => 'required|numeric|min:0',
				'area_to' => 'required|numeric|min:' . $request->area_from,
				'price_from' => 'required|numeric|min:0',
				'price_to' => 'required|numeric|min:' . $request->price_from,
				'date' => 'required|max:191',
				'buyer_seller' => 'required',
			];
		} else {
			$rules = [
				'lead' => 'required|max:191',
				'location' => 'required|max:191',
				'down_payment' => 'required|max:191',
				// 'unit_type_id' => 'required|max:191',
				'unit_type' => 'required|max:191',
				// 'request_type' => 'required|max:191',
				'area_from' => 'required|numeric|min:0',
				'area_to' => 'required|numeric|min:' . $request->area_from,
				'price_from' => 'required|numeric|min:0',
				'price_to' => 'required|numeric|min:' . $request->price_from,
				'date' => 'required|max:191',
				'buyer_seller' => 'required',
			];
		}
		$validator = Validator::make($request->all(), $rules);
		$validator->SetAttributeNames([
			'lead' => trans('admin.lead'),
			'location' => trans('admin.location'),
			'request_type' => trans('admin.request_type'),
			'unit_type_id' => trans('admin.type'),
			'unit_type' => trans('admin.unit_type'),
			'down_payment' => trans('admin.down_payment'),
			'area_from' => trans('admin.area_from'),
			'area_to' => trans('admin.area_to'),
			'date' => trans('admin.date'),
			'price_from' => trans('admin.price_from'),
			'price_to' => trans('admin.price_to'),
			'buyer_seller' => trans('admin.buyer_seller'),
		]);
		if ($validator->fails()) {
			return back()->withInput()->withErrors($validator);
		} else {
			$req = new Model;
			$req->lead_id = $request->lead;
			$req->location = $request->location;
			$req->down_payment = $request->down_payment;
			$req->area_from = $request->area_from;
			$req->area_to = $request->area_to;
			$req->price_from = $request->price_from;
			$req->price_to = $request->price_to;
			$req->date = $request->date;
			$req->unit_type = $request->unit_type;
			$req->project_id = $request->project_id;
			$req->lat = $request->lat;
			$req->lng = $request->lng;
			$req->zoom = $request->zoom;
			$req->type = $request->buyer_seller;
			if ('land' != $request->unit_type) {
				$req->request_type = $request->request_type;
				$req->unit_type_id = $request->unit_type_id;
			} else {
				$req->request_type = 'land';
				$req->unit_type_id = 0;
			}

			if ($request->request_type != 'new_home' or $request->request_type != 'land') {
				$req->rooms_from = $request->rooms_from;
				$req->rooms_to = $request->rooms_to;
				$req->bathrooms_from = $request->bathrooms_from;
				$req->bathrooms_to = $request->bathrooms_to;
			}
			$req->notes = $request->notes;
			$req->user_id = Auth::user()->id;
			$req->save();
			// dd($req);

			DB::table('lead_actions')->insert([
				'lead_id' => $request->lead,
				'type' => 'request',
				'agent_type' => 0,
				'time' => strtotime(time()),
				'user_id' => Auth::user()->id,
			]);

			$old_data = json_encode($req);
			LogController::add_log(
				__('admin.created', [], 'ar') . ' ' . __('admin.request', [], 'ar'),
				__('admin.created', [], 'en') . ' ' . __('admin.request', [], 'en'),
				'requests',
				$req->id,
				'create',
				auth()->user()->id,
				$old_data
			);

			// session()->flash('success', trans('admin.created'));
			// return redirect(adminPath() . '/requests/' . $req->id);
			return response()->json(['status' => 'Added'],200);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function show(Model $request) {
		// return $request ;
		// return view('admin.requests.show', ['title' => trans('admin.all_requests'), 'req' => $request]);
		$request = DB::table('requests')
		->leftjoin('projects','requests.project_id','=','projects.id')
		->leftjoin('leads','requests.lead_id','=','leads.id')
		->where('requests.id','=',$request->id)
		->select('requests.id','leads.id as lead','leads.first_name as leadName','requests.price_from','requests.price_to','requests.area_from','requests.area_to','requests.request_type','requests.type','requests.unit_type','requests.rooms_from','requests.rooms_to','requests.bathrooms_from','requests.bathrooms_to','requests.location','requests.date','requests.down_payment','projects.en_name as project','requests.notes')
		->first();
        return response()->json($request);
        

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Model $request) {
		return view('admin.requests.edit', ['title' => trans('admin.edit_lead'), 'data' => $request]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $asd) {
		// dd($request->all());
		// return  $request;
		$rules = [
			'lead' => 'required|max:191',
			'unit_type' => 'required|max:191',
			'price_from' => 'required|numeric|min:0',
			// 'price_to' => 'required|numeric|min:' . $request->price_from . '',
			'date' => 'required|max:191',
			'notes' => 'required',

			'area_from' => 'required|numeric|min:',
			'area_to' => 'required|numeric|min:',
			'request_type' => 'required',
			'type' => 'required',
			'rooms_from' => 'required|numeric|min:',
			'rooms_to' => 'required|numeric|min:',
			'bathrooms_from' => 'required|numeric|min:',
			'bathrooms_to' => 'required|numeric|min:',
			'location' => 'required',
			'down_payment' => 'required|numeric',
			'project' => 'required',
		];
		$validator = Validator::make($request->all(), $rules);
		$validator->SetAttributeNames([
			'lead' => trans('admin.lead'),
			'unit_type' => trans('admin.unit_type'),
			'price_from' => trans('admin.price') . ' ' . trans('admin.from'),
			'price_to' => trans('admin.price') . ' ' . trans('admin.to'),
			'date' => 'required|max:191',
			'notes' => trans('admin.notes'),

			'area_from' => trans('admin.area') . ' ' . trans('admin.from'),
			'area_to' => trans('admin.area') . ' ' . trans('admin.to'),
			'request_type' => trans('admin.request_type'),
			'type' => trans('admin.type'),
			'rooms_from' => trans('admin.rooms') . ' ' . trans('admin.from'),
			'rooms_to' => trans('admin.rooms') . ' ' . trans('admin.to'),
			'bathrooms_from' => trans('admin.bathrooms') . ' ' . trans('admin.from'),
			'bathrooms_to' => trans('admin.bathrooms') . ' ' . trans('admin.to'),
			'location' => trans('admin.location'),
			'down_payment' => trans('admin.down_payment'),
			'project' => trans('admin.project'),
		]);

		if ($validator->fails()) {
			return ("validation error");
			// return back()->withInput()->withErrors($validator);
		} else {
			$lead = Model::find($asd);
			$lead->lead_id = $request->lead;
			$lead->unit_type_id = $request->unit_type;
			$lead->price_from = $request->price_from;
			$lead->price_to = $request->price_to;
			$lead->date = $request->date;
			// $lead->date_from = strtotime($request->start_date);
			// $lead->date_to = strtotime($request->end_date);
			$lead->notes = $request->notes;
			$lead->type = $request->buyer_seller;

			$lead->area_from = $request->area_from;
			$lead->area_to = $request->area_to;
			$lead->request_type = $request->request_type;
			$lead->unit_type = $request->type;
			$lead->rooms_from = $request->rooms_from;
			$lead->rooms_to = $request->rooms_to;
			$lead->bathrooms_from = $request->bathrooms_from;
			$lead->bathrooms_to = $request->bathrooms_to;
			$lead->location = $request->location;
			$lead->down_payment = $request->down_payment;
			$lead->project_id = $request->project;
			$lead->save();
			// return redirect(adminPath() . '/requests');
		return response()->json([ "status" => "done"],200);
			
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($request) {
		$data = Model::find($request);

		$old_data = json_encode($data);
		LogController::add_log(
			__('admin.deleted', [], 'ar') . ' ' . __('admin.request', [], 'ar'),
			__('admin.deleted', [], 'en') . ' ' . __('admin.request', [], 'en'),
			'requests',
			$data->id,
			'delete',
			auth()->user()->id,
			$old_data
		);

		$data->delete();
		// session()->flash('success', trans('admin.deleted'));
		return response()->json([ "status" => "done"],200);

		// return redirect(adminPath() . '/requests');
	}

	public function interestedRequest($unit, $req) {
		if (InterestedRequest::where('unit_id', $unit)->where('request_id', $req)->count()) {
			$interests = InterestedRequest::where('unit_id', $unit)->where('request_id', $req)->get();
			foreach ($interests as $interest) {
				$interest->delete();
			}
			session()->flash('success', __('admin.removed'));
		} else {
			$interest = new InterestedRequest;
			$interest->unit_id = $unit;
			$interest->request_id = $req;
			$interest->save();
			session()->flash('success', __('admin.added'));
		}

		session()->flash('return_to_suggestions', 1);
		return back();
	}

	public function getProjects(Request $r) {
		$projects = Project::where('developer_id', $r->id)->get();
		return view('admin.requests.get_projects', compact('projects'));
	}
	public function searchRequest(Request $request){
        $search = $request->searchInput;
        if (Auth::user()->type === 'admin' ) {
			$requests = DB::table('requests')
			->join('leads as lead','requests.lead_id','=','lead.id')
			->where('requests.id', 'LIKE', '%' . $search . '%')
            ->orWhere('requests.unit_type', 'LIKE', '%' . $search . '%')  
            ->select('requests.id','lead.first_name','requests.unit_type','requests.price_from','requests.price_to','requests.created_at','requests.date')
			->get();
            return $requests;
        }

	}
	public function searchTeam(Request $request){
        $search = $request->searchInput;
        if (Auth::user()->type === 'admin' ) {
			$teams = DB::table('requests')
			->join('leads as lead','requests.lead_id','=','lead.id')
			->join('users as user','requests.user_id','=','user.id')

			->where('requests.id', 'LIKE', '%' . $search . '%')
			->orWhere('requests.unit_type', 'LIKE', '%' . $search . '%')  
            ->orWhere('lead.first_name', 'LIKE', '%' . $search . '%')  
            ->orWhere('user.name', 'LIKE', '%' . $search . '%')  
            ->select('requests.id','lead.first_name','user.name as agent','requests.unit_type','requests.price_from','requests.price_to','requests.created_at','requests.date')
			->get();
			// dd($teams);
            return $teams;
        }

	}
	public function searchBroadcast(Request $request){
        $search = $request->searchInput;
        if (Auth::user()->type === 'admin' ) {
			$broadcast = DB::table('requests_broadcast as requests')
			->join('users as user','requests.user_id','=','user.id')
			
			->where('requests.id', 'LIKE', '%' . $search . '%')
            ->orWhere('requests.unit_type', 'LIKE', '%' . $search . '%')
            ->select('requests.id','user.name','requests.unit_type','requests.price_from','requests.price_to','requests.created_at','requests.date')
			->get();
            return $broadcast;
        }

	}

	public function getMeRequestInputs(){
        $leads = DB::table('leads')->select('id','first_name')->get();
        return response()->json($leads);
	}

	public function getRequestSuggestions()
    {
        $suggestions = DB::table('suggestions as suggestion')
			->leftjoin('locations as location', 'suggestion.location_id', '=', 'location.id')
			->join('leads as lead', 'suggestion.lead_id', '=', 'lead.id')
			->join('requests as request', 'request.lead_id', '=', 'lead.id')
			->join('projects as project', 'project.location_id', '=', 'suggestion.id')
            ->select('project.id as id','suggestion.id','request.id as requestID','suggestion.title', 'suggestion.type', 'location.en_name as location', 'suggestion.price', 'suggestion.area','request.rooms_from as rooms','request.bathrooms_from as bathrooms','request.date')
            ->get();

        return response()->json($suggestions);
	}
	public function searchSuggestions(Request $request){
        $search = $request->searchInput;
        if (Auth::user()->type === 'admin' ) {
			$Suggestions = DB::table('suggestions as suggestion')
			->leftjoin('locations as location', 'suggestion.location_id', '=', 'location.id')
			->join('leads as lead', 'suggestion.lead_id', '=', 'lead.id')
			->join('requests as request', 'request.lead_id', '=', 'lead.id')
			->join('projects as project', 'project.location_id', '=', 'suggestion.id')
			->where('suggestion.title', 'LIKE', '%' . $search . '%')
			->orwhere('location.en_name', 'LIKE', '%' . $search . '%')
            ->select('project.id','suggestion.id','request.id as requestID','suggestion.title', 'suggestion.type', 'location.en_name as location', 'suggestion.price', 'suggestion.area','request.rooms_from as rooms','request.bathrooms_from as bathrooms','request.date')

			->get();
            return $Suggestions;
        }

    }


}
