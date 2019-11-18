<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Meeting;
use App\ToDo;
use Validator;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         $data = Meeting::select('id' ,'lead_id' ,'date' ,'time' ,'location')->get();
        $data->map(function ($item)  {
            $item->leads = $item->lead['name'];
            unset($item->lead);
            unset($item->lead_id);
        });
        return $this->successResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $auth = $this->auth();
        $rules =  [
            'lead_id'      => 'required',
            'contact_id'   => 'required',
            'duration'     => 'required',
            'date'         => 'required',
            'time'         => 'required',
            'probability'  => 'required',
            'location'     => 'required',
            'description'  => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }

        $input = $request->except('due_date','to_do_type','status');
        $input['user_id'] = $auth;
        $data['meeting'] = Meeting::create($input);
        if ($request->to_do_type) {
            $todo = $request->except('contact_id','duration','date','time','probability','location');
            $todo['user_id'] = $auth;
            $todo['status'] = 'pending';
            $todo['meeting_id'] = $data['meeting']->id;
            $data['todo'] = ToDo::create($todo);
        }

        $message = __('admin.created');
        return $this->successResponse($data, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data= Meeting::where('id', $id)->select("id", "lead_id", "duration", 'date', 'location', 'probability', 'description')
            ->get();
        $data->map(function ($item)  {
            $item->leads = $item->lead['name'];
            unset($item->lead);
            unset($item->lead_id);
        });
        return $this->successResponse($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $auth = $this->auth();
        $rules =  [
            'lead_id'      => 'required',
            'contact_id'   => 'required',
            'duration'     => 'required',
            'date'         => 'required',
            'time'         => 'required',
            'probability'  => 'required',
            'location'     => 'required',
            'description'  => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        $input = $request->except('due_date','to_do_type','status');
        $input['user_id'] = $auth;

        $data['meeting'] = Meeting::find($id);
        $data['meeting']->update($input);

        if ($request->to_do_type) {
            $todo = $request->except('contact_id','duration','date','time','probability','location');
            $todo['user_id'] = $auth;
            $todo['meeting_id'] = $id;
            $todo['status'] = 'pending';
            $data['todo'] = ToDo::where('meeting_id',$id)->first();
            $data['todo']->update($todo);
        }

        $message = __('admin.updated');
        return $this->successResponse($data, $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = Meeting::findOrFail($id);
        $data->delete();
        $message = __('admin.deleted');
        return $this->successResponse(null, $message);

    }
}
