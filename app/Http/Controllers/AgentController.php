<?php

namespace App\Http\Controllers;

use App\RentalUnit;
use App\ResaleUnit;
use App\User;
use App\Group;
use Illuminate\Http\Request;
use Validator;
use DB;
use Hash;
use Auth;
use App\Employee;

class AgentController extends Controller
{
    public function __construct()
    {
        //    $this->middleware(function ($request, $next) {
        //        if (checkRole('settings') or @auth()->user()->type == 'admin') {
        //            return $next($request);
        //        } else {
        //            session()->flash('error', __('admin.you_dont_have_permission'));
        //            return back();
        //        }
        //    });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (checkRole('settings') or @auth()->user()->type == 'admin') {
            $sources = DB::table('users')->join('agent_types', 'users.agent_type_id', '=', 'agent_types.id')
            ->select('users.id', 'users.name', 'users.email', 'users.phone', 'agent_types.name as source_name')
            ->paginate(100);
            return response()->json($sources);
            // return view('admin.agents.index', ['title' => trans('admin.all') . ' ' . trans('admin.agent'), 'index' => $sources]);
        } else {
            return response()->json("Error you dont have permission");
            // session()->flash('error', __('admin.you_dont_have_permission'));
            // return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (checkRole('settings') or @auth()->user()->type == 'admin') {
            return view('admin.agents.create', ['title' => trans('admin.add') . ' ' . trans('admin.agent')]);
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $image = false;
        if ($request->hasFile('image')) {
            $rules = [
                'name' => 'required|max:191',
                'email' => 'email|max:191|unique:users',
                'phone' => 'required|unique:users',
                'agent_source' => 'required|max:191',
                'password' => 'required|max:191',
                'image' => 'required',
                'type' => 'required',
                'residential_commercial' => 'required',
            ];
            $image = true;
        } else {
            $rules = [
                'name' => 'required|max:191',
                'email' => 'email|max:191|unique:users',
                'phone' => 'required',
                'agent_source' => 'required|max:191',
                'password' => 'required|max:191',
                'type' => 'required|max:191',
                'residential_commercial' => 'required',
            ];
        }

        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'name' => trans('admin.name'),
            'email' => trans('admin.email'),
            'phone' => trans('admin.phone'),
            'password' => trans('admin.password'),
            'agent_source' => trans('admin.lead_source'),
            'type' => trans('admin.type'),
            'residential_commercial' => trans('admin.residential_commercial'),
        ]);


        if ($validator->fails()) {
            // return 1;
            return back()->withInput()->withErrors($validator);
        } else {
            // return 2;
            try {
                DB::beginTransaction();
                $lead = new User;
                $lead->name = $request->name;
                $lead->email = $request->email;
                $lead->phone = $request->phone;
                $lead->type = $request->type;
                $lead->role_id = $request->role_id;
                $lead->agent_type_id = $request->agent_source;
                $lead->residential_commercial = $request->residential_commercial;
                $lead->email_password = encrypt($request->email_password);
                $lead->user_id = Auth::user()->id;
                $lead->password = bcrypt($request->password);
                if ($image) {
                    $lead->image = uploads($request, 'image');
                } else {
                    $lead->image = "image.jpg";
                }

                $lead->save();
                $emp = new Employee();
                $emp->en_first_name = $request->name;
                $emp->personal_mail = $request->email;
                // $emp->password = bcrypt($request->password);
                $emp->user_id = $lead->id;
                $emp->save();
                $ld = User::where('id', $lead->id)->first();
                $ld->employee_id = $emp->id;
                $ld->save();

                $old_data = json_encode($lead);
                LogController::add_log(
                    __('admin.created', [], 'ar') . ' ' . $lead->name,
                    __('admin.created', [], 'en') . ' ' . $lead->name,
                    'agent',
                    $lead->id,
                    'create',
                    auth()->user()->id,
                    $old_data
                );
                DB::commit();
                return response()->json("Agent Created Successfully!!");
            } catch (Exception $ex) {
                DB::rollBack();
                return response()->json("Something went wrong!!");                
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agent $agent
     * @return \Illuminate\Http\Response
     */
    public function show($agent)
    {
        // if (checkRole('settings') or @auth()->user()->type == 'admin' or auth()->user()->id == $agent) {
        //     $show = DB::table('users')->join('agent_types', 'users.agent_type_id', '=', 'agent_types.id')->select('users.id', 'users.name', 'users.email', 'users.phone', 'users.image', 'users.role_id', 'users.type', 'agent_types.name as source')->where('users.id', '=', $agent)->first();
        //     $resale = ResaleUnit::join('leads', 'leads.id', 'resale_units.lead_id')->join('unit_types', 'resale_units.unit_type_id', '=', 'unit_types.id')->where('leads.agent_id', $agent)->select(
        //             'resale_units.' . app()->getLocale() . '_title as title',
        //             'unit_types.' . app()->getLocale() . '_name as unit_type',
        //             'leads.first_name as first_name',
        //             'leads.last_name as last_name',
        //             'resale_units.price as price',
        //             'resale_units.image as image',
        //             'resale_units.availability as availability',
        //             'resale_units.id as id',
        //             'resale_units.type as type'
        //         )->get();
        //     $rental = RentalUnit::join('leads', 'leads.id', 'rental_units.lead_id')->join('unit_types', 'rental_units.unit_type_id', '=', 'unit_types.id')->where('leads.agent_id', $agent)->select(
        //             'rental_units.' . app()->getLocale() . '_title as title',
        //             'unit_types.' . app()->getLocale() . '_name as unit_type',
        //             'leads.first_name as first_name',
        //             'leads.last_name as last_name',
        //             'rental_units.rent as price',
        //             'rental_units.image as image',
        //             'rental_units.availability as availability',
        //             'rental_units.id as id',
        //             'rental_units.type as type'
        //         )->get();
        //     return view(
        //         'admin.agents.show',
        //         [
        //             'title' => trans('admin.show') . ' ' . trans('admin.agent'),
        //             'show' => $show,
        //             'resale' => $resale,
        //             'rental' => $rental
        //         ]
        //     );
        // } else {
        //     session()->flash('error', __('admin.you_dont_have_permission'));
        //     return back();
        // }
        if (checkRole('settings') or @auth()->user()->type == 'admin' or auth()->user()->id == $agent) {
            $agent = DB::table('users')
            ->leftjoin('agent_types', 'users.agent_type_id', '=', 'agent_types.id')
            ->leftjoin('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.id', 'users.name', 'users.email', 'users.phone','roles.name as role', 'users.image','users.password','users.email_password', 'users.role_id', 'users.type','users.agent_type_id as source_id','agent_types.name as source','users.residential_commercial')
            ->where('users.id', '=', $agent)
            ->first();
            return response()->json($agent);            
        }else{
            return response()->json("Error : you dont have permission");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agent $agent
     * @return \Illuminate\Http\Response
     */
    public function edit($agent)
    {
        if (checkRole('settings') or @auth()->user()->type == 'admin' or auth()->user()->id == $agent) {
            $data = User::find($agent);
            return view('admin.agents.edit', ['title' => trans('admin.edit') . ' ' . trans('admin.agent'), 'data' => $data]);
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Agent $agent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $agent)
    {
        // $lead = User::find($agent);

        // $rules = [
        //     'name' => 'required|max:191',
        //     'email' => 'email|max:191|unique:users,email,' . $agent . ',id',
        //     'phone' => 'required|numeric',
        //     'agent_source' => 'required|max:191',
        //     'type' => 'required|max:191',
        // ];
        // $validator = Validator::make($request->all(), $rules);

        // $validator->SetAttributeNames([
        //     'name' => trans('admin.name'),
        //     'email' => trans('admin.email'),
        //     'phone' => trans('admin.phone'),
        //     'agent_source' => trans('admin.lead_source'),
        //     'type' => trans('admin.type'),
        // ]);

        // if ($validator->fails()) {
        //     return back()->withInput()->withErrors($validator);
        // } else {
        //     $old_data = json_encode($lead);
        //     $file_path = 'uploads/' . $lead->image;
        //     if (file_exists($file_path)) {
        //         if ($request->hasFile('image')) {
        //             if ($request->file('image')->isValid()) {
        //                 if ($lead->image != 'image.jpg')
        //                     @unlink($file_path);
        //                 $lead->image = uploads($request, 'image');
        //             }
        //         }
        //     }
        //     $lead->name = $request->name;
        //     $lead->email = $request->email;
        //     $lead->phone = $request->phone;
        //     $lead->type = $request->type;
        //     $lead->role_id = $request->role_id;
        //     $lead->agent_type_id = $request->agent_source;
        //     $lead->residential_commercial = $request->residential_commercial;
        //     if ($request->password != '') {
        //         $lead->password = Hash::make($request->password);
        //     }

        //     if ($request->email_password != '') {
        //         $lead->email_password = encrypt($request->email_password);
        //     }
        //     $lead->save();

        //     session()->flash('success', trans('admin.updated'));
        //     $new_data = json_encode($lead);
        //     LogController::add_log(
        //         __('admin.updated', [], 'ar') . ' ' . $lead->name,
        //         __('admin.updated', [], 'en') . ' ' . $lead->name,
        //         'agent',
        //         $lead->id,
        //         'update',
        //         auth()->user()->id,
        //         $old_data,
        //         $new_data
        //     );

        //     return redirect(adminPath() . '/agent');
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agent $agent
     * @return \Illuminate\Http\Response
     */
    public function destroy($agent)
    {
        if (checkRole('settings') or @auth()->user()->type == 'admin') {
            $data = User::find($agent);

            $old_data = json_encode($data);
            LogController::add_log(
                __('admin.deleted', [], 'ar') . ' ' . $data->name,
                __('admin.deleted', [], 'en') . ' ' . $data->name,
                'agent',
                $data->id,
                'delete',
                auth()->user()->id,
                $old_data
            );

            if ($data->image != "image.jpg") {
                $file_path = 'uploads/' . $data->image;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            DB::table('leads')->where('agent_id', $agent)->update(['agent_id' => 0]);
            DB::table('leads')->where('commercial_agent_id', $agent)->update(['commercial_agent_id' => 0]);
            $data->delete();
            return response()->json("Agent Deleted Successfully!");
            // session()->flash('success', trans('admin.deleted'));
            // return redirect(adminPath() . '/agent');
        } else {
            return response()->json("Error : you dont have permission");
            // session()->flash('error', __('admin.you_dont_have_permission'));
            // return back();
        }
    }

    public function getDailyReports()
    {
        $user = auth()->user();
        $user_id = $user->id;
        $agents = [];
        if ($user->type == 'admin') {
            $agents = User::select('name', 'id')->get();
        } else if ($user->type == 'agent' && $user->role_id == 6) {
            $teamLeaderGroupID = Group::where('team_leader_id', $user_id)->pluck('id');
            $agents = DB::table('group_members as member')->whereIn('group_id', $teamLeaderGroupID)
                ->join('users as user', 'user.id', '=', 'member.member_id')
                ->select('member.member_id as id', 'user.name as name')->get();
        }
        return view('admin.dailyreports')->with('agents', $agents);
    }

    public function getDailyReportsByCall()
    {
        $user = auth()->user();
        $user_id = $user->id;
        $agents = [];
        if ($user->type == 'admin') {
            $agents = User::select('name', 'id')->get();
        } else if ($user->type == 'agent' && $user->role_id == 6) {
            $teamLeaderGroupID = Group::where('team_leader_id', $user_id)->pluck('id');
            $agents = DB::table('group_members as member')->whereIn('group_id', $teamLeaderGroupID)
                ->join('users as user', 'user.id', '=', 'member.member_id')
                ->select('member.member_id as id', 'user.name as name')->get();
        }
        $lead_sources = \App\LeadSource::select('id', 'name')->get();
        return view('admin.dailyreportsbycall')->with('agents', $agents)
            ->with('lead_sources', $lead_sources);
    }

    public function getAllAgents()
    {
        $agents = DB::table('users as agents')->select('agents.id', 'agents.name','agents.commission')->get();
        return $agents;
    }
    public function getUserEmails(Request $request){
        $email = $request->email;
        $usersEmails = DB::table('users')
        ->select('id','email')
        ->where('email','LIKE','%' . $email . '%')
        ->orderBy('id', 'desc')
        ->get();
		return response()->json($usersEmails);
    }

    public function filterAgents(Request $request){
        $search = $request->searchInput;
        if (Auth::user()->type === 'admin' ) {
            $agents = DB::table('users as user')
            ->join('agent_types as source', 'user.agent_type_id', '=', 'source.id')
			->where('user.id', 'LIKE', '%' . $search . '%')
			->orWhere('user.name', 'LIKE', '%' . $search . '%')
			->orWhere('user.email', 'LIKE', '%' . $search . '%')
            ->orWhere('user.phone', 'LIKE', '%' . $search . '%')
            ->orWhere('source.name', 'LIKE', '%' . $search . '%')            
            ->select('user.id','user.email','user.name','user.phone','source.name as source_name')
            ->get();
            return $agents;
        }

    }

    public function updateAgent(Request $request,$agent){
        $lead = User::find($agent);
        $rules = [
            'name' => 'required|max:191',
            'email' => 'email|max:191|unique:users,email,' . $agent . ',id',
            'phone' => 'required|numeric',
            'agent_source' => 'required|max:191',
            'type' => 'required|max:191',
        ];
        $validator = Validator::make($request->all(), $rules);

        $validator->SetAttributeNames([
            'name' => trans('admin.name'),
            'email' => trans('admin.email'),
            'phone' => trans('admin.phone'),
            'agent_source' => trans('admin.lead_source'),
            'type' => trans('admin.type'),
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $old_data = json_encode($lead);
            $file_path = 'uploads/' . $lead->image;
            if (file_exists($file_path)) {
                if ($request->hasFile('image')) {
                    if ($request->file('image')->isValid()) {
                        if ($lead->image != 'image.jpg')
                            @unlink($file_path);
                        $lead->image = uploads($request, 'image');
                    }
                }
            }
            $lead->name = $request->name;
            $lead->email = $request->email;
            $lead->phone = $request->phone;
            $lead->type = $request->type;
            $lead->role_id = $request->role_id;
            if($request->agent_source){
                $lead->agent_type_id = $request->agent_source;
            }
            $lead->residential_commercial = $request->residential_commercial;
            if ($request->password != '') {
                $lead->password = Hash::make($request->password);
            }

            if ($request->email_password != '') {
                $lead->email_password = encrypt($request->email_password);
            }
            $lead->save();

            session()->flash('success', trans('admin.updated'));
            $new_data = json_encode($lead);
            LogController::add_log(
                __('admin.updated', [], 'ar') . ' ' . $lead->name,
                __('admin.updated', [], 'en') . ' ' . $lead->name,
                'agent',
                $lead->id,
                'update',
                auth()->user()->id,
                $old_data,
                $new_data
            );

            return redirect(adminPath() . '/agent');
        }
    }

    public function getAgentTypes(){
        return DB::table('agent_types')->select('id','name')->get();
    }

    public function getRoles(){
        return DB::table('roles')->select('id','name')->get();
    }
   
    

}
