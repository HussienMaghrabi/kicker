<?php

namespace App\Http\Controllers;
use \App\AdminNotification;
use App\ToDo;
use App\Call;
use App\City;
use App\ClosedDeal;
use App\Contact;
use App\Developer;
use App\Lead;
use App\VoiceNote;
use App\LeadNote;
use App\MainSlider;
use App\Meeting;
use App\Phase;
use App\Project;
use App\Property;
use App\Proposal;
use App\RentalUnit;
use App\Request as LeadReq;
use App\ResaleUnit;
use App\UnitType;
use App\User;
use App\Website;
use App\Land;
use App\Rate;
use App\Cil;
use App\Player;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Validator;
use App\Request as Model;
use Auth;
use OneSignal;


class AjaxController extends Controller
{
    public function testAgax(Request $request)
    {
        return $request->all();
    }
    public function get_cities(Request $request)
    {
        $id = $request->id;
        $cities = City::where('country_id', $id)->get();
        return view('admin.leads.cities', ['cities' => $cities]);
    }

    public function get_contacts(Request $request)
    {
        $id = $request->id;
        $contacts = Contact::where('lead_id', $id)->get();
        return view('admin.leads.contacts', ['contacts' => $contacts]);
    }

    public function get_calls_contacts(Request $request)
    {
        $id = $request->id;
        $contacts = Contact::where('lead_id', $id)->get();
        $lead = Lead::find($id);
        return view('admin.calls.contacts', ['contacts' => $contacts, 'lead' => $lead]);
    }

    public function get_calls(Request $request)
    {
        $id = $request->id;
        $calls = Call::where('lead_id', $id)->with('call_status')->latest()->get();
        return view('admin.calls.get_calls', ['calls' => $calls]);
    }

    public function get_meetings(Request $request)
    {
        $id = $request->id;
        $meetings = Meeting::where('lead_id', $id)->with('meeting_status')->latest()->get();
        return view('admin.meetings.get_meetings', ['meetings' => $meetings]);
    }

    public function get_requests(Request $request)
    {
        $id = $request->id;
        $requests = LeadReq::where('lead_id', $id)->latest()->get();
        return view('admin.leads.get_requests', ['reqs' => $requests]);
    }

    public function get_unit_types(Request $request)
    {
        $usage = $request->usage;
        if ($usage == 'residential') {
            $usage = 'personal';
        }
        $types = UnitType::where('usage', $usage)->get();
        return view('admin.rental.unit_types', ['types' => $types]);
    }

    public function get_phones(Request $request)
    {
        $id = $request->contact_id;
        $lead = $request->lead;
        if (!isset($request->return)) {
            if ($request->contact_id != 0) {
                $contact = Contact::find($id);
                return view('admin.calls.get_phones', ['contact' => $contact, 'type' => 'contact']);
            } else {
                $contact = Lead::find($lead);
                return view('admin.calls.get_phones', ['lead' => $contact, 'type' => 'lead']);
            }
        } else {
            if ($request->contact_id != 0) {
                $contact = Contact::find($id);
                return $contact;
            } else {
                $contact = Lead::find($lead);
                return $contact->phone;
            }
        }
    }
    //old get_units with old blade
    // public function get_units(Request $request)
    // {
    //     $personal_commercial = $request->personal_commercial;
    //     $type = $request->type;
    //     if ($request->has('unit_id')) {
    //         $unit_id = $request->unit_id;
    //     } else {
    //         $unit_id = 0;
    //     }
    //     if ($type == 'new_home') {
    //         $unit = Property::select(app()->getLocale() . '_name as title', 'id')->
    //         where('availability', 'available')->
    //         where('type', $personal_commercial)->
    //         get();
    //         return view('admin.proposals.get_units', ['units' => $unit, 'unit_id' => $unit_id]);
    //     } elseif ($type == 'resale') {
    //         $unit = ResaleUnit::select(app()->getLocale() . '_title as title', 'id')->
    //         where('availability', 'available')->
    //         where('type', $personal_commercial)->
    //         get();
    //         return view('admin.proposals.get_units', ['units' => $unit, 'unit_id' => $unit_id]);
    //     } elseif ($type == 'rental') {
    //         $unit = RentalUnit::select(app()->getLocale() . '_title as title', 'id')->
    //         where('availability', 'available')->
    //         where('type', $personal_commercial)->
    //         get();
    //         return view('admin.proposals.get_units', ['units' => $unit, 'unit_id' => $unit_id]);
    //     }
    // }
    //new get_units with .._new.blade
    public function get_units(Request $request)
    {
        $personal_commercial = $request->personal_commercial;
        $type = $request->type;
        if ($request->has('unit_id')) {
            $unit_id = $request->unit_id;
        } else {
            $unit_id = 0;
        }
        if ($type == 'new_home') {
            $unit = Property::select(app()->getLocale() . '_name as title', 'id')->where('availability', 'available')->where('type', $personal_commercial)->get();
            return $unit;
        } elseif ($type == 'resale') {
            $unit = ResaleUnit::select(app()->getLocale() . '_title as title', 'id')->where('availability', 'available')->where('type', $personal_commercial)->get();
            return $unit;
        } elseif ($type == 'rental') {
            $unit = RentalUnit::select(app()->getLocale() . '_title as title', 'id')->where('availability', 'available')->where('type', $personal_commercial)->get();
            return $unit;
        }
    }


    public function get_proposal(Request $request)
    {
        $id = $request->proposal;
        $proposal = Proposal::find($id);
        $buyer = $proposal->lead_id;
        $price = $proposal->price;
        $lead = @Lead::find($buyer);
        $agent = @\App\User::find($lead->agent_id);
        $agent_id = $agent->id;
        $agent_name = $agent->name;
        $agent_commission = $agent->commission;
        $commission = 0;
        $broker = 0;
        if ($proposal->unit_type == 'new_home') {
            $unit = Property::find($proposal->unit_id);
            $phase = Phase::find($unit->phase_id);
            $project = Project::find($phase->project_id);
            $commission = $project->commission;
            $broker = 0;
            $seller = 0;
        } elseif ($proposal->unit_type == 'rental') {
            $unit = RentalUnit::find($proposal->unit_id);
            $seller = $unit->lead_id;
            $broker = $unit->broker_id;
        } elseif ($proposal->unit_type == 'resale') {
            $unit = ResaleUnit::find($proposal->unit_id);
            $seller = $unit->lead_id;
            $broker = $unit->broker_id;
        } elseif ($proposal->unit_type == 'land') {
            $unit = Land::find($proposal->unit_id);
            $seller = $unit->lead_id;
            $broker = $unit->broker_id;
        }
        return response()->json([
            'id' => $id,
            'type' => $proposal->unit_type,
            'price' => $price,
            'commission' => $commission,
            'seller' => $seller,
            'buyer' => $buyer,
            'agent_id' => $agent_id,
            'agent_name' => $agent_name,
            'agent_commission' => $agent_commission,
            'broker' => $broker,
        ]);
    }

    public function add_call(Request $request)
    {
        //return ['status'=>'sssss'];
        // dd($request);

        $rules = [
            'lead_id' => 'required',
            'contact_id' => 'required',
            'phone' => 'required',
            //'duration' => 'required',
            // 'date' => 'required',
            // 'probability' => 'required',
            //'description' => 'required',
            'call_status_id' => 'required',
            'phone_in_out' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'lead_id' => trans('admin.lead'),
            'contact_id' => trans('admin.contact'),
            'phone' => trans('admin.phone'),
            //'duration' => trans('admin.duration'),
            // 'date' => trans('admin.date'),
            // 'probability' => trans('admin.probability'),
            //'description' => trans('admin.description'),
            'call_status_id' => trans('admin.call_status'),
            'phone_in_out' => trans('admin.phone_in_out'),
        ]);

        if ($validator->fails()) {
            // dd(["required"=>"false",'status'=>'501', $validator->errors()]);
            return ["required" => "false", 'status' => '501', $validator->errors()];
        } else {
            $leadInfo = Lead::where('id',$request->lead_id)->first();
            $userInfo = \App\user::where('id',Auth::user()->id)->first();
            $call = new Call;
            $call->lead_id = $request->lead_id;
            $call->contact_id = $request->contact_id;
            $call->duration = $request->duration;
            $call->phone = $request->phone;
            $call->date = strtotime($request->date);
            $call->probability = $request->probability;
            $call->call_status_id = $request->call_status_id;
            if ($request->has('location_id')) {
                $call->location_id = $request->location_id;
            } else {
                $call->location_id = NULL;
            }
            if ($request->has('projects')) {
                // dd($request->has('projects'));
                // dd($request->projects);
                // dd(json_encode($request->projects));
                $call->projects = json_encode($request->projects);
            } else {
                $call->projects = '[]';
            }
            $call->description = $request->description;
            $call->budget = $request->budget;
            $call->user_id =  auth()->user()->id;
            $call->phone_in_out = $request->phone_in_out;
            $saved = $call->save();

            if($saved > 0){
                $noti = new AdminNotification;
                $noti->user_id = Auth::user()->id;
                $noti->assigned_to = Auth::user()->id;
                $noti->type = 'call';
                $noti->type_id = $request->lead_id;
                $noti->status = 0;
                $noti->save();
                $Players = player::where('user_id',Auth::user()->id)->first();
                $player_id = $Players->player_id;
                $Omassege = $userInfo->name. 'You have a call with'.$leadInfo->first_name.'  '.$leadInfo->last_name;
                $this->signalHelper($player_id,$Omassege);
            }

            $lead[] = $request->lead_id;

            if ($request->has('to_do_type')) {
                $todos = ToDo::where('leads', $request->lead_id)->where('to_do_type', $request->to_do_type)->get();
                if (count($todos) != 0) {
                    foreach ($todos as $key => $value) {
                        $value->delete();
                    }
                }
                $todo = new ToDo;
                $todo->user_id = auth()->user()->id;
                $todo->leads = $request->lead_id;
                $todo->due_date = strtotime($request->to_do_due_date);
                $todo->to_do_type = $request->to_do_type;
                $todo->description = $request->to_do_description;
                $todo->status = 'pending';
                $todo->save();
            }

            if ($request->has('req_down_payment')) {
                $req = new LeadReq;
                $req->lead_id = $request->lead_id;
                $req->location = $request->req_location;
                $req->down_payment = $request->req_down_payment;
                $req->area_from = $request->req_area_from;
                $req->area_to = $request->req_area_to;
                $req->price_from = $request->req_price_from;
                $req->price_to = $request->req_price_to;
                $req->date = $request->req_date;
                $req->notes =  $request->req_notes;
                $req->user_id = auth()->user()->id;
                $req->save();
            }

            DB::table('lead_actions')->insert([
                'lead_id' => $request->lead_id,
                'type' => 'call',
                'agent_type' => 0,
                'time' => strtotime(time()),
                'user_id' => auth()->user()->id
            ]);

            session()->flash('success', trans('admin.created'));

            $old_data = json_encode($call);
            LogController::add_log(
                __('admin.created', [], 'ar') . ' ' . __('admin.call', [], 'ar'),
                __('admin.created', [], 'en') . ' ' . __('admin.call', [], 'en'),
                'calls',
                $call->id,
                'create',
                auth()->user()->id,
                $old_data
            );
            return ['status' => 'ok', 'call' => $call];
        }
    }

    public function bulkAction(Request $request)
    {
        foreach ($request->leads as $key => $value) {
            $lead = \App\Lead::where('id', $value)->first();
            // $request->request->add(['lead_id', $value]);
            $request->merge(['lead_id' => $value]);
            $request->merge(['phone' => $lead->phone]);
            $request->merge(['contact_id' => 0]);
            $request->merge(['phone_in_out' => 'out']);
            $request->merge(['projects' => [null]]);
            $this->add_call($request);
        }
        return ['status' => 'ok'];
    }

    // function to add meeting
    //
    public function add_meetings(Request $request)
    {
        // return ['status' => 'peter'];
        // dd($request);
        $leadInfo = Lead::where('id',$request->lead_id)->first();
        $userInfo = \App\user::where('id',Auth::user()->id)->first();
     $rules = [
            'lead_id' => 'required',
            'contact_id' => 'required',
            // 'date' => 'required',
            'time' => 'required',
            'location' => 'required',
            // 'probability' => 'required',
            // 'description' => 'required',
            // 'duration' => 'required',
            'meeting_status_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'lead_id' => trans('admin.lead'),
            'contact_id' => trans('admin.contact'),
            // 'date' => trans('admin.date'),
            'time' => trans('admin.time'),
            // 'duration' => trans('admin.duration'),
            'location' => trans('admin.location'),
            // 'probability' => trans('admin.probability'),
            // 'description' => trans('admin.description'),
            'meeting_status_id' => trans('admin.meeting_status'),
        ]);

        if ($validator->fails()) {
            return ["required" => "false", 'status' => '501', $validator->errors()];
        } else {
            $meeting = new Meeting;
            $meeting->lead_id = $request->lead_id;
            $meeting->contact_id = $request->contact_id;
            $meeting->date = strtotime($request->date);
            $meeting->time = $request->time;
            $meeting->probability = $request->probability;
            $meeting->description = $request->description;
            $meeting->location = $request->location;
            $meeting->duration = $request->duration;
            $meeting->meeting_status_id = $request->meeting_status_id;
            $meeting->budget = $request->budget;
            $meeting->user_id =  auth()->user()->id;
            if ($request->has('projects')) {
                // dd($request->has('projects'));
                // dd($request->projects);
                // dd(json_encode($request->projects));
                $meeting->projects = json_encode($request->projects);
            } else {
                $call->projects = '[]';
            }
            $saved = $meeting->save();
            if($saved > 0){
                $noti = new AdminNotification;
                $noti->user_id = Auth::user()->id;
                $noti->assigned_to = Auth::user()->id;
                $noti->type = 'meeting';
                $noti->type_id = $request->lead_id;
                $noti->status = 0;
                $noti->save();
                $Players = player::where('user_id',Auth::user()->id)->first();
                $player_id = $Players->player_id;
                $Omassege = $userInfo->name. 'You have metting  with'.$leadInfo->first_name.'  '.$leadInfo->last_name;
                $this->signalHelper($player_id,$Omassege);
            }
            $lead[] = $request->lead_id;

            if ($request->has('to_do_type')) {
                $todos = ToDo::where('leads', $request->lead_id)->where('to_do_type', $request->to_do_type)->get();
                if (count($todos) != 0) {
                    foreach ($todos as $key => $value) {
                        $value->delete();
                    }
                }
                $todo = new ToDo;
                $todo->user_id = auth()->user()->id;
                $todo->leads = $request->lead_id;
                $todo->due_date = strtotime($request->to_do_due_date);
                $todo->to_do_type = $request->to_do_type;
                $todo->description = $request->to_do_description;
                $todo->status = 'pending';
                $todo->save();
            }
            if ($request->has('req_location')) {
                $req = new LeadReq;
                $req->lead_id = $request->lead_id;
                $req->location = $request->req_location;
                $req->down_payment = $request->req_down_payment;
                $req->area_from = $request->req_area_from;
                $req->area_to = $request->req_area_to;
                $req->price_from = $request->req_price_from;
                $req->price_to = $request->req_price_to;
                $req->date = $request->req_date;
                $req->notes =  $request->req_notes;
                $req->user_id = auth()->user()->id;
                $req->save();
            }

            DB::table('lead_actions')->insert([
                'lead_id' => $request->lead_id,
                'type' => 'meeting',
                'agent_type' => 0,
                'time' => strtotime(time()),
                'user_id' => auth()->user()->id
            ]);

            $old_data = json_encode($meeting);
            LogController::add_log(
                __('admin.created', [], 'ar') . ' ' . __('admin.meeting', [], 'ar'),
                __('admin.created', [], 'en') . ' ' . __('admin.meeting', [], 'en'),
                'meetings',
                $meeting->id,
                'create',
                auth()->user()->id,
                $old_data
            );

            session()->flash('success', trans('admin.created'));
            return ['status' => 'ok', 'meeting' => $meeting];
        }
    }


    // function add_request
    // to add requests

    public function add_Request(Request $request)
    {
        // return 'test';
        // dd($request);down_payment
        if ($request->unit_type == 'land') {
            $rules = [
                // 'lead' => 'required|max:191',
                'location' => 'required|max:191',
                // 'down_payment' => 'required|max:191',
                // 'unit_type_id' => 'required|max:191',
                'unit_type' => 'required|max:191',
                // 'request_type' => 'required|max:191',
                // 'area_from' => 'required|numeric|min:0',
                // 'area_to' => 'required|numeric|min:' . $request->area_from,
                // 'price_from' => 'required|numeric|min:0',
                // 'price_to' => 'required|numeric|min:' . $request->price_from,
                // 'date' => 'required|max:191',
            ];
        } else {
            $rules = [
                // 'lead' => 'required|max:191',
                'location' => 'required|max:191',
                // 'down_payment' => 'required|max:191',
                'unit_type_id' => 'required|max:191',
                'unit_type' => 'required|max:191',
                'request_type' => 'required|max:191',
                // 'area_from' => 'required|numeric|min:0',
                // 'area_to' => 'required|numeric|min:' . $request->area_from,
                // 'price_from' => 'required|numeric|min:0',
                // 'price_to' => 'required|numeric|min:' . $request->price_from,
                // 'date' => 'required|max:191',
            ];
        }
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'lead' => trans('admin.lead'),
            'location' => trans('admin.location'),
            'request_type' => trans('admin.request_type'),
            // 'unit_type_id' => trans('admin.type'),
            'unit_type' => trans('admin.unit_type'),
            // 'down_payment' => trans('admin.down_payment'),
            // 'area_from' => trans('admin.area_from'),
            'area_to' => trans('admin.area_to'),
            // 'date' => trans('admin.date'),
            // 'price_from' => trans('admin.price_from'),
            // 'price_to' => trans('admin.price_to'),
        ]);


        if ($validator->fails()) {
            return ['status' => 'error', 'errorMessage' => $validator->errors()];
        } else {
            $req = new Model;
            $req->lead_id = $request->lead_id;
            $req->location = $request->location;
            $req->down_payment = $request->down_payment;
            $req->area_from = $request->area_from;
            $req->area_to = $request->area_to;
            $req->price_from = $request->price_from;
            $req->price_to = $request->price_to;
            $req->date = $request->date;
            $req->unit_type = $request->unit_type;
            $req->project_id = json_encode($request->project_id);
            $req->lat = $request->lat;
            $req->lng = $request->lng;
            $req->zoom = $request->zoom;
            $req->type = $request->buyer_seller;
            if ($request->unit_type != 'land') {
                $req->request_type = $request->request_type;
                $req->unit_type_id = $request->unit_type_id;
            } else {
                $req->request_type = 'land';
                $req->unit_type_id = 0;
            }

            if ($request->request_type != 'new_home' or $request->request_type != 'land') {
                $req->rooms_from = $request->rooms_from;
                $req->rooms_to = $request->rooms_to;
                $req->bathrooms_from = $request->bathrooms_from;
                $req->bathrooms_to = $request->bathrooms_to;
            }
            $req->notes = $request->notes;
            $req->user_id = Auth::user()->id;
            $req->save();

            DB::table('lead_actions')->insert([
                'lead_id' => $request->lead_id,
                'type' => 'request',
                'agent_type' => 0,
                'time' => strtotime(time()),
                'user_id' => auth()->user()->id
            ]);

            $old_data = json_encode($req);
            LogController::add_log(
                __('admin.created', [], 'ar') . ' ' . __('admin.request', [], 'ar'),
                __('admin.created', [], 'en') . ' ' . __('admin.request', [], 'en'),
                'requests',
                $req->id,
                'create',
                auth()->user()->id,
                $old_data
            );

            session()->flash('success', trans('admin.created'));
            return ['status' => 'ok', 'meeting' => $req];
        }
    }

    public function get_proposal_html(Request $request)
    {
        $id = $request->proposal;
        $proposal = Proposal::find($id);
        return view('admin.deals.units', ['proposal' => $proposal]);
    }

    public function get_property(Request $request)
    {
        $id = $request->id;
        if ($request->type == "Property")
            $slide = Property::find($id);
        elseif ($request->type == "Project")
            $slide = Project::find($id);
        return view('admin.website_setting.ajax_prop', ['slide' => $slide, 'type' => $request->type]);
    }

    public function save_main_slider(Request $request)
    {
        return back();
    }

    public function getBtns(Request $request)
    {
        /* $leads = Lead::where(function($q) use ($request){
          $q->where('agent_id', $request->user_id)->orWhere('commercial_agent_id', $request->user_id);
        }); */
        $todayLeads = Lead::whereDate('created_at', Carbon::today())->where(function ($q) use ($request) {
            $q->where('agent_id', $request->user_id)->orWhere('commercial_agent_id', $request->user_id);
        })->count();
        $seen = Lead::where("seen", 1)->where(function ($q) use ($request) {
            $q->where('agent_id', $request->user_id)->orWhere('commercial_agent_id', $request->user_id);
        })->count();
        $notSeen = Lead::where("seen", 0)->where(function ($q) use ($request) {
            $q->where('agent_id', $request->user_id)->orWhere('commercial_agent_id', $request->user_id);
        })->count();
        $facebook = Lead::where("lead_source_id", 7)->where(function ($q) use ($request) {
            $q->where('agent_id', $request->user_id)->orWhere('commercial_agent_id', $request->user_id);
        })->count();
        $coldCalls = Lead::where("lead_source_id", 28)->where(function ($q) use ($request) {
            $q->where('agent_id', $request->user_id)->orWhere('commercial_agent_id', $request->user_id);
        })->count(); // Cold Calls
        $todayColdCalls = Lead::whereDate('created_at', Carbon::today())->where("lead_source_id", 28)
            ->where(function ($q) use ($request) {
                $q->where('agent_id', $request->user_id)->orWhere('commercial_agent_id', $request->user_id);
            })->count(); // Today Cold Calls
        $switch = Lead::where(function ($q) use ($request) {
            $q->where('agent_id', $request->user_id)->orWhere('commercial_agent_id', $request->user_id);
        })->whereRaw("agent_id <> agent_flag")->count(); // switched
        $hotLeads = Lead::where(function ($q) use ($request) {
            $q->where('agent_id', $request->user_id)->orWhere('commercial_agent_id', $request->user_id);
        })->where('hot', 1)->count();
        $favLeads = Lead::where(function ($q) use ($request) {
            $q->where('agent_id', $request->user_id)->orWhere('commercial_agent_id', $request->user_id);
        })->where('favorite', 1)->count();
        $individualLeads = Lead::where('agent_id', 0)->where('commercial_agent_id', 0)->count();

        $btns = [
            ['title' => 'Hot Leads', 'count' => $hotLeads],
            ['title' => 'Favorite Leads', 'count' => $favLeads],
            ['title' => 'Facebook', 'count' => $facebook],
            ['title' => 'Cold Calls', 'count' => $coldCalls],
            ['title' => 'Switch', 'count' => $switch],
            ['title' => 'todayLeads', 'count' => $todayLeads],
            ['title' => 'seen', 'count' => $seen],
            ['title' => 'notSeen', 'count' => $notSeen],
            ['title' => 'Today Cold Calls', 'count' => $todayColdCalls],
            ['title' => 'Individual Leads', 'count' => $individualLeads], 
        ];

        $response = 'ok';
        return ['status' => $response, 'btns' => $btns];
    }
    public function getLeadsByAgent(Request $request)
    {
        $leads = Lead::where(function ($q) use ($request) {
            $q->where('agent_id', $request->user_id)->orWhere('commercial_agent_id', $request->user_id);
        });
        $todayLeads = Lead::whereDate('created_at', Carbon::today())->where(function ($q) use ($request) {
            $q->where('agent_id', $request->user_id)->orWhere('commercial_agent_id', $request->user_id);
        })->count();
        $seen = Lead::where("seen", 1)->where(function ($q) use ($request) {
            $q->where('agent_id', $request->user_id)->orWhere('commercial_agent_id', $request->user_id);
        })->count();
        $notSeen = Lead::where("seen", 0)->where(function ($q) use ($request) {
            $q->where('agent_id', $request->user_id)->orWhere('commercial_agent_id', $request->user_id);
        })->count();
        $facebook = Lead::where("lead_source_id", 7)->where(function ($q) use ($request) {
            $q->where('agent_id', $request->user_id)->orWhere('commercial_agent_id', $request->user_id);
        })->count();
        $coldCalls = Lead::where("lead_source_id", 28)->where(function ($q) use ($request) {
            $q->where('agent_id', $request->user_id)->orWhere('commercial_agent_id', $request->user_id);
        })->count(); // Cold Calls
        $todayColdCalls = Lead::whereDate('created_at', Carbon::today())->where("lead_source_id", 28)->where('agent_id', $request->user_id)->count(); // Today Cold Calls
        $switch = Lead::where("agent_id", $request->user_id)->whereRaw("agent_id <> agent_flag")->count(); // switched to me
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

        $btns = [
            ['title' => 'Hot Leads', 'count' => $hotLeads],
            ['title' => 'Favorite Leads', 'count' => $favLeads],
            ['title' => 'Facebook', 'count' => $facebook],
            ['title' => 'Cold Calls', 'count' => $coldCalls],
            ['title' => 'Followup', 'count' => $followUp],
            ['title' => 'Switch', 'count' => $switch],
            ['title' => 'Lowest', 'count' => $lowest],
            ['title' => 'High', 'count' => $high],
            ['title' => 'Highest', 'count' => $highest],
            ['title' => 'todayLeads', 'count' => $todayLeads],
            ['title' => 'seen', 'count' => $seen],
            ['title' => 'notSeen', 'count' => $notSeen],
            ['title' => 'Today Cold Calls', 'count' => $todayColdCalls],
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
            $page = isset($request_json->page) ? abs((int)$request_json->page) : 0;

            // $leads = Lead::where('agent_id', $user_id)->offset(($page-1)*25)->limit(25)->get() ;

            $userData = User::find($user_id);
            $leads = Lead::where('agent_id', $user_id)->orderBy('created_at', 'desc')->orderBy('seen');
            if ($request->target) {

                if ("Hot Leads" == $request->target) {
                    $leads = $leads->where('hot', 1);
                    $leads = $leads->get();
                } elseif ("Favorite Leads" == $request->target) {
                    $leads = $leads->where('favorite', 1);
                    $leads = $leads->get();
                } elseif ("Facebook" == $request->target) {
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
                                array(
                                    'number' => $key1,
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
                    'agent_id' => $row->agent_id ? $row->agent_id : 0,
                    'agent_name' => @$row->agent->name,
                    // {{$user->photo ? $user->photo->file : 'http://placehold.it/400x400'}}
                    'commercial_agent_id' => $row->commercial_agent_id,
                    'commercial_agent_name' => @$row->commercialAgent->name,
                    'reference' => $row->reference ? $row->reference : '',
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
                if (count(\App\Group::where('team_leader_id', $userData->id)->get()) > 0) {
                    $users = [];
                    foreach (\App\Group::where('team_leader_id', $userData->id)->get() as $group) {
                        if ($group->parent_id != 0) {
                            foreach (\App\GroupMember::where('group_id', $group->id)->get() as $member) {
                                $users[] = $member->member_id;
                            }
                        }
                    }
                    $agentsData = User::whereIn('id', $users)->get()->toArray();
                }
            }

            $response = 'ok';
            return ['status' => $response, 'leads' => $data, 'agents' => $agentsData, 'btns' => $btns];
        } catch (Exception $e) {
            $response =
                'error';
            return ['status' => $response, 'leads' => $data, 'agents' => $agentsData, 'btns' => $btns];
        }
    }
    public function fav_lead(Request $request)
    {
        $lead = Lead::find($request->id);
        if ($lead->favorite) {
            $lead->favorite = 0;
            $lead->save();
            $status = 0;
        } else {
            $lead->favorite = 1;
            $lead->save();
            $status = 1;
        }
        return response()->json([
            'status' => $status,
        ]);
    }

    public function hot_lead(Request $request)
    {
        $lead = Lead::find($request->id);
        if ($lead->hot) {
            $lead->hot = 0;
            $lead->save();
            $status = 0;
        } else {
            $lead->hot = 1;
            $lead->save();
            $status = 1;
        }
        return response()->json([
            'status' => $status,
        ]);
    }
    //old get lands with old blade
    // public function get_lands()
    // {
    //     $lands = Land::get();
    //     return view('admin.proposals.get_lands', ['lands' => $lands]);
    // }

    //new get lands with  .._new.blade
    public function get_lands(Request $request)
    {
        return DB::table('lands')->select('id', app()->getLocale() . '_title as title')->get();
    }


    public function get_suggestions(Request $req)
    {
        $locationsArray = HomeController::getChildren($req->location);
        $locationsArray[] = $req->location;
        $units = [];
        $type = '';

        if ($req->unit_type != 'land') {
            if ($req->request_type == 'new_home') {
                $units = @Project::where('type', $req->unit_type)->whereBetween('meter_price', [$req->price_from, $req->price_to])->whereBetween('area', [$req->area_from, $req->area_to])->whereIn('location_id', $locationsArray)->get();
                $type = 'new_home';
            } elseif ($req->request_type == 'resale') {
                $units = @ResaleUnit::whereBetween('rooms', [$req->rooms_from, $req->rooms_to])->where('type', $req->unit_type)->where('unit_type_id', $req->unit_type_id)->whereBetween('total', [$req->price_from, $req->price_to])->whereBetween('area', [$req->area_from, $req->area_to])->whereBetween('rooms', [$req->rooms_from, $req->rooms_to])->whereIn('location', $locationsArray)->where('delivery_date', $req->date)->whereBetween('bathrooms', [$req->bathrooms_from, $req->bathrooms_to])->get();
                $type = 'resale';
            } elseif ($req->request_type == 'rental') {
                $units = @RentalUnit::whereBetween('rooms', [$req->rooms_from, $req->rooms_to])->where('type', $req->unit_type)->where('unit_type_id', $req->unit_type_id)->whereBetween('rent', [$req->price_from, $req->price_to])->whereBetween('area', [$req->area_from, $req->area_to])->whereBetween('rooms', [$req->rooms_from, $req->rooms_to])->whereIn('location', $locationsArray)->where('delivery_date', $req->date)->whereBetween('bathrooms', [$req->bathrooms_from, $req->bathrooms_to])->get();
                $type = 'rental';
            }
        } else {
            $units = @Land::whereBetween('meter_price', [$req->price_from, $req->price_to])->whereBetween('area', [$req->area_from, $req->area_to])->whereIn('location', $locationsArray)->get();
            $type = 'lands';
        }
        return view('admin.requests.get_suggestions', ['units' => $units, 'type' => $type]);
    }
    // old get_projects old blade
    // public function get_projects(Request $request)
    // {
    //     $projects = @Project::where('developer_id', $request->id)->get();
    //     return view('admin.leads.get_projects', ['projects' => $projects]);
    // }

    // new get_projects .._index.blade
    public function get_projects(Request $request)
    {
        $projects = @Project::select(app()->getLocale() . '_name as name', 'id')->where('developer_id', $request->id)->get();
        return $projects;
    }
    public function get_report_form(Request $request)
    {
        if ($request->report == 'leads') {
            return view('admin.leads_report_form');
        } else if ($request->report == 'agents') {
            return view('admin.agents_report_form');
        } else if ($request->report == 'developers') {
            $developers = @Developer::get();
            return view('admin.developers_report_form', ['developers' => $developers]);
        } else if ($request->report == 'sales_forecast') {
            return view('admin.sales_forecast_form');
        } else if ($request->report == 'lead_stage') {
            $evaluating = 0;
            $follow = 0;
            $negotiation = 0;
            $won = 0;
            foreach (Lead::get() as $lead) {
                if (Meeting::where('lead_id', $lead->id)->count() == 0 and Call::where('lead_id', $lead->id)->count() == 0 and Proposal::where('lead_id', $lead->id)->count() == 0 and ClosedDeal::where('buyer_id', $lead->id)->count() == 0) {
                    $evaluating++;
                } else if (Meeting::where('lead_id', $lead->id)->count() > 0 and Call::where('lead_id', $lead->id)->count() > 0 and Proposal::where('lead_id', $lead->id)->count() == 0 and ClosedDeal::where('buyer_id', $lead->id)->count() == 0) {
                    $follow++;
                } else if (Meeting::where('lead_id', $lead->id)->count() > 0 and Call::where('lead_id', $lead->id)->count() > 0 and Proposal::where('lead_id', $lead->id)->count() > 0 and ClosedDeal::where('buyer_id', $lead->id)->count() == 0) {
                    $negotiation++;
                } else if (Meeting::where('lead_id', $lead->id)->count() > 0 and Call::where('lead_id', $lead->id)->count() > 0 and Proposal::where('lead_id', $lead->id)->count() > 0 and ClosedDeal::where('buyer_id', $lead->id)->count() > 0) {
                    $won++;
                }
            }
            return view('admin.lead_stage', [
                'evaluating' => $evaluating,
                'follow' => $follow,
                'negotiation' => $negotiation,
                'won' => $won
            ]);
        }
    }

    public function getDailyReports(Request $request)
    {
        $request->validate([
            'agents' => 'required|array',
            'fromDate' => 'required|date',
            'toDate' => 'required|date',
        ]);

        $leads = DB::table("leads as lead")
        ->join('calls as call','lead.id','=','call.lead_id')
        ->leftJoin('lead_sources as source',"lead.lead_source_id","=","source.id")
        ->leftJoin('users as user','lead.user_id','=','user.id')
        ->leftJoin('call_statuses as status','call.call_status_id','=','status.id')
        ->where([
            ['lead.created_at','>=',$request->fromDate." 00:00:00"],
            ['lead.created_at','<=',$request->toDate." 23:59:59"]
        ])
        ->whereIn('lead.agent_id', $request->agents)->orWhereIn('lead.commercial_agent_id', $request->agents)
        ->select('lead.id as id','lead.first_name','lead.last_name as last_name','lead.phone as phone','source.name as lead_source_name','status.name as call_status_name','lead.created_at')
        ->get();
        return response()->json($leads,200);
    }

    public function getDailyReportsByCall(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'agents' => 'required|array',
            'fromDate' => 'required|date',
            'toDate' => 'required|date',
        ]);
        // $calls = \App\Call::whereIn('user_id', $request->agents)
        //     ->with('user');
        // if ($request->sources) {
        //     $calls = $calls->whereHas('lead', function ($q) use ($request) {
        //         $q->whereIn('lead_source_id', $request->sources);
        //     });
        // }
        // $calls = $calls->whereRaw("created_at >= ? AND created_at <= ?", array($request->fromDate . " 00:00:00", $request->toDate . " 23:59:59"))->get();

        $calls = DB::table('calls as call')
        ->join('users as user','user.id','=','call.user_id')
        ->leftJoin('leads as lead','call.lead_id','=','lead.id')
        ->leftjoin('call_statuses as status','status.id','=','call.call_status_id')
        ->leftJoin('lead_sources as source','source.id','=','lead.lead_source_id');
        if ($request->sources) {
            $calls = $calls->where('lead.id','!=',null)->whereIn('lead.lead_source_id', $request->sources);
        }
        $calls = $calls->where([
            ['call.created_at','>=',$request->fromDate." 00:00:00"],
            ['call.created_at','<=',$request->toDate." 23:59:59"]
        ])
        ->whereIn('call.user_id', $request->agents)
        ->select('call.id as id','user.name as name','lead.first_name','lead.last_name','lead.phone','status.name as call_status_name','call.created_at','source.name as lead_source','call.description')
        ->get();
        // return view('admin.dailyreportshowbycall', ['calls' => $calls, 'selected_sources' => $request->sources ?: [], 'date']);
        return response()->json($calls);
    }


    public function get_lead_report(Request $request)
    {
        $from = $request->from;
        $to = $request->to;

        $leads = Lead::get();


        return view('admin.get_lead_report', ['from' => $from, 'to' => $to, 'leads' => $leads]);
    }

    public function get_leads_data(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $src = $request->source;

        if ($src != 'all') {
            $leads = Lead::where('created_at', '<=', $to . ' 00:00:00')->where('created_at', '>=', $from . ' 23:59:59')->where('lead_source_id', $src)->get();
        } else {
            $leads = Lead::where('created_at', '<=', $to . ' 00:00:00')->where('created_at', '>=', $from . ' 23:59:59')->get();
        }

        return view('admin.get_leads_data', ['from' => $from, 'to' => $to, 'leads' => $leads]);
    }

    /**
     * update_lead_ajax
     */
    public function updateLead(Request $req)
    {
        $request = json_decode($req->getContent());
        // $lead = @Lead::find($request->id);
        $rules = [
            'first_name' => 'required|max:191',
            'last_name' => 'required|max:191',
            'phone' => 'required|numeric|unique:leads,phone,' . $request->id . ',id',
            'lead_source_id' => 'required|numeric',
            //'image' => 'image',

        ];
        $validator = Validator::make((array)$request, $rules);
        $validator->SetAttributeNames([
            'first_name' => trans('admin.first_name'),
            'last_name' => trans('admin.last_name'),
            'middle_name' => trans('admin.middle_name'),
            'email' => trans('admin.email'),
            'phone' => trans('admin.phone'),
            'address' => trans('admin.address'),
            'lead_source' => trans('admin.lead_source'),
            'image' => trans('admin.image'),
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $lead = Lead::find($request->id);
            $old_data = json_encode($lead);
            if (@$request->prefix_name) {
                $lead->prefix_name = $request->prefix_name;
            }
            if (@$request->first_name) {
                $lead->first_name = $request->first_name;
            }
            if (@$request->last_name) {
                $lead->last_name = $request->last_name;
            }
            if (@$request->middle_name) {
                $lead->middle_name = $request->middle_name;
            }
            if (@$request->ar_first_name) {
                $lead->ar_first_name = $request->ar_first_name;
            }
            if (@$request->ar_last_name) {
                $lead->ar_last_name = $request->ar_last_name;
            }
            if (@$request->ar_middle_name) {
                $lead->ar_middle_name = $request->ar_middle_name;
            }
            if (@$request->email) {
                $lead->email = $request->email;
            }
            if (@$request->phone) {
                $lead->phone = $request->phone;
            }
            if (@$request->nationality) {
                $lead->nationality = $request->nationality;
            }
            if (@$request->country_id) {
                $lead->country_id = $request->country_id;
            }
            if (@$request->city_id) {
                $lead->city_id = $request->city_id;
            }
            if (@$request->address) {
                $lead->address = $request->address;
            }
            if (@$request->club) {
                $lead->club = $request->club;
            }
            if (@$request->title_id) {
                $lead->title_id = $request->title_id;
            }
            if (@$request->religion) {
                $lead->religion = $request->religion;
            }
            if (@$request->birth_date) {
                $lead->birth_date = strtotime($request->birth_date);
            }
            if (@$request->lead_source_id) {
                $lead->lead_source_id = $request->lead_source_id;
            }
            if (@$request->social) {
                $lead->social = json_encode($request->social);
            }
            if (@$request->industry_id) {
                $lead->industry_id = $request->industry_id;
            }
            if (@$request->company) {
                $lead->company = $request->company;
            }
            if (@$request->school) {
                $lead->school = $request->school;
            }
            if (@$request->school) {
                $lead->school = $request->school;
            }
            if (@$request->facebook) {
                $lead->facebook = $request->facebook;
            }
            if (@$request->id_number) {
                $lead->id_number = $request->id_number;
            }

            if (@$request->id_number) {
                $lead->status = $request->status;
            }

            //
            // if (@$request->other_phones) {
            //     foreach ($request->other_phones as $k => $v) {
            //         $phones[] = array(
            //             $request->other_phones[$k] => $request->other_socials[$k],
            //         );
            //     }
            //     $lead->other_phones = json_encode($phones);
            // }
            //
            if (@$request->other_emails) {
                $lead->other_emails = json_encode($request->other_emails);
            }
            // if(@$request->notes){
            //     $lead->notes = $request->notes;
            // }
            if (@$request->seen) {
                $lead->seen = @$request->seen;
            }

            if (@$request->user_id) {
                $lead->user_id = @$request->user_id;
            }
            //$lead->user_id = auth()->user()->id;
            // if ($request->hasFile('image')) {
            //     $lead->image = uploads($request, 'image');
            // }
            $lead->save();
            // session()->flash('success', trans('admin.updated'));

            $new_data = json_encode($lead);
            LogController::add_log(
                __('admin.updated', [], 'ar') . ' ' . $lead->ar_first_name,
                __('admin.updated', [], 'en') . ' ' . $lead->first_name,
                'leads',
                $lead->id,
                'update',
                auth()->user()->id,
                $old_data,
                $new_data
            );
            // return redirect(adminPath() . '/leads/' . $lead->id);
            return ['status' => 'Ok', 'lead' => $lead];
        }
    }

    public function get_target(Request $request)
    {
        $agents = User::get();
        return view('admin.get_target', ['month' => $request->target, 'agents' => $agents]);
    }

    public function get_developer_report(Request $request)
    {
        $deals = ClosedDeal::join('proposals', 'proposals.id', '=', 'closed_deals.proposal_id')->join('properties', 'properties.id', '=', 'proposals.unit_id')->join('phases', 'properties.phase_id', '=', 'phases.id')->join('projects', 'projects.id', '=', 'phases.project_id')->join('developers', 'projects.developer_id', '=', 'developers.id')->where('proposals.unit_type', 'new_home')->where('developers.id', $request->developer)->where('closed_deals.created_at', '>=', $request->from . ' 00:00:00')->where('closed_deals.created_at', '<=', $request->to . ' 23:59:59')->select(
            'closed_deals.id as id',
            'closed_deals.buyer_id as buyer_id',
            'closed_deals.seller_id as seller_id',
            'closed_deals.created_at as date',
            'projects.ar_name as ar_project_name',
            'projects.en_name as en_project_name',
            'closed_deals.price as price'
        )->get();
        return view('admin.developer_deals', ['deals' => $deals, 'developer_id' => $request->developer]);
    }

    public function get_project_deals(Request $request)
    {
        if ($request->project != 'all') {
            $deals = ClosedDeal::join('proposals', 'proposals.id', '=', 'closed_deals.proposal_id')->join('properties', 'properties.id', '=', 'proposals.unit_id')->join('phases', 'properties.phase_id', '=', 'phases.id')->join('projects', 'projects.id', '=', 'phases.project_id')->join('developers', 'projects.developer_id', '=', 'developers.id')->where('proposals.unit_type', 'new_home')->where('projects.id', $request->project)->where('closed_deals.created_at', '>=', $request->from . ' 00:00:00')->where('closed_deals.created_at', '<=', $request->to . ' 23:59:59')->select(
                'closed_deals.id as id',
                'closed_deals.buyer_id as buyer_id',
                'closed_deals.seller_id as seller_id',
                'closed_deals.created_at as date',
                'projects.ar_name as ar_project_name',
                'projects.en_name as en_project_name',
                'closed_deals.price as price'
            )->get();
        } else {
            $deals = ClosedDeal::join('proposals', 'proposals.id', '=', 'closed_deals.proposal_id')->join('properties', 'properties.id', '=', 'proposals.unit_id')->join('phases', 'properties.phase_id', '=', 'phases.id')->join('projects', 'projects.id', '=', 'phases.project_id')->join('developers', 'projects.developer_id', '=', 'developers.id')->where('proposals.unit_type', 'new_home')->where('developers.id', $request->developer)->where('closed_deals.created_at', '>=', $request->from . ' 00:00:00')->where('closed_deals.created_at', '<=', $request->to . ' 23:59:59')->select(
                'closed_deals.id as id',
                'closed_deals.buyer_id as buyer_id',
                'closed_deals.seller_id as seller_id',
                'closed_deals.created_at as date',
                'projects.ar_name as ar_project_name',
                'projects.en_name as en_project_name',
                'closed_deals.price as price'
            )->get();
        }
        return view('admin.project_deals', ['deals' => $deals]);
    }
    //old getphase with blade
    // public function get_phases(Request $request)
    // {
    //     $phases = Phase::where('project_id', $request->id)->get();
    //     return view('admin.proposals.get_phases', ['phases' => $phases]);
    // }
    //new getphase with .._new.blade
    public function get_phases(Request $request)
    {
        $phases = Phase::select(app()->getLocale() . '_name as name', 'id')->where('project_id', $request->id)->get();
        return $phases;
    }

    //old getphase_units with blade
    // public function get_phase_units(Request $request)
    // {
    //     $properties = Property::where('phase_id', $request->id)->where('type', $request->type)->get();
    //     return view('admin.proposals.get_phase_units', ['properties' => $properties]);
    // }

    public function get_phase_units(Request $request)
    {
        $properties = Property::select(app()->getLocale() . '_name as name', 'id')->where('phase_id', $request->id)->where('type', $request->type)->get();
        return $properties;
    }


    public function get_sales_forecast_report(Request $request)
    {
        if ($request->agent == 'all') {
            $to = new \DateTime($request->to);
            $from = new \DateTime($request->from);

            $diff = $to->diff($from);
            $diffM = $diff->m;
            $diffY = $diff->y * 12;
            $diff = $diffM + $diffY;
            //        $toS = strtotime($request->to);
            $fromS = strtotime($request->from);
            $data = [];
            for ($i = 0; $i <= $diff; $i++) {
                $date = date('Y-m', strtotime('+' . $i . ' month', $fromS));
                $deals = ClosedDeal::where('created_at', '>=', $date . '-01 00:00:00')->where('created_at', '<=', $date . '-31 23:59:59')->sum('price');
                $com = ClosedDeal::where('created_at', '>=', $date . '-01 00:00:00')->where('created_at', '<=', $date . '-31 23:59:59')->sum('company_commission');
                $data[$date] = ['total' => $deals, 'commission' => $com];
            }
        } else {
            $to = new \DateTime($request->to);
            $from = new \DateTime($request->from);

            $diff = $to->diff($from);
            $diffM = $diff->m;
            $diffY = $diff->y * 12;
            $diff = $diffM + $diffY;
            //        $toS = strtotime($request->to);
            $fromS = strtotime($request->from);
            $data = [];
            for ($i = 0; $i <= $diff; $i++) {
                $date = date('Y-m', strtotime('+' . $i . ' month', $fromS));
                $deals = ClosedDeal::where('created_at', '>=', $date . '-01 00:00:00')->where('created_at', '<=', $date . '-31 23:59:59')->where('agent_id', $request->agent)->sum('price');
                $com = ClosedDeal::where('created_at', '>=', $date . '-01 00:00:00')->where('created_at', '<=', $date . '-31 23:59:59')->where('agent_id', $request->agent)->sum('company_commission');
                $data[$date] = ['total' => $deals, 'commission' => $com];
            }
        }
        return view('admin.sales_forecast_report', ['data' => $data]);
    }

    public function get_countries_cities(Request $request)
    {
        $cities = DB::table('city')->where('country_id', $request->id)->get();
        return view('admin.resale_units.cities', ['cities' => $cities]);
    }

    public function get_cities_districts(Request $request)
    {
        $districts = DB::table('district')->where('city_id', $request->id)->get();
        return view('admin.resale_units.districts', ['districts' => $districts]);
    }

    public function get_form_projects(Request $request)
    {
        $projects = Project::where('developer_id', $request->id)->get();
        return view('admin.forms.projects', ['projects' => $projects]);
    }

    public function get_form_phases(Request $request)
    {
        $phases = Phase::where('project_id', $request->id)->get();
        return view('admin.forms.phases', ['phases' => $phases]);
    }

    public function get_lead_data(Request $request, $lead_id = 0)
    {
        if (empty($lead_id)) {

            $request = json_decode($request->getContent());

            $lead_id = isset($request->lead_id) ? abs((int)$request->lead_id) : 0;

            if (0 === $lead_id) {

                return ['status' => 'not_found'];
            }
        }

        $lead = Lead::find($lead_id);
        if ($lead) {
            if ($lead->image == 'image.jpg') {
                $lead->image = '';
            }

            if (@$lead->agent->image == 'image.jpg') {
                @$lead->agent->image = '';
            }

            if (@$lead->commercialAgent->image == 'image.jpg') {
                @$lead->commercialAgent->image = '';
            }

            $calls = Call::where('lead_id', $lead_id)->with('call_status')->orderBy('id', 'desc')->with('user')->take(3)->get();
            $meetings = Meeting::where('lead_id', $lead_id)->with('meeting_status')->orderBy('id', 'desc')->with('user')->take(3)->get();
            $voice_notes = VoiceNote::where('lead_id', $lead_id)->orderBy('id', 'desc')->with('user')->take(3)->get();
            $notes = LeadNote::where('lead_id', $lead_id)->orderBy('id', 'desc')->with('user')->take(3)->get();
            $requests = LeadReq::where('lead_id', $lead_id)->with('loc')->with('unittype')->with('project')->orderBy('id', 'desc')->with('user')->take(3)->get();

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
            if ($lead->seen) {
                $seen = 'seen_without_action';
                if (DB::table('lead_actions')->where('lead_id', $lead->id)->count()) {
                    $seen = 'seen_with_action';
                }
            }

            $data = [
                'id' => $lead->id,
                'first_name' => $lead->first_name,
                'last_name' => $lead->last_name,
                'image' => $lead->image,
                'phone' => $lead->phone,
                'lead_source_id' => @$lead->lead_source_id,
                'lead_source' => @$lead->source->name,
                'reference' => $lead->reference,
                'title' => @$lead->title->name,
                'industry' => @$lead->industry->name,
                'email' => $lead->email,
                'status' => @$seen,
                'created_by' => @$lead->user->name,
                'created_at' => @$lead->created_at->format('Y-m-d H:i:s'),
                'updated_at' => @$lead->updated_at->format('Y-m-d H:i:s'),
                'r_agent' => [
                    'name' => @$lead->agent->name,
                    'image' => @$lead->agent->image,
                    'type' => @$lead->agent->agentType->name,
                ],
                'c_agent' => [
                    'name' => @$lead->commercialAgent->name,
                    'image' => @$lead->commercialAgent->image,
                    'type' => @$lead->commercialAgent->agentType->name,
                ],
                'calls' => $calls,
                'meetings' => $meetings,
                'voice_notes' => $voice_notes,
                'notes' => $notes,
                'documents' => @$lead->documents,
                'requests'  => $requests
            ];
            return ['status' => 'ok', 'lead' => $data];
        } else {
            return ['status' => 'not_found'];
        }
    }

    public function get_statics()
    {
        $date = date('m');
        $acceptedapplications = Application::where('created_at', '>=', $date)
            ->where('acceptness', '=', 'accepted')
            ->get();
        $accpts = $acceptedapplications->toArray();
        $accptsCount = count($accpts);
        $accptspercentage = (int)(($accptsCount / $appsCount) * 100);
        return response()->json([
            'accptspercentage' => $accptspercentage
        ]);
    }

    public function rate_employee(Rate $rate)
    {
        $rated_employee_id = request('rated');
        $employee_id = request('id');
        $ratedcol = $rate->where('rated_employee_id', '=', $rated_employee_id)
            ->where('employee_id', '=', $employee_id)
            ->where('Is_rated', "=", 0)
            ->first();

        if (request('rated_work') == NULl) {
            $ratedcol->work = 0;
        } else {
            $ratedcol->work = request('rated_work');
        }
        if (request('rated_apperance') == NULL) {
            $ratedcol->apperance = 0;
        } else {
            $ratedcol->apperance = request('rated_apperance');
        }
        if (request('rated_efficient') == NULL) {
            $ratedcol->effeciant = 0;
        } else {
            $ratedcol->effeciant = request('rated_efficient');
        }
        if (request('rated_target') == NULL) {
            $ratedcol->target = 0;
        } else {
            $ratedcol->target = request('rated_target');
        }
        if (request('rated_ideas') == NULL) {
            $ratedcol->ideas = 0;
        } else {
            $ratedcol->ideas = request('rated_ideas');
        }
        $ratedcol->rate_date = Carbon::now();
        $ratedcol->Is_rated = 1;
        $ratedcol->save();
        return response()->json([
            'status' => '200',
            'test' => 1002
        ]);
    }

    public function search_cloud(Request $r, $phone = 0)
    {
        $request = json_decode($r->getContent());
        if (empty($phone)) {

            $phone = isset($request->phone) ? $request->phone : '';

            if ('' === $phone) {

                return ['status' => 'not_found'];
            }
        }

        $name = "";
        $result = opencnam($phone);
        if (isset($result)) {
            $json = json_decode($result);
            $name = $json->data->cnam;
        }

        if ($name == "" || $name == "EG") {
            $name = $request->name;
        }

        search_cse($name);

        return $result->toJson();

        // $lead = Lead::find($lead_id);
        // if ($lead) {
        //     if ($lead->image == 'image.jpg') {
        //         $lead->image = '';
        //     }
        //
        //     if (@$lead->agent->image == 'image.jpg') {
        //         @$lead->agent->image = '';
        //     }
        //
        //     if (@$lead->commercialAgent->image == 'image.jpg') {
        //         @$lead->commercialAgent->image = '';
        //     }
        //
        //     $calls = Call::where('lead_id', $lead_id)->with('call_status')->orderBy('id', 'desc')->with('user')->take(3)->get();
        //     $meetings = Meeting::where('lead_id', $lead_id)->orderBy('id', 'desc')->with('user')->take(3)->get();
        //     $voice_notes = VoiceNote::where('lead_id', $lead_id)->orderBy('id', 'desc')->with('user')->take(3)->get();
        //     $notes = LeadNote::where('lead_id', $lead_id)->orderBy('id', 'desc')->with('user')->take(3)->get();
        //
        //     foreach($meetings as $meeting) {
        //         if (@$meeting->user->image == 'image.jpg') {
        //             $meeting->image = '';
        //         }
        //     }
        //
        //     foreach($calls as $call) {
        //         if (@$call->user->image == 'image.jpg') {
        //             $call->image = '';
        //         }
        //     }
        //
        //     foreach($voice_notes as $note) {
        //         $note->user_name = @$note->user->name;
        //         $note->date = @\Carbon\Carbon::createFromTimeStamp(strtotime($note->created_at))->diffForHumans();
        //         if (@$note->user->image == 'image.jpg') {
        //             $note->image = '';
        //         }
        //     }
        //
        //     foreach($notes as $note) {
        //         $note->user_name = @$note->user->name;
        //         $note->date = @\Carbon\Carbon::createFromTimeStamp(strtotime($note->created_at))->diffForHumans();
        //         if (@$note->user->image == 'image.jpg') {
        //             $note->image = '';
        //         }
        //     }
        //
        //     $seen = 'not_seen';
        //     if ($lead->seen) {
        //         $seen = 'seen_without_action';
        //         if (DB::table('lead_actions')->where('lead_id', $lead->id)->count()) {
        //             $seen = 'seen_with_action';
        //         }
        //     }
        //
        //     $data = [
        //         'id' => $lead->id,
        //         'first_name' => $lead->first_name,
        //         'last_name' => $lead->last_name,
        //         'image' => $lead->image,
        //         'phone' => $lead->phone,
        //         'lead_source' => @$lead->source->name,
        //         'reference' => $lead->reference,
        //         'title' => @$lead->title->name,
        //         'industry' => @$lead->industry->name,
        //         'email' => $lead->email,
        //         'status' => @$seen,
        //         'created_by' =>@ $lead->user->name,
        //         'created_at' => @$lead->created_at->format('Y-m-d H:i:s'),
        //         'updated_at' => @$lead->updated_at->format('Y-m-d H:i:s'),
        //         'r_agent' => [
        //             'name' => @$lead->agent->name,
        //             'image' => @$lead->agent->image,
        //             'type' => @$lead->agent->agentType->name,
        //         ],
        //         'c_agent' => [
        //             'name' => @$lead->commercialAgent->name,
        //             'image' => @$lead->commercialAgent->image,
        //             'type' => @$lead->commercialAgent->agentType->name,
        //         ],
        //         'calls' => $calls,
        //         'meetings' => $meetings,
        //         'voice_notes' => $voice_notes,
        //         'notes' => $notes,
        //         'documents' => @$lead->documents
        //     ];
        //     return ['status' => 'ok', 'lead' => $data];
        // } else {
        //     return ['status' => 'not_found'];
        // }
    }

    public function dateInterval(Request $request)
    {

        $start = date('Y-m-d', strtotime($request->start));
        $end = date('Y-m-d', strtotime($request->end));
        $title = __('admin.attendance');

        $attendance = Attendance::whereBetween('date', [$start, $end])
            ->get();

        return view('admin.attendance.index', compact('attendance', 'title'));
    }
    public function count_notify(Request $request)
    {
        $query = new Lead;
        if (@$request->probability) {
            echo "1";
            $requests = \App\Call::where('probability', $requests->probability)->pluck('lead_id')->toArray();
            $query = $query->whereIn('id', $requests);
            $requests = \App\Meeting::where('probability', $requests->probability)->pluck('lead_id')->toArray();
            $query = $query->whereIn('id', $requests);
        }
        if (@$request->location) {
            $requests = \App\Request::where('location', $request->location)->pluck('lead_id')->toArray();
            $query = $query->whereIn('id', $requests);
        }
        if (@$request->developer) {
            $requests = \App\Request::where('developer_id', $request->developer)->pluck('lead_id')->toArray();
            $query = $query->whereIn('id', $requests);
        }
        if (@$request->project) {
            $requests = \App\Request::where('project_id', $request->project)->pluck('developer_id')->toArray();
            $requests = \App\Project::whereIn('id', $requests)->pluck('lead_id')->toArray();
            $query = $query->whereIn('id', $requests);
        }

        echo $query->count();
    }
    public function get_callsstatus(Request $req)
    {

        $callStatus = new \App\CallStatus;
        $callStatus = $callStatus->has('calls')->withCount(['calls' => function ($q) use ($req) {
            $q->whereIn('user_id', $req->users)->where('created_at', '>', $req->startDate)->where('created_at', '<', $req->endDate);
        }])->get();
        $data = array();
        $sumCalls = 0;
        foreach ($callStatus as $k => $c) {
            $sumCalls += $c->calls_count;
        }
        if ($sumCalls == 0) $sumCalls = 1;
        foreach ($callStatus as $k => $c) {
            $data[$k] = array($sumCalls - $c->calls_count, $c->calls_count);
        }
        return $data;
    }

    public function get_activity(Request $req)
    {
        // dd($req->all());
        if ($req->users) {
            // dd($req->users);
            $notEarly = \App\Log::whereIn('user_id', $req->users)->orderBy('created_at', 'desc')->limit(10)->get();
        } elseif (auth()->user()->type == 'admin' && empty($req->team_user_id) && empty($req->ids)) {
            $notEarly = \App\Log::orderBy('created_at', 'desc')->limit(10)->get();
        } else {
            if (!empty($req->team_user_id)) {
                $groupId = \App\Group::where('id', $req->team_user_id)->pluck('id')->toArray();
                $userId = \App\GroupMember::whereIn('group_id', $groupId)->pluck('member_id')->toArray();
                if (!empty($req->ids) && !empty($userId)) {
                    $notEarly = \App\Log::whereIn('user_id', $userId)->whereIn('user_id', $req->ids)->orderBy('created_at', 'desc')->limit(10)->get();
                } else {
                    $notEarly = \App\Log::whereIn('user_id', $userId)->orderBy('created_at', 'desc')->limit(10)->get();
                }
            } else {
                if (!empty($req->ids)) {
                    $notEarly = \App\Log::whereIn('user_id', $req->ids)->orderBy('created_at', 'desc')->limit(10)->get();
                } else {
                    $notEarly = \App\Log::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->limit(10)->get();
                }
            }
        }
        return view('admin.activity', ["notEarly" => $notEarly]);
    }

    public function send_notify(Request $request)
    { }
    public function edit_dashboard(Request $request)
    {
        if (\App\UserEdit::where('user_id', auth()->user()->id)->where('type', $request->type)->count() == 0) {
            $edits = new \App\UserEdit;
            $edits->user_id = auth()->user()->id;
            $edits->type = $request->type;
            $edits->data = json_encode($request->data);
            $edits->save();
        } else {
            $edits = \App\UserEdit::where('user_id', auth()->user()->id)->where('type', $request->type)->update(['data' => json_encode($request->data)]);
        }
    }

    public function deleteNote(Request $request)
    {
        $id = $request->input('id');
        return LeadNote::where('id', '=', $id)->delete();
    }

    public function getOwnedUnits($id)
    {
        $resalesQuery = ResaleUnit::where('lead_id', $id)
            ->with(array('project' => function ($query) {
                $query->select('id', 'en_name');
            }))
            ->with(array('location' => function ($query) {
                $query->select('id', 'en_name');
            }))
            ->select('id', 'en_title', 'price', 'rooms', 'bathrooms', 'image', 'location', 'project_id')
            ->get();

        $rentalsQuery = RentalUnit::where('lead_id', $id)
            ->with(array('project' => function ($query) {
                $query->select('id', 'en_name');
            }))
            ->with(array('location' => function ($query) {
                $query->select('id', 'en_name');
            }))
            ->select('id', 'en_title', 'value_of_rent', 'image', 'location', 'project_id')
            ->get();
        return response()->json([
            'resales' => $resalesQuery,
            'rentals' => $rentalsQuery
        ]);
    }

    public function add_suggestion(Request $request)
    {
        $suggestions = array();
        $userID = auth()->user()->id;
        $selected_suggestions = $request->selected_suggestions;
        if ($request->request_type != "new_home") {
            $title = "title";
            if ($request->request_type == "resale") {
                $price = "price";
            } else {
                $price = "value_of_rent";
            }
            $location_id = "location";
        } else {
            $title = "en_name";
            $price = "meter_price";
            $location_id = "location_id";
        }
        if ($request->request_type == "new_home") {
            foreach ($selected_suggestions as $suggestion) {
                $suggestions[] = array(
                    'lead_id' => $request->lead_id,
                    'type' => $request->request_type,
                    'title' => $suggestion['en_name'],
                    'price' => $suggestion['meter_price'],
                    'area' => $suggestion['area'],
                    'location_id' => $suggestion['location_id'],
                    'user_id' => $userID,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
            }
        } else if ($request->request_type == "resale") {
            foreach ($selected_suggestions as $suggestion) {
                $suggestions[] = array(
                    'lead_id' => $request->lead_id,
                    'type' => $request->request_type,
                    'title' => $suggestion['en_title'],
                    'price' => $suggestion['price'],
                    'area' => $suggestion['area'],
                    'location_id' => $suggestion['location'],
                    'user_id' => $userID,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
            }
        } else {
            foreach ($selected_suggestions as $suggestion) {
                $suggestions[] = array(
                    'lead_id' => $request->lead_id,
                    'type' => $request->request_type,
                    'title' => $suggestion['en_title'],
                    'price' => $suggestion['value_of_rent'],
                    'area' => $suggestion['area'],
                    'location_id' => $suggestion['location'],
                    'user_id' => $userID,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
            }
        }

        DB::table('suggestions')->insert($suggestions);
    }

    public function getLeadSuggestions($id)
    {
        $new_home_suggestions = DB::table('suggestions as suggestion')
            ->join('locations as location', 'suggestion.location_id', '=', 'location.id')
            ->where('suggestion.lead_id', $id)
            ->where('suggestion.type', 'new_home')
            ->select('suggestion.id', 'suggestion.title', 'suggestion.type', 'location.en_name as location', 'suggestion.price', 'suggestion.area')
            ->get();
        $resale_suggestions  = DB::table('suggestions as suggestion')
            ->join('locations as location', 'suggestion.location_id', '=', 'location.id')
            ->where('suggestion.lead_id', $id)
            ->where('suggestion.type', 'resale')
            ->select('suggestion.id', 'suggestion.title', 'suggestion.type', 'location.en_name as location', 'suggestion.price', 'suggestion.area')
            ->get();

        $rental_suggestions  = DB::table('suggestions as suggestion')
            ->join('locations as location', 'suggestion.location_id', '=', 'location.id')
            ->where('suggestion.lead_id', $id)
            ->where('suggestion.type', 'rental')
            ->select('suggestion.id', 'suggestion.title', 'suggestion.type', 'location.en_name as location', 'suggestion.price', 'suggestion.area')
            ->get();
        return [
            'new_home_suggestions' => $new_home_suggestions,
            'resale_suggestions' => $resale_suggestions,
            'rental_suggestions' => $rental_suggestions
        ];
    }


    public function get_suggestions_new(Request $req)
    {
        $units = [];
        $type = '';
        $rules = [
            'unit_type' => 'required',
            'request_type' => 'required',
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return ['status' => 'error', 'errorMessage' => $validator->errors()];
        }
        if (count($req->project_id) > 0 && $req->request_type != "resale" && $req->request_type != "rental") {
            return;
        }
        if ($req->unit_type == "residential") {
            $req->unit_type = "personal";
        }
        $locationsArray = HomeController::getChildren($req->location);
        $locationsArray[] = $req->location;
        $units = [];
        $type = '';

        if ($req->unit_type != 'land') {
            if ($req->request_type == 'new_home') {
                $units = @Project::where('type', $req->unit_type);
                if ($req->location) {
                    $units = $units->whereIn('location_id', $locationsArray);
                }
                if ($req->price_from) {
                    $units = $units->where('meter_price', '>=', $req->price_from);
                }
                if ($req->price_to) {
                    $units = $units->where('meter_price', '<=', $req->price_to);
                }
                if ($req->area_from) {
                    $units = $units->where('area', '>=', $req->area_from);
                }
                if ($req->area_to) {
                    $units = $units->where('area', '<=', $req->area_to);
                }
                $units = $units->get();

                $type = 'new_home';
                // $units = @Project::where('type', $req->unit_type)->
                // whereBetween('meter_price', [$req->price_from, $req->price_to])->
                // whereBetween('area', [$req->area_from, $req->area_to])->
                // whereIn('location_id', $locationsArray)->
                // get();

            } elseif ($req->request_type == 'resale') {
                $units = @ResaleUnit::where('type', $req->unit_type);
                if ($req->unit_type_id) {
                    $units = $units->where('unit_type_id', $req->unit_type_id);
                }
                if ($req->location) {
                    $units = $units->whereIn('location', $locationsArray);
                }
                if ($req->project_id) {
                    $units = $units->whereIn('project_id', $req->project_id);
                }
                if ($req->price_from) {
                    $units = $units->where('meter_price', '>=', $req->price_from);
                }
                if ($req->price_to) {
                    $units = $units->where('meter_price', '<=', $req->price_to);
                }
                if ($req->area_from) {
                    $units = $units->where('area', '>=', $req->area_from);
                }
                if ($req->area_to) {
                    $units = $units->where('area', '<=', $req->area_to);
                }
                if ($req->rooms_from) {
                    $units = $units->where('rooms', '>=', $req->rooms_from);
                }
                if ($req->rooms_to) {
                    $units = $units->where('rooms', '<=', $req->rooms_to);
                }
                if ($req->bathrooms_from) {
                    $units = $units->where('bathrooms', '>=', $req->bathrooms_from);
                }
                if ($req->bathrooms_to) {
                    $units = $units->where('bathrooms', '<=', $req->bathrooms_to);
                }
                $units = $units->get();
                $type = 'resale';
                // $units = @ResaleUnit::whereBetween('rooms', [$req->rooms_from, $req->rooms_to])->
                // where('type', $req->unit_type)->
                // where('unit_type_id', $req->unit_type_id)->
                // whereBetween('total', [$req->price_from, $req->price_to])->
                // whereBetween('area', [$req->area_from, $req->area_to])->
                // whereBetween('rooms', [$req->rooms_from, $req->rooms_to])->
                // whereIn('location', $locationsArray)->
                // where('delivery_date', $req->date)->
                // whereBetween('bathrooms', [$req->bathrooms_from, $req->bathrooms_to])->get();
                // $type = 'resale';

            } elseif ($req->request_type == 'rental') {
                $units = @RentalUnit::where('type', $req->unit_type);
                if ($req->unit_type_id) {
                    $units = $units->where('unit_type_id', $req->unit_type_id);
                }
                if ($req->location) {
                    $units = $units->whereIn('location', $locationsArray);
                }
                if ($req->project_id) {
                    $units = $units->whereIn('project_id', $req->project_id);
                }
                if ($req->price_from) {
                    $units = $units->where('meter_price', '>=', $req->price_from);
                }
                if ($req->price_to) {
                    $units = $units->where('meter_price', '<=', $req->price_to);
                }
                if ($req->area_from) {
                    $units = $units->where('area', '>=', $req->area_from);
                }
                if ($req->area_to) {
                    $units = $units->where('area', '<=', $req->area_to);
                }
                if ($req->rooms_from) {
                    $units = $units->where('rooms', '>=', $req->rooms_from);
                }
                if ($req->rooms_to) {
                    $units = $units->where('rooms', '<=', $req->rooms_to);
                }
                if ($req->bathrooms_from) {
                    $units = $units->where('bathrooms', '>=', $req->bathrooms_from);
                }
                if ($req->bathrooms_to) {
                    $units = $units->where('bathrooms', '<=', $req->bathrooms_to);
                }
                $units = $units->get();
                // $units = @RentalUnit::whereBetween('rooms', [$req->rooms_from, $req->rooms_to])->
                // where('type', $req->unit_type)->
                // where('unit_type_id', $req->unit_type_id)->
                // whereBetween('rent', [$req->price_from, $req->price_to])->
                // whereBetween('area', [$req->area_from, $req->area_to])->
                // whereBetween('rooms', [$req->rooms_from, $req->rooms_to])->
                // whereIn('location', $locationsArray)->
                // where('delivery_date', $req->date)->
                // whereBetween('bathrooms', [$req->bathrooms_from, $req->bathrooms_to])->get();
                $type = 'rental';
            }
        } else {
            $units = @Land::whereBetween('meter_price', [$req->price_from, $req->price_to])->whereBetween('area', [$req->area_from, $req->area_to])->whereIn('location', $locationsArray)->get();
            $type = 'lands';
        }
        return $units;
        // return view('admin.requests.get_suggestions', ['units' => $units, 'type' => $type]);
    }

    public function getAgentLeads()
    {
        $leads = Lead::getAgentLeads();
        foreach ($leads as $lead) {
            $lead->agentName = DB::table('users')->where('id', $lead->agent_id)->value('name');
        }
        return $leads;
    }
    public function signalHelper($player_id = null,$Omassege=null,$url='',$data=[])
    {
        $app_id = config('onesignal.app_id');
        if($app_id != null && $app_id != ""){
            if($player_id != 'No Player id' && $player_id != null && $url != null){
                OneSignal::sendNotificationToUser(
                    $Omassege,
                    $player_id,
                    $url = null,
                    $data = null
                );
            }
        }
        
        // return response()->json([
        //     'status' => "ok",
        //     "massege" => 'sending one OneSignal'
        // ]);
    }
}
