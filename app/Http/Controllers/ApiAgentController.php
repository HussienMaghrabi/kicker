<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Country;
use App\Favorite;
use App\Industry;
use App\Lead;
use App\LeadDocument;
use App\LeadNote;
use App\Location;
use App\Message;
use App\Project;
use App\Property;
use App\Title;
use App\ToDo;
use App\UnitType;
use Illuminate\Http\Request;
use App\Meeting;
use App\Call;
use Validator;
use App\ResaleUnit;
use App\RentalUnit;
use App\Phase;
use App\Gallery;
use App\UnitFacility;
use App\ResalImage;
use App\RentalImage;
use App\Request as Request1;
use App\Land;
use App\GroupMember;
use App\Group;
use App\Facility;
use App\Icon;
use App\Interested;
use App\User;
use App\InterestedRequest;
use DB;
use App\VoiceNote;
// use Illuminate\Support\Facades\Auth;
use Auth;

use Cache;
use Carbon\Carbon;

class ApiAgentController extends Controller
{
    public function todo_info(Request $request)
    {
        $request = json_decode($request->getContent());
        $lang = $request->lang;
        $user_id = $request->user_id;
        $locations = [];
        $projects = [];
        $leads = Lead::where('agent_id', $user_id)->select(
            'id',
            'first_name',
            'last_name',
            'phone'
        )->get()->toArray();
        if ($lang == 'ar') {
            $projects = Project::select('id', 'ar_name as name')->get()->toArray();
            $locations = Location::select('id', 'ar_name as name')->get()->toArray();
        } elseif ($lang == 'en') {
            $projects = Project::select('id', 'en_name as name')->get()->toArray();
            $locations = Location::select('id', 'en_name as name')->get()->toArray();
        }

        $data['projects'] = $projects;
        $data['lead'] = $leads;
        $data['location'] = $locations;

        return json_encode($data);
    }

    public function add_todo(Request $request)
    {

        $requests = json_decode($request->getContent());

        foreach ($requests->data as $request) {
            if ($request->type=='others') {
                $rules = [
                    'user_id' => 'required|numeric',
                    'date' => 'required|max:191',
                    'description' => 'required',
                    'time'=>'required',
                    'leads' => 'required',
                    'type' => 'required',
                ];
            } else {
                $rules = [
                    'user_id' => 'required|numeric',
                    'leads' => 'required',
                    'date' => 'required|max:191',
                    'description' => 'required',
                    'type' => 'required',
                ];
            }
            $validator = Validator::make(
                array(
                    'type' => $request->type,
                    'user_id' => $request->user_id,
                    'leads' => $request->leads,
                    'date' => $request->date,
                    'time'=> $request->time,
                    'description' => $request->description,
                ),
                $rules
            );
            if ($validator->fails()) {
                $response = array(
                    "status" => 'error',
                );
            } else {
                $todo = new ToDo();
                $todo->user_id = $request->user_id;
                $todo->leads = $request->leads;
                $todo->due_date = strtotime($request->date);
                $todo->time = strtotime($request->time);
                $todo->to_do_type = $request->type;
                $todo->status = 'pending';
                $todo->description = $request->description;
                $todo->save();
                $response = array(
                    "status" => 'ok',
                );
            }
        }
        return $response;
    }

    public function add_todo_ios(Request $request)
    {

        //$requests = json_decode($request->getContent());

        if ($request->type=='others') {
            $rules = [
                'user_id' => 'required|numeric',
                'date' => 'required|max:191',
                'description' => 'required',
                'time'=>'required',
                'leads' => 'required',
                'type' => 'required',
            ];
        } else {
            $rules = [
                'user_id' => 'required|numeric',
                'leads' => 'required',
                'date' => 'required|max:191',
                'description' => 'required',
                'type' => 'required',
            ];
        }
        $validator = Validator::make(array(
                'type' => $request->type,
                'user_id' => $request->user_id,
                'leads' => $request->leads,
                'date' => $request->date,
                'time'=> $request->time,
                'description' => $request->description,
            ), $rules);
        if ($validator->fails()) {
            $response = array(
                    "status" => 'error',
                );
        } else {
            $todo = new ToDo();
            $todo->user_id = $request->user_id;
            $todo->leads = $request->leads;
            $todo->due_date = strtotime($request->date);
            $todo->time = strtotime($request->time);
            $todo->to_do_type = $request->type;
            $todo->status = 'pending';
            $todo->description = $request->description;
            $todo->save();
            $response = array(
                    "status" => 'ok',
                );
        }

        return $response;
    }

    /*
        public function get_leads(Request $request)
        {

            try {
            $request_json = json_decode($request->getContent());

            if ( !isset($request_json->user_id) ) {
                return [];
            }

            $user_id = $request_json->user_id;
            $data = [];
            $other_phones = [];
            $page = isset($request_json->page) ? abs( (int) $request_json->page ) : 0;

            // $leads = Lead::where('agent_id', $user_id)->offset(($page-1)*25)->limit(25)->get() ;

            $userData = User::find($user_id);
            $leads = Lead::getAgentLeads($userData, 25, $page);

            // if(count($leads = Lead::offset(($page-1)*25)->limit(25)->get()) < 25){
            //     $page ++;
            //     $leads = Lead::offset(($page-1)*25)->limit(25)->get() ;
            // }
            // else {
                // $leads = Lead::offset(($page-1)*25)->limit(25)->get() ;

            // }



            $get_full_info = isset($request_json->full_info) && 'yes' === $request_json->full_info;

            if ( $get_full_info ) {

                $agent_controller = app('App\Http\Controllers\Agentapi');

            }


             $agents = [];
            $agentsData = [];

            foreach ($leads as $row) {
                $other_phones = [];
                $other_emails = '';
                $other_emails = json_decode($row->other_emails);
                if ($other_emails == null)
                    $other_emails = [];

                if ($row->other_phones != null) {

                    $p = json_decode($row->other_phones, true);
                    foreach ($p as $key => $row1)
                        foreach ($row1 as $key1 => $value) {
                            $value['whatsapp'];
                            array_push($other_phones,
                                array('number' => $key1,
                                    'whatsapp' => $value['whatsapp'],
                                    'sms' => $value['sms'],
                                    'viber' => $value['viber']
                                ));
                        }
                }
                if ($row->industry_id != null) {
                    $industry = $row->industry->name;
                } else $industry = '';

                if ($row->title_id == null)
                    $title = '';
                else
                    $title = $row->title->name;

                if ($row->country_id != null) {
                    $country = @$row->country->ar_name;
                } else
                    $country = '';



                if ($row->lead_source_id != null) {
                    $source = @$row->source->name;
                } else
                    $source = '';


                if ($row->social != null) {
                    $social = json_decode($row->social, true);
                } else {
                    $social = (object)[];
                }

                if ($row->image and $row->image != 'image.jpg') {
                    $image = $row->image;
                } else {
                    $image = 'image.jpg';
                }

                $lastCall = Call::where('lead_id', $row->id)->with('call_status')->orderBy('id', 'desc')->first();
                $lastMeeting = Meeting::where('lead_id', $row->id)->with('meeting_status')->orderBy('id', 'desc')->first();

                if (@$lastCall->created_at->timestamp > @$lastMeeting->created_at->timestamp) {
                    @$leadProbability = $lastCall->probability;
                } else {
                    @$leadProbability = $lastMeeting->probability;
                }

                if (!$leadProbability) {
                    $leadProbability = 'normal';
                }

                $lead = array(0
                    'id' => $row->id,
                    'name' => $row->first_name . ' ' . $row->last_name,
                    'phone' => $row->phone,
                    'email' => $row->email ? $row->email : '',
                    'other_emails' => $other_emails,
                    'club' => $row->club,
                    'birth_date' => $row->birth_date ? date('d-m-Y', $row->birth_date) : '',
                    'other_phones' => $other_phones,
                    'company' => $row->company ? $row->company : '',
                    'school' => $row->school ? $row->school : '',
                    'image' => $image,
                    'notes' => $row->notes ? $row->notes : '',
                    'id_number' => $row->id_number ? $row->id_number : '',
                    'religion' => $row->religion ? $row->religion : '',
                    'address' => $row->address ? $row->address : '',
                    'country' => $country ? $country : '',
                    'social' => $social,
                    'title' => $title,
                    'industry' => $industry,
                    'agent_id'=>$row->agent_id ? $row->agent_id:0 ,
                    'agent_name' => @$row->agent->name,
                    // {{$user->photo ? $user->photo->file : 'http://placehold.it/400x400'}}
                    'commercial_agent_id' => $row->commercial_agent_id,
                    'commercial_agent_name' => @$row->commercialAgent->name,
                    'reference' => $row->reference?$row->reference:'',
                    'lead_source' => @$source,
                    'probability' => $leadProbability,
                );

                if ( $get_full_info ) {

                    $lead['full_info'] = $agent_controller->get_lead( $request, $row->id );

                }

                $data[] = $lead;
            }

            $agentsData = User::select('id', 'name')->get()->toArray();

            // foreach ($data as $row) {
            //     $agents[] = $row['agent_id'];
            //     $agents[] = $row['commercial_agent_id'];
            // }
            // $agents = array_unique($agents);
            // foreach ($agents as $agent) {
            //     $agentData = User::find($agent);
            //     if ($agentData) {
            //         $arr = [];
            //         $arr['name'] = $agentData->name;
            //         $arr['id'] = $agent;
            //         $agentsData[] = $arr;
            //     }
            // }

            if ($userData->type != 'admin') {
                $agentsData = [];
            }

            $response = 'ok';
            return [ 'status'=>$response,'leads' => $data, 'agents' => $agentsData ];
            } catch (Exception $e) {
                $response =
                     'error'
                ;
                return ['status'=>$response,'leads' => $data, 'agents' => $agentsData ];

            }

        }

        public function get_agent_leads(Request $request)
        {

            try {
            $request_json = json_decode($request->getContent());

            if ( !isset($request_json->user_id) ) {
                return [];
            }

            $user_id = $request_json->user_id;
            $agent_id = $request_json->agent_id;
            $data = [];
            $other_phones = [];
            $page = isset($request_json->page) ? abs( (int) $request_json->page ) : 0;

            // $leads = Lead::where('agent_id', $user_id)->offset(($page-1)*25)->limit(25)->get() ;

            $userData = User::find($user_id);
            $leads = Lead::getAgentLeadsByAgent($userData, 25, $page, $agent_id);

            // if(count($leads = Lead::offset(($page-1)*25)->limit(25)->get()) < 25){
            //     $page ++;
            //     $leads = Lead::offset(($page-1)*25)->limit(25)->get() ;
            // }
            // else {
                // $leads = Lead::offset(($page-1)*25)->limit(25)->get() ;

            // }



            $get_full_info = isset($request_json->full_info) && 'yes' === $request_json->full_info;

            if ( $get_full_info ) {

                $agent_controller = app('App\Http\Controllers\Agentapi');

            }


             $agents = [];
            $agentsData = [];

            foreach ($leads as $row) {
                $other_phones = [];
                $other_emails = '';
                $other_emails = json_decode($row->other_emails);
                if ($other_emails == null)
                    $other_emails = [];

                if ($row->other_phones != null) {

                    $p = json_decode($row->other_phones, true);
                    foreach ($p as $key => $row1)
                        foreach ($row1 as $key1 => $value) {
                            $value['whatsapp'];
                            array_push($other_phones,
                                array('number' => $key1,
                                    'whatsapp' => $value['whatsapp'],
                                    'sms' => $value['sms'],
                                    'viber' => $value['viber']
                                ));
                        }
                }
                if ($row->industry_id != null) {
                    $industry = $row->industry->name;
                } else $industry = '';

                if ($row->title_id == null)
                    $title = '';
                else
                    $title = $row->title->name;

                if ($row->country_id != null) {
                    $country = @$row->country->ar_name;
                } else
                    $country = '';



                if ($row->lead_source_id != null) {
                    $source = @$row->source->name;
                } else
                    $source = '';


                if ($row->social != null) {
                    $social = json_decode($row->social, true);
                } else {
                    $social = (object)[];
                }

                if ($row->image and $row->image != 'image.jpg') {
                    $image = $row->image;
                } else {
                    $image = 'image.jpg';
                }

                $lastCall = Call::where('lead_id', $row->id)->with('call_status')->orderBy('id', 'desc')->first();
                $lastMeeting = Meeting::where('lead_id', $row->id)->with('meeting_status')->orderBy('id', 'desc')->first();

                if (@$lastCall->created_at->timestamp > @$lastMeeting->created_at->timestamp) {
                    @$leadProbability = $lastCall->probability;
                } else {
                    @$leadProbability = $lastMeeting->probability;
                }

                if (!$leadProbability) {
                    $leadProbability = 'normal';
                }

                $lead = array(
                    'id' => $row->id,
                    'name' => $row->first_name . ' ' . $row->last_name,
                    'phone' => $row->phone,
                    'email' => $row->email ? $row->email : '',
                    'other_emails' => $other_emails,
                    'club' => $row->club,
                    'birth_date' => $row->birth_date ? date('d-m-Y', $row->birth_date) : '',
                    'other_phones' => $other_phones,
                    'company' => $row->company ? $row->company : '',
                    'school' => $row->school ? $row->school : '',
                    'image' => $image,
                    'notes' => $row->notes ? $row->notes : '',
                    'id_number' => $row->id_number ? $row->id_number : '',
                    'religion' => $row->religion ? $row->religion : '',
                    'address' => $row->address ? $row->address : '',
                    'country' => $country ? $country : '',
                    'social' => $social,
                    'title' => $title,
                    'industry' => $industry,
                    'agent_id'=>$row->agent_id ? $row->agent_id:0 ,
                    'agent_name' => @$row->agent->name,
                    // {{$user->photo ? $user->photo->file : 'http://placehold.it/400x400'}}
                    'commercial_agent_id' => $row->commercial_agent_id,
                    'commercial_agent_name' => @$row->commercialAgent->name,
                    'reference' => $row->reference?$row->reference:'',
                    'lead_source' => @$source,
                    'probability' => $leadProbability,
                );

                if ( $get_full_info ) {

                    $lead['full_info'] = $agent_controller->get_lead( $request, $row->id );

                }

                $data[] = $lead;
            }  foreach ($data as $row) {
                $agents[] = $row['agent_id'];
                $agents[] = $row['commercial_agent_id'];
            }
            $agents = array_unique($agents);
            foreach ($agents as $agent) {
                $agentData = User::find($agent);
                if ($agentData) {
                    $arr = [];
                    $arr['name'] = $agentData->name;
                    $arr['id'] = $agent;
                    $agentsData[] = $arr;
                }
            }

            if ($userData->type != 'admin') {
                $agentsData = [];
            }

            $response = 'ok';
            return [ 'status'=>$response,'leads' => $data, 'agents' => $agentsData ];
            } catch (Exception $e) {
                $response =
                     'error'
                ;
                return ['status'=>$response,'leads' => $data, 'agents' => $agentsData ];

            }

        }
    */

    public function get_leads(Request $request)
    {
        // return ['ssssss'=>'wwwwww'];
        try {
            if (!isset($request->user_id)) {
                return [];
            }
            $user_id = $request->user_id;
            $data = [];
            $other_phones = '';
            $page = isset($request->page) ? abs((int) $request->page) : 0;

            // $leads = Lead::where('agent_id', $user_id)->offset(($page-1)*25)->limit(25)->get() ;

            $userData = User::find($user_id);
            if($userData == null){
                return [];
            }
            $result = Lead::getAgentLeadsResult($userData, 25, $page);
            $leads = $result->leads;
            $count = $result->count;
            // if(count($leads = Lead::offset(($page-1)*25)->limit(25)->get()) < 25){
            //     $page ++;
            //     $leads = Lead::offset(($page-1)*25)->limit(25)->get() ;
            // }
            // else {
            // $leads = Lead::offset(($page-1)*25)->limit(25)->get() ;

            // }



            $get_full_info = isset($request->full_info) && 'yes' === $request->full_info;

            if ($get_full_info) {
                $agent_controller = app('App\Http\Controllers\Agentapi');
            }


            $agents = [];
            $agentsData = [];

            foreach ($leads as $row) {
                $other_phones = '';
                $other_emails = '';
                $other_emails = json_decode($row->other_emails);
                if ($other_emails == null) {
                    $other_emails = [];
                }

                //if ($row->other_phones != null) {
                    //$p = explode(",",$row->other_phones);
                    // $p = json_decode($row->other_phones, true);
                    // foreach ($p as $key => $row1) {
                    //     foreach ($row1 as $key1 => $value) {
                    //         $value['whatsapp'];
                    //         array_push(
                    //         $other_phones,
                    //         array('number' => $key1,
                    //             'whatsapp' => $value['whatsapp'],
                    //             'sms' => $value['sms'],
                    //             'viber' => $value['viber']
                    //         )
                    //     );
                    //     }
                    // }
                //}
                if ($row->industry_id != null) {
                    $industry = $row->industry->name;
                } else {
                    $industry = '';
                }

                if ($row->title_id == null) {
                    $title = '';
                } else {
                    $title = $row->first_name . $row->last_name;
                }

                if ($row->country_id != null) {
                    $country = @$row->country->ar_name;
                } else {
                    $country = '';
                }



                if ($row->lead_source_id != null) {
                    $source = @$row->source->name;
                } else {
                    $source = '';
                }


                if ($row->social != null) {
                    $social = json_decode($row->social, true);
                } else {
                    $social = (object)[];
                }

                if ($row->image and $row->image != 'image.jpg') {
                    $image = $row->image;
                } else {
                    $image = 'image.jpg';
                }

                $lastCall = Call::where('lead_id', $row->id)->with('call_status')->orderBy('id', 'desc')->first();
                $lastMeeting = Meeting::where('lead_id', $row->id)->with('meeting_status')->orderBy('id', 'desc')->first();

                if (@$lastCall->created_at->timestamp > @$lastMeeting->created_at->timestamp) {
                    @$leadProbability = $lastCall->probability;
                } else {
                    @$leadProbability = $lastMeeting->probability;
                }

                if (!$leadProbability) {
                    $leadProbability = 'normal';
                }

                $lead = array(
                'id' => $row->id,
                'name' => $row->first_name . ' ' . $row->last_name,
                'phone' => $row->phone,
                'email' => $row->email ? $row->email : '',
                'other_emails' => $other_emails,
                'club' => $row->club,
                'birth_date' => $row->birth_date ? date('d-m-Y', $row->birth_date) : '',
                'other_phones' => $other_phones,
                'company' => $row->company ? $row->company : '',
                'school' => $row->school ? $row->school : '',
                // 'image' => $image,
                'notes' => $row->notes ? $row->notes : '',
                'id_number' => $row->id_number ? $row->id_number : '',
                'religion' => $row->religion ? $row->religion : '',
                'address' => $row->address ? $row->address : '',
                'country' => $country ? $country : '',
                'social' => $social,
                'title' => $title,
                'industry' => $industry,
                'agent_id'=>$row->agent_id ? $row->agent_id:0 ,
                'agent_name' => @$row->agent->name,
                // {{$user->photo ? $user->photo->file : 'http://placehold.it/400x400'}}
                'commercial_agent_id' => $row->commercial_agent_id,
                'commercial_agent_name' => @$row->commercialAgent->name,
                'reference' => $row->reference?$row->reference:'',
                'lead_source' => @$source,
                'probability' => $leadProbability,
            );

                if ($get_full_info) {
                    $lead['full_info'] = $agent_controller->get_lead($request, $row->id);
                }

                $data[] = $lead;
            }

            $agentsData = User::select('id', 'name')->get()->toArray();

            // foreach ($data as $row) {
            //     $agents[] = $row['agent_id'];
            //     $agents[] = $row['commercial_agent_id'];
            // }
            // $agents = array_unique($agents);
            // foreach ($agents as $agent) {
            //     $agentData = User::find($agent);
            //     if ($agentData) {
            //         $arr = [];
            //         $arr['name'] = $agentData->name;
            //         $arr['id'] = $agent;
            //         $agentsData[] = $arr;
            //     }
            // }

            if ($userData->type != 'admin') {
                if (count(Group::where('team_leader_id', $userData->id)->get()) > 0) {
                    $users = [];
                    foreach (Group::where('team_leader_id', $userData->id)->get() as $group) {
                        if ($group->parent_id != 0) {
                            foreach (GroupMember::where('group_id', $group->id)->get() as $member) {
                                $users[] = $member->member_id;
                            }
                        }
                    }
                    $agentsData = User::whereIn('id', $users)->get()->toArray();
                }
            }

            $response = 'ok';
            return [ 'status'=>$response, 'count' => $count, 'leads' => $data, 'agents' => $agentsData ];
        } catch (Exception $e) {
            $response =
                 'error'
            ;
            return [ 'status'=>$response, 'count' => $count, 'leads' => $data, 'agents' => $agentsData ];
        }
    }

    public function get_agent_leads(Request $request)
    {
            $leads = Lead::where('agent_id', $request->user_id);
            $todayLeads = Lead::whereDate('created_at', Carbon::today())->where('agent_id', $request->user_id)->count();
            $seen = Lead::where("seen", 1)->where('agent_id', $request->user_id)->count();
            $notSeen = Lead::where("seen", 0)->where('agent_id', $request->user_id)->count();
            $facebook = Lead::where("lead_source_id", 7)->where('agent_id', $request->user_id)->count();
            $coldCalls = Lead::where("lead_source_id", 28)->where('agent_id', $request->user_id)->count(); // Cold Calls
            $switch = Lead::where("agent_id",$request->user_id)->whereRaw("agent_id <> agent_flag")->count(); // switched to me
            $followUp = $leads->whereHas('lead_actions', function ($q) {
                $q->where("id", '>', 0);
            })->count();
            $lowest = [];
            $highest = [];
            $high = [];
            foreach ($leads->get() as $value) {
                $lastCall = Call::where("lead_id", $value->id)->latest()->first();
                // dd($lastCall);
                $lastMeeting = Meeting::where("lead_id", $value->id)->latest()->first();
                if (@$lastCall->probability == "lowest" || @$lastMeeting->probability == "lowest") {
                    array_push($lowest, $value);
                }
                if (@$lastCall->probability == "highest" || @$lastMeeting->probability == "highest") {
                    array_push($highest, $value);
                }
                if (@$lastCall->probability == "high" || @$lastMeeting->probability == "high") {
                    // dd('test');
                    array_push($high, $value);
                }
            }
            $lowest = count($lowest);
            $high = count($high);
            $highest = count($highest);

            $hotLeads = Lead::where('agent_id', $request->user_id)->where('hot', 1)->count();
            $favLeads = Lead::where('agent_id', $request->user_id)->where('favorite', 1)->count();

            $btns= [
                ['title'=>'Hot Leads','count'=>$hotLeads],
                ['title'=>'Favorite Leads','count'=>$favLeads],
                ['title'=>'Facebook','count'=>$facebook],
                ['title'=>'Cold Calls','count'=>$coldCalls],
                ['title'=>'Followup','count'=>$followUp],
                ['title'=>'Switch','count'=>$switch],
                ['title'=>'Lowest','count'=>$lowest],
                ['title'=>'High','count'=>$high],
                ['title'=>'Highest','count'=>$highest],
                ['title'=>'todayLeads','count'=>$todayLeads],
                ['title'=>'seen','count'=>$seen],
                ['title'=>'notSeen','count'=>$notSeen],
            ];
            try {
            $request_json = json_decode($request->getContent());

            if (!isset($request_json->user_id)) {
                return [];
            }

            $user_id = $request_json->user_id;
            $agent_id = $request_json->agent_id;
            $data = [];
            $other_phones = [];
            $page = isset($request_json->page) ? abs((int) $request_json->page) : 0;

            // $leads = Lead::where('agent_id', $user_id)->offset(($page-1)*25)->limit(25)->get() ;

            $userData = User::find($user_id);
            $leads = Lead::where('agent_id', $user_id)->orderBy('created_at', 'desc')->orderBy('seen');
            if ($request->target) {

            if ("Hot Leads" == $request->target) {
                $leads = $leads->where('hot', 1);
                $leads = $leads->get();
            }elseif ("Favorite Leads" == $request->target) {
                $leads = $leads->where('favorite', 1);
                $leads = $leads->get();
            }elseif ("Facebook" == $request->target) {
                $leads = $leads->where("lead_source_id", 7); // facebook
                $leads = $leads->get();
            } elseif ("Cold Calls" == $request->target) {
                $leads = $leads->where("lead_source_id", 28); // Cold Calls
                $leads = $leads->get();
            } elseif ("Followup" == $request->target) {
                $leads = $leads->whereHas('lead_actions', function ($q) {
                    $q->where("id", '>', 0);
                });
                $leads = $leads->get();
            } else {
                    $coll = null;
                    $lowest = [];
                    $highest = [];
                    $high = [];

                    $switch = Lead::where("agent_id", $user_id)->whereRaw("agent_id <> agent_flag")->get(); // switched to me

                    foreach ($leads->get() as $value) {
                            $lastCall = Call::where("lead_id", $value->id)->latest()->first();
                            $lastMeeting = Meeting::where("lead_id", $value->id)->latest()->first();
                            if (@$lastCall->probability == "lowest" || @$lastMeeting->probability == "lowest") {
                                array_push($lowest, $value);
                            }

                            if (@$lastCall->probability == "highest" || @$lastMeeting->probability == "highest") {
                                array_push($highest, $value);
                            }

                            if (@$lastCall->probability == "high" || @$lastMeeting->probability == "high") {
                                array_push($high, $value);
                            }
                        }
            if ("Lowest" == $request->target) {
                $coll = collect($lowest);
                $leads = $coll;
            } elseif ("High" == $request->target) {
                $coll = collect($high);
                $leads = $coll;
            } elseif ("Highest" == $request->target) {
                $coll = collect($highest);
                $leads = $coll;
            } elseif ("Switch" == $request->target) {
                $switch = collect($switch);
                $leads = $switch;
            }
                }
            } else {
            $leads = Lead::getAgentLeadsByAgent($userData, 25, $page, $agent_id);
            }

            // if(count($leads = Lead::offset(($page-1)*25)->limit(25)->get()) < 25){
            //     $page ++;
            //     $leads = Lead::offset(($page-1)*25)->limit(25)->get() ;
            // }
            // else {
            // $leads = Lead::offset(($page-1)*25)->limit(25)->get() ;

            // }



            $get_full_info = isset($request_json->full_info) && 'yes' === $request_json->full_info;

            if ($get_full_info) {
                $agent_controller = app('App\Http\Controllers\Agentapi');
            }


            $agents = [];
            $agentsData = [];
            // $leads->sortByDesc('id');
            foreach ($leads as $row) {
                $other_phones = [];
                $other_emails = '';
                $other_emails = json_decode($row->other_emails);
                if ($other_emails == null) {
                    $other_emails = [];
                }

                if ($row->other_phones != null) {
                    $p = json_decode($row->other_phones, true);
                    foreach ($p as $key => $row1) {
                        foreach ($row1 as $key1 => $value) {
                            $value['whatsapp'];
                            array_push(
                            $other_phones,
                            array('number' => $key1,
                                'whatsapp' => $value['whatsapp'],
                                'sms' => $value['sms'],
                                'viber' => $value['viber']
                            )
                        );
                        }
                    }
                }
                if ($row->industry_id != null) {
                    $industry = $row->industry->name;
                } else {
                    $industry = '';
                }

                if ($row->title_id == null) {
                    $title = '';
                } else {
                    $title = $row->first_name . $row->last_name; // $row->title->name;
                }

                if ($row->country_id != null) {
                    $country = @$row->country->ar_name;
                } else {
                    $country = '';
                }



                if ($row->lead_source_id != null) {
                    $source = @$row->source->name;
                } else {
                    $source = '';
                }


                if ($row->social != null) {
                    $social = json_decode($row->social, true);
                } else {
                    $social = (object)[];
                }

                if ($row->image and $row->image != 'image.jpg') {
                    $image = $row->image;
                } else {
                    $image = 'image.jpg';
                }

                $lastCall = Call::where('lead_id', $row->id)->with('call_status')->orderBy('id', 'desc')->first();
                $lastMeeting = Meeting::where('lead_id', $row->id)->with('meeting_status')->orderBy('id', 'desc')->first();

                if (@$lastCall->created_at->timestamp > @$lastMeeting->created_at->timestamp) {
                    @$leadProbability = $lastCall->probability;
                } else {
                    @$leadProbability = $lastMeeting->probability;
                }

                if (!$leadProbability) {
                    $leadProbability = 'normal';
                }

                $lead = array(
                'id' => $row->id,
                'name' => $row->first_name . ' ' . $row->last_name,
                'phone' => $row->phone,
                'email' => $row->email ? $row->email : '',
                'other_emails' => $other_emails,
                'club' => $row->club,
                'birth_date' => $row->birth_date ? date('d-m-Y', $row->birth_date) : '',
                'other_phones' => $other_phones,
                'company' => $row->company ? $row->company : '',
                'school' => $row->school ? $row->school : '',
                'image' => $image,
                'notes' => $row->notes ? $row->notes : '',
                'id_number' => $row->id_number ? $row->id_number : '',
                'religion' => $row->religion ? $row->religion : '',
                'address' => $row->address ? $row->address : '',
                'country' => $country ? $country : '',
                'social' => $social,
                'title' => $title,
                'industry' => $industry,
                'agent_id'=>$row->agent_id ? $row->agent_id:0 ,
                'agent_name' => @$row->agent->name,
                // {{$user->photo ? $user->photo->file : 'http://placehold.it/400x400'}}
                'commercial_agent_id' => $row->commercial_agent_id,
                'commercial_agent_name' => @$row->commercialAgent->name,
                'reference' => $row->reference?$row->reference:'',
                'lead_source' => @$source,
                'probability' => $leadProbability,
            );

                if ($get_full_info) {
                    $lead['full_info'] = $agent_controller->get_lead($request, $row->id);
                }

                $data[] = $lead;
            }
            foreach ($data as $row) {
                $agents[] = $row['agent_id'];
                $agents[] = $row['commercial_agent_id'];
            }
            $agents = array_unique($agents);
            foreach ($agents as $agent) {
                $agentData = User::find($agent);
                if ($agentData) {
                    $arr = [];
                    $arr['name'] = $agentData->name;
                    $arr['id'] = $agent;
                    $agentsData[] = $arr;
                }
            }

            if ($userData->type != 'admin') {
                if (count(Group::where('team_leader_id', $userData->id)->get()) > 0) {
                    $users = [];
                    foreach (Group::where('team_leader_id', $userData->id)->get() as $group) {
                        if ($group->parent_id != 0) {
                            foreach (GroupMember::where('group_id', $group->id)->get() as $member) {
                                $users[] = $member->member_id;
                            }
                        }
                    }
                    $agentsData = User::whereIn('id', $users)->get()->toArray();
                }
            }

            $response = 'ok';
            return [ 'status'=>$response,'leads' => $data, 'agents' => $agentsData ,'btns' => $btns];
        } catch (Exception $e) {
            $response =
                 'error'
            ;
            return ['status'=>$response,'leads' => $data, 'agents' => $agentsData ,'btns' => $btns];
        }
    }


    public function get_leads_sync(Request $request)
    {
        //return Cache::get('deletedLeads2');
        try {
            $updates = [];
            $deleteArray = [];
            $request_json = json_decode($request->getContent());
            foreach ($request_json->updatesArray as $key => $lead) {
                $updates[] = json_decode($lead);
            }

            if (!isset($request_json->user_id)) {
                return [];
            }

            // save coming data
            // lead

            foreach ($updates as $lead) {
                // lead

                $oldlead = $lead->full_info->lead;
                $agent_id = $lead->agent_id;
                $lead_id = $oldlead->id;
                $newlead = Lead::find($oldlead->id);

                if ($newlead) {
                    if (isset($oldlead->prefix_name)) {
                        $newlead->prefix_name = $oldlead->prefix_name;
                    }
                    if (isset($agent_id)) {
                        $newlead->agent_id = $agent_id;
                    }
                    $newlead->first_name = $oldlead->first_name;
                    $newlead->last_name = $oldlead->last_name;
                    if (isset($oldlead->middle_name)) {
                        $newlead->middle_name = $oldlead->middle_name;
                    }
                    if (isset($oldlead->ar_first_name)) {
                        $newlead->ar_first_name = $oldlead->ar_first_name;
                    }
                    if (isset($oldlead->ar_last_name)) {
                        $newlead->ar_last_name = $oldlead->ar_last_name;
                    }
                    if (isset($oldlead->ar_middle_name)) {
                        $newlead->ar_middle_name = $oldlead->ar_middle_name;
                    }
                    $newlead->email = $oldlead->email;
                    $newlead->phone = $oldlead->phone;
                    if (isset($oldlead->nationality)) {
                        $newlead->nationality = $oldlead->nationality;
                    }
                    if (isset($oldlead->country_id)) {
                        $newlead->country_id = $oldlead->country_id;
                    }
                    if (isset($oldlead->city_id)) {
                        $newlead->city_id = $oldlead->city_id;
                    }
                    if (isset($oldlead->address)) {
                        $newlead->address = $oldlead->address;
                    }
                    if (isset($oldlead->club)) {
                        $newlead->club = $oldlead->club;
                    }
                    if (isset($oldlead->title_id)) {
                        $newlead->title_id = $oldlead->title_id;
                    }
                    if (isset($oldlead->religion)) {
                        $newlead->religion = $oldlead->religion;
                    }
                    if (isset($oldlead->birth_date)) {
                        $newlead->birth_date = $oldlead->birth_date;//strtotime($oldlead->birth_date);
                    }
                    if (isset($oldlead->lead_source_id)) {
                        $newlead->lead_source_id = $oldlead->lead_source;
                    }
                    if (isset($oldlead->social)) {
                        $newlead->social = $oldlead->social;
                    }
                    if (isset($oldlead->industry_id)) {
                        $newlead->industry_id = $oldlead->industry_id;
                    }
                    if (isset($oldlead->company)) {
                        $newlead->company = $oldlead->company;
                    }
                    if (isset($oldlead->school)) {
                        $newlead->school = $oldlead->school;
                    }
                    if (isset($oldlead->facebook)) {
                        $newlead->facebook = $oldlead->facebook;
                    }
                    if (isset($oldlead->id_number)) {
                        $newlead->id_number = $oldlead->id_number;
                    }

                    $newlead->status = $oldlead->status;//'new';
                    if (isset($oldlead->other_phones)) {
                        $newlead->other_phones = $oldlead->other_phones;
                    }
                    if (isset($oldlead->other_emails)) {
                        $newlead->other_emails = $oldlead->other_emails;
                    }

                    // $newlead->notes = $oldlead->notes;
                    if (isset($oldlead->user_id)) {
                        $newlead->user_id = $oldlead->user_id;
                    }
                    if (isset($oldlead->image)) {
                        $newlead->image = $oldlead->image;
                    }

                    $newlead->save();
                } else {
                    $newlead = new Lead();
                    if (isset($oldlead->prefix_name)) {
                        $newlead->prefix_name = $oldlead->prefix_name;
                    }
                    if (isset($agent_id)) {
                        $newlead->agent_id = $agent_id;
                    }
                    $newlead->first_name = $oldlead->first_name;
                    $newlead->last_name = $oldlead->last_name;
                    if (isset($oldlead->middle_name)) {
                        $newlead->middle_name = $oldlead->middle_name;
                    }
                    if (isset($oldlead->ar_first_name)) {
                        $newlead->ar_first_name = $oldlead->ar_first_name;
                    }
                    if (isset($oldlead->ar_last_name)) {
                        $newlead->ar_last_name = $oldlead->ar_last_name;
                    }
                    if (isset($oldlead->ar_middle_name)) {
                        $newlead->ar_middle_name = $oldlead->ar_middle_name;
                    }
                    $newlead->email = $oldlead->email;
                    $newlead->phone = $oldlead->phone;
                    if (isset($oldlead->nationality)) {
                        $newlead->nationality = $oldlead->nationality;
                    }
                    if (isset($oldlead->country_id)) {
                        $newlead->country_id = $oldlead->country_id;
                    }
                    if (isset($oldlead->city_id)) {
                        $newlead->city_id = $oldlead->city_id;
                    }
                    if (isset($oldlead->address)) {
                        $newlead->address = $oldlead->address;
                    }
                    if (isset($oldlead->club)) {
                        $newlead->club = $oldlead->club;
                    }
                    if (isset($oldlead->title_id)) {
                        $newlead->title_id = $oldlead->title_id;
                    }
                    if (isset($oldlead->religion)) {
                        $newlead->religion = $oldlead->religion;
                    }
                    if (isset($oldlead->birth_date)) {
                        $newlead->birth_date = $oldlead->birth_date;//strtotime($oldlead->birth_date);
                    }
                    if (isset($oldlead->lead_source_id)) {
                        $newlead->lead_source_id = $oldlead->lead_source;
                    }
                    if (isset($oldlead->social)) {
                        $newlead->social = $oldlead->social;
                    }
                    if (isset($oldlead->industry_id)) {
                        $newlead->industry_id = $oldlead->industry_id;
                    }
                    if (isset($oldlead->company)) {
                        $newlead->company = $oldlead->company;
                    }
                    if (isset($oldlead->school)) {
                        $newlead->school = $oldlead->school;
                    }
                    if (isset($oldlead->facebook)) {
                        $newlead->facebook = $oldlead->facebook;
                    }
                    if (isset($oldlead->id_number)) {
                        $newlead->id_number = $oldlead->id_number;
                    }

                    $newlead->status = $oldlead->status;//'new';
                    if (isset($oldlead->other_phones)) {
                        $newlead->other_phones = $oldlead->other_phones;
                    }
                    if (isset($oldlead->other_emails)) {
                        $newlead->other_emails = $oldlead->other_emails;
                    }

                    // $newlead->notes = $oldlead->notes;
                    if (isset($oldlead->user_id)) {
                        $newlead->user_id = $oldlead->user_id;
                    }
                    if (isset($oldlead->image)) {
                        $newlead->image = $oldlead->image;
                    }

                    $newlead->save();
                    $lead_id = $newlead->id;
                }

                // calls
                $calls = $lead->full_info->lead->calls;
                foreach ($calls as $call) {
                    $newcall = \App\Call::find($call->id);
                    if ($newcall) {
                        $newcall->user_id = $call->user_id;
                        $newcall->lead_id = $lead_id;
                        $newcall->contact_id = $call->contact_id;
                        $newcall->call_status_id = $call->call_status_id;
                        $newcall->duration = $call->duration;
                        $newcall->date = $call->date;
                        $newcall->probability = $call->probability;
                        $newcall->phone = $call->phone;
                        $newcall->projects = $call->projects;
                        $newcall->description = $call->description;
                        $newcall->budget = $call->budget;

                        $newcall->save();
                    } else {
                        $newcall = new \App\Call();
                        $newcall->user_id = $call->user_id;
                        $newcall->lead_id = $lead_id;
                        $newcall->contact_id = $call->contact_id;
                        $newcall->call_status_id = $call->call_status_id;
                        $newcall->duration = $call->duration;
                        $newcall->date = $call->date;
                        $newcall->probability = $call->probability;
                        $newcall->phone = $call->phone;
                        $newcall->projects = $call->projects;
                        $newcall->description = $call->description;
                        $newcall->budget = $call->budget;

                        $newcall->save();
                    }
                }
                // meetings
                $meetings = $lead->full_info->lead->meetings;
                foreach ($meetings as $meeting) {
                    $newmeeting = \App\Meeting::find($meeting->id);
                    if ($newmeeting) {
                        $newmeeting->user_id = $meeting->user_id;
                        $newmeeting->lead_id = $lead_id;
                        $newmeeting->contact_id = $meeting->contact_id;
                        $newmeeting->meeting_status_id = $meeting->meeting_status_id;
                        $newmeeting->duration = $meeting->duration;
                        $newmeeting->phone = $meeting->phone;
                        $newmeeting->date = $meeting->date;
                        $newmeeting->time = $meeting->time;
                        $newmeeting->probability = $meeting->probability;
                        $newmeeting->projects = $meeting->projects;
                        $newmeeting->location = $meeting->location;
                        $newmeeting->description = $meeting->description;
                        $newmeeting->budget = $meeting->budget;

                        $newmeeting->save();
                    } else {
                        $newmeeting = \App\Meeting();
                        $newmeeting->user_id = $meeting->user_id;
                        $newmeeting->lead_id = $lead_id;
                        $newmeeting->contact_id = $meeting->contact_id;
                        $newmeeting->meeting_status_id = $meeting->meeting_status_id;
                        $newmeeting->duration = $meeting->duration;
                        $newmeeting->phone = $meeting->phone;
                        $newmeeting->date = $meeting->date;
                        $newmeeting->time = $meeting->time;
                        $newmeeting->probability = $meeting->probability;
                        $newmeeting->projects = $meeting->projects;
                        $newmeeting->location = $meeting->location;
                        $newmeeting->description = $meeting->description;
                        $newmeeting->budget = $meeting->budget;

                        $newmeeting->save();
                    }
                }
                // voice_notes
                $voicenotes = $lead->full_info->lead->voice_notes;
                foreach ($voicenotes as $vnote) {
                    $newvnote = \App\VoiceNote::find($vnote->id);
                    if ($newvnote) {
                        $newvnote->lead_id = $lead_id;
                        $newvnote->user_id = $vnote->user_id;
                        $newvnote->note = $vnote->note;
                        $newvnote->title = $vnote->title;

                        $newvnote->save();
                    } else {
                        $newvnote = \App\VoiceNote();
                        $newvnote->lead_id = $lead_id;
                        $newvnote->user_id = $vnote->user_id;
                        $newvnote->note = $vnote->note;
                        $newvnote->title = $vnote->title;

                        $newvnote->save();
                    }
                }
                // notes
                $notes = $lead->full_info->lead->notes;
                foreach ($notes as $note) {
                    $newnote = \App\LeadNote::find($note->id);
                    if ($newnote) {
                        $newnote->lead_id = $lead_id;
                        $newnote->user_id = $note->user_id;
                        $newnote->note = $note->note;

                        $newnote->save();
                    } else {
                        $newnote = new \App\LeadNote();
                        $newnote->lead_id = $lead_id;
                        $newnote->user_id = $note->user_id;
                        $newnote->note = $note->note;

                        $newnote->save();
                    }
                }
                // documents
                $documents = $lead->full_info->lead->documents;
                foreach ($documents as $document) {
                    $newdocument = \App\LeadDocument::find($document->id);
                    if ($newdocument) {
                        $newdocument->lead_id = $lead_id;
                        $newdocument->title = $document->title;
                        $newdocument->file = $document->file;
                        $newdocument->contact_id = $document->contact_id;
                        $newdocument->user_id = $document->user_id;

                        $newdocument->save();
                    } else {
                        $newdocument = \App\LeadDocument();
                        $newdocument->lead_id = $lead_id;
                        $newdocument->title = $document->title;
                        $newdocument->file = $document->file;
                        $newdocument->contact_id = $document->contact_id;
                        $newdocument->user_id = $document->user_id;

                        $newdocument->save();
                    }
                }
            }
            // end save coming data
            // delete leads
            $delete = [];
            foreach ($request_json->deleteArray as $key => $del_lead) {
                try {
                    $data = Lead::find($del_lead);
                    if ($data == null) {
                        continue;
                    }
                    $file_path = url('uploads/' . @$data->image);
                    if (@$data->image != 'image.jpg' and @$data->image != 'image.ico' and file_exists($file_path)) {
                        @unlink($file_path);
                    }
                    $user = User::find($request_json->user_id)->first();
                    $roles = [];
                    if ($user) {
                        $role = \App\Role::find($user->role->id);
                        $roles = json_decode($role->roles, true);
                    }
                    if ($roles['hard_delete_leads']) {
                        $lead = $del_lead;
                        DB::table('calls')->where('lead_id', $lead)->delete();
                        DB::table('cils')->where('lead_id', $lead)->delete();
                        DB::table('contacts')->where('lead_id', $lead)->delete();
                        DB::table('contracts')->where('lead_id', $lead)->delete();
                        DB::table('favorites')->where('lead_id', $lead)->delete();
                        DB::table('lands')->where('lead_id', $lead)->delete();
                        DB::table('lead_actions')->where('lead_id', $lead)->delete();
                        DB::table('lead_documents')->where('lead_id', $lead)->delete();
                        DB::table('lead_notes')->where('lead_id', $lead)->delete();
                        DB::table('lead_notifications')->where('lead_id', $lead)->delete();
                        DB::table('massages')->where('lead_id', $lead)->delete();
                        DB::table('meetings')->where('lead_id', $lead)->delete();
                        DB::table('proposals')->where('lead_id', $lead)->delete();
                        DB::table('recent_vieweds')->where('lead_id', $lead)->delete();
                        DB::table('requests')->where('lead_id', $lead)->delete();
                        DB::table('to_dos')->where('leads', $lead)->delete();
                        DB::table('tasks')->where('leads', $lead)->delete();
                        $data->delete();
                        $delete[] = $lead;
                    } elseif ($roles['soft_delete_leads']) {
                        $data->agent_id = 0;
                        $data->save();
                        $delete[] = $lead;
                    } else {
                        $delete = 'no permission';
                    }
                    $old_data = json_encode($data);
                } catch (\Exception $e) {
                    $delete = 'failed';
                }
            }

            if(Cache::has('deletedLeads2')){
                $deleteArray = Cache::get('deletedLeads2');
                foreach($deleteArray as $d){
                    if($d['time'] > strtotime($request_json->last_sync)){
                        $delete[] = $d['id'];
                    }
                }
            }


            // end delete
            $user_id = $request_json->user_id;
            $last_sync = $request_json->last_sync;
            $data = [];
            $other_phones = [];
            $page = isset($request_json->page) ? abs((int) $request_json->page) : 0;

            // $leads = Lead::where('agent_id', $user_id)->offset(($page-1)*25)->limit(25)->get() ;

            $userData = User::find($user_id);
            $ids = [];

            $leadNotesIds = \App\LeadNote::getLeadNotesSync($last_sync);
            $leadDocumentsIds = \App\LeadDocument::getLeadDocumentsSync($last_sync);
            $leadCallsIds = \App\Call::getLeadCallsSync($last_sync);
            $leadMeetingsIds = \App\Meeting::getLeadMeetingsSync($last_sync);
            $leadVoiceNotesIds = \App\VoiceNote::getLeadVoiceNotesSync($last_sync);
            $leadRequestsIds = \App\Request::getLeadRequestsSync($last_sync);
            $ids = array_merge($leadNotesIds, $leadDocumentsIds, $leadCallsIds, $leadMeetingsIds, $leadVoiceNotesIds, $leadRequestsIds);
            $ids = array_unique($ids);

            $leads = Lead::getAgentLeadsSync($userData, null, $page, $last_sync, $ids);

            // if(count($leads = Lead::offset(($page-1)*25)->limit(25)->get()) < 25){
            //     $page ++;
            //     $leads = Lead::offset(($page-1)*25)->limit(25)->get() ;
            // }
            // else {
            // $leads = Lead::offset(($page-1)*25)->limit(25)->get() ;

            // }



            $get_full_info = isset($request_json->full_info) && 'yes' === $request_json->full_info;

            if ($get_full_info) {
                $agent_controller = app('App\Http\Controllers\Agentapi');
            }


            $agents = [];
            $agentsData = [];

            foreach ($leads as $row) {
                $other_phones = [];
                $other_emails = '';
                $other_emails = json_decode($row->other_emails);
                if ($other_emails == null) {
                    $other_emails = [];
                }

                if ($row->other_phones != null) {
                    $p = json_decode($row->other_phones, true);
                    foreach ($p as $key => $row1) {
                        foreach ($row1 as $key1 => $value) {
                            $value['whatsapp'];
                            array_push(
                                $other_phones,
                                array('number' => $key1,
                                    'whatsapp' => $value['whatsapp'],
                                    'sms' => $value['sms'],
                                    'viber' => $value['viber']
                                )
                            );
                        }
                    }
                }
                if ($row->industry_id != null) {
                    $industry = $row->industry->name;
                } else {
                    $industry = '';
                }

                if ($row->title_id == null) {
                    $title = '';
                } else {
                    $title = $row->title->name;
                }

                if ($row->country_id != null) {
                    $country = @$row->country->ar_name;
                } else {
                    $country = '';
                }



                if ($row->lead_source_id != null) {
                    $source = @$row->source->name;
                } else {
                    $source = '';
                }


                if ($row->social != null) {
                    $social = json_decode($row->social, true);
                } else {
                    $social = (object)[];
                }

                if ($row->image and $row->image != 'image.jpg') {
                    $image = $row->image;
                } else {
                    $image = 'image.jpg';
                }

                $lastCall = Call::where('lead_id', $row->id)->with('call_status')->orderBy('id', 'desc')->first();
                $lastMeeting = Meeting::where('lead_id', $row->id)->with('meeting_status')->orderBy('id', 'desc')->first();

                if (@$lastCall->created_at->timestamp > @$lastMeeting->created_at->timestamp) {
                    @$leadProbability = $lastCall->probability;
                } else {
                    @$leadProbability = $lastMeeting->probability;
                }

                if (!$leadProbability) {
                    $leadProbability = 'normal';
                }

                $lead = array(
                    'id' => $row->id,
                    'name' => $row->first_name . ' ' . $row->last_name,
                    'phone' => $row->phone,
                    'email' => $row->email ? $row->email : '',
                    'other_emails' => $other_emails,
                    'club' => $row->club,
                    'birth_date' => $row->birth_date ? date('d-m-Y', $row->birth_date) : '',
                    'other_phones' => $other_phones,
                    'company' => $row->company ? $row->company : '',
                    'school' => $row->school ? $row->school : '',
                    'image' => $image,
                    'notes' => $row->notes ? $row->notes : '',
                    'id_number' => $row->id_number ? $row->id_number : '',
                    'religion' => $row->religion ? $row->religion : '',
                    'address' => $row->address ? $row->address : '',
                    'country' => $country ? $country : '',
                    'social' => $social,
                    'title' => $title,
                    'industry' => $industry,
                    'agent_id'=>$row->agent_id ? $row->agent_id:0 ,
                    'agent_name' => @$row->agent->name,
                    // {{$user->photo ? $user->photo->file : 'http://placehold.it/400x400'}}
                    'commercial_agent_id' => $row->commercial_agent_id,
                    'commercial_agent_name' => @$row->commercialAgent->name,
                    'reference' => $row->reference?$row->reference:'',
                    'lead_source' => @$source,
                    'probability' => $leadProbability,
                );

                if ($get_full_info) {
                    $lead['full_info'] = $agent_controller->get_lead($request, $row->id);
                }

                $data[] = $lead;
            }
            foreach ($data as $row) {
                $agents[] = $row['agent_id'];
                $agents[] = $row['commercial_agent_id'];
            }
            $agents = array_unique($agents);
            foreach ($agents as $agent) {
                $agentData = User::find($agent);
                if ($agentData) {
                    $arr = [];
                    $arr['name'] = $agentData->name;
                    $arr['id'] = $agent;
                    $agentsData[] = $arr;
                }
            }

            if ($userData->type != 'admin') {
                $agentsData = [];
            }

            $response = 'ok';
            return [ 'status'=>$response,'leads' => $data, 'agents' => $agentsData, 'delete' => $delete  ];
        } catch (Exception $e) {
            $response =
                     'error'
                ;
            return ['status'=>$response,'leads' => $data, 'agents' => $agentsData, 'delete' => $delete ];
        }
    }

    public function get_team_leads(Request $request)
    {
        $request = json_decode($request->getContent());
        $user_id = $request->user_id;
        $userData = User::find($user_id);
        $data = [];
        $other_phones = [];
        $page = $request->page;
        $leads = Lead::getTeamLeads2($userData, $page);
        $agents = [];
        $agentsData = [];

        foreach ($leads as $row) {
            $other_emails = json_decode($row->other_emails);
            if ($other_emails == null) {
                $other_emails = [];
            }

            if ($row->other_phones != null) {
                $p = json_decode($row->other_phones, true);
                foreach ($p as $key => $row1) {
                    foreach ($row1 as $key1 => $value) {
                        $value['whatsapp'];
                        array_push(
                            $other_phones,
                            array('number' => $key1,
                                'whatsapp' => $value['whatsapp'],
                                'sms' => $value['sms'],
                                'viber' => $value['viber']
                            )
                        );
                    }
                }
            }
            if ($row->industry_id != null) {
                $industry = @$row->industry->name;
            } else {
                $industry = '';
            }

            if ($row->title_id == null) {
                $title = '';
            } else {
                $title = @$row->title->name;
            }

            if ($row->country_id != null) {
                $country = @$row->country->ar_name;
            } else {
                $country = '';
            }

            if ($row->lead_source_id != null) {
                $source = @$row->source->name;
            } else {
                $source = '';
            }

            if ($row->social != null) {
                $social = json_decode($row->social, true);
            } else {
                $social = (object)[];
            }

            if ($row->image and $row->image != 'image.jpg') {
                $image = $row->image;
            } else {
                $image = 'image.jpg';
            }

            array_push($data, array(
                'id' => $row->id,
                'name' => $row->first_name . ' ' . $row->last_name,
                'phone' => $row->phone,
                'email' => $row->email ? $row->email : '',
                'other_emails' => $other_emails,
                'club' => $row->club,
                'birth_date' => $row->birth_date ? date('d-m-Y', $row->birth_date) : '',
                'other_phones' => $other_phones,
                'company' => $row->company ? $row->company : '',
                'school' => $row->school ? $row->school : '',
                'image' => $image,
                'notes' => $row->notes ? $row->notes : '',
                'id_number' => $row->id_number ? $row->id_number : '',
                'religion' => $row->religion ? $row->religion : '',
                'address' => $row->address ? $row->address : '',
                'country' => $country ? $country : '',
                'social' => $social,
                'title' => $title,
                'industry' => $industry,
                'agent_id' => @$row->agent_id,
                'agent_name' => @$row->agent->name,
                'commercial_agent_id' => $row->commercial_agent_id,
                'commercial_agent_name' => @$row->commercialAgent->name,
                'reference' => $row->reference?$row->reference:'',
                'lead_source' => $source,
            ));
        }
        // $data2=Lead::getTeamLeads($userData);
        // foreach ($data2 as $row) {
        //     $agents[] = $row['agent_id'];
        //     $agents[] = $row['commercial_agent_id'];
        // }
        // $agents = array_unique($agents);
        // foreach ($agents as $agent) {
        //     $agentData = User::find($agent);
        //     if ($agentData) {
        //         $arr = [];
        //         $arr['name'] = $agentData->name;
        //         $arr['id'] = $agent;
        //         $agentsData[] = $arr;
        //     }
        // }

        $agentsData=User::select('id','name')->where('id','!=',$user_id)->where('type','agent')->get();

        return ['leads' => $data, 'agents' => $agentsData];
    }
    public function get_teams(Request $request){
        // $groups = \App\Group::with('groupMembers')->get();
        // $group_id = \App\Group::where('team_leader_id', auth()->user()->id)->first()->id;
        // $groupMembers = \App\GroupMember::where('group_id', $group_id);
        // $ids = $groupMembers->pluck('member_id')->toArray();
        $teams = \App\Group::select( 'id','name','parent_id','team_leader_id')->get();
        return $teams;
    }
    public function get_team_children(Request $request){
        $teams = \App\Group::whereIn('team_leader_id',$request->team_leaders_id)->with('groupMembers')->get();
        $t=array();
        foreach($teams as $l=>$team){
            foreach($team->groupMembers as $k => $m){
                $t[$l][$k]['group_id']=$team->id;
                $t[$l][$k]['user_id']=$m->member->id;
                $t[$l][$k]['name']=$m->member->name;
            }
        }
        return $t;
    }
    public function dash_get_sources(Request $request){
        $request = json_decode($request->getContent());
        $index=0;
        if (@$request->date_from && @$request->date_to) {

            } else {
                $index=1;
                $request->date_from = date('Y-m-d', strtotime('01/01'));
                $request->date_to = date('Y-m-d', strtotime('12/31'));
            }
            if(@$request->ids){
                $index=1;
                $ids = \App\GroupMember::whereIn('group_id', $request->ids)->pluck('member_id')->toArray();
            }elseif(@$request->team_users_id){
                $ids = $request->team_users_id;
            }else{
                if (\App\User::where('id',$request->user_id)->first()->type == 'admin') {
                    $ids = \App\GroupMember::pluck('member_id')->toArray();
                }elseif(\App\Group::where('team_leader_id', $request->user_id)->count() > 0){
                    $groupMembers=\App\Group::where('team_leader_id', $request->user_id)->with('groupMembers')->first()->groupMembers;
                    $ids = $groupMembers->pluck('member_id')->toArray();
                }else{
                    $ids = array();
                }
            }
        $sources = \App\LeadSource::has('leads')->withcount(['leads' => function ($q) use ($request, $ids) {
            $q->where(function ($qa) use ($ids) {
                $qa->whereIn('agent_id', $ids)->orWhereIn('commercial_agent_id', $ids);
            })->where('created_at', '>', $request->date_from)->where('created_at', '<', $request->date_to);
        }])->orderBy('leads_count',"desc")->limit(8)->get();
        $totalLeads=0;
        foreach($sources as $source){
            $totalLeads+=$source->leads_count;
        }
        if($totalLeads==0)$totalLeads=1;
        $ss=array();
        foreach($sources as $k => $source){
            $ss['data'][$k]['id']=$source->id;
            $ss['data'][$k]['name']=$source->name;
            $ss['data'][$k]['percent']=round($source->leads_count*100/$totalLeads,2);
        }
        if($index){
            if (\App\User::where('id',$request->user_id)->first()->type == 'admin') {
                $ss['teams']=\App\Group::select( 'id','name','parent_id','team_leader_id')->get();
            }elseif(\App\Group::where('team_leader_id', $request->user_id)->count() > 0){
                $ss['teams']=\App\Group::select( 'id','name','parent_id','team_leader_id')->where('team_leader_id',$request->user_id)->get();
            }else{
                $ss['teams']=array();
            }
            if(isset($request->ids) && count($request->ids)>0){
                $teams = \App\Group::whereIn('id',$request->ids)->with('groupMembers')->get();
                //dd($teams);
                foreach($teams as $l=>$team){
                    foreach($team->groupMembers as $k => $m){
                        $ss['agents'][$l.$k]['group_id']=$team->id;
                        $ss['agents'][$l.$k]['user_id']=$m->member->id;
                        $ss['agents'][$l.$k]['name']=$m->member->name;
                    }
                }
            }
        }
        return $ss;

    }
    public function dash_get_status(Request $request){
        $request = json_decode($request->getContent());
        $index=0;
        if (@$request->date_from && @$request->date_to) {

            } else {
                $index=1;
                $request->date_from = date('Y-m-d', strtotime('01/01'));
                $request->date_to = date('Y-m-d', strtotime('12/31'));
            }
            if(@$request->ids){
                $index=1;
            $groupMembers = \App\GroupMember::whereIn('group_id', $request->ids)->get();
            $ids = $groupMembers->pluck('member_id')->toArray();
            }elseif(@$request->team_users_id){
            $ids = $request->team_users_id;
            }else{
                if (\App\User::where('id',$request->user_id)->get()->first()->type == 'admin') {
                    $groupMembers = \App\GroupMember::get();
                    $ids = $groupMembers->pluck('member_id')->toArray();
                }elseif(\App\Group::where('team_leader_id', $request->user_id)->count() > 0){
                    $groupMembers=\App\Group::where('team_leader_id', $request->user_id)->with('groupMembers')->first()->groupMembers;
                    $ids = $groupMembers->pluck('member_id')->toArray();
                }else{
                    $ids = array();
                }
            }
        $callStatus = new \App\CallStatus;
        $callStatus = $callStatus->has('calls')->withCount(['calls' => function ($q) use ($request, $ids) {
            $q->whereIn('user_id', $ids)->where('created_at', '>', $request->date_from)->where('created_at', '<', $request->date_to);
        }])->orderBy('calls_count',"desc")->get();
        $totalLeads=0;
        foreach($callStatus as $source){
            $totalLeads+=$source->calls_count;
        }
        if($totalLeads==0)$totalLeads=1;
        $ss=array();
        foreach($callStatus as $k => $source){
            $ss['data'][$k]['id']=$source->id;
            $ss['data'][$k]['name']=$source->name;
            $ss['data'][$k]['percent']=round($source->calls_count*100/$totalLeads,2);
        }
        if($index){

            if (\App\User::where('id',$request->user_id)->first()->type == 'admin') {
                $ss['teams']=\App\Group::select( 'id','name','parent_id','team_leader_id')->get();
            }elseif(\App\Group::where('team_leader_id', $request->user_id)->count() > 0){
                $ss['teams']=\App\Group::select( 'id','name','parent_id','team_leader_id')->where('team_leader_id',$request->user_id)->get();
            }else{
                $ss['teams']=array();
            }
            if(isset($request->ids) && count($request->ids)>0){
                $teams = \App\Group::whereIn('id',$request->ids)->with('groupMembers')->get();
                //dd($teams);
                foreach($teams as $l=>$team){
                    foreach($team->groupMembers as $k => $m){
                        $ss['agents'][$l.$k]['group_id']=$team->id;
                        $ss['agents'][$l.$k]['user_id']=$m->member->id;
                        $ss['agents'][$l.$k]['name']=$m->member->name;
                    }
                }
            }
        }
        return $ss;
    }

    public function search_leads(Request $request)
    {
        $request = json_decode($request->getContent());
        $search = $request->search;
        $group = $request->group;
        $user_id = $request->user_id;
        $page = $request->page;
        $leads = [];
        $team = [];
        $data = [];
        $other_phones =[];
        if ($group) {
            $user = User::find($user_id);
            $users = [];
            if ($user->type == 'admin' or @Group::where('team_leader_id', $user->id)->count()) {
                $leads = Lead::getAgentLeads($user);
                foreach ($leads as $lead) {
                    if ($lead->agent_id != auth()->id()) {
                        $users[] = User::find($lead->agent_id);
                    }
                }
            }
            $team = array_unique($users);
            $leads = DB::table('leads')->whereIn('agent_id', $team)
                ->where('first_name', 'LIKE', '%' . $search . '%')
                ->orWhere('middle_name', 'LIKE', '%' . $search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                ->orWhere('ar_first_name', 'LIKE', '%' . $search . '%')
                ->orWhere('ar_middle_name', 'LIKE', '%' . $search . '%')
                ->orWhere('ar_last_name', 'LIKE', '%' . $search . '%')
                ->orWhere('phone', 'LIKE', '%' . $search . '%')
                ->offset(($page - 1) * 20)
                ->limit(20)
                ->get();
        } else {
            $leads = DB::table('leads')->where('agent_id', $user_id)
                ->where('first_name', 'LIKE', '%' . $search . '%')
                ->orWhere('middle_name', 'LIKE', '%' . $search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                ->orWhere('ar_first_name', 'LIKE', '%' . $search . '%')
                ->orWhere('ar_middle_name', 'LIKE', '%' . $search . '%')
                ->orWhere('ar_last_name', 'LIKE', '%' . $search . '%')
                ->orWhere('phone', 'LIKE', '%' . $search . '%')
                ->offset(($page - 1) * 20)
                ->limit(20)
                ->get();
        }

        foreach ($leads as $row) {
            $other_emails = json_decode($row->other_emails);
            if ($other_emails == null) {
                $other_emails = [];
            }

            if ($row->other_phones != null) {
                $p = json_decode($row->other_phones, true);
                foreach ($p as $key => $row1) {
                    foreach ($row1 as $key1 => $value) {
                        $value['whatsapp'];
                        array_push(
                            $other_phones,
                            array('number' => $key1,
                                'whatsapp' => $value['whatsapp'],
                                'sms' => $value['sms'],
                                'viber' => $value['viber']
                            )
                        );
                    }
                }
            }

            if ($row->industry_id != null) {
                $industry = @$row->industry->name;
            } else {
                $industry = '';
            }

            if ($row->title_id == null) {
                $title = '';
            } else {
                $title = @$row->title->name;
            };

            if ($row->country_id != null) {
                $country = @$row->country->ar_name;
            } else {
                $country = '';
            }

            if ($row->social != null) {
                $social = json_decode($row->social, true);
            } else {
                $social = (object)[];
            }

            if ($row->image and $row->image != 'image.jpg') {
                $image = $row->image;
            } else {
                $image = 'image.jpg';
            }
            array_push($data, array(
                'id' => $row->id,
                'name' => $row->first_name . ' ' . $row->last_name,
                'phone' => $row->phone,
                'email' => $row->email ? $row->email : '',
                'other_emails' => $other_emails,
                'club' => $row->club,
                'birth_date' => $row->birth_date ? date('d-m-Y', $row->birth_date) : '',
                'other_phones' => $other_phones,
                'company' => $row->company ? $row->company : '',
                'school' => $row->school ? $row->school : '',
                'image' => $image,
                'notes' => $row->notes ? $row->notes : '',
                'id_number' => $row->id_number ? $row->id_number : '',
                'religion' => $row->religion ? $row->religion : '',
                'address' => $row->address ? $row->address : '',
                'country' => $country ? $country : '',
                'social' => $social,
                'title' => $title,
                'industry' => $industry,
                'agent_id' => '',
                'agent_name' => '',
                'reference'=>$row->reference?$row->reference:'',
            ));
        }
        return $data;
    }

    public function getAgentLeads(Request $request)
    {
        // return ['qqqq'=>'wwwwwww'];

        //$request = json_decode($request->getContent());
        // $page = $request->page;
        $leads = Lead::where('agent_id', $request->agent_id)->orWhere('commercial_agent_id', $request->agent_id)->orderBy('id', 'desc')->limit(20)->get();
        return $leads;
        $data = [];
        $other_phones = [];
        foreach ($leads as $row) {
            $other_emails = json_decode($row->other_emails);
            if ($other_emails == null) {
                $other_emails = [];
            }

            if ($row->other_phones != null) {
                $p = json_decode($row->other_phones, true);
                foreach ($p as $key => $row1) {
                    foreach ($row1 as $key1 => $value) {
                        $value['whatsapp'];
                        array_push(
                            $other_phones,
                            array('number' => $key1,
                                'whatsapp' => $value['whatsapp'],
                                'sms' => $value['sms'],
                                'viber' => $value['viber']
                            )
                        );
                    }
                }
            }
            if ($row->industry_id != null) {
                $industry = Industry::find($row->industry_id)->name;
            } else {
                $industry = '';
            }

            if ($row->title_id == null) {
                $title = '';
            } else {
                $title = Title::find($row->title_id)->name;
            }

            if ($row->country_id != null) {
                $country = Country::find($row->country_id)->ar_name;
            } else {
                $country = '';
            }
            if ($row->social != null) {
                $social = json_decode($row->social, true);
            } else {
                $social = (object)[];
            }

            if ($row->image and $row->image != 'image.jpg') {
                $image = $row->image;
            } else {
                $image = 'image.jpg';
            }

            array_push($data, array(
                'id' => $row->id,
                'name' => $row->first_name . ' ' . $row->last_name,
                'phone' => $row->phone,
                'email' => $row->email ? $row->email : '',
                'other_emails' => $other_emails,
                'club' => $row->club,
                'birth_date' => $row->birth_date ? date('d-m-Y', $row->birth_date) : '',
                'other_phones' => $other_phones,
                'company' => $row->company ? $row->company : '',
                'school' => $row->school ? $row->school : '',
                'image' => $image,
                'notes' => $row->notes ? $row->notes : '',
                'id_number' => $row->id_number ? $row->id_number : '',
                'religion' => $row->religion ? $row->religion : '',
                'address' => $row->address ? $row->address : '',
                'country' => $country ? $country : '',
                'social' => $social,
                'title' => $title,
                'industry' => $industry,
                'agent_id' => $row->agent_id,
                'agent_name' => @$row->agent->name,
                'commercial_agent_id' => $row->commercial_agent_id,
                'commercial_agent_name' => @$row->commercialAgent->name,
                'reference'=>$row->reference?$row->reference:'',
            ));
        }

        return $data;
    }

    public function get_projects(Request $request)
    {
        $request = json_decode($request->getContent());
        $user_id = $request->user_id;
        $lang = $request->lang;
        $projects = Project::where('type', $request->type)->get();

        $data = [];
        foreach ($projects as $row) {
            $location = @Location::find(@$row->location_id)->{$lang . '_name'};
            array_push($data, array(
                "id" => @$row->id,
                "name" => @$row->{$lang . '_name'},
                'price' => @$row->meter_price,
                'logo' => @$row->logo,
                'image' => @$row->cover,
                'payment' => @$row->down_payment,
                'lat' => @$row->lat,
                'lng' => @$row->lng,
                'zoom' => @$row->zoom,
                'installment_year' => @$row->installment_year,
                'delivery_date' => @$row->delivery_date,
                'location' => @$location
            ));
        }
        return $data;
    }

    public function get_resales(Request $request)
    {
        // dd($request->all());
        $user_id = $request->user_id;
        $privacy = $request->privacy;
        $filters = $request->filters;
        // $resalesQuery = ResaleUnit::with('location');
        $resalesQuery = DB::table('resale_units as resale')
        ->leftjoin('projects as project','resale.project_id','=','project.id')
        ->leftjoin('users as user','resale.user_id','=','user.id')
        ->leftjoin('locations as location','resale.location','=','location.id')
        ->leftjoin('developers as developer','project.developer_id','=','developer.id');

        if ($privacy == 'only_me') {
         
          $resalesQuery 
          ->where('resale.privacy', $privacy)
          ->join('leads as lead','resale.lead_id','=','lead.id')
          ->where('resale.lead_id','!=',null)       
          ->where('lead.agent_id',$user_id)->orWhere('lead.commercial_agent_id',$user_id);
        //   ->where(function ($q) use ($user_id) {
        //     $q
        //     ->whereHas('lead', function ($q) use ($user_id) {
        //         $q->where('agent_id',$user_id)->orWhere('commercial_agent_id',$user_id);
        //     })
        //     ->orWhere('agent_id', $user_id);
        //   });
        } elseif ($privacy == 'team_only') {
          $ownGroups = Group::where('team_leader_id', $user_id)->pluck('id');
          $ownGroupParents = Group::whereIn('id', $ownGroups)->where('parent_id','!=','0')->pluck('parent_id');

          if(!$ownGroups->isEmpty()){
            $ownGroupsMembers = GroupMember::whereIn('group_id', $ownGroups)->select('member_id')->get();
            $users = array_map(function ($g) {
              return $g['member_id'];
            }, $ownGroupsMembers->toArray());

            $teamLeaderIds = Group::whereIn('id', $ownGroupParents)->pluck('team_leader_id');
            foreach($teamLeaderIds as $teamLeaderId){
              array_push($users, $teamLeaderId);
            }
          }

          else{
            $group = DB::table('group_members AS members')
            ->select('members.member_id', 'members.group_id')
            ->join('group_members AS user_group', function ($join) use ($user_id){
                $join
                ->select('user_group.member_id', 'user_group.group_id')
                ->on('user_group.group_id', '=', 'members.group_id')
                ->where('user_group.member_id', $user_id);
            })
            ->groupBy('members.member_id')
            ->get();
            $groupIDs = GroupMember::where('member_id',$user_id)->pluck('group_id');
            $teamLeaderID = Group::whereIn('id',$groupIDs)->where('parent_id',0)->value('team_leader_id');
            $users = array_map(function ($g) {
              return $g->member_id;
            }, $group->toArray());
            array_push($users, $teamLeaderID);
          }

          array_push($users, $user_id);

          $resalesQuery
          ->where('resale.privacy', $privacy)
          ->join('leads as lead','resale.lead_id','=','lead.id')
          ->where('resale.lead_id','!=',null)       
          ->where('lead.agent_id',$user_id)->orWhere('lead.commercial_agent_id',$user_id);
        //   ->where(function ($q) use ($users) {
        //     $q
        //     ->whereHas('lead', function ($q) use ($users) {
        //       $q->whereIn('agent_id', $users)->orWhereIn('commercial_agent_id', $users);
        //     })
        //     ->orWhereIn('agent_id', $users);
        //   });
        
        }
        elseif (User::find($user_id)->type != "admin") {
          $resalesQuery
          ->where('resale.privacy', $privacy);
        }
        if (array_key_exists('developer', $filters) && !empty($filters['developer'])) {
            $resalesQuery->where('developer.id', '=', $filters['developer']);
        }
        if (array_key_exists('min_price', $filters) && $filters['min_price'] != null) {
          $resalesQuery->where('resale.price', '>=', (int)$filters['min_price']);
        }
        if (array_key_exists('max_price', $filters) && $filters['max_price'] != null) {
          $resalesQuery->where('resale.price', '<=', (int)$filters['max_price']);
        }
        if (array_key_exists('min_area', $filters) && $filters['min_area'] != null) {
            $resalesQuery->where('resale.area', '>=', (int)$filters['min_area']);
        }
        if (array_key_exists('max_area', $filters) && $filters['max_area'] != null) {
            $resalesQuery->where('resale.area', '<=', (int)$filters['max_area']);
        }
        if (array_key_exists('min_down_payment', $filters) && $filters['min_down_payment'] != null) {
            $resalesQuery->where('resale.payed', '>=', (int)$filters['min_down_payment']);
        }
        if (array_key_exists('max_down_payment', $filters) && $filters['max_down_payment'] != null) {
            $resalesQuery->where('resale.payed', '<=', (int)$filters['max_down_payment']);
        }
        if (array_key_exists('project', $filters) && !empty($filters['project'])) {
            // return 1;
          $resalesQuery->where('resale.project_id', $filters['project']);
        }
        if (array_key_exists('typee', $filters) && !empty($filters['typee'])) {
          $resalesQuery->where('resale.type', $filters['typee']);
        }
        if (array_key_exists('location', $filters) && !empty($filters['location'])) {
            // return 2;
          $resalesQuery->where('resale.location', $filters['location']);
        }

        if (array_key_exists('unit_typee', $filters) && !empty($filters['unit_typee'])) {
          $resalesQuery->where('resale.unit_type_id', $filters['unit_typee']);
        }
        
        $resales = $resalesQuery->orderBy('id', 'desc')
        ->select('resale.id as id','resale.location_number','resale.maintenance','resale.transfer','resale.priod_type','resale.value_ensure','resale.value_of_rent','resale.bua','resale.villa','resale.type','resale.unit_type_id','resale.lead_id as lead','resale.original_price','resale.payed','resale.rest','resale.total','resale.delivery_date','resale.finishing','resale.location','resale.ar_notes','resale.en_notes','resale.ar_description','resale.en_description','resale.ar_title','resale.en_title','resale.ar_address','resale.en_address','resale.youtube_link','resale.phone','resale.other_phones','resale.area','resale.price','resale.rooms','resale.bathrooms','resale.floors','resale.lng','resale.lat','resale.zoom','resale.image','resale.other_images','resale.payment_method','resale.view','resale.availability','resale.due_now','resale.broker','resale.featured','resale.priority','resale.user_id','resale.meta_description','resale.meta_keywords','resale.created_at','resale.updated_at','resale.watermarked_image','resale.other_watermarked_images','resale.confirmed','resale.maintenance_fees','resale.district_id','resale.privacy','resale.agent_id','resale.custom_agents','resale.completed','project.logo as project_logo','developer.logo as developer_logo', 'user.name as user', 'location.en_name as location_en_name')
        ->paginate(9);
        foreach($resales as $resale){
            $resale->user = DB::table('users')->where('id',$resale->user_id)->value('name');
        }
        return $resales;
    }

    public function getDeveloperInfo(Request $request){
        return DB::table('developers')->select('id',app()->getLocale() .'_name as name','logo')->get();
    }
    public function getDeveloperInfoWithPaginate(Request $request){
        return DB::table('developers')->select('id',app()->getLocale() .'_name as name','logo')->paginate(10);
    }

    public function get_rentals_new(Request $request)
    {
      $user_id = $request->user_id;
      $privacy = $request->privacy;
      $filters = $request->filters;

      $resalesQuery = RentalUnit::has('lead')
                      ->with('location')
                      ->where('privacy', $privacy);

      if ($privacy == 'only_me') {

        $resalesQuery
        ->where('agent_id', $user_id);

      } elseif ($privacy == 'team_only') {

        $group = DB::table('group_members AS members')
        ->select('members.member_id', 'members.group_id')
        ->join('group_members AS user_group', function ($join) use ($user_id){
          $join
          ->select('user_group.member_id', 'user_group.group_id')
          ->on('user_group.group_id', '=', 'members.group_id')
          ->where('user_group.member_id', $user_id);
        })
        ->get();

        $users = array_map(function ($g) {
          return $g->member_id;
        }, $group->toArray());

        // array_push($users, $user_id);

        $resalesQuery
        ->whereIn('agent_id', $users);

      }

      if (array_key_exists('from', $filters) && !empty($filters['from'])) {
        $resalesQuery->where('created_at', '>', $filters['from']);
      }

      if (array_key_exists('to', $filters) && !empty($filters['to'])) {
        $resalesQuery->where('created_at', '<', $filters['to']);
      }

      if (array_key_exists('project', $filters) && !empty($filters['project'])) {
        $resalesQuery->where('project_id', $filters['project']);
      } elseif (array_key_exists('typee', $filters) && !empty($filters['typee'])) {
        $resalesQuery->where('type', $filters['typee']);
      } elseif (array_key_exists('location', $filters) && !empty($filters['location'])) {
        $resalesQuery->where('location', $filters['location']);
      }

      if (array_key_exists('unit_typee', $filters) && !empty($filters['unit_typee'])) {
        $resalesQuery->where('unit_type_id', $filters['unit_typee']);
      }

      return $resalesQuery->paginate(10);
    }

    public function get_rentals(Request $request)
    {
        $user_id = $request->user_id;
        $privacy = $request->privacy;
        $filters = $request->filters;
        // $rentalsQuery = RentalUnit::with('location');
        $rentalsQuery = DB::table('rental_units as rental')
        ->leftjoin('projects as project','rental.project_id','=','project.id')
        ->leftjoin('users as user','rental.user_id','=','user.id')
        ->leftjoin('locations as location','rental.location','=','location.id')
        ->leftjoin('developers as developer','project.developer_id','=','developer.id');

        if ($privacy == 'only_me') {
            $rentalsQuery
            ->where('rental.privacy', $privacy)
            ->join('leads as lead','rental.lead_id','=','lead.id')
            ->where('rental.lead_id','!=',null)       
            ->where('lead.agent_id',$user_id)->orWhere('lead.commercial_agent_id',$user_id);
            // ->where(function ($q) use ($user_id) {
            //   $q
            //   ->whereHas('lead', function ($q) use ($user_id) {
            //       $q->where('agent_id',$user_id)->orWhere('commercial_agent_id',$user_id);
            //   })
            //   ->orWhere('agent_id', $user_id);
            // });
        } elseif ($privacy == 'team_only') {
            $ownGroups = Group::where('team_leader_id', $user_id)->pluck('id');
            $ownGroupParents = Group::whereIn('id', $ownGroups)->where('parent_id','!=','0')->pluck('parent_id');

            if(!$ownGroups->isEmpty()){
                $ownGroupsMembers = GroupMember::whereIn('group_id', $ownGroups)->select('member_id')->get();
                $users = array_map(function ($g) {
                return $g['member_id'];
                }, $ownGroupsMembers->toArray());

                $teamLeaderIds = Group::whereIn('id', $ownGroupParents)->pluck('team_leader_id');
                foreach($teamLeaderIds as $teamLeaderId){
                    array_push($users, $teamLeaderId);
                }

            }
            else{
                $group = DB::table('group_members AS members')
                ->select('members.member_id', 'members.group_id')
                ->join('group_members AS user_group', function ($join) use ($user_id){
                    $join
                    ->select('user_group.member_id', 'user_group.group_id')
                    ->on('user_group.group_id', '=', 'members.group_id')
                    ->where('user_group.member_id', $user_id);
                })
                ->groupBy('members.member_id')
                ->get();
                $groupIDs = GroupMember::where('member_id',$user_id)->pluck('group_id');
                $teamLeaderID = Group::whereIn('id',$groupIDs)->where('parent_id',0)->value('team_leader_id');
                $users = array_map(function ($g) {
                  return $g->member_id;
                }, $group->toArray());
                array_push($users, $teamLeaderID);
            }
            array_push($users, $user_id);

            $rentalsQuery
            ->where('rental.privacy', $privacy)
            ->join('leads as lead','rental.lead_id','=','lead.id')
            ->where('rental.lead_id','!=',null)       
            ->where('lead.agent_id',$user_id)->orWhere('lead.commercial_agent_id',$user_id);
            // ->where(function ($q) use ($users) {
            //     $q
            //     ->whereHas('lead', function ($q) use ($users) {
            //     $q->whereIn('agent_id', $users)->orWhereIn('commercial_agent_id', $users);
            //     })
            //     ->orWhereIn('agent_id', $users);
            // });
        }
        elseif (User::find($user_id)->type != "admin") {
            $rentalsQuery
            ->where('rental.privacy', $privacy);
        }

        if (array_key_exists('developer', $filters) && !empty($filters['developer'])) {
            $rentalsQuery->where('developer.id', '=', $filters['developer']);
        }
        if (array_key_exists('min_price', $filters) && $filters['min_price'] != null) {
          $rentalsQuery->where('rental.price', '>=', (int)$filters['min_price']);
        }
        if (array_key_exists('max_price', $filters) && $filters['max_price'] != null) {
          $rentalsQuery->where('rental.price', '<=', (int)$filters['max_price']);
        }
        if (array_key_exists('min_area', $filters) && $filters['min_area'] != null) {
            $rentalsQuery->where('rental.area', '>=', (int)$filters['min_area']);
        }
        if (array_key_exists('max_area', $filters) && $filters['max_area'] != null) {
            $rentalsQuery->where('rental.area', '<=', (int)$filters['max_area']);
        }
        if (array_key_exists('min_down_payment', $filters) && $filters['min_down_payment'] != null) {
            $rentalsQuery->where('rental.payed', '>=', (int)$filters['min_down_payment']);
        }
        if (array_key_exists('max_down_payment', $filters) && $filters['max_down_payment'] != null) {
            $rentalsQuery->where('rental.payed', '<=', (int)$filters['max_down_payment']);
        }
        if (array_key_exists('project', $filters) && !empty($filters['project'])) {
          $rentalsQuery->where('rental.project_id', $filters['project']);
        }
        if (array_key_exists('typee', $filters) && !empty($filters['typee'])) {
          $rentalsQuery->where('rental.type', $filters['typee']);
        }
        if (array_key_exists('location', $filters) && !empty($filters['location'])) {
          $rentalsQuery->where('rental.location', $filters['location']);
        }

        if (array_key_exists('unit_typee', $filters) && !empty($filters['unit_typee'])) {
            $rentalsQuery->where('rental.unit_type_id', $filters['unit_typee']);
        }

        $rentals = $rentalsQuery->orderBy('id', 'desc')
        ->select('rental.id as id','rental.location_number','rental.maintenance_fees','rental.priod_type','rental.value_ensure','rental.value_of_rent','rental.bua','rental.villa','rental.type','rental.unit_type_id','rental.lead_id as lead','rental.delivery_date','rental.finishing','rental.location','rental.ar_notes','rental.en_notes','rental.ar_description','rental.en_description','rental.ar_title','rental.en_title','rental.ar_address','rental.en_address','rental.youtube_link','rental.phone','rental.other_phones','rental.area','rental.rooms','rental.bathrooms','rental.floors','rental.lng','rental.lat','rental.zoom','rental.image','rental.other_images','rental.payment_method','rental.view','rental.availability','rental.due_now','rental.broker','rental.user_id','rental.meta_description','rental.meta_keywords','rental.created_at','rental.updated_at','rental.watermarked_image','rental.confirmed','rental.maintenance_fees','rental.district_id','rental.privacy','rental.agent_id','rental.custom_agents','rental.completed','project.logo as project_logo','developer.logo as developer_logo', 'user.name as user', 'location.en_name as location_en_name')
        ->paginate(10);
        foreach($rentals as $rental){
            $rental->user = DB::table('users')->where('id',$rental->user_id)->value('name');
        }
        return $rentals;
        
    }

    public function single_project(Request $request)
    {
        $request = json_decode($request->getContent());
        $id = $request->id;
        $lang = $request->lang;
        $project = Project::find($id);

        $data['data'] = array();
        $data['units'] = array();
        $data['gallery'] = array();
        $data['facility'] = array();
        $data['pdfs']= array();
        $data['pdfs']['broker_pdf'] = array();
        $data['pdfs']['developer_pdf'] = array();
        $data['pdfs']['broker_pdf']=  json_decode($project->developer_pdf);
        $data['pdfs']['developer_pdf']=  json_decode($project->developer_pdf);
        $location = Location::find($project->location_id)->{$lang . '_name'};

        $phase = Phase::where('project_id', '=', $project->id)->get();

        $data['data'] = array("id" => $project->id, "name" => $project->{$lang . '_name'},
            'description' => $project->{$lang . '_description'}, 'price' => $project->meter_price,
            'logo' => $project->logo, 'image' => $project->cover, 'payment' => $project->down_payment,
            'installment_year' => $project->installment_year, 'lat' => $project->lat,
            'lng' => $project->lng, 'zoom' => $project->zoom, 'delivery_date' => $project->delivery_date,
            'location' => $location);

        foreach ($phase as $row) {
            $units = Property::leftJoin('unit_types', 'unit_types.id', '=', 'properties.unit_id')
                ->where('phase_id', '=', $row->id)->where('availability', 'available')
                ->select(
                    'properties.id as id',
                    'properties.en_name as en_name',
                    'properties.ar_name as ar_name',
                    'unit_types.en_name as en_type',
                    'unit_types.ar_name as ar_type',
                    'properties.start_price as price',
                    'properties.area_from as area_from',
                    'properties.area_to as area_to'
                )
                ->get();

            foreach ($units as $unit) {
                array_push($data['units'], array("id" => $unit->id, "name" => $unit->{$lang . '_name'}, 'price' => $unit->price,
                    'type' => $unit->{$lang . '_type'}, 'area_from' => $unit->area_from, 'area_to' => $unit->area_to));
            }

            //---------------------------------------------------------------------------------
        }
        $data['gallery'] = Gallery::where('project_id', '=', $id)->select('image')->get()->toArray();

        $facility = UnitFacility::where('unit_id', $id)->where('type', 'project')->get();

        foreach ($facility as $row1) {
            $facility1 = Facility::find($row1->facility_id);

            $icon = Icon::find($facility1->icon);

            array_push($data['facility'], array("icon" => $icon->icon, "name" => $facility1->{$lang . '_name'}));
        }

        return $data;
    }

    public function single_resale(Request $request)
    {
        $request = json_decode($request->getContent());
        $id = $request->id;
        $lang = $request->lang;
        $unit = ResaleUnit::with('facilities')->find($id);
        if (!$unit) {
            return ['status' => 'error', 'msg' => 'not found'];
        }
        $type='';
        $name='';
        $phone='';
        $other_phone = json_decode(@$unit->other_phones);
        if (@$unit->privacy == 'only_me') {
            $type='lead';
            $lead = Lead::find(@$unit->lead_id);
            if ($lead) {
                $name= @$lead->first_name. ' '. @$lead->first_name;
                $phone = @$lead->phone;
            }
        } else {
            $type= 'agent';
            $agent = User::find(@$unit->agent_id);
            if ($agent) {
                $name = @$agent->name;
                $phone = @$agent->phone;
                $other_phone = [];
            }
        }

        $location = @Location::find($unit->location)->{$lang . '_name'};
        $otherimages = ResalImage::where('unit_id', $id)->get();
        $images = [];
        foreach ($otherimages as $row) {
            array_push($images, $row->image);
        }
        $unit->other_images = $images;
        return $unit;
        /**
        $data = array('status' => 'success','id' => $unit->id, 'location' => $location,
            'home_image' => $unit->image, 'other_images' => $images,
            'title' => $unit->{$lang . '_title'}, 'price' => $unit->price, 'area' => $unit->area,
            'rooms' => $unit->rooms, 'bathrooms' => $unit->bathrooms,
            'due_now' => $unit->due_now, 'finished' => $unit->finishing,
            'description' => $unit->{$lang . '_description'},
            'main_phone' => $phone, 'other_phone' => $other_phone,
            'type'=>$type,'name'=>$name,

        );
        return $data;
        */
    }

    public function single_rental(Request $req)
    {
        $request = json_decode($req->getContent());
        $id = $request->id;
        $lang = $request->lang;

        $unit = @RentalUnit::with('facilities')->find($id);
        if (!$unit) {
            return ['status' => 'error', 'msg' => 'not found'];
        }
        $type  = '';
        $name  = '';
        $phone = '';
        $agent = '';

        $other_phone= json_decode($unit->other_phones);
        if (@$unit->privacy == 'only_me') {
            $type='lead';
            $lead = @Lead::find(@$unit->lead_id);
            if ($lead) {
                $name=@$lead->first_name. ' '.@$lead->first_name;
                $phone = @$unit->main_phone;
            }
        } else {
            $type= 'agent';
            $agent = @User::find(@$unit->agent_id);
            if ($agent) {
                $name = @$agent->name;
                $phone = @$agent->phone;
                $other_phone= [];
            }
        }

        $location = @Location::find($unit->location)->{$lang . '_name'};
        $otherimages = @RentalImage::where('unit_id', $id)->get();
        $images = [];
        foreach ($otherimages as $row) {
            array_push($images, $row->image);
        }
        $unit->other_images = $images;
        return $unit;
        /**
        $data = array('status' => 'success','id' => $unit->id, 'location' => $location,
            'home_image' => $unit->image, 'other_images' => $images,
            'title' => $unit->{$lang . '_title'}, 'price' => $unit->rent, 'area' => $unit->area,
            'rooms' => $unit->rooms, 'bathrooms' => $unit->bathrooms,
            'due_now' => $unit->due_now, 'finished' => $unit->finishing,
            'description' => $unit->{$lang . '_description'},
            'main_phone' => $phone, 'other_phone' => $other_phone,
            'type'=>$type,'name'=>$name,
        );
        return $data;
        */
    }

    public function lead_contact(Request $request)
    {
        $request = json_decode($request->getContent());
        $user_id = $request->user_id;
        $lead_id = $request->lead_id;
        $data = Contact::where('lead_id', $lead_id)->get()->toArray();
        return $data;
    }

    public function lead_note(Request $request)
    {
        $request = json_decode($request->getContent());
        $user_id = $request->user_id;
        $lead_id = $request->lead_id;
        $leads = LeadNote::where('lead_id', $lead_id)->get();
        $voices = VoiceNote::where('lead_id', $lead_id)->get();
        $data = [];
        foreach ($leads as $row) {
            $row->date = date('d/m/Y', strtotime($row->created_at));
            $row->agent = User::find($row->user_id)->name;
            $row->voice = false;
            $data[] = $row;
        }

        foreach ($voices as $row1) {
            $row1->date = date('d/m/Y', strtotime($row1->created_at));
            $row1->agent = User::find($row1->user_id)->name;
            $row1->voice = true;
            $data[] = $row1;
        }

        return $data;
    }

    public function lead_message(Request $request)
    {
        $request = json_decode($request->getContent());
        $user_id = $request->user_id;
        $lead_id = $request->lead_id;
        $leads = Message::join('leads', 'leads.id', '=', 'messages.user_id')->where('messages.user_id', $lead_id)->
        select(
            'leads.id as id',
            'leads.first_name as first_name',
            'leads.last_name as last_name',
            'messages.message as message'
        )->get()->toArray();
        return $leads;
    }

    public function lead_document(Request $request)
    {
        $request = json_decode($request->getContent());
        $user_id = $request->user_id;
        $lead_id = $request->lead_id;
        $leads = LeadDocument::where('lead_id', $lead_id)->get()->toArray();
        return $leads;
    }

    public function lead_request(Request $request)
    {
        $request = json_decode($request->getContent());
        $user_id = $request->user_id;
        $lang = $request->lang;
        $lead_id = $request->lead_id;
        $data = [];
        $requests = Request1::where('lead_id', $lead_id)->get();
        foreach ($requests as $row) {
            $recieve = $this->suggest($row);
            $units = $this->single_unit($recieve['unit'], $recieve['type'], $lang, $lead_id);
            $row->units = $units;
            $location = @Location::find($row->location)->{$lang . '_name'};
            $type = @UnitType::find($row->unit_type_id)->{$lang . '_name'};
            $row->location = $location;
            $row->unit_type_id = $type;
            array_push($data, $row->toArray());
        }
        return $data;
    }

    public function get_suggestion(Request $request)
    {
        $request = json_decode($request->getContent());
        $lang = $request->lang;
        $requests = Request1::find($request->request_id);
        $lead_id = $requests->lead_id;
        $recieve = $this->suggest($requests);
        $units = $this->single_unit($recieve['unit'], $recieve['type'], $lang, $lead_id, $request->request_id);

        return $units;
    }

    private function suggest($req)
    {
        $data['unit'] = [];
        $data['type'] = [];
        $units=[];
        $type=[];
        $locationsArray = HomeController::getChildren($req->location);
        $locationsArray[] = $req->location;
        if ($req->request_type != 'land') {
            if ($req->request_type == 'new_home') {
                $units = @Project::where('type', $req->unit_type)->
                whereBetween('meter_price', [$req->price_from, $req->price_to])->
                whereBetween('area', [$req->area_from, $req->area_to])->
                whereIn('location_id', $locationsArray)->select('id')->
                get()->toArray();
                $type = 'project';
            } elseif ($req->request_type == 'resale') {
                $units = @ResaleUnit::whereBetween('rooms', [$req->rooms_from, $req->rooms_to])->
                where('type', $req->unit_type)->
                where('unit_type_id', $req->unit_type_id)->
                whereBetween('total', [$req->price_from, $req->price_to])->
                whereBetween('area', [$req->area_from, $req->area_to])->
                whereBetween('rooms', [$req->rooms_from, $req->rooms_to])->
                whereIn('location', $locationsArray)->
                where('delivery_date', $req->date)->
                whereBetween('bathrooms', [$req->bathrooms_from, $req->bathrooms_to])->select('id')->get()->toArray();
                $type = 'resale';
            } elseif ($req->request_type == 'rental') {
                $units = @RentalUnit::whereBetween('rooms', [$req->rooms_from, $req->rooms_to])->
                where('type', $req->unit_type)->
                where('unit_type_id', $req->unit_type_id)->
                whereBetween('rent', [$req->price_from, $req->price_to])->
                whereBetween('area', [$req->area_from, $req->area_to])->
                whereBetween('rooms', [$req->rooms_from, $req->rooms_to])->
                whereIn('location', $locationsArray)->
                where('delivery_date', $req->date)->
                whereBetween('bathrooms', [$req->bathrooms_from, $req->bathrooms_to])->select('id')->get()->toArray();
                $type = 'rental';
            }
        } else {
            $units = @Land::whereBetween('meter_price', [$req->price_from, $req->price_to])->
            whereBetween('area', [$req->area_from, $req->area_to])->
            whereIn('location', $locationsArray)->get();
            $type = 'lands';
        }
        $data['unit'] = $units;
        $data['type'] = $type;
        return $data;
    }

    private function single_unit($id, $type, $lang, $lead_id, $req_id = null)
    {
        $data = [];
        $favorite=false;

        if ($type == "rental") {
            $rentals = RentalUnit::leftJoin('locations', 'locations.id', '=', 'rental_units.location')->
            where('availability', 'available')->whereIn('rental_units.id', $id)->
            select(
                'rental_units.id',
                'rental_units.image',
                'rental_units.other_images',
                'rental_units.en_title',
                'rental_units.ar_title',
                'rental_units.rent',
                'rental_units.rooms',
                'rental_units.area',
                'rental_units.bathrooms',
                'locations.ar_name',
                'locations.en_name'
            )->get();

            foreach ($rentals as $rental) {
                $images = RentalImage::where('unit_id', $rental->id)->select('image')->get()->toArray();
                $favorite = false;
                if (Interested::where('unit_id', $rental->id)->where('lead_id', $lead_id)->where('type', $type)->count() > 0) {
                    $favorite = true;
                }

                $interest = false;
                if (InterestedRequest::where('unit_id', $rental->id)->where('request_id', $req_id)->count()) {
                    $interest = true;
                }

                array_push($data, array('id' => $rental->id, 'location' => $rental->{$lang . '_name'},
                    'home_image' => $rental->image, 'other_images' => $images,
                    'title' => $rental->{$lang . '_title'}, 'price' => $rental->rent, 'area' => $rental->area,
                    'rooms' => $rental->rooms, 'bathrooms' => $rental->bathrooms,'favorite'=>$favorite, 'interest' => $interest
                ));
            }
        } elseif ($type == "resale") {
            $resales = ResaleUnit::leftJoin('locations', 'locations.id', '=', 'resale_units.location')->
            where('availability', 'available')->whereIn('resale_units.id', $id)->
            select(
                'resale_units.id',
                'resale_units.image',
                'resale_units.other_images',
                'resale_units.en_title',
                'resale_units.ar_title',
                'resale_units.price',
                'resale_units.rooms',
                'resale_units.area',
                'resale_units.bathrooms',
                'locations.ar_name',
                'locations.en_name'
            )->get();
            foreach ($resales as $resale) {
                $favorite = false;
                if (Interested::where('unit_id', $resale->id)->where('lead_id', $lead_id)->where('type', $type)->count()>0) {
                    $favorite=true;
                }

                $interest = false;
                if (InterestedRequest::where('unit_id', $resale->id)->where('request_id', $req_id)->count()) {
                    $interest = true;
                }

                array_push($data, array('id' => $resale->id, 'location' => $resale->{$lang . '_name'},
                    'home_image' => $resale->image, 'other_images' => json_decode($resale->other_images),
                    'title' => $resale->{$lang . '_title'}, 'price' => $resale->price, 'area' => $resale->area,
                    'rooms' => $resale->rooms, 'bathrooms' => $resale->bathrooms,'favorite'=>$favorite, 'interest' => $interest
                ));
            }
        } elseif ($type == "project") {
            $projects = Project::whereIn('id', $id)->get();
            foreach ($projects as $row) {
                $favorite=false;
                if (Interested::where('unit_id', $row->id)->where('lead_id', $lead_id)->where('type', $type)->count()>0) {
                    $favorite=true;
                }

                $interest = false;
                if (InterestedRequest::where('unit_id', $row->id)->where('request_id', $req_id)->count()) {
                    $interest = true;
                }

                $location = Location::find($row->location_id)->{$lang . '_name'};
                array_push($data, array("id" => $row->id, "name" => $row->{$lang . '_name'}, 'price' => $row->meter_price,
                    'logo' => $row->logo, 'image' => $row->cover, 'payment' => $row->down_payment,
                    'lat' => $row->lat, 'lng' => $row->lng, 'zoom' => $row->zoom,
                    'installment_year' => $row->installment_year, 'delivery_date' => $row->delivery_date,
                    'location' => $location,'favorite'=>$favorite, 'interest' => $interest));
            }
        }
        return $data;
    }

    public function getinfo(Request $request)
    {
        $request = json_decode($request->getContent());
        $contacts = Contact::where('lead_id', $request->lead_id)->get();
        $lang = $request->lang;
        $data['contact'] = [];
        $projects = Project::select('id', $lang . '_name as name')->get()->toArray();
        $data['project'] = $projects;
        $call_status = \App\CallStatus::all()->toArray();
        $data['call_status'] = $call_status;
        $meeting_status = \App\MeetingStatus::all()->toArray();
        $data['meeting_status'] = $meeting_status;
        foreach ($contacts as $row) {
            if ($row->other_phones != null) {
                $phone = json_decode($row->other_phones);
            } else {
                $phone = [];
            }
            array_push($data['contact'], array('id' => $row->id, 'name' => $row->name, 'main_phone' => $row->phone, 'other_phone' => $phone));
        }
        return $data;
    }

    public function add_call(Request $request)
    {
        $request = json_decode($request->getContent());
        $rules = [
           'user_id' => 'required|numeric',
           'lead_id' => 'required',
           // 'date' => 'required|max:191',
           // 'duration' => 'required|max:191',
           // 'projects' => 'required',
           'contact_id' => 'required',
           // 'probability' => 'required',
           'phone_in_out' => 'required',
           'call_status_id' => 'required'
       ];
        $validator = Validator::make(array(
           'user_id' => $request->user_id,
           'lead_id' => $request->lead_id,
           'contact_id' => $request->contact_id,
           // 'date' => $request->date,
           // 'duration' => $request->duration,
           // 'projects' => $request->projects,
           // 'probability' => $request->probability,
           'phone_in_out' => $request->phone_in_out,
           'call_status_id' => $request->call_status_id
       ), $rules);
        if ($validator->fails()) {
            $response = array(
               "status" => 'error', 'data' => $validator->errors()
           );
        } else {
            $call = new Call();
            $call->user_id = $request->user_id;
            $call->lead_id = $request->lead_id;
            $call->call_status_id = $request->call_status_id;
            $call->contact_id = $request->contact_id;
            $call->duration = $request->duration;
            $call->date = $request->date;
            $call->probability = $request->probability;
            if ($request->contact_id) {
                $call->phone = Lead::where('id', $request->lead_id)->pluck('phone');
            } else {
                $call->phone = Contact::where('id', $request->contact_id)->pluck('phone');
            }
            $call->projects = json_encode($request->projects);
            $call->description = $request->description;
            $call->save();
            $has_next_action = $call->call_status->has_next_action;

            DB::table('lead_actions')->insert([
                'lead_id'=>$request->lead_id,
                'type'=> 'call',
                'agent_type'=> 0,
                'time'=>strtotime(time()),
                'user_id'=>$request->user_id
            ]);

            $response = array(
               "status" => "OK",
               "has_next_action" => $has_next_action
           );
        }
        return $response;
    }

    public function add_interested(Request $request)
    {
        try {
            $request = json_decode($request->getContent());
            $unit_id = $request->unit_id;
            $lead_id = $request->lead_id;
            $type = $request->type;
            if (Interested::where('unit_id', $unit_id)->where('lead_id', $lead_id)->where('type', $type)->count()==0) {
                $interested = new Interested();
                $interested->unit_id = $unit_id;
                $interested->lead_id = $lead_id;
                $interested->type = $type;
                $interested->save();
            }
            $response = array(
                "status" => 'ok',
            );
            return $response;
        } catch (Exception $e) {
            $response = array(
                "status" => 'error',
            );
            return $response;
        }
    }

    public function get_teamLeads(Request $request)
    {
        $request = json_decode($request->getContent());
        $user_id = $request->user_id;
        $userData = User::find($user_id);
        $data = [];
        $other_phones = [];
        // $page = $request->page;
        // $leads = Lead::getAgentLea($userData)->paginate(15);
        // $page = isset($request_json->page) ? abs( (int) $request_json->page ) : 0;
        // $leads = Lead::offset(($page-1)*20)->limit(20)->get();

        $get_full_info = isset($request_json->full_info) && 'yes' === $request_json->full_info;

        if ($get_full_info) {
            $agent_controller = app('App\Http\Controllers\Agentapi');
        }
        $agents = [];
        $agentsData = [];

        foreach ($leads as $row) {
            $other_emails = json_decode($row->other_emails);
            if ($other_emails == null) {
                $other_emails = [];
            }

            if ($row->other_phones != null) {
                $p = json_decode($row->other_phones, true);
                foreach ($p as $key => $row1) {
                    foreach ($row1 as $key1 => $value) {
                        $value['whatsapp'];
                        array_push(
                            $other_phones,
                            array('number' => $key1,
                                'whatsapp' => $value['whatsapp'],
                                'sms' => $value['sms'],
                                'viber' => $value['viber']
                            )
                        );
                    }
                }
            }
            if ($row->industry_id != null) {
                $industry = @$row->industry->name;
            } else {
                $industry = '';
            }

            if ($row->title_id == null) {
                $title = '';
            } else {
                $title = @$row->title->name;
            }

            if ($row->country_id != null) {
                $country = @$row->country->ar_name;
            } else {
                $country = '';
            }

            if ($row->lead_source_id != null) {
                $source = @$row->source->name;
            } else {
                $source = '';
            }

            if ($row->social != null) {
                $social = json_decode($row->social, true);
            } else {
                $social = (object)[];
            }

            if ($row->image and $row->image != 'image.jpg') {
                $image = $row->image;
            } else {
                $image = 'image.jpg';
            }
            /////////////////////////////////////////////
            /////////////////////////////////////////////
            $calls = Call::where('lead_id', $row->id)->with('call_status')->orderBy('id', 'desc')->with('user')->take(3)->get();
            $meetings = Meeting::where('lead_id', $row->id)->with('meeting_status')->orderBy('id', 'desc')->with('user')->take(3)->get();
            $voice_notes = VoiceNote::where('lead_id', $row->id)->orderBy('id', 'desc')->with('user')->take(3)->get();
            $notes = LeadNote::where('lead_id', $row->id)->orderBy('id', 'desc')->with('user')->take(3)->get();

            foreach ($meetings as $meeting) {
                if (@$meeting->user->image == 'image.jpg') {
                    $meeting->image = '';
                }
            }

            foreach ($calls as $call) {
                if (@$call->user->image == 'image.jpg') {
                    $call->image = '';
                }
            }

            foreach ($voice_notes as $note) {
                $note->user_name = @$note->user->name;
                $note->date = @\Carbon\Carbon::createFromTimeStamp(strtotime($note->created_at))->diffForHumans();
                if (@$note->user->image == 'image.jpg') {
                    $note->image = '';
                }
            }

            foreach ($notes as $note) {
                $note->user_name = @$note->user->name;
                $note->date = @\Carbon\Carbon::createFromTimeStamp(strtotime($note->created_at))->diffForHumans();
                if (@$note->user->image == 'image.jpg') {
                    $note->image = '';
                }
            }

            $seen = 'not_seen';
            if ($row->seen) {
                $seen = 'seen_without_action';
                if (DB::table('lead_actions')->where('lead_id', $row->id)->count()) {
                    $seen = 'seen_with_action';
                }
            }
            $dataa = [
                        'id' => $row->id,
                        'first_name' => $row->first_name,
                        'last_name' => $row->last_name,
                        'image' => $row->image,
                        'phone' => $row->phone,
                        'lead_source' => @$row->source->name,
                        'reference' => $row->reference,
                        'title' => @$row->title->name,
                        'industry' => @$row->industry->name,
                        'email' => $row->email,
                        'status' => $seen,
                        'created_by' => $row->user->name,
                        'created_at' => @$row->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => @$row->updated_at->format('Y-m-d H:i:s'),
                        'r_agent' => [
                            'name' => @$row->agent->name,
                            'image' => @$row->agent->image,
                            'type' => @$row->agent->agentType->name,
                        ],
                        'c_agent' => [
                         'name' => @$row->commercialAgent->name,
                         'image' => @$row->commercialAgent->image,
                         'type' => @$row->commercialAgent->agentType->name,
                        ],
                        'calls' => $calls,
                        'meetings' => $meetings,
                        'voice_notes' => $voice_notes,
                        'notes' => $notes,
                        'documents' => @$row->documents
                    ];
            /////////////////////////////////////////////
            ////////////////////////////////////////////

            array_push($data, array(
                'id' => $row->id,
                'name' => $row->first_name . ' ' . $row->last_name,
                'phone' => $row->phone,
                'email' => $row->email ? $row->email : '',
                'other_emails' => $other_emails,
                'club' => $row->club,
                'birth_date' => $row->birth_date ? date('d-m-Y', $row->birth_date) : '',
                'other_phones' => $other_phones,
                'company' => $row->company ? $row->company : '',
                'school' => $row->school ? $row->school : '',
                'image' => $image,
                'notes' => $row->notes ? $row->notes : '',
                'id_number' => $row->id_number ? $row->id_number : '',
                'religion' => $row->religion ? $row->religion : '',
                'address' => $row->address ? $row->address : '',
                'country' => $country ? $country : '',
                'social' => $social,
                'title' => $title,
                'industry' => $industry,
                'agent_id'=>@$row->agent_id,
                'agent_name' => @$row->agent->name,
                'commercial_agent_id' => $row->commercial_agent_id,
                'commercial_agent_name' => @$row->commercialAgent->name,
                'reference' => $row->reference?$row->reference:'',
                'lead_source' => $source,
                'data'=>$dataa
            ));
        }

        foreach ($data as $row) {
            $agents[] = $row['agent_id'];
            $agents[] = $row['commercial_agent_id'];
        }
        $agents = array_unique($agents);
        foreach ($agents as $agent) {
            $agentData = User::find($agent);
            if ($agentData) {
                $arr = [];
                $arr['name'] = $agentData->name;
                $arr['id'] = $agent;
                $agentsData[] = $arr;
            }
        }

        return ['leads' => $data, 'agents' => $agentsData];
    }
    public function getFiltersBtn(Request $request){
        $leads = Lead::where('agent_id', $request->user_id);
        $facebook = Lead::where("lead_source_id", 7)->where('agent_id', $request->user_id)->count();
		$coldCalls = Lead::where("lead_source_id", 28)->where('agent_id', $request->user_id)->count(); // Cold Calls
        $switch = Lead::where("agent_id",$request->user_id)->whereRaw("agent_id <> agent_flag")->count(); // switched to me
        // dd($facebook);
		$followUp = $leads->whereHas('lead_actions', function ($q) {
			$q->where("id", '>', 0);
		})->count();
		$lowest = [];
		$highest = [];
		$high = [];
		foreach ($leads->get() as $value) {
			$lastCall = Call::where("lead_id", $value->id)->latest()->first();
			// dd($lastCall);
			$lastMeeting = Meeting::where("lead_id", $value->id)->latest()->first();
			if (@$lastCall->probability == "lowest" || @$lastMeeting->probability == "lowest") {
				array_push($lowest, $value);
			}
			if (@$lastCall->probability == "highest" || @$lastMeeting->probability == "highest") {
				array_push($highest, $value);
			}
			if (@$lastCall->probability == "high" || @$leastMeeting->probability == "high") {
                // dd('test');
				array_push($high, $value);
			}
		}
		$lowest = count($lowest);
		$high = count($high);
        $highest = count($highest);

        return [
            ['title'=>'facebook','count'=>$facebook],
            ['title'=>'coldCalls','count'=>$coldCalls],
            ['title'=>'followUp','count'=>$followUp],
            ['title'=>'switch','count'=>$switch],
            ['title'=>'lowest','count'=>$lowest],
            ['title'=>'high','count'=>$high],
            ['title'=>'highest','count'=>$highest],
        ];
    }
}
