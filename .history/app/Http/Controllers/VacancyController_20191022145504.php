<?php

namespace App\Http\Controllers;

use App\JobTitle;
use App\vacancy;
use DB;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VacancyController extends Controller
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
        return vacancy::vacancies();
        // $vacancies = DB::table('vacancies as vacancy')
        //  ->join('job_titles as title','vacancy.job_title_id','=','title.id')
        //  ->groupBy('vacancy.en_name')
        //  ->select('vacancy.id','vacancy.en_name','title.en_name as jobTitle',DB::raw('count(title.en_name) as applications'))
        //  ->paginate(100);

        // return response()->json($vacancies);
                    
        // $title = __('admin.vacancy');
        // $vacancies = Vacancy::with('jobTitle')->get();
        // $vacancies = Vacancy::all();
        // return view('admin.vacancy.index',compact('title','vacancies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = __('admin.vacancy');
        $jobTitles = JobTitle::all();
        return view('admin.vacancy.create',compact('title','jobTitles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
         $rules = [
            'en_name' => 'required',
            'ar_name' => 'required',
            // 'en_description' => 'required',
            // 'ar_description' => 'required',
            'job_title_id' => 'required',
            'status' => 'required',
            'vacancies_type_id' => 'required',
    ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'en_name' => trans('admin.en_name'),
            'ar_name' => trans('admin.ar_name'),
            'en_description' => trans('admin.en_description'),
            'ar_description' => trans('admin.ar_description'),
            'job_title_id' => trans('admin.job_title_id'),
            'vacancies_type_id' => trans('admin.status'),
            'type' => trans('admin.type'),

        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
        vacancy::create($request->all());
        // $vacancy = new vacancy();
        // $vacancy->en_name = $request->en_name;
        // $vacancy->ar_name = $request->ar_name;
        // $vacancy->en_description = $request->en_description;
        // $vacancy->ar_description = $request->ar_description;
        // $vacancy->job_title_id = $request->job_title_id;
        // $vacancy->status = $request->status ;
        // $vacancy->type = $request->type;
        // $vacancy->save();
        // return redirect(adminPath().'/vacancies');
        return response()->json([
            'status' => 'Added'
        ],200);
    }}

    /**
     * Display the specified resource.
     *
     * @param  \App\vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function show(vacancy $vacancy)
    {
        $title = __('admin.vacancy');
        $JobTitle = DB::table('vacancies as vacancy')
            ->join('job_titles as title','vacancy.job_title_id','=','title.id')
            ->select('title.en_name')
            ->where('vacancy.id',$vacancy->id)
            ->value('title.en_name');
            
  
        return response()->json([
            "vacancy"=>$vacancy,
             'JobTitle' => $JobTitle]);
   
        // return view('admin.vacancy.show',compact('vacancy','title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function edit(vacancy $vacancy)
    {
        $title = __('admin.vacancy');
        $jobTitles = JobTitle::all();
        return view('admin.vacancy.edit',compact('title','vacancy','jobTitles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, vacancy $vacancy)
    {
        // dd($request->all());
          $rules = [
            'en_name' => 'required',
            'ar_name' => 'required',
            'en_description' => 'required',
            'ar_description' => 'required',
            'job_title_id' => 'required',
            'status' => 'required',
            'vacancies_type_id' => 'required',
        ];
            $validator = Validator::make($request->all(), $rules);
            $validator->SetAttributeNames([
                'en_name' => trans('admin.en_name'),
                'ar_name' => trans('admin.ar_name'),
                'en_description' => trans('admin.en_description'),
                'ar_description' => trans('admin.ar_description'),
                'job_title_id' => trans('admin.job_title_id'),
                'status' => trans('admin.status'),
                'vacancies_type_id' => trans('admin.type'),
            ]);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator);
            } else {
                    $vacancy->en_name = $request->en_name;
                    $vacancy->ar_name = $request->ar_name;
                    $vacancy->en_description = $request->en_description;
                    $vacancy->ar_description = $request->ar_description;
                    $vacancy->job_title_id = $request->job_title_id;
                    $vacancy->status = $request->status;
                    $vacancy->vacancies_type_id = $request->vacancies_type_id;
                    $vacancy->save();

        // return redirect(adminPath().'/vacancies');
        return response()->json(["status"=>"Updated"],200);
            }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\vacancy  $vacancy
     * @return \Illuminate\Http\Response
     */
    public function destroy(vacancy $vacancy)
    {
        $vacancy->delete();
        // return back();
        return response()->json([
            'status' => 'Deleted'
        ],200);
    }

    public function get_vacancy_applications($id){
        $vacancy = vacancy::find($id);
        $applications = $vacancy->applications;
        $title = __('admin.application');
        return reponse()->json("doneee");
        // return view('admin.applications.index',compact('vacancy','title','applications'));
    }

    public function searchVacancies(Request $request){
        $search = $request->searchInput;
        if (Auth::user()->type === 'admin' ) {
            $vacancies = DB::table('vacancies as vacancy')
             ->join('job_titles as title','vacancy.job_title_id','=','title.id')
             ->groupBy('vacancy.en_name')
             ->where('vacancy.en_name', 'LIKE', '%' . $search . '%')
			 ->orWhere('title.en_name', 'LIKE', '%' . $search . '%')   
             ->select('vacancy.id','vacancy.en_name','title.en_name as jobTitle',DB::raw('count(title.en_name) as applications'))
             ->get();

            return $vacancies;
        }

    }

    public function getVacancyInputs(){
        $jobTitle = DB::table('job_titles')->select('id','en_name')->get();
        return response()->json($jobTitle);
    }
    

}

