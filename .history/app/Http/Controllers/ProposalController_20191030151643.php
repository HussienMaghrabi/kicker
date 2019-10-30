<?php

namespace App\Http\Controllers;

use App\Item;
use App\Proposal;
use App\Company;
use Illuminate\Http\Request;
use Validator;
use DB;

class ProposalController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(function ($request, $next) {
    //         if (checkRole('proposals') or @auth()->user()->type == 'admin') {
    //             return $next($request);
    //         } else {
    //             session()->flash('error', __('admin.you_dont_have_permission'));
    //             return back();
    //         }
    //     });
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr=[];
        $i=0;
        $proposals = Proposal::orderBy('created_at', 'desc')->with('items')->get();
        foreach($proposals as $proposal){
            $arr[$i]['proposed_company']=Company::where('id',$proposal->proposed_company_id)->value('name');
            $arr[$i]['company']=Company::where('id',$proposal->company_id)->value('name');
            $arr[$i]['valid_until']=$proposal->valid_until;
            $arr[$i]['sub_total']=$proposal->sub_total;
            $arr[$i]['Discount']=$proposal->discount;
            $arr[$i]['Total']=$proposal->total;
            $i++;
        }
        return response()->json([
            'status'=>'success',
            'data'=>$arr
        ]);
        // $proposals = DB::table('proposals as proposal')
        //     ->leftjoin('leads as lead', 'proposal.lead_id', '=', 'lead.id')
        //     ->select('proposal.id', 'proposal.lead_id', 'lead.first_name', 'lead.last_name')->get();
        // return view('admin.proposals.index_new', ['title' => trans('admin.all_proposals'), 'proposals' => $proposals]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.proposals.create_new', ['title' => trans('admin.add_proposal')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Proposal::storeData();
        // dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proposal = DB::table('proposals as proposal')
            ->leftjoin('leads as lead', 'proposal.lead_id', '=', 'lead.id')
            ->leftjoin('properties as property', 'proposal.unit_id', '=', 'property.id')
            ->leftjoin('resale_units as resale', 'proposal.unit_id', '=', 'resale.id')
            ->leftjoin('rental_units as rental', 'proposal.unit_id', '=', 'rental.id')
            ->leftjoin('projects as project','proposal.project_id','project.id')
            ->leftjoin('developers as developer', 'proposal.developer_id', '=', 'developer.id')
            ->leftjoin('phases as phase', 'proposal.phase_id', '=', 'phase.id')
            ->select(
                'proposal.id',
                'lead.first_name',
                'lead.last_name',
                'proposal.unit_type',
                'proposal.personal_commercial',
                'property.' . app()->getLocale() . '_name as property_name',
                'resale.' . app()->getLocale() . '_title as resale_title',
                'rental.' . app()->getLocale() . '_title as rental_title',
                'proposal.file',
                'proposal.price',
                'proposal.unit_id',
                'proposal.description',
                'project.en_name as project',
                'project.id as project_id',
                'developer.en_name as developer',
                'phase.en_name as phase',
                'property.en_name as phaseUnit'
            )
            ->where('proposal.id', '=', $id)
            ->first();
        return response()->json($proposal);
        // return view('admin.proposals.show_new', ['title' => trans('admin.proposal'), 'proposal' => $proposal]);
    }
    /* old Show
    // public function show(Proposal $proposal)
    // {
    //     return view('admin.proposals.show', ['title' => trans('admin.proposal'), 'proposal' => $proposal]);
    // }
    */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proposal = DB::table('proposals as proposal')
            ->leftjoin('leads as lead', 'proposal.lead_id', '=', 'lead.id')
            ->leftjoin('properties as property', 'proposal.unit_id', '=', 'property.id')
            ->leftjoin('resale_units as resale', 'proposal.unit_id', '=', 'resale.id')
            ->leftjoin('rental_units as rental', 'proposal.unit_id', '=', 'rental.id')
            ->leftjoin('developers as developer', 'proposal.developer_id', '=', 'developer.id')
            ->leftjoin('projects as project', 'proposal.project_id', '=', 'project.id')
            ->leftjoin('phases as phase', 'proposal.phase_id', '=', 'phase.id')
            ->leftjoin('lands as land', 'proposal.unit_id', '=', 'land.id')
            ->select(
                'proposal.id',
                'proposal.unit_type',
                'proposal.personal_commercial',
                'proposal.file',
                'proposal.price',
                'proposal.description',
                'lead.first_name',
                'lead.last_name',
                'lead.id as lead_id',
                'property.' . app()->getLocale() . '_name as property_name',
                'property.id as property_id',
                'resale.' . app()->getLocale() . '_title as resale_title',
                'resale.id as resale_id',
                'rental.' . app()->getLocale() . '_title as rental_title',
                'rental.id as rental_id',
                'developer.' . app()->getLocale() . '_name as developer_name',
                'developer.id as developer_id',
                'project.' . app()->getLocale() . '_name as project_name',
                'project.id as project_id',
                'phase.' . app()->getLocale() . '_name as phase_name',
                'phase.id as phase_id',
                'land.' . app()->getLocale() . '_title as land_title',
                'land.id as land_id'

            )
            ->where('proposal.id', '=', $id)
            ->first();
        return view('admin.proposals.edit_new', ['title' => trans('admin.proposal'), 'proposal' => $proposal]);
    }
    // //  old Edit
    // public function edit(Proposal $proposal)
    // {
    //     return view('admin.proposals.edit', ['title' => trans('admin.proposal'), 'proposal' => $proposal]);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proposal $proposal)
    {
        if ($request->unit_type != 'land') {
            $rules = [
                'unit_type' => 'required',
                // 'unit_id' => 'required',
                'lead_id' => 'required',
                'description' => 'required',
                'price' => 'required',
                'personal_commercial' => 'required',
            ];
        } else {
            $rules = [
                'unit_type' => 'required',
                // 'unit_id' => 'required',
                'lead_id' => 'required',
                'description' => 'required',
                'price' => 'required',
                // 'personal_commercial' => 'required',
            ];
        }
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'unit_type' => trans('admin.unit_type'),
            'unit_id' => trans('admin.unit'),
            'lead_id' => trans('admin.lead'),
            'description' => trans('admin.description'),
            'price' => trans('admin.price'),
            'personal_commercial' => trans('admin.personal_commercial'),
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $old_data = json_encode($proposal);
            $proposal->unit_type = $request->unit_type;
            $proposal->unit_id = $request->unit_id;
            $proposal->lead_id = $request->lead_id;
            $proposal->price = $request->price;
            $proposal->personal_commercial = $request->personal_commercial;
            $proposal->description = $request->description;
            if ($request->hasFile('file')) {
                $proposal->file = $request->file('file')->store('proposal');
            }
            $proposal->user_id = auth()->user()->id;
            $proposal->save();

            $new_data = json_encode($proposal);
            LogController::add_log(
                __('admin.updated', [], 'ar') . ' ' . __('admin.proposal', [], 'ar'),
                __('admin.updated', [], 'en') . ' ' . __('admin.proposal', [], 'en'),
                'proposals',
                $proposal->id,
                'update',
                auth()->user()->id,
                $old_data,
                $new_data
            );

            session()->flash('success', trans('admin.updated'));
            return response()->json($proposal);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Proposal $proposal)
    // {
    //     $old_data = json_encode($proposal);
    //     LogController::add_log(
    //         __('admin.deleted', [], 'ar') . ' ' . __('admin.proposal', [], 'ar'),
    //         __('admin.deleted', [], 'en') . ' ' . __('admin.proposal', [], 'en'),
    //         'proposals',
    //         $proposal->id,
    //         'delete',
    //         auth()->user()->id,
    //         $old_data
    //     );

    //     $proposal->delete();
    //     session()->flash('success', trans('admin.deleted'));
    //     return redirect(adminPath().'/proposals');
    // }

    public function destroy($id)
    {
        $proposal = Proposal::find($id);
        if (@auth()->user()->type == 'admin') {
            $old_data = json_encode($proposal);
            LogController::add_log(
                __('admin.deleted', [], 'ar') . ' ' . __('admin.proposal', [], 'ar'),
                __('admin.deleted', [], 'en') . ' ' . __('admin.proposal', [], 'en'),
                'proposals',
                $proposal->id,
                'delete',
                auth()->user()->id,
                $old_data
            );

            $proposal->delete();
            session()->flash('success', trans('admin.deleted'));
            return redirect(adminPath() . '/proposals');
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return back();
        }
    }

    public function getProposalWithPaginate(Request $request)
    {
        $user = auth()->user();
        $teamleaderGroup = DB::table('groups')->where('team_leader_id',$user->id)->first();
		if($teamleaderGroup){
            $groupAgents = DB::table('group_members')->where('group_id', $teamleaderGroup->id)->groupBy('member_id')->pluck('member_id')->toArray();
            array_push($groupAgents,$user->id);
            $proposals = DB::table('proposals as proposal')
            ->leftjoin('leads as lead', 'proposal.lead_id', '=', 'lead.id')
            ->whereIn('lead.commercial_agent_id',$groupAgents)->orWhereIn('lead.agent_id', $groupAgents)
            ->select('proposal.id', 'proposal.lead_id', 'lead.first_name', 'proposal.status', 'lead.last_name')->paginate(10);
		}
        else if(auth()->user()->type == "admin"){
            $proposals = DB::table('proposals as proposal')
            ->leftjoin('leads as lead', 'proposal.lead_id', '=', 'lead.id')
            ->select('proposal.id', 'proposal.lead_id', 'lead.first_name', 'proposal.status', 'lead.last_name')->paginate(10);
        }
        else{
            $proposals = DB::table('proposals as proposal')
            ->leftjoin('leads as lead', 'proposal.lead_id', '=', 'lead.id')
            ->where('lead.commercial_agent_id',$user->id)->orWhere('lead.agent_id', $user->id)
            ->select('proposal.id', 'proposal.lead_id', 'lead.first_name', 'proposal.status', 'lead.last_name')->paginate(10);
        }
    
        return $proposals;
    }
    public function confirm_proposal($id)
    {
        $proposal = Proposal::find($id);
        if ($proposal->status != 'confirmed') {
            $proposal->status = 'confirmed';
        } else {
            $proposal->status = 'pending';
        }
        $proposal->save();
        return back();
    }

    public function getProposalsConfirmed()
    {
        $proposals = DB::table('proposals as proposal')
            ->leftjoin('leads as lead', 'proposal.lead_id', '=', 'lead.id')
            ->leftjoin('properties as property', 'proposal.unit_id', '=', 'property.id')
            ->leftjoin('resale_units as resale', 'proposal.unit_id', '=', 'resale.id')
            ->leftjoin('rental_units as rental', 'proposal.unit_id', '=', 'rental.id')
            ->leftjoin('users as agent', 'proposal.user_id', '=', 'agent.id')
            ->where('proposal.status', '=', 'confirmed')
            ->select(
                'proposal.id',
                'agent.name as user_name',
                'lead.first_name as client_first_name',
                'lead.last_name as client_last_name'
            )->get();

        return  $proposals;
    }

    public function getProposalClosedDeal($id)
    {
        $proposal = DB::table('proposals as proposal')
            ->leftjoin('leads as lead', 'proposal.lead_id', '=', 'lead.id')
            ->leftjoin('properties as property', 'proposal.unit_id', '=', 'property.id')
            ->leftjoin('resale_units as resale', 'proposal.unit_id', '=', 'resale.id')
            ->leftjoin('rental_units as rental', 'proposal.unit_id', '=', 'rental.id')
            ->leftjoin('projects as project', 'proposal.project_id', '=', 'project.id')
            ->leftjoin('phases as phase', 'proposal.phase_id', '=', 'phase.id')
            ->leftjoin('lands as land', 'proposal.unit_id', '=', 'land.id')
            ->leftjoin('leads as leadResale', 'resale.lead_id', '=', 'leadResale.id')
            ->leftjoin('leads as leadRental', 'rental.lead_id', '=', 'leadRental.id')
            ->leftjoin('leads as leadLand', 'land.lead_id', '=', 'leadLand.id')
            ->leftjoin('users as user', 'lead.agent_id', '=', 'user.id')
            ->select(
                'proposal.id',
                'proposal.unit_type',
                'proposal.file',
                'proposal.price as proposal_price',
                'lead.first_name',
                'lead.last_name',
                'lead.id as lead_id',
                'property.' . app()->getLocale() . '_name as property_name',
                'property.id as property_id',
                'property.start_price',
                'resale.' . app()->getLocale() . '_title as resale_title',
                'resale.id as resale_id',
                'resale.price',
                'rental.' . app()->getLocale() . '_title as rental_title',
                'rental.id as rental_id',
                'rental.rent',
                'project.' . app()->getLocale() . '_name as project_name',
                'project.id as project_id',
                'project.commission as project_commission',
                'phase.' . app()->getLocale() . '_name as phase_name',
                'phase.id as phase_id',
                'land.' . app()->getLocale() . '_title as land_title',
                'land.id as land_id',
                'land.meter_price',
                'land.area',
                'leadResale.first_name as leadResale_first_name',
                'leadResale.last_name as leadResale_last_name',
                'leadResale.id as leadResale_id',
                'leadRental.first_name as leadRental_first_name',
                'leadRental.last_name as leadRental_last_name',
                'leadRental.id as leadRental_id',
                'leadLand.first_name as leadLand_first_name',
                'leadLand.last_name as leadLand_last_name',
                'leadLand.id as leadLand_id',
                'user.id as user_id',
                'user.name as user_name',
                'user.commission as user_commission'

            )
            ->where('proposal.id', '=', $id)
            ->groupBy('proposal.id')
            ->first();
        return response()->json($proposal);
    }

    public function getProposal(){
        return Proposal::allProposal();
    }


}
