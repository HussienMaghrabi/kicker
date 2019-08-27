<?php

namespace App\Http\Controllers;

use Validator;
use App\Title;
use Auth;
use DB;
use Illuminate\Http\Request;

class TitleController extends Controller
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
        $titles = Title::paginate(100);
        return response()->json($titles);
        // return view('admin.titles.index', ['title' => trans('admin.all_job_titles'), 'titles' => $titles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.titles.create', ['title' => trans('admin.add_job_title')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'name' => trans('admin.name'),
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $title = New Title;
            $title->name = $request->name;
            $title->description = $request->description;
            $title->user_id = auth()->user()->id;
            $title->save();

            $old_data = json_encode($title);
            LogController::add_log(
                __('admin.created', [], 'ar') . ' ' . $title->name,
                __('admin.created', [], 'en') . ' ' . $title->name,
                'titles',
                $title->id,
                'create',
                auth()->user()->id,
                $old_data
            );
            session()->flash('success', trans('admin.created'));
            // return redirect(adminPath() . '/titles/' . $title->id);
            return response()->json(['status' => 'added'],200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Title $title
     * @return \Illuminate\Http\Response
     */
    public function show($title)
    {
        $sources = DB::table('titles')->join('users', 'titles.user_id', '=', 'users.id')
            ->where('titles.id',$title)
            ->select('titles.id','users.name','titles.user_id', 'titles.name', 'titles.description')
            ->first();
        return response()->json($sources);

        // return view('admin.titles.show', ['title' => trans('admin.show_job_title'), 'titles' => $title]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Title $title
     * @return \Illuminate\Http\Response
     */
    public function edit(Title $title)
    {
        return view('admin.titles.edit', ['title' => trans('admin.edit_job_title'), 'titles' => $title]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Title $title
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Title $title)
    {
        $rules = [
            'name' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'name' => trans('admin.name'),
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $old_data = json_encode($title);
            $title->name = $request->name;
            $title->description = $request->description;
            $title->save();

            $new_data = json_encode($title);
            LogController::add_log(
                __('admin.updated', [], 'ar') . ' ' . $title->name,
                __('admin.updated', [], 'en') . ' ' . $title->name,
                'titles',
                $title->id,
                'update',
                auth()->user()->id,
                $old_data,
                $new_data
            );

            session()->flash('success', trans('admin.updated'));
            return redirect(adminPath() . '/titles/' . $title->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Title $title
     * @return \Illuminate\Http\Response
     */
    public function destroy(Title $title)
    {
        $old_data = json_encode($title);
        LogController::add_log(
            __('admin.deleted', [], 'ar') . ' ' . $title->name,
            __('admin.deleted', [], 'en') . ' ' . $title->name,
            'titles',
            $title->id,
            'delete',
            auth()->user()->id,
            $old_data
        );

        $title->delete();
        session()->flash('success', trans('admin.deleted'));
        return response()->json(["status" => "deleted"],200);
        // return redirect(adminPath().'/titles');
    }

    public function searchTitles(Request $request){
        $search = $request->searchInput;
        if (Auth::user()->type === 'admin') {
            $titles = DB::table('titles')
            ->where('id','LIKE','%' . $search . '%')
			->orwhere('name', 'LIKE', '%' . $search . '%')      
            ->select('id','name')
            ->get();
            return $titles;
        }

    }

}
