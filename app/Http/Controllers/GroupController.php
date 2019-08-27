<?php

namespace App\Http\Controllers;

use App\Group;
use App\GroupMember;
use App\User;
use Illuminate\Http\Request;
use Validator;
use DB;

class GroupController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Group::where('parent_id', '=', 0)->get();
        $child = Group::where('parent_id', '!=', 0)->get();
        $agents = User::all();
        return response()->json([
            'perants' => $categories,
            'children' => $child,
            'agents' => $agents
        ]);
        // return $categories;
        // return $allCategories;
        // return view('admin.groups.index', ['title' => trans('admin.groups'),
        //     'categories' => $categories,
        //     'allCategories' => $allCategories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Group::where('parent_id', '=', 0)->get();
        $allCategories = @Group::all();
        $agents = User::all();
        return view('admin.groups.create', ['title' => trans('admin.groups'),
            'categories' => $categories,
            'allCategories' => $allCategories,
            'agents' => $agents]);
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
        $rules = [
            'parent_id' => 'required',
            'name' => 'required',
            'team_leader_id' => 'required',
            'members' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'parent_id' => trans('admin.parent'),
            'name' => trans('admin.name'),
            'team_leader_id' => trans('admin.team_leader'),
            'members' => trans('admin.members'),
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $group = new Group;
            $group->parent_id = $request->parent_id;
            $group->name = $request->name;
            $group->team_leader_id = $request->team_leader_id;
            $group->notes = $request->notes;
            $group->user_id = auth()->user()->id;
            $group->save();
            foreach ($request->members as $member) {
                $members = new GroupMember;
                $members->member_id = $member;
                $members->group_id = $group->id;
                $members->save();
            }

            $old_data = json_encode($group);
            LogController::add_log(
                __('admin.created', [], 'ar') . ' ' . $group->name,
                __('admin.created', [], 'en') . ' ' . $group->name,
                'groups',
                $group->id,
                'create',
                auth()->user()->id,
                $old_data
            );

            // return redirect(adminPath() . '/groups');
            return response()->json([
                'data' => 'added'
            ],200);
        }
        // return back()->with('success', 'New Category added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        // dd($group);
        $categories = Group::where('parent_id', '=', 0)->get();
        $child = Group::where('parent_id', '!=', 0)->get();
        $agents = User::all();
        // $groupMembes = GroupMember::select('member_id')->where('group_id',$group->id)->get();
        $groupMembes = DB::table('group_members as g_member')
        ->leftjoin('users as user','g_member.member_id','=','user.id')
        ->select('g_member.member_id as id','g_member.group_id','user.name')
        ->where('g_member.group_id',$group->id)
        ->get();
        return response()->json([
            'group' => $group,
            'perants' => $categories,
            'children' => $child,
            'agents' => $agents,
            'group_members_ids' => $groupMembes
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        $categories = Group::where('parent_id', '=', 0)->get();
        $allCategories = Group::all();
        $agents = User::all();
        return view('admin.groups.edit', ['title' => trans('admin.groups'),
            'categories' => $categories,
            'allCategories' => $allCategories,
            'group' => $group,
            'agents' => $agents]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Group $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $rules = [
            'parent_id' => 'required',
            'name' => 'required',
            'team_leader_id' => 'required',
            'members' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'parent_id' => trans('admin.parent'),
            'name' => trans('admin.name'),
            'team_leader_id' => trans('admin.team_leader'),
            'members' => trans('admin.members'),
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $old_data = json_encode($group);
            $group->parent_id = $request->parent_id;
            $group->name = $request->name;
            $group->team_leader_id = $request->team_leader_id;
            $group->notes = $request->notes;
            $group->user_id = auth()->user()->id;
            $group->save();

            foreach (GroupMember::where('group_id', $group->id)->get() as $member) {
                $member->delete();
            }

            foreach ($request->members as $member) {
                $members = new GroupMember;
                $members->member_id = $member;
                $members->group_id = $group->id;
                $members->save();
            }

            $new_data = json_encode($group);
            LogController::add_log(
                __('admin.updated', [], 'ar') . ' ' . $group->name,
                __('admin.updated', [], 'en') . ' ' . $group->name,
                'groups',
                $group->id,
                'update',
                auth()->user()->id,
                $old_data,
                $new_data
            );

            return redirect(adminPath() . '/groups');
        }
        return response()->json([
            'data' => 'success'
        ],200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group $group
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::find($id);

        $old_data = json_encode($group);
        LogController::add_log(
            __('admin.deleted', [], 'ar') . ' ' . $group->name,
            __('admin.deleted', [], 'en') . ' ' . $group->name,
            'groups',
            $group->id,
            'delete',
            auth()->user()->id,
            $old_data
        );

        $group->delete();
        foreach (GroupMember::where('group_id', $id)->get() as $member) {
            $member->delete();
        }
        foreach (Group::where('parent_id', $id)->get() as $group) {
            $group->parent_id = 0;
            $group->save();
        }

        return response()->json([
            'data' => 'group is delete',
            'status' => 200
        ],200);
        // return redirect(adminPath() . '/groups');
    }

    public function get_group(Request $request)
    {
        $group = Group::find($request->id[0]);
        return view('admin.groups.get_group', ['group' => $group]);
    }
}
