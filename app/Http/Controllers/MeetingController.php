<?php

namespace App\Http\Controllers;

use App\Meeting;
use App\Request as LeadReq;
use App\ToDo;
use App\Lead;
use DB;
use Auth;
use Illuminate\Http\Request;
use Validator;

class MeetingController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (checkRole('meetings') or @auth()->user()->type == 'admin') {
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
    public function index()
    {
        // $meetings = Meeting::get();
        

        $meetings = DB::table('meetings as meeting')
        ->join('users as user','meeting.user_id','=','user.id')
        ->join('leads as lead','meeting.lead_id','=','lead.id')

        ->select('meeting.id','lead.first_name as lead','user.name as agent','meeting.date','meeting.time','meeting.location')
        ->paginate(100);
        return response()->json($meetings);
        // return view('admin.meetings.index', ['title' => trans('admin.all_meetings'), 'meetings' => $meetings]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.meetings.create', ['title' => trans('admin.add_meeting')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
                // echo dd($request);
        if ($request->has('to_do_type')) {
            $rules = [
                'lead_id' => 'required',
                // 'contact_id' => 'required',
                'date' => 'required',
                'time' => 'required',
                // 'location' => 'required',
                'probability' => 'required',
                'description' => 'required',
                'duration' => 'required',
                'meeting_status_id' => 'required',
                'to_do_type' => 'required',
            ];
        } else {
            $rules = [
                'lead_id' => 'required',
                'contact_id' => 'required',
                'date' => 'required',
                'time' => 'required',
                // 'location' => 'required',
                'probability' => 'required',
                'description' => 'required',
                'duration' => 'required',
                'meeting_status_id' => 'required',
            ];
        }
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'lead_id' => trans('admin.lead'),
            'contact_id' => trans('admin.contact'),
            'date' => trans('admin.date'),
            'time' => trans('admin.time'),
            'duration' => trans('admin.duration'),
            // 'location' => trans('admin.location'),
            'probability' => trans('admin.probability'),
            'description' => trans('admin.description'),
            'meeting_status_id' => trans('admin.meeting_status'),
        ]);
        if ($validator->fails()) {
            echo dd($validator->fails());
           // return back()->withInput()->withErrors($validator);
            return response()->json([ "status" => "faild_Added"],200);
        } else {
            $meeting = new Meeting;
            $meeting->lead_id = $request->lead_id;
            // $meeting->contact_id = $request->contact_id;
            $meeting->date = strtotime($request->date);
            $meeting->time = $request->time;
            $meeting->probability = $request->probability;
            $meeting->description = $request->description;
            // $meeting->location = $request->location;
            $meeting->location = "24";
            $meeting->duration = $request->duration;
            $meeting->meeting_status_id = $request->meeting_status_id;
            $meeting->budget = $request->budget;
            $meeting->user_id = auth()->user()->id;
            // foreach ($request->projects as $value) {
            //     $meeting->projects = $value;
            // }
            $meeting->save();

            if ($request->has('to_do_type')) {
                $todo = new ToDo;
                $todo->user_id = auth()->user()->id;
                $todo->leads = $request->lead_id;
                $todo->due_date = strtotime($request->to_do_due_date);
                $todo->to_do_type = $request->to_do_type;
                $todo->description = $request->to_do_description;
                $todo->status = 'pending';

                $todo->save();
            }

            if ($request->has('req_location')) {
                $req = new LeadReq;
                $req->lead_id = $request->lead_id;
                $req->location = $request->req_location;
                $req->down_payment = $request->req_down_payment;
                $req->area_from = $request->req_area_from;
                $req->area_to = $request->req_area_to;
                $req->price_from = $request->req_price_from;
                $req->price_to = $request->req_price_to;
                $req->date = $request->req_date;
                $req->notes = $request->req_notes;
                $req->user_id = auth()->user()->id;
                $req->save();
            }

            DB::table('lead_actions')->insert([
                'lead_id' => $request->lead_id,
                'type' => 'meeting',
                'agent_type' => 0,
                'time' => strtotime(time()),
                'user_id' => auth()->user()->id,
            ]);

            $old_data = json_encode($meeting);
            LogController::add_log(
                __('admin.created', [], 'ar') . ' ' . __('admin.meeting', [], 'ar'),
                __('admin.created', [], 'en') . ' ' . __('admin.meeting', [], 'en'),
                'meetings',
                $meeting->id,
                'create',
                auth()->user()->id,
                $old_data
            );

            // session()->flash('success', trans('admin.created'));
            // return redirect(adminPath() . '/meetings/' . $meeting->id);
            return response()->json([ "status" => "Added"],200);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function show(Meeting $meeting)
    {
        // $meeting = Meeting::find($id);
        // return view('admin.meetings.show', ['title' => trans('admin.meeting'), 'meeting' => $meeting]);

        $meetings = DB::table('meetings as meeting')
        ->leftjoin('users as user','meeting.user_id','=','user.id')
        ->leftjoin('leads as lead','meeting.lead_id','=','lead.id')
        ->where('meeting.id','=', $meeting->id)
        ->select('user.name as agent','lead.first_name as leadName','meeting.duration','meeting.date','meeting.location',
        'meeting.projects','meeting.probability','meeting.description')
        ->first();
    

        return response()->json($meetings);

        

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function edit(Meeting $meeting)
    {
        return view('admin.meetings.edit', ['title' => trans('admin.edit_meeting'), 'meeting' => $meeting]);
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Meeting  $meeting
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Meeting $meeting) {
    //    return ($request);

		$rules = [
			'lead_id' => 'required',
			// 'contact_id' => 'required',
			'date' => 'required',
			'time' => 'required',
			'location' => 'required',
			'probability' => 'required',
			'description' => 'required',
			'duration' => 'required',
		];
		$validator = Validator::make($request->all(), $rules);
		$validator->SetAttributeNames([
			'lead_id' => trans('admin.lead'),
			// 'contact_id' => trans('admin.contact'),
			'date' => trans('admin.date'),
			'time' => trans('admin.time'),
			'duration' => trans('admin.duration'),
			'location' => trans('admin.location'),
			'probability' => trans('admin.probability'),
			'description' => trans('admin.description'),
		]);
		if ($validator->fails()) {
			return back()->withInput()->withErrors($validator);
		} else {
			$old_data = json_encode($meeting);
			// dd($old_data);
			$meeting->lead_id = $request->lead_id;
			$meeting->contact_id = $request->contact_id;
			$meeting->date = strtotime($request->date);
			$meeting->time = $request->time;
			$meeting->probability = $request->probability;
			$meeting->description = $request->description;
			$meeting->location = $request->location;
			$meeting->duration = $request->duration;
			$meeting->user_id = auth()->user()->id;
			$meeting->save();

            session()->flash('success', trans('admin.updated'));

            $new_data = json_encode($meeting);
            LogController::add_log(
                __('admin.updated', [], 'ar') . ' ' . __('admin.meeting', [], 'ar'),
                __('admin.updated', [], 'en') . ' ' . __('admin.meeting', [], 'en'),
                'meetings',
                $meeting->id,
                'update',
                auth()->user()->id,
                $old_data,
                $new_data
            );

            return redirect(adminPath() . '/meetings/' . $meeting->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meeting $meeting)
    {
        $old_data = json_encode($meeting);
        LogController::add_log(
            __('admin.deleted', [], 'ar') . ' ' . __('admin.meeting', [], 'ar'),
            __('admin.deleted', [], 'en') . ' ' . __('admin.meeting', [], 'en'),
            'meetings',
            $meeting->id,
            'delete',
            auth()->user()->id,
            $old_data
        );

        $meeting->delete();
        // session()->flash('success', trans('admin.deleted'));
        // return redirect(adminPath() . '/meetings');
    return response()->json([ "status" => "done"],200);


    }
    public function searchMeeting(Request $request){

        $search = $request->searchInput;
        if (Auth::user()->type === 'admin' ) {
            $meetings = DB::table('meetings as meeting')
            ->join('users as user','meeting.user_id','=','user.id')
            ->join('leads as lead','meeting.lead_id','=','lead.id')
            ->select('meeting.id','lead.first_name as lead','user.name as agent','meeting.date','meeting.time','meeting.location')
			->where('meeting.id', 'LIKE', '%' . $search . '%')
            ->select('meeting.id','lead.first_name as lead','user.name as agent','meeting.date','meeting.time','meeting.location')
            ->get();
            return $meetings;
        }

    }
 
    public function getMeetingsInputs(){
        $leads = Lead::getAgentLeads();
        $meeting_statuses = DB::table('meeting_statuses')->select('id','name')->get();
        $projects = DB::table('projects')->select('id','en_name')->get();
        
        return response()->json([
            'leads' => $leads,
            'meeting_statuses' => $meeting_statuses,
            'projects' => $projects
        ]);
    }
    public function getcontactLead($id)
    {
        // dd('aaa');
        // return $id;
        $contactsLeads = DB::table('contacts')
                         ->where('lead_id',$id)
                         ->select('id','name')
                         ->get();


        // $contactsLeads = DB::table('meetings')
        // ->join('contacts','contacts.lead_id','=','meetings.lead_id')
        // ->where('meetings.lead_id',$id)
        // ->select('contacts.id','contacts.name')
        // ->get();

        // $contactsLeads = Contact::getAgentLeads($id)->where('id',$id)->get();
        return response()->json($contactsLeads);
    }
}
