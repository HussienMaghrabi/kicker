<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Archive;
use App\Call;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ArchiveController extends Controller
{

    public function allArchive()
    {
        return view('admin.archive.showarchiving');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $archives = Archive::all();
        // return view('admin.archive.index')->with('archives', $archives);
        return view('admin.archive.index-new');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $calls = new Call();
        if ($request->wrongNubmer != false) {
            $calls = $calls->where('call_status_id', '8');
            // dd($calls->get());
        }
        if ( $request->probability != false ) {
            $calls = $calls->orWhere('call_status_id', '5')->where('probability', 'lowest');
        }
        if ( $request->archiveAll != false ) {
            $commercialAgents = @\App\User::where('residential_commercial', 'commercial')->get()->pluck('id')->toArray();
            // dd($commercialAgents);
            $residentialAgents = @\App\User::where('residential_commercial', 'residential')->get()->pluck('id')->toArray();
            $allAgents = [];
            foreach ($commercialAgents as $key => $value) {
                array_push($allAgents, $value);
            }
            foreach ($commercialAgents as $key => $value) {
                array_push($allAgents, $value);
            }
            $allcalls = Call::where('call_status_id','==', '6' )->pluck('lead_id')->toArray();
            // dd($allcalls);
            if ($request->agentId == 0) {
                foreach ($allAgents as $key => $value) {
                    // dd($request->fromDate);
                    $leads = \App\Lead::
                    whereDate('created_at', '>=', $request->fromDate)->
                    whereDate('created_at', '<=', $request->toDate)->
                    whereNotIn('id', $allcalls)->get();
                    // dd($leads);

                    // dd($leads);
                    foreach ($leads as $key => $value) {
                        $archive = $value->toArray();
                        unset($archive['requests']);
                        Archive::insert($archive);
                        $value->delete();
                    }
                }
            }
            else{
                $leads = \App\Lead::where('agent_id', $request->agentId)->
                orWhere('commercial_agent_id', $request->agentId)->
                whereNotIn('id', $allcalls)->get();
                // dd($leads[0]);
                foreach ($leads as $key => $value) {
                    $archive = $value->toArray();
                    unset($archive['requests']);
                    Archive::insert($archive);
                    $value->delete();
                }
            }
            return 'true';
        }
        $calls = $calls->get();
        foreach ($calls as $key => $value) {

            $archive = $value->lead;

            // if ($request->from != '' && $request->to != '') {
            //     $archive->where('created_at', 'like', $request->from)
            // }

            $archive = $archive->toArray();
            unset($archive['requests']);
            if ($archive['id'] == null)
                continue;
            if (Archive::where('phone', $archive['phone'])->count())
                continue;
            // dd( $archive );
            Archive::insert($archive);
            $value->lead->delete();

        }
        return  'true';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $archive = Archive::find($id);
        if($archive){
            $archive->delete();
        }else{
            return response()->json("Archive id not found");
        }
        return response()->json("Deleted Archive Successfully");
    }

    /**
     * Filter and archive data
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function archive_data(Request $request)
    {
        ini_set('memory_limit', '-1');
        $leads = DB::table('leads');
        if($request->dateFrom){
            $leads = $leads->where('created_at','>=',$request->dateFrom." 00:00:00");
        }
        if($request->dateTo){
            $leads = $leads->where('created_at','<=',$request->dateTo." 23:59:59");
        }
        if($request->wrong_number){
            $wrong_number_leads = DB::table('calls')->where('call_status_id',8)->pluck('lead_id');
            $leads = $leads->whereIn('id',$wrong_number_leads);            
        }
        if($request->probability){
            $callLeads = DB::table('calls')->where([
                'call_status_id' => 4,
                'probability' => 'lowest'
            ])->pluck('lead_id');
            $leads = $leads->whereIn('id',$callLeads);
        }
        if($request->agent_id && $request->agent_id != 0){
            $agent_id = $request->agent_id;
            $leads = $leads->where(function ($query) use ($agent_id) {
                $query->where('agent_id',$agent_id)
                      ->orWhere('commercial_agent_id',$agent_id);
            });
        }
        $answeredCallLeads = DB::table('calls')->where('call_status_id',6)->pluck('lead_id');
        $leads = $leads->whereNotIn('id',$answeredCallLeads);
        $count = $leads->delete();
        return $count . "Leads Deleted";
    }
}
