<?php

namespace App\Http\Controllers;

use App\Campaign;
use Illuminate\Http\Request;
use Validator;
use Excel;
use Auth ;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (checkRole('marketing') or @auth()->user()->type == 'admin') {
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
        $campaigns = DB::table('campaigns as campaign')
            ->join('campaign_types as type','campaign.campaign_type_id','=','type.id')
            ->join('projects as project','campaign.project_id','=','project.id')
            ->select('campaign.id','campaign.'.app()->getLocale().'_name as name','campaign.budget',
            'type.'.app()->getLocale().'_name as type','project.'.app()->getLocale().'_name as project')
            ->paginate(100);
            // return $campaigns;
            // return view('admin.campaigns.index', ['title' => trans('admin.campaigns'), 'index' => Campaign::all()]);
        return response()->json($campaigns);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.campaigns.create', ['title' => trans('admin.add_campaign')]);
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
            'en_name' => 'required',
            'ar_name' => 'required',
            'budget' => 'required',
            'project_id' => 'required',
            'campaign_type_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'en_name' => trans('admin.en_name'),
            'ar_name' => trans('admin.ar_name'),
            'budget' => trans('admin.budget'),
            'project_id' => trans('admin.project'),
            'campaign_type_id' => trans('admin.campaign_type'),
            'start_date' => trans('admin.start_date'),
            'end_date' => trans('admin.end_date'),
        ]);
        if ($validator->fails()) {
            return response()->json("Validation Error");
        } else {
            $campaign = new Campaign;
            $campaign->ar_name = $request->ar_name;
            $campaign->en_name = $request->en_name;
            $campaign->budget = $request->budget;
            $campaign->project_id = $request->project_id;
            $campaign->campaign_type_id = $request->campaign_type_id;
            $campaign->start_date = strtotime($request->start_date);
            $campaign->end_date = strtotime($request->end_date);
            $campaign->description = $request->description;
            $campaign->user_id = auth()->user()->id;
            $campaign->save();
            session()->flash('success', trans('admin.created'));

            $old_data = json_encode($campaign);
            LogController::add_log(
                __('admin.created', [], 'ar') . ' ' . $campaign->ar_name,
                __('admin.created', [], 'en') . ' ' . $campaign->en_name,
                'campaigns',
                $campaign->id,
                'create',
                auth()->user()->id,
                $old_data
            );

            // return redirect(adminPath() . '/campaigns/' . $campaign->id);
            return response()->json([ "status" => "Added"],200);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campaign $campain
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
         // return view('admin.campaigns.show', ['title' => trans('admin.campaign'), 'show' => $campaign]);
         $allCampaign = DB::table('campaigns')
         ->join('campaign_types','campaigns.campaign_type_id','=','campaign_types.id')
         ->join('projects','campaigns.project_id','=','projects.id')

         ->select('campaign_types.en_name as campaignType','projects.en_name as project')
         ->paginate(100);


        return response()->json(
            ["campaign"=>$campaign,
             "all"=> $allCampaign]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Campaign $campain
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign)
    {
        return view('admin.campaigns.edit', ['title' => trans('admin.campaign'), 'edit' => $campaign]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Campaign $campain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign)
    {
        $rules = [
            'en_name' => 'required',
            'ar_name' => 'required',
            'budget' => 'required',
            'project_id' => 'required',
            'campaign_type_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'en_name' => trans('admin.en_name'),
            'ar_name' => trans('admin.ar_name'),
            'budget' => trans('admin.budget'),
            'project_id' => trans('admin.project'),
            'campaign_type_id' => trans('admin.campaign_type'),
            'start_date' => trans('admin.start_date'),
            'end_date' => trans('admin.end_date'),
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $old_data = json_encode($campaign);
            $campaign->ar_name = $request->ar_name;
            $campaign->en_name = $request->en_name;
            $campaign->budget = $request->budget;
            $campaign->project_id = $request->project_id;
            $campaign->campaign_type_id = $request->campaign_type_id;
            $campaign->start_date = strtotime($request->start_date);
            $campaign->end_date = strtotime($request->end_date);
            $campaign->description = $request->description;
            $campaign->user_id = auth()->user()->id;
            $campaign->save();
            session()->flash('success', trans('admin.updated'));

            $new_data = json_encode($campaign);
            LogController::add_log(
                __('admin.updated', [], 'ar') . ' ' . $campaign->ar_name,
                __('admin.updated', [], 'en') . ' ' . $campaign->en_name,
                'campaigns',
                $campaign->id,
                'update',
                auth()->user()->id,
                $old_data,
                $new_data
            );

            return redirect(adminPath() . '/campaigns/' . $campaign->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campaign $campain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        session()->flash('success', trans('admin.deleted'));

        $old_data = json_encode($campaign);
        LogController::add_log(
            __('admin.deleted', [], 'ar') . ' ' . $campaign->ar_name,
            __('admin.deleted', [], 'en') . ' ' . $campaign->en_name,
            'campaigns',
            $campaign->id,
            'delete',
            auth()->user()->id,
            $old_data
        );

        // return redirect(adminPath() . '/campaigns');
        return response()->json([ "status" => "done"],200);

    }
    public function export_xls(Request $request)
    {
        Excel::create('campaign',function ($excel){
            $excel->sheet('campaign',function ($sheet){
                $sheet->loadView('admin.xls');
            });
        })->export('xls');
    }
    public function searchCampaign(Request $request){
        $search = $request->searchInput;

        if (Auth::user()->type === 'admin' ) {
            $campaigns = DB::table('campaigns')
            ->join('campaign_types','campaigns.campaign_type_id','=','campaign_types.id')
            ->join('projects','campaigns.project_id','projects.id')
            ->where('campaigns.id', 'LIKE', '%' . $search . '%')
            ->orWhere('campaigns.en_name', 'LIKE', '%' . $search . '%')  
            ->select('campaigns.id','campaigns.en_name as name','campaign_types.en_name as type','projects.en_name as project','campaigns.budget')
            ->get();
        return response()->json($campaigns);
        }

    }
    public function getCampaignInputs(){
        // $campaigns = DB::table('campaigns')
        // ->leftjoin('campaign_types as types','campaigns.campaign_type_id','=','types.id')
        // ->leftjoin('projects','campaigns.project_id','=','projects.id')
        // ->select('campaigns.id','campaigns.en_name','types.en_name',
        //         'projects.en_name')->get();

        // return response()->json($campaigns);

        $projects = DB::table('projects')
        ->select('projects.id','projects.en_name')->get();

        $campaignTypes = DB::table('campaign_types as types')
                        ->select('types.id','types.en_name')
                        ->get();

        return response()->json([
            "projects"=>$projects,
            "campaignTypes"=>$campaignTypes
        ]);
    }

    public function getAllcampaigns(){
        return DB::table('campaigns')->select('id',app()->getLocale().'_name as name')->get();
    }

}
