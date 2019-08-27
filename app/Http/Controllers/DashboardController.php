<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Lead;
use App\Call;
use App\Meeting;
use App\ClosedDeal;
use App\ResaleUnit;
use App\Project;
use App\Group;
use App\GroupMember;
use App\User;
use Illuminate\Support\Facades\DB;
use Auth;
use App\UserEdit;

class DashboardController extends Controller
{
  public function dashboard_section_statistics_for_agent(Request $request)
  {
    $now = Carbon::now();
    $today = (string)Carbon::today();
    $month = (string)$now->startOfMonth();
    $uid = (int)$request->query('uid');
    $startDate = $request->query('startDate');
    $endDate = $request->query('endDate');

    $results = [];
    $results['metadata'] = [
      'today' => $today,
      'month' => $month,
      'uid' => $uid,
      'startDate' => $startDate,
      'endDate' => $endDate,
    ];
    $userID = auth()->user()->id;
    if (\App\User::where('id',$userID)->first()->type == 'admin') {
        $results['agentLeads'] = Lead::count();
        $results['agentTodayLeads'] = Lead::whereDate('created_at', '>=', $today)->count();
        $results['todayLeads'] = Lead::whereDate('created_at', '>=', $today)->count();
        $results['todaySales'] = ClosedDeal::where('created_at', '>=', $today)->sum('price');
        $results['monthSales'] = ClosedDeal::where('created_at', '>=', $month)->sum('price');
        $results['seen'] = Lead::where("seen", 1)->count();
        $results['notSeen'] = Lead::where("seen", 0)->count();
    }
    else{
        $results['agentLeads'] = Lead::where('agent_id',$userID)->orWhere('commercial_agent_id',$userID)->count();
        $results['agentTodayLeads'] = Lead::whereDate('created_at', '>=', $today)->where(function ($query) use($userID) {
          $query->where('agent_id', $userID)
                ->orWhere('commercial_agent_id',$userID);
        })->count();
        $results['todayLeads'] = Lead::whereDate('created_at', '>=', $today)->where(function ($query) use($userID) {
            $query->where('agent_id', $userID)
                  ->orWhere('commercial_agent_id',$userID);
        })->count();

        $results['todaySales'] = ClosedDeal::where([
          ['created_at', '>=', $today],
          ['agent_id','=', $uid]
        ])->sum('price');
        $results['monthSales'] = ClosedDeal::where([
          ['created_at', '>=', $month],
          ['agent_id', '=' ,$uid]
        ])->sum('price');
        $results['seen'] = Lead::where("seen", 1)->where(function ($query) use($userID) {
            $query->where('agent_id', $userID)
                  ->orWhere('commercial_agent_id',$userID);
        })->count();
        $results['notSeen'] = Lead::where("seen", 0)->where(function ($query) use($userID) {
            $query->where('agent_id', $userID)
                  ->orWhere('commercial_agent_id',$userID);
        })->count();
    }

    $results['inventory'] = ResaleUnit::sum('price');

    return response()->json($results);
  }

  public function agent_events(Request $request)
  {
    //     "lang": "en",
    //     "token": "",
    //     "date": "",
    //     "user_id": ""
    return "One Agent Events";
  }

  public function get_projects(Request $request)
  {
      $startDate = explode('T',$request->query('startDate'))[0] . " " .explode('.',explode('T',$request->query('startDate'))[1])[0];
      $endDate = explode('T',$request->query('endDate'))[0] . " " .explode('.',explode('T',$request->query('endDate'))[1])[0];
      $validator = Validator::make($request->all(), [
          'startDate' => 'required|date',
          'endDate' => 'required|date',
      ]);

      if ($validator->fails()) {
          $error = [
              'code' => Response::HTTP_BAD_REQUEST,
              'type' => 'InvalidArgumentException',
              'messages' => $validator->messages(),
          ];
          return response()->json($error)->setStatusCode(Response::HTTP_BAD_REQUEST);
      }

      // TODO : Fix this method
      // $projects = Project::has('request')->withcount('request as leads')->where('created_at', '>', $startDate)
      // ->where('created_at', '<', $endDate)->orderBy('leads', 'desc')->limit(10)->get();

      $projects = Project::has('request')->withcount('request as leads')->orderBy('leads', 'desc')->limit(10)->get();

      $results = [
          'metadata' => [
              'startDate' => $startDate,
              'endDate' => $endDate,
          ],
          'projects' => $projects,
      ];

      return response()->json($results);
  }

  public function get_achievements_stats(Request $request)
  {     
      $uid = auth()->user()->id;
     
      $todayQuery = Call::where('created_at','>',Carbon::today()->subDays(1))->where('created_at','<',Carbon::today()->addDays(1));
      $yesterdayQuery = Call::where('created_at', '<', Carbon::today())->where('created_at', '>', Carbon::now()->subDays(1));
      $monthQuery = Call::where('created_at', '<', Carbon::today())->where('created_at', '>', Carbon::now()->subDays(30));
      $results = [
        'today' => $todayQuery->where('user_id', $uid)->count(),
        'yesterday' => $yesterdayQuery->where('user_id', $uid)->count(),
        'month' => $monthQuery->where('user_id', $uid)->count()
      ];

      return $results;
  }

  public function getOrder(){
        $orders =  UserEdit::where('user_id',auth()->user()->id)->value('data');
        $orders = json_decode($orders);
        for($i=0;$i<count($orders);$i++){
            $orders[$i] = substr($orders[$i],1);
        }
        return $orders;
  }

  public function get_TeamAchievements_Stats(Request $request){
    $uid = auth()->user()->id;
    $results = [];
    if(!$request->teamIds){
      $startDate = explode('T',$request->date_from)[0] . " " .explode('.',explode('T',$request->date_from)[1])[0];
      $endDate = explode('T',$request->date_to)[0] . " " .explode('.',explode('T',$request->date_to)[1])[0];
    }
    $agents = [];
    if(auth()->user()->type == "admin"){
      if(!$request->teamIds){
        $agents = User::select('id','name','image')->get();
      }else{
        $userHasGroup = Group::whereIn('id', $request->teamIds)->pluck('team_leader_id');
        $groupAgents = GroupMember::whereIn('group_id', $request->teamIds)->groupBy('member_id')->pluck('member_id')->toArray();
        foreach($userHasGroup as $teamLeader){
          array_push($groupAgents,$teamLeader);
        }
        $agents = User::whereIn('id',$groupAgents)->select('id','name','image')->get();
      }
    }
    else{
      $userHasGroup = Group::where('team_leader_id', $uid)->first();
      if($userHasGroup){
          $groupAgents = GroupMember::where('group_id', $userHasGroup->id)->groupBy('member_id')->pluck('member_id')->toArray();
          array_push($groupAgents,$uid);
          $agents = User::whereIn('id',$groupAgents)->select('id','name','image')->get();
      }
      else{
        $agents = User::select('id','name','image')->where('id',$uid)->get();
      }
    }
    
    $agentCounter = 0;
    foreach($agents as $agent){
        if($agent->image == null){
            $agent->image = "";
        }
        if(!$request->teamIds){
          $totalCalls = Call::where([['created_at','>',$startDate],['created_at','<',$endDate],['user_id','=',$agent->id]])->count();
          $totalMeetings = Meeting::where([['created_at','>',$startDate],['created_at','<',$endDate],['user_id','=',$agent->id]])->count();
        }
        else{
          $totalCalls = Call::where('user_id',$agent->id)->count();
          $totalMeetings = Meeting::where('user_id',$agent->id)->count();
        }
        $convertedLeads = DB::table('leads as lead')
                        ->join('calls as call','call.lead_id','=','lead.id')
                        ->where('call.call_status_id', '=',6)
                        ->where(function ($query) use ($agent) {
                            $query->where('lead.agent_id',$agent->id)
                                  ->orWhere('lead.commercial_agent_id',$agent->id);
                        })
                        ->count();
        $totalLeads = Lead::where('agent_id', $agent->id)->orWhere('commercial_agent_id',$agent->id)->count();
        unset($agent->id);
        $agent['id'] = $agentCounter++;
        $agent['totalCalls'] = $totalCalls;             
        $agent['totalMeetings'] = $totalMeetings;
        $agent['convertedLeads'] = $convertedLeads;
        $agent['totalLeads'] = $totalLeads;
    } 

    return $agents;
  }
}
