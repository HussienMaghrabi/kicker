<?php

namespace App\Http\Controllers;

use App\MeetingStatus;
use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;

class MeetingStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (checkRole('settings') or @auth()->user()->type == 'admin') {
                return $next($request);
            } else {
                session()->flash('error', __('admin.you_dont_have_permission'));
                return back();
            }
        });
    }

    public function index()
    {
        $statuses = MeetingStatus::all();
        return response()->json($statuses);
//        $sources=
        // return view('admin.meeting_statuses.index', ['title' => trans('admin.meeting_statuses'), 'index' => $statuses]);
    }

    public function create()
    {
        return view('admin.meeting_statuses.create', ['title' => trans('admin.meeting_status')]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:191',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'name' => trans('admin.name'),
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Check your inputs'
            ],302);
        } else {
            $status = new MeetingStatus;
            $status->name = $request->name;
            if($request->has_next_action){
                $status->has_next_action = $request->has_next_action;
            }
            $status->user_id = auth()->user()->id;
            $status->save();

            session()->flash('success', trans('admin.created'));

            $old_data = json_encode($status);
            LogController::add_log(
                __('admin.created', [], 'ar') . ' ' . $status->name,
                __('admin.created', [], 'en') . ' ' . $status->name,
                'meeting_statuses',
                $status->id,
                'create',
                auth()->user()->id,
                $old_data
            );
            
            return response()->json(["status","Added"],200);
            // return redirect(adminPath().'/meeting_statuses');
        }
    }

    public function show($id)
    {
        $show = MeetingStatus::find($id);
        return response()->json($show);
        // return view('admin.meeting_statuses.show', ['title' => trans('admin.meeting_status'), 'show' => $show]);
    }

    public function edit($id)
    {
        $edit = MeetingStatus::find($id);
        return view('admin.meeting_statuses.edit', ['title' => trans('admin.meeting_status'), 'edit' => $edit]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:191',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'name' => trans('admin.name'),
        ]);


        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $status = MeetingStatus::find($id);
            $old_data = json_encode($status);
            $status->name = $request->name;
            $status->has_next_action = $request->has_next_action;
            $status->save();

            session()->flash('success', trans('admin.updated'));

            $new_data = json_encode($status);
            LogController::add_log(
                __('admin.updated', [], 'ar') . ' ' . $status->name,
                __('admin.updated', [], 'en') . ' ' . $status->name,
                'meeting_statuses',
                $status->id,
                'update',
                auth()->user()->id,
                $old_data,
                $new_data
            );
            
            return response()->json([
                'massege' => 'updated'
            ],200);
            
            // return redirect(adminPath().'/meeting_statuses');
        }
    }

    public function destroy($id)
    {
        $data = MeetingStatus::find($id);

        $old_data = json_encode($data);
        LogController::add_log(
            __('admin.deleted', [], 'ar') . ' ' . $data->name,
            __('admin.deleted', [], 'en') . ' ' . $data->name,
            'meeting_statuses',
            $data->id,
            'delete',
            auth()->user()->id,
            $old_data
        );
        $data->delete();
        return response()->json(["status","deleted"],200);
        // session()->flash('success', trans('admin.deleted'));
        // return redirect(adminPath().'/meeting_statuses');
    }

    public function searchMeetingStatus(Request $request){
        $search = $request->searchInput;
        if (Auth::user()->type === 'admin') {
            $meetingStatus = DB::table('meeting_statuses')
            ->where('id','LIKE','%' . $search . '%')
			->orwhere('name', 'LIKE', '%' . $search . '%')
            ->orWhere('has_next_action', 'LIKE', '%' . $search . '%')                  
            ->select('id','name','has_next_action')
            ->get();
            return $meetingStatus;
        }

    }
}
