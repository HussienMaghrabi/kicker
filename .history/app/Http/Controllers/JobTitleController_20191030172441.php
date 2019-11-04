<?php

namespace App\Http\Controllers;

use App\JobCategory;
use App\JobTitle;
use DB;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobTitleController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (checkRole('employees') or @auth()->user()->type == 'admin') {
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
        return JobTitle::jobTitles();
        // $titles = DB::table('job_titles as title')
        //                ->leftjoin('job_categories as category','category.id','=','title.job_category_id')
        //                 ->select('title.id','title.en_name','title.en_description','category.en_name as department')
        //                 ->paginate(100);
        // return response()->json($titles);

        // return view('admin.job_title.index',compact('title','jobTitles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jobCategories = JobCategory::all();
        $title = __('admin.job_title');
        return view('admin.job_title.create',compact('title','jobCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'en_name' => 'required',
            'ar_name' => 'required',
            'en_description' => 'required',
            'ar_description' => 'required',
            'job_category_id' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'en_name' => trans('admin.en_name'),
            'ar_name' => trans('admin.ar_name'),
            'en_description' => trans('admin.en_description'),
            'ar_description' => trans('admin.ar_description'),
            'job_category_id' => trans('admin.category_id'),

        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
        $newTitle = JobTitle::create($request->all());
        // $jobTitle = new JobTitle();
        // $jobTitle->en_name = $request->en_name;
        // $jobTitle->ar_name = $request->ar_name;
        // $jobTitle->en_description = $request->en_description;
        // $jobTitle->ar_description = $request->ar_description;
        // $jobTitle->job_category_id = $request->category_id;
        // $jobTitle->save();
        return response()->json(["status","Added"],200);
        // return redirect(adminPath().'/job_titles');
    }
}

    /**
     * Display the specified resource.
     *
     * @param  \App\JobTitle  $jobTitle
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $show = JobTitle::find($id);
        return response()->json($show);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JobTitle  $jobTitle
     * @return \Illuminate\Http\Response
     */
    public function edit(JobTitle $jobTitle)
    {
        $title = __('admin.job_title');
        $jobCategories = JobCategory::all();
        return view('admin.job_title.edit',compact('jobTitle','title','jobCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JobTitle  $jobTitle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobTitle $jobTitle)
    {
        // dd($request->all());
        $rules = [
            'en_name' => 'required',
            'ar_name' => 'required',
            'en_description' => 'required',
            'ar_description' => 'required',
            // 'job_category_id' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'en_name' => trans('admin.en_name'),
            'ar_name' => trans('admin.ar_name'),
            'en_description' => trans('admin.en_description'),
            'ar_description' => trans('admin.ar_description'),
            'job_category_id' => trans('admin.job_category_id'),

        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
        $jobTitle->en_name = $request->en_name;
        $jobTitle->ar_name = $request->ar_name;
        $jobTitle->en_description = $request->en_description;
        $jobTitle->ar_description = $request->ar_description;
        $jobTitle->job_category_id = $request->category_id;
        $jobTitle->update();
        return redirect(adminPath().'/job_titles');
    }
}

    public function get_titles(Request $request){
        $titles = JobTitle::where('job_category_id',$request->cat)->get();
        return view('admin.applications.titles',compact('titles'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JobTitle  $jobTitle
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobTitle $jobTitle)
    {
        $jobTitle->delete();
        // return back();
        return response()->json(["status" => "deleted"],200);
    }

    public function searchJobTitles(Request $request){
        $search = $request->searchInput;
        if (Auth::user()->type === 'admin' ) {
            $JobTitles = DB::table('job_titles as title')
            ->join('job_categories as category','title.job_category_id','=','category.id')     
            ->where('title.en_name', 'LIKE', '%' . $search . '%')
            ->orwhere('title.en_description', 'LIKE', '%' . $search . '%')
            ->orWhere('category.en_name', 'LIKE', '%' . $search . '%')    
            ->select('title.job_category_id','title.en_name','title.en_description','category.en_name as department')
            ->get();
            return $JobTitles;
        }
    }

    public function getJobTitleInputs(){
        $department = DB::table('job_categories')->select('id','en_name')->get();
        return response()->json($department);
    }
}
