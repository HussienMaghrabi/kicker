<?php

namespace App\Http\Controllers;

use App\Task;
use App\Lead;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use App\AdminNotification;
use App\User;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sources = DB::table('tasks')
                   ->join('users', 'tasks.agent_id', '=', 'users.id')
                   ->select('tasks.id','users.name', 'tasks.leads', 'tasks.due_date', 'tasks.task_type',
                    'tasks.status', 'tasks.description','tasks.agent_id')->paginate(100);
        // return view('admin.tasks.index', ['title' => trans('admin.task'), 'source' => $sources]);
        return response()->json($sources);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tasks.create', ['title' => trans('admin.task')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return response()->json($request);
        $rules = [
            'agent_id' => 'required|max:191',
            'leads' => 'required',
            'due_date' => 'required|max:191',
            'task_type' => 'required|max:191',
            'description' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'agent_id' => trans('admin.agent'),
            'leads' => trans('admin.lead'),
            'due_date' => trans('admin.date'),
            'task_type' => trans('admin.tasks_type'),
            'status' => trans('admin.status'),
            'description' => trans('admin.description'),
        ]);

        if(!is_array($request->leads)){
            $request->leads = (array)$request->leads;
        }
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $task = new Task;
            $task->agent_id = $request->agent_id;

            $task->leads = json_encode($request->leads);
            $task->due_date = strtotime($request->due_date);
            $task->task_type = $request->task_type;
            $task->status = 'pending';
            $task->description =  $request->description;
            $task->user_id = Auth::user()->id;
            $task->save();
            Log::info('TEST');
            $old_data = json_encode($task);
            LogController::add_log(
                __('admin.created', [], 'ar') . ' ' . __('admin.task',[],'ar'),
                __('admin.created', [], 'en') . ' ' . __('admin.task',[],'en'),
                'tasks',
                $task->id,
                'create',
                auth()->user()->id,
                $old_data
            );
              $not = new AdminNotification;
            $not->user_id = auth()->user()->id;
            $not->assigned_to = $request->agent;
            $not->type = 'task';
            $not->type_id = $task->id;
            $not->save();

            $tokens=User::where('refresh_token', '!=', '')->where('id',$request->agent_id)->pluck('refresh_token')->toArray();
            $msg = array(
                'title' => __('admin.task', [], 'en'),
                'body' => Auth::user()->name.' set you in '.$request->task_type.' in '.$request->due_date,
                'image' => 'myIcon',/*Default Icon*/
                'sound' => 'mySound'/*Default sound*/
            );

            notify1($tokens, $msg);
            // session()->flash('success', trans('admin.created'));
            return response()->json([
                'status' => 'added'
            ],200);
            // return redirect(adminPath().'/tasks/'. $task->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($task)
    {
        $sources = DB::table('tasks')->join('users', 'tasks.agent_id', '=', 'users.id')
            ->where('tasks.id',$task)
            ->select('tasks.id','users.name','tasks.user_id', 'tasks.leads', 'tasks.due_date', 'tasks.task_type', 'tasks.status', 'tasks.description','tasks.agent_id')
            ->first();
            return response()->json($sources);

        // return view('admin.tasks.show', ['title' => trans('admin.task'), 'source' => $sources]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit($task)
    {
        $sources = DB::table('tasks')->join('users', 'tasks.agent_id', '=', 'users.id')
            ->where('tasks.id',$task)
            ->select('tasks.id','users.name','tasks.agent_id' ,'tasks.leads', 'tasks.due_date', 'tasks.task_type', 'tasks.status', 'tasks.description')
            ->first();
        return view('admin.tasks.edit', ['title' => trans('admin.task'), 'data' => $sources]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        // dd($request->all());
        $rules = [
            'agent_id' => 'required|max:191',
            'leads' => 'required',
            'due_date' => 'required|max:191',
            'task_type' => 'required|max:191',
            'description' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'agent_id' => trans('admin.agent'),
            'leads' => trans('admin.lead'),
            'due_date' => trans('admin.date'),
            'task_type' => trans('admin.tasks_type'),
            'description' => trans('admin.description'),
        ]);


        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $old_data = json_encode($task);
            $task->agent_id = $request->agent_id;
            $task->leads = $request->leads;
            $task->due_date = strtotime($request->due_date);
            $task->task_type = $request->task_type;
            $task->description =  $request->description;
            $task->save();

            $new_data = json_encode($task);
            LogController::add_log(
                __('admin.updated', [], 'ar') . ' ' . __('admin.task',[],'ar'),
                __('admin.updated', [], 'en') . ' ' . __('admin.task',[],'en'),
                'tasks',
                $task->id,
                'update',
                auth()->user()->id,
                $old_data,
                $new_data
            );

            // session()->flash('success', trans('admin.updated'));
            // return redirect(adminPath().'/tasks/'. $task->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $old_data = json_encode($task);
        LogController::add_log(
            __('admin.deleted', [], 'ar') . ' ' . __('admin.task',[],'ar'),
            __('admin.deleted', [], 'en') . ' ' . __('admin.task',[],'en'),
            'tasks',
            $task->id,
            'delete',
            auth()->user()->id,
            $old_data
        );
        $task->delete();
        // session()->flash('success', trans('admin.deleted'));
        return response()->json([
            'status' => 'done'
        ],200);
        // return redirect(adminPath().'/tasks');
    }

    public function confirm_task($id)
    {
        $task = Task::find($id);
        $task->status = 'done';
        $task->save();
        // session()->flash('success', trans('admin.confirmed'));
        // return back();
        return response()->json(["status"=>"Confirmed"],200);

    }

    public function todosTest(){
        $sources = DB::table('tasks')->join('users', 'tasks.agent_id', '=', 'users.id')
           ->select('tasks.id','users.name', 'tasks.leads', 'tasks.due_date', 'tasks.task_type', 'tasks.status', 'tasks.description')->get();
        return $sources;
    }

    public function searchTasks(Request $request){
        $search = $request->searchInput;
        if (Auth::user()->type === 'admin') {
            $Tasks = DB::table('tasks')
            ->where('id','LIKE','%' . $search . '%')
			->orwhere('agent_id', 'LIKE', '%' . $search . '%')
            ->orWhere('due_date', 'LIKE', '%' . $search . '%')            
			->orWhere('task_type', 'LIKE', '%' . $search . '%')        
            ->orWhere('status', 'LIKE', '%' . $search . '%')        
            ->select('id','agent_id','due_date','task_type','status')
            ->get();
            return $Tasks;
        }

    }

    public function getTaskInputs(){
        $leads = Lead::getAgentLeads();
        $agents = DB::table('users')->select('id','name')->get();
        return response()->json([
            'leads' => $leads,
            'agents' => $agents
        ]);
    }

    public function getAllLeads(){
		
        $leads = Lead::getAgentLeads();
        return response()->json($leads);

	}
}
