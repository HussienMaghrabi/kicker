<?php

namespace App\Http\Controllers;

use App\CallStatus;
use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;

class CallStatusController extends Controller
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
        $statuses = CallStatus::paginate(100);
        return response()->json($statuses);
//        $sources=
        // return view('admin.call_statuses.index', ['title' => trans('admin.call_statuses'), 'index' => $statuses]);
        
    }

    public function create()
    {
        return view('admin.call_statuses.create', ['title' => trans('admin.call_status')]);
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
            return back()->withInput()->withErrors($validator);
        } else {
            $status = new CallStatus;
            $status->name = $request->name;
            $status->has_next_action = $request->has_next_action;
            $status->user_id = auth()->user()->id;
            $status->save();

            session()->flash('success', trans('admin.created'));

            $old_data = json_encode($status);
            LogController::add_log(
                __('admin.created', [], 'ar') . ' ' . $status->name,
                __('admin.created', [], 'en') . ' ' . $status->name,
                'call_statuses',
                $status->id,
                'create',
                auth()->user()->id,
                $old_data
            );

            return redirect(adminPath().'/call_statuses');
        }
    }

    public function show($id)
    {
        $show = CallStatus::find($id);
        return response()->json($show);


        // return view('admin.call_statuses.show', ['title' => trans('admin.call_status'), 'show' => $show]);
    }

    public function edit($id)
    {
        $edit = CallStatus::find($id);
        return view('admin.call_statuses.edit', ['title' => trans('admin.call_status'), 'edit' => $edit]);
    }

    public function update(Request $request, $id)
    {
        // dd($id);
        // dd('sadsa');
        // dd($request->name);
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
            $status = CallStatus::find($id);
            $old_data = json_encode($status);
            $status->name = $request->name;
            $status->has_next_action = $request->has_next_action;
            $status->update();

            session()->flash('success', trans('admin.updated'));

            $new_data = json_encode($status);
            LogController::add_log(
                __('admin.updated', [], 'ar') . ' ' . $status->name,
                __('admin.updated', [], 'en') . ' ' . $status->name,
                'call_statuses',
                $status->id,
                'update',
                auth()->user()->id,
                $old_data,
                $new_data
            );
            return response()->json([
                'massege' => 'updated'
            ],200);
            // return redirect(adminPath().'/call_statuses');
        }
    }

    public function destroy($id)
    {
        // dd($id);
        $data = CallStatus::find($id);

        $old_data = json_encode($data);
        LogController::add_log(
            __('admin.deleted', [], 'ar') . ' ' . $data->name,
            __('admin.deleted', [], 'en') . ' ' . $data->name,
            'call_statuses',
            $data->id,
            'delete',
            auth()->user()->id,
            $old_data
        );
        $data->delete();
        // session()->flash('success', trans('admin.deleted'));
        // return redirect(adminPath().'/call_statuses');
        return response()->json([ "status" => "done"],200);
    }
    public function returnForApi(){
        $statuses = CallStatus::all();
        return response()->json([
            'data' => $this->statusCollection($statuses)
        ]);
    }
    private function statusCollection($pram){
        return array_map([$this,"returnstatus"],$pram->toArray());
    }
    private function returnstatus($pram){
        return [
            'id' => $pram['id'],
            'name' => $pram['name'],
            "nextAction" => (boolean) $pram['has_next_action']
        ];
    }


    public function searchCallStatus(Request $request){
        $search = $request->searchInput;
        if (Auth::user()->type === 'admin') {
            $callStatus = DB::table('call_statuses')
            ->where('id','LIKE','%' . $search . '%')
			->orwhere('name', 'LIKE', '%' . $search . '%')
            ->orWhere('has_next_action', 'LIKE', '%' . $search . '%')                  
            ->select('id','name','has_next_action')
            ->get();
            return $callStatus;
        }

    }

}
