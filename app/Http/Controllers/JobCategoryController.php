<?php

namespace App\Http\Controllers;

use App\JobCategory;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobCategoryController extends Controller
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
        $categories = JobCategory::All_Categories();
        // $categories = DB::table('job_categories as category')
        //                 ->leftjoin('job_titles as title','category.id','=','title.job_category_id')
        //                 ->groupBy('category.id')
        //                 ->select('category.id','category.en_name','category.en_description',DB::raw('count(title.job_category_id) as jobtitles'))
        //                 ->paginate(100);
        return response()->json($categories);

        // return view('admin.job_categories.index',compact('categories','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('admin.job_categories');
        return view('admin.job_categories.create',compact('title'));
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
            // 'en_description' => 'required',
            // 'ar_description' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'en_name' => trans('admin.en_name'),
            'ar_name' => trans('admin.ar_name'),
            'en_description' => trans('admin.en_description'),
            'ar_description' => trans('admin.ar_description'),

        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $Categories = JobCategory::create($request->all());
            // return redirect(adminPath().'/job_categories');
            return "Added";
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\JobCategory  $jobCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $show = JobCategory::find($id);
        return response()->json($show);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JobCategory  $jobCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(JobCategory $jobCategory)
    {
        $title = __('admin.job_categories');
        return view('admin.job_categories.edit',compact('title','jobCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JobCategory  $jobCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobCategory $jobCategory)
    {
        $rules = [
            'en_name' => 'required',
            'ar_name' => 'required',
            // 'en_description' => 'required',
            // 'ar_descraption' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'en_name' => trans('admin.en_name'),
            'ar_name' => trans('admin.ar_name'),
            'en_description' => trans('admin.en_description'),
            'ar_descraption' => trans('admin.ar_description'),

        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
        $jobCategory->en_name = $request->en_name;
        $jobCategory->ar_name = $request->ar_name;
        $jobCategory->en_description = $request->en_description;
        $jobCategory->ar_description= $request->ar_description;
        $jobCategory->update();
        // return redirect(adminPath().'/job_categories');
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JobCategory  $jobCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobCategory $jobCategory)
    {
        $jobCategory->delete();
        // return back();
        return response()->json(["status" => "deleted"],200);
    }

    public function searchJobCategory(Request $request){
        $search = $request->searchInput;
        if (Auth::user()->type === 'admin' ) {
            $JobCategories = DB::table('job_categories as category')
            ->join('job_titles as title','title.job_category_id','=','category.id')     
            ->groupBy('title.job_category_id')       
            ->where('category.en_name', 'LIKE', '%' . $search . '%')
            ->orwhere('category.en_description', 'LIKE', '%' . $search . '%')
            ->select('category.en_name','category.en_description')    
            ->get();
            return $JobCategories;
        }
    }
}
