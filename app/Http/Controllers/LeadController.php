<?php
namespace App\Http\Controllers;
use App\AdminNotification;
use App\Agent;
use App\Call;
use App\Campaign;
use App\Cil;
use App\City;
use App\Contact;
use App\Country;
use App\Developer;
use App\Facility;
use App\Favorite;
use App\Form;
use App\Group;
use App\GroupMember;
use App\Industry;
use App\Interested;
use App\Lead;
use App\Player;
use App\LeadNote;
use App\LeadSource;
use App\Location;
use App\Meeting;
use App\Project;
use App\RentalUnit;
use App\Request as Req;
use App\Request as Model;
use App\ResaleUnit;
use App\Setting;
use App\User;
use App\VoiceNote;
use App\ToDo;
use App\Role;
use App\UnitType;
use App\LeadAction;
use App\Tag;
use App\Archive;
use Auth;
use Config;
use Excel;
use File;
use Hash;
use Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;
use Validator;
use Cache;
use \App\newintrest;
use Carbon\Carbon;
use OneSignal;


class LeadController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	/*public function index(Request $request)
	{
		$query = new Lead;
		// return $request->all();
		if (@$request->date_from and @$request->date_to) {
			$from = date('Y-m-d', strtotime($request->date_from));
			$to = date('Y-m-d', strtotime($request->date_to));
			$query = $query->whereBetween('created_at', [$from, $to]);
		}
		if (@$request->location) {
			$requests = \App\Request::where('location', $request->location)->pluck('lead_id')->toArray();
			$query = $query->whereIn('id', $requests);
		}
		if (@$request->call_status) {
			$calls = Call::where('call_status_id', $request->call_status)->pluck('lead_id')->toArray();
			$query = $query->whereIn('id', $calls);
		}
		if (@$request->meeting_status) {
			$meetings = Meeting::where('meeting_status_id', $request->meeting_status)->pluck('lead_id')->toArray();
			$query = $query->whereIn('id', $meetings);
		}
		if (@$request->group_id != 0) {
			$agents = GroupMember::where('group_id', $request->group_id)->pluck('member_id')->toArray();
			$query = $query->whereIn('agent_id', $agents);
		}
		$users = [];
		$user_ids = [];
		if (@$request->agent_id != 0) {
			$query = $query->where('agent_id', $request->agent_id)->orWhere('commercial_agent_id', $request->agent_id);
		} else {
			if (auth()->user()->type == 'admin' or @Group::where('team_leader_id', auth()->id())->count()) {
				// $teamLeads = Lead::getAgentLeads();
				$teamLeads = Lead::getTeamLeads();
				// dd(count($teamLeads) );
				foreach ($teamLeads as $lead) {
					if (auth()->user()->type == 'admin' && $lead->agent_id != auth()->id()) {
						$users[] = User::find($lead->agent_id);
						$user_ids[] = $lead->agent_id;
					} elseif ($lead->agent_id != auth()->id()) {
						$users[] = User::find($lead->agent_id);
						$user_ids[] = $lead->agent_id;
					}
				}
			}
			$users = array_unique($users);
			//dd($user_ids);
			$query = $query->where('agent_id', '>', 0)->whereIn('agent_id', $user_ids);
		}
		if (auth()->user()->type == 'admin') {
			$Agents = User::get();
		} else {
			$Agents = User::find($user_ids);
		}
		$query = $query->orderBy('id', 'desc');
		$teams = $query->paginate(10, ['*'], 'team');
		$leads = Lead::where('agent_id', auth()->id());
		if (auth()->user()->type == 'admin') {
			$groups = Group::get();
		} else {
			$groups = Group::where('team_leader_id', auth()->id())->get();
		}
		$facebook = Lead::where("lead_source_id", 7)->where('agent_id', auth()->id())->count();
		$coldCalls = Lead::where("lead_source_id", 28)->where('agent_id', auth()->id())->count(); // Cold Calls
		$lead_agent = Lead::where('agent_id',auth()->user()->id )->get();
		$switch = Lead::where("agent_id",auth()->user()->id)->whereRaw("agent_id <> agent_flag")->count(); // switched to me
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
			if (@$lastCall->probability == "high" || @$lastMeeting->probability == "high") {
				// dd('test');
				array_push($high, $value);
			}
		}
		$lowest = count($lowest);
		$high = count($high);
		$highest = count($highest);
		// $switch = count($switch);
		if ($leads->count()) {
			$show = $leads->first();
		} else {
			$show = new Lead();
		}
		// dd($show);
		return view('admin.leads.index', ['show' => $show, 'title' => trans('admin.all_leads'), 'agents' => $users, 'leads' => $leads, 'teams' => $teams->appends(Input::except('team')), 'agent_ids' => $user_ids, 'groups' => $groups,
			'Agents' => $Agents,'switch'=>$switch ,'facebook' => $facebook, 'coldCalls' => $coldCalls, 'followUp' => $followUp, 'lowest' => $lowest, 'high' => $high, 'highest' => $highest]);
	}*/

	public function index(){
		$sources = DB::table('leads')
				   ->select('leads.id','leads.prefix_name', 'leads.first_name','leads.last_name','leads.email','leads.phone','leads.status')
				   ->paginate(100);
				   
		// return view('admin.tasks.index', ['title' => trans('admin.task'), 'source' => $sources]);
		
		return response()->json($sources);
		

		// return view('newlead');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('admin.leads.create', ['title' => trans('admin.add_lead')]);
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	protected function getleadd($id) {
		$request = new Request;
		$request->lead_id = $id;
		$agent_controller = app('App\Http\Controllers\Agentapi');
		$row = Lead::Find($id);
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
					array_push($other_phones,
						array('number' => $key1,
							'whatsapp' => $value['whatsapp'],
							'sms' => $value['sms'],
							'viber' => $value['viber'],
						));
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
			$title = $row->first_name . $row->last_name; //$row->title->name;
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
			$social = (object) [];
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
			$leadProbability = 'Follow Up';
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
			'full_info' => null,
		);
		//$lead['full_info'] = $agent_controller->get_lead($request, $row->id);
		return $lead;
	}
	public function store(Request $request) {
		// dd($request->all());
		$rules = [
			'first_name' => 'required|max:191',
			'last_name' => 'required|max:191',
			'phone' => 'required|numeric|unique:leads',
			// 'lead_source' => 'required|max:191',
			// 'image' => 'image',
//            'agent_id' => 'required',
			//            'commercial_agent_id' => 'required',
		];
		$validator = Validator::make($request->all(), $rules);
		$validator->SetAttributeNames([
			'first_name' => trans('admin.first_name'),
			'last_name' => trans('admin.last_name'),
			'middle_name' => trans('admin.middle_name'),
			'email' => trans('admin.email'),
			'phone' => trans('admin.phone'),
			'address' => trans('admin.address'),
			'lead_source' => trans('admin.lead_source'),
			'image' => trans('admin.image'),
			'agent_id' => trans('admin.residential_agent'),
			'commercial_agent_id' => trans('admin.commercial_agent'),
		]);
		if ($validator->fails()) {
			return back()->withInput()->withErrors($validator);
		} else {
			$lead = new Lead;
			$leadInstance = new Lead;
			$lead->prefix_name = $request->prefix_name;
			$lead->first_name = $request->first_name;
			$lead->last_name = $request->last_name;
			$lead->email = $request->email;
			// $lead->phone = $request->phone;
			$contact = $leadInstance->reformPhone($request->phone);

			$lead->phone = $contact->phone;
			$lead->phone_iso = $contact->iso;
			$lead->reference = $request->reference;
			$lead->lead_source_id = $request->lead_source;
			$lead->status = 'new';
			if ($request->has('other_phones')) {
				foreach ($request->other_phones as $k => $v) {
					$phones[] = array(
						$request->other_phones[$k] => $request->other_socials[$k],
					);
				}
				$lead->other_phones = json_encode($phones);
			}
			$lead->other_emails = json_encode($request->other_emails);
			$lead->notes = $request->notes;
			$lead->user_id = auth()->user()->id;
			$setting = Setting::first();
			if (auth()->user()->residential_commercial == "residential" and auth()->user()->type != 'admin') {
				$lead->agent_id = auth()->user()->id;
			} elseif (auth()->user()->residential_commercial == "commercial" and auth()->user()->type != 'admin') {
				$lead->commercial_agent_id = auth()->user()->id;
			}
			if ($request->has('agent_id')) {
				$lead->agent_id = $request->agent_id;
			} else {
				$lead->agent_id = 0;
			}
			if ($request->has('commercial_agent_id')) {
				$lead->commercial_agent_id = $request->commercial_agent_id;
			} else {
				$lead->commercial_agent_id = 0;
			}
			if ($request->hasFile('image')) {
				$lead->image = uploads($request, 'image');
			} else {
				$lead->image = 'image.jpg';
			}
			if (!$request->has('agent_id') and !$request->has('commercial_agent_id')) {
				if (auth()->user()->residential_commercial == 'commercial') {
					$lead->commercial_agent_id = auth()->user()->id;
				} else {
					$lead->agent_id = auth()->user()->id;
				}
			}
			$lead->save();
			if ($request->has('notes') and $request->notes != '' and $request->notes != null) {
				$note = new LeadNote;
				$note->lead_id = $lead->id;
				$note->note = $request->notes;
				$note->user_id = auth()->id();
				$note->save();
			}
			if ($request->has('contact_name')) {
				foreach ($request->contact_name as $k => $v) {
					$contact = new Contact;
					$contact->lead_id = $lead->id;
					$contact->name = $request->contact_name[$k];
					$contact->relation = $request->contact_relation[$k];
					$contact->nationality = $request->contact_nationality[$k];
					$contact->title_id = $request->contact_title_id[$k];
					$contact->email = $request->contact_email[$k];
					$contact->other_emails = json_encode($request->contact_other_emails[$k]);
					$contact->phone = $request->contact_phone[$k];
					$contact->other_phones = json_encode($request->contact_other_phones[$k]);
					$contact->social = json_encode($request->contact_social[$k]);
					if ($request->has('contact_other_phones')) {
						foreach ($request->contact_other_phones[$k] as $k1 => $v1) {
							$contactPhones[] = array(
								$request->contact_other_phones[$k][$k1] => $request->contact_other_socials[$k][$k1],
							);
						}
						$contact->other_phones = json_encode($contactPhones);
					};
					$contact->save();
				}
			}
			$lead_request = null;
			$request_project = [];
			if (isset($request->request_type)) {
				if ($request->has('request_project_id')) {
					foreach ($request->request_project_id as $project) {
						$lead_request = new Req;
						$lead_request->user_id = Auth::user()->id;
						$lead_request->lead_id = $lead->id;
						$lead_request->location = $request->request_location;
						$lead_request->request_type = $request->request_type;
						$lead_request->type = $request->buyer_seller;
						$lead_request->unit_type = $request->request_unit_type;
						$lead_request->unit_type_id = $request->request_unit_type_id;
						$lead_request->project_id = $project;		
						$lead_request->save();
					}
				} else {
					$lead_request = new Req;
					$lead_request->user_id = Auth::user()->id;
					$lead_request->lead_id = $lead->id;
					$lead_request->location = $request->request_location;
					$lead_request->request_type = $request->request_type;
					$lead_request->type = $request->buyer_seller;
					$lead_request->unit_type = $request->request_unit_type;
					$lead_request->unit_type_id = $request->request_unit_type_id;
					$lead_request->project_id = null;		
					$lead_request->save();
				}
			}
			$source = @LeadSource::find($request->lead_source)->name;
			if ($request->agent_id) {
				$notify = new AdminNotification;
				$notify->type = 'added_lead';
				$notify->type_id = $lead->id;
				$notify->status = 0;
				$notify->user_id = auth()->user()->id;
				$notify->assigned_to = $request->agent_id;
				$notify->save();
				$agent = User::find($request->agent_id);
				$lead->agent_id = $request->agent_id;
				$agent = User::find($request->agent_id);
				$sender = auth()->user();
				if ($setting->leads_mail) {
					Config::set('mail.username', $setting->leads_mail);
					Config::set('mail.password', $setting->leads_mail_password);
				} else {
					//  dd(decryptHelper(auth()->user()->email_password));
					Config::set('mail.username', auth()->user()->email);
					Config::set('mail.password', auth()->user()->password);
				}
				Config::set('mail.port', 26);
				Config::set('mail.host', 'mail.newavenue-egypt.com');
				/*Mail::send('admin.leads.new_lead_mail',
				 ['lead' => $lead,'sender'=>$sender,'request'=>$request,'lead_request'=>$lead_request,'source'=>$source],
				  function ($message) use ($agent,$sender,$request) {
						$message->to($agent->email)->subject('New Lead')->from(auth()->user()->email, auth()->user()->name);
				});*/
			}
			if ($request->commercial_agent_id) {
				$notify = new AdminNotification;
				$notify->type = 'added_lead';
				$notify->type_id = $lead->id;
				$notify->status = 0;
				$notify->user_id = auth()->user()->id;
				$notify->assigned_to = $request->commercial_agent_id;
				$notify->save();
				$agent = User::find($request->commercial_agent_id);
				$lead->commercial_agent_id = $request->commercial_agent_id;
				$sender = auth()->user();
				if ($setting->leads_mail) {
					Config::set('mail.username', $setting->leads_mail);
					Config::set('mail.password', $setting->leads_mail_password);
				} else {
					Config::set('mail.username', auth()->user()->email);
					Config::set('mail.password', auth()->user()->password);
				}
				Config::set('mail.port', 26);
				Config::set('mail.host', 'mail.newavenue-egypt.com');
				/*Mail::send('admin.leads.new_lead_mail',
					['lead' => $lead,'sender'=>$sender,'request'=>$request,'lead_request'=>$lead_request,'source'=>$source],
					 function ($message) use ($agent,$sender,$request) {
					$message->to($agent->email)->subject('New Lead');
				});*/
			}
			session()->flash('success', trans('admin.created'));
			$old_data = json_encode($lead);
			LogController::add_log(
				__('admin.created', [], 'ar') . ' ' . $lead->ar_first_name,
				__('admin.created', [], 'en') . ' ' . $lead->first_name,
				'leads',
				$lead->id,
				'create',
				auth()->user()->id,
				$old_data
			);
			$notify = new AdminNotification;
			$notify->type = 'added_lead';
			$notify->type_id = $lead->id;
			$notify->status = 0;
			$notify->user_id = auth()->user()->id;
			$notify->save();
			$agent = User::where('id', $request->agent_id)->orWhere('id', $request->commercial_agent_id)->get();
			$message = "New Lead  \"$request->first_name $request->first_name\"  has been added to you.";
			$url = url(adminPath() . '/leads/' . $lead->id);
			$leads = [];
			$leads['data'] = $this->getleadd($lead->id);
			$leads['activityToBeOpened'] = "lead";
			foreach ($agent as $a) {
				foreach ($a->player as $p) {
					$url2 = $url;
					if ("ios" == $p->device || "android" == $p->device) {
						$url2 = null;
					}
					sendOne($message, $p->player_id, $url2, $leads);
				}
			}
			$this->send_notification($lead->agent_id, $lead->id);
			return redirect(adminPath() . '/leads/' . $lead->id);
		}
	}
	private function send_notification($agent_id, $lead_id)
	{
		$tokens = User::where('refresh_token', '!=', '')->where('id', $agent_id)->pluck('refresh_token')->toArray();
		// $tokens = User::where('refresh_token', '!=', '')->pluck('refresh_token')->toArray();
		$msg = [
			'title' => __('admin.lead_added', [], 'en'),
			'body' => 'New Lead has been added to you',
			'image' => 'myIcon', /*Default Icon*/
			'sound' => 'mySound' /*Default sound*/
		];

		$data = [
			'lead_id' => $lead_id,
		];

		notify1($tokens, $msg, $data);
		return 1;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Lead $lead
	 * @return \Illuminate\Http\Response
	 */
	public function show(Lead $lead)
	{
		$projectPrice = Project::get()->pluck('meter_price')->toArray();
		$rentalPrice = RentalUnit::get()->pluck('rent')->toArray();
		$resalePrice = ResaleUnit::get()->pluck('price')->toArray();
		$prices = array_merge($projectPrice, $rentalPrice, $resalePrice);
		$projectAreaMin = Project::get()->pluck('area')->toArray();
		$projectAreaMax = Project::get()->pluck('area_to')->toArray();
		$rentalArea = RentalUnit::get()->pluck('area')->toArray();
		$resaleArea = ResaleUnit::get()->pluck('area')->toArray();
		$areas = array_merge($projectAreaMin, $projectAreaMax, $rentalArea, $resaleArea, $resaleArea);

		$minArea = min($areas);
		$maxArea = max($areas);

		$minPrice = min($prices);
		$maxPrice = max($prices);

		if (!$lead->seen && Lead::where('agent_id', auth()->id())->where('id', $lead->id)) {
			$lead->seen = 1;
			$lead->save();
		}
		return view('admin.leads.show_new', [
			'title' => trans('admin.show_lead'),
			'show' => $lead,
			'minArea' => $minArea,
			'maxArea' => $maxArea,
			'minPrice' => $minPrice,
			'maxPrice' => $maxPrice,
		]);
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Lead $lead
	 * @return \Illuminate\Http\Response
	 */
	public function edit($lead)
	{
		$data = Lead::find($lead);
		return view('admin.leads.edit', ['title' => trans('admin.edit_lead'), 'data' => $data]);
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Lead $lead
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $lead)
	{
		// return $request;
		$rules = [
			'first_name' => 'required|max:191',
			'last_name' => 'required|max:191',
			'phone' => 'required|numeric|unique:leads,phone,' . $lead . ',id',
			// 'lead_source' => 'required|max:191',
			// 'image' => 'image',
		];
		$validator = Validator::make($request->all(), $rules);
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
			return back()->withInput()->withErrors($validator);
		} else {
			$lead = Lead::find($lead);
			$old_data = json_encode($lead);
			$lead->prefix_name = $request->prefix_name;
			$lead->first_name = $request->first_name;
			$lead->last_name = $request->last_name;
			$lead->middle_name = $request->middle_name;
			$lead->ar_first_name = $request->ar_first_name;
			$lead->ar_last_name = $request->ar_last_name;
			$lead->ar_middle_name = $request->ar_middle_name;
			$lead->email = $request->email;
			$lead->phone = $request->phone;
			$lead->nationality = $request->nationality;
			$lead->country_id = $request->country_id;
			$lead->city_id = $request->city_id;
			$lead->address = $request->address;
			$lead->club = $request->club;
			$lead->title_id = $request->title_id;
			$lead->religion = $request->religion;
			$lead->birth_date = strtotime($request->birth_date);
			$lead->lead_source_id = $request->lead_source;
			$lead->social = json_encode($request->social);
			$lead->industry_id = $request->industry_id;
			$lead->company = $request->company;
			$lead->school = $request->school;
			$lead->facebook = $request->facebook;
			$lead->id_number = $request->id_number;
			$lead->status = 'new';
			if ($request->has('other_phones')) {
				foreach ($request->other_phones as $k => $v) {
					$phones[] = [
						$request->other_phones[$k] => $request->other_socials[$k],
					];
				}
				$lead->other_phones = json_encode($phones);
			}
			$lead->other_emails = json_encode($request->other_emails);
			$lead->notes = $request->notes;
			$lead->user_id = auth()->user()->id;
			if ($request->hasFile('image')) {
				$lead->image = uploads($request, 'image');
			}
			$lead->save();
			session()->flash('success', trans('admin.updated'));
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

			return response()->json(["status"=>"updated"],200);
		}
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Lead $lead
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($lead)
	{
		$data = Lead::find($lead);
		$deletedLead = [];
		$deletedLeadData = ['time'=>time(),'id'=>$data['id']];
		if(Cache::has('deletedLeads2')){
			$value = Cache::get('deletedLeads2');
			$deletedLead = $value;
			$deletedLead[] = $deletedLeadData;
			Cache::put('deletedLeads2',$deletedLead,2000000);
		}else {
			$deletedLead[] = $deletedLeadData;
			Cache::put('deletedLeads2',$deletedLead,2000000);
		}
		$file_path = url('uploads/' . @$data->image);
		if (@$data->image != 'image.jpg' and @$data->image != 'image.ico' and file_exists($file_path)) {
			@unlink($file_path);
		}
		$old_data = json_encode($data);
		LogController::add_log(
			__('admin.deleted', [], 'ar') . ' ' . @$data->ar_first_name,
			__('admin.deleted', [], 'en') . ' ' . @$data->first_name,
			'leads',
			$data->id,
			'delete',
			auth()->user()->id,
			$old_data
		);

		if (checkRole('hard_delete_leads')) {
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
			DB::table('to_dos')->where('leads', $lead)->delete();
			// dd($data);
			$data->delete();

			session()->flash('success', trans('admin.deleted'));
			return redirect(adminPath() . '/leads');
		} elseif (checkRole('soft_delete_leads')) {
			$archivedLead = array();
			foreach($data->toArray() as $key => $value){
				$archivedLead["$key"] = $value;
			}
			$archivedLead['lead_id'] = $data->id;

			unset($archivedLead['id']);
			unset($archivedLead['requests']);
			unset($archivedLead['company_id']);
			unset($archivedLead['company_status']);
			unset($archivedLead['full_name']);						
			unset($archivedLead['gender']);						
			unset($archivedLead['mobile_number']);						
			unset($archivedLead['specilization_id']);
			DB::table('archives')->insert([$archivedLead]);
			DB::table('leads')->where('id',$data->id)->delete();	
			// $data->save();
			session()->flash('success', trans('admin.deleted'));
			return redirect(adminPath() . '/leads');
		} else {
			session()->flash('error', __('admin.you_dont_have_permission'));
			// ret urn back();
		}
		session()->flash('success', trans('admin.deleted'));
		return redirect(adminPath() . '/leads');
	}
	public function upload_file()
	{
		return view('admin.leads.upload_leads');
	}
	public function upload_excel(Request $request)
	{
		// return File::mimeType($_FILES['xls']['tmp_name']);
		$rules1 = [
			'lead_source' => 'required',
			'xls' => 'file|max:100|mimeTypes:' .
			'application/vnd.ms-office,' .
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,' .
			'application/vnd.ms-excel',
		];
		$validator1 = Validator::make($request->all(), $rules1);
		$validator1->SetAttributeNames([
			'lead_source' => trans('admin.lead_source'),
			'xls' => trans('admin.xls'),
		]);
		if ($validator1->fails()) {
			return back()->withInput()->withErrors($validator1);
		} else {
			$source = $request->lead_source;
			$path = $request->file('xls')->getRealPath();
			Excel::load($path, function ($reader) use ($source, $path) {
				$array = $reader->toArray();
				foreach ($array as $item) {
					if (isset($item['phone'])) {
						$check1 = Lead::where('phone', $item['phone'])->get();
						if (count($check1) < 1) {
							$rules = [
								'first_name' => 'required|max:191',
								'last_name' => 'required|max:191',
								'gender' => 'required',
								'phone' => 'required',
							];

							$validator = Validator::make($item, $rules);

							if (!$validator->fails()) {
								$data = new Lead();
								if (isset($item['email'])) {
									$check2 = Lead::where('phone', $item['phone'])->get();
									if (count($check2) < 1) {
										$validator = Validator::make(
											['email' => 'required|email']
										);
										if (!$validator->fails()) {
											$data->email = $item['email'];
										}
									}
								}
								// if (count($campaign = Campaign::where('en_name', $item['campaign'])->orWhere('ar_name', $item['campaign'])->first()) > 0) {
								$data->first_name = $item['first_name'];
								$data->last_name = $item['last_name'];
								$data->phone = $item['phone'];
								$data->lead_source_id = $source;
								$data->campain_id = 0;
								if ('female' == $item['gender']) {
									$data->prefix_name = 'ms';
								} else {
									$data->prefix_name = 'mr';
								}
								$data->agent_id = Auth::user()->id;
								$data->user_id = 0;
								$data->save();
								// }
							}
						}
					}
				}
			});

			return redirect(adminPath() . '/leads');
		}
	}

	public function login(Request $request)
	{
		$client = Client::find(3);
		$request->request->add(
			[
				'username' => $request->email,
				'password' => $request->password,
				'client_id' => $client->id,
				'client_secret' => $client->secret,
				'grant_type' => 'password',
				'response_type' => 'code',
				'scope' => '',
			]
		);
		$leads = @Lead::where('email', $request->email)->first();
		if (count($leads) > 0) {
			$tokenRequest = Request::create(
				env('APP_URL') . '/oauth/token',
				'post'
			);
			$response = json_decode(Route::dispatch($tokenRequest)->getContent());
			if (@$response->access_token) {
				return ['status' => true, $response];
			} else {
				return ['status' => 'no token'];
			}
		} else {
			return ['status' => 'no lead'];
		}
	}
	public function send_cil(Request $request)
	{
		$lead = @Lead::find($request->lead_id);
		$file = $request->file;
		$project = 0;
		for ($x = 0; $x < count($request->developers); $x++) {
			$rules = [
				"developers" => 'required',
				"projects" => 'required',
			];
			$validator = Validator::make($request->all(), $rules);
			if ($validator->fails()) {
				return back()->withInput()->withErrors($validator);
			}else{
				if($request->developers[$x] && $request->projects[$x]){
					$cil = new Cil;
					$cil->lead_id = $request->lead_id;
					$cil->developer_id = $request->developers[$x];
					$cil->user_id=auth()->user()->id;
					$cil->status = 'not_sent';
					$cil->project_id = $request->projects[$x];
					$cil->save();
					$developer = @Developer::find($request->developers[$x]);
					if ($request->projects[$x]) {
						$project = $request->projects[$x];
					}
				}else{
					return back()->withInput()->withErrors(['errors'=>['Project and developer must be selected.']]);
				}
			}

			// try{
			// \Mail::send('admin.leads.cil', ['lead' => $lead,
			// 	'project' => $project,
			// 	'file' => $file], function ($message) use ($developer) {
			// 	$message->to($developer->email)->subject('CIL');
			// 	});
			// }
			// catch(\Exception $e){
			// 	// Never reached
			// 	dd($e);
			// }
		}
		session()->flash('success', trans('admin.sent'));
		return back();
	}
	public function website_login(Request $request) {
		$rules = [
			'email' => 'email|required',
			'password' => 'required',
		];
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return back()->withInput()->withErrors($validator);
		} else {
			// dd($request->all());
			if (auth()->guard('lead')->attempt(['email' => $request->email, 'password' => $request->password])) {
				return redirect()->intended('/');
			} else {
				//dd($request->all());
				session()->flash('error', trans('error'));
				return back()->withInput();
			}
		}
	}
	public function website_logout() {
		auth('lead')->logout();
		return redirect('/');
	}
	public function add_lead(Request $request) {
		$rules = [
			'email' => 'email',
			'password' => 'required',
			'passwordConfirm' => 'same:password',
		];
		$validator = Validator::make($request->all(), $rules);
		$validator->SetAttributeNames([
		]);
		if ($validator->fails()) {
			return back()->withInput()->withErrors($validator);
		} else {
			$phone_exist = Lead::where('phone', $request->phone)->count();
			$email_exist = Lead::where('email', $request->email)->count();
			if ($phone_exist > 0 || $email_exist > 0) {
				if ($phone_exist > 0) {
					$connected_lead = Lead::where('phone', $request->phone)->first();
					$connected_lead->confirm = 1;
					$connected_lead->password = bcrypt($request->password);
					$connected_lead->last_name = $request->lName;
					$connected_lead->middle_name = $request->mName;
					$connected_lead->first_name = $request->fName;
					$connected_lead->save();
				}
				if ($email_exist > 0) {
					$connected_lead = Lead::where('email', $request->email)->first();
					$connected_lead->confirm = 1;
					$connected_lead->password = bcrypt($request->password);
					$connected_lead->last_name = $request->lName;
					$connected_lead->middle_name = $request->mName;
					$connected_lead->first_name = $request->fName;
					$connected_lead->save();
				}
			} else {
				$lead = new Lead;
				$lead->first_name = $request->fName;
				if ($request->mName != null) {
					$lead->middle_name = $request->mName;
				}
				$lead->last_name = $request->lName;
				$lead->phone = $request->phone;
				$lead->email = $request->email;
				$lead->password = bcrypt($request->password);
				$lead->lead_source_id = 0;
				$lead->agent_id = 0;
				$lead->user_id = 0;
				$lead->save();
				if (@auth()->guard('lead')->attempt(['email' => $request->email, 'password' => $request->password])) {
					return redirect()->intended('/');
				} else {
					return redirect('login');
				}
			}
			return redirect('/');
		}
	}
	public function autoSwitch(Request $request, $newArr = []) {
		$restOfSelectedLeads = [];
		if(count($newArr) == 0){
			$selectedLeads = $request->selectedLeads;
		}
		else{
			$selectedLeads = $newArr;
		}
		if($request->agent_id){
			foreach ($request->agent_id as $key => $rAgent) {
				$splicedArr = array_splice( $selectedLeads , 0 , $request->perAgent );
				foreach ($splicedArr as $key => $lead) {
					$getLead = \App\Lead::find($lead['id']);
					$getLead->agent_id = $rAgent['id'];
					$getLead->save();
				}
			}
			if($request->perAgent <= count($request->agent_id)){
				$restOfSelectedLeads = array_splice( $selectedLeads , $request->perAgent , count($selectedLeads));
			}else{
				$restOfSelectedLeads = [];
			}
		}

		// if (count($newArr) == 0){
		// 	$selectedLeads = $request->selectedLeads;
		// }
		// else{
		// 	$selectedLeads = $newArr;
		// }
			
		if($request->commercial_agent_id){
			foreach ($request->commercial_agent_id as $key => $cAgent) {
				$splicedArr = array_splice( $selectedLeads , 0 , $request->perAgent );
				foreach ($splicedArr as $key => $lead) {
					$getLead = \App\Lead::find($lead['id']);
					$getLead->commercial_agent_id = $cAgent['id'];
					$getLead->save();
				}
			}
			if($request->perAgent <= count($request->commercial_agent_id)){
				$restOfSelectedLeads = array_splice( $selectedLeads , $request->perAgent , count($selectedLeads));
			}else{
				$restOfSelectedLeads = [];
			}
		}	
		if ( count($restOfSelectedLeads) != 0 )
			$this->autoSwitch($request, $restOfSelectedLeads);

		return ['status'=>'okay'];

	}
	///////////////////////////////////////////////////////////////////////////////
	public function updatelead(Request $request)
	{
		// dd($request->all());
		$leads = Lead::where('id',$request->lead_id)->first();
		if(!empty($request->first_name and $request->last_name)){
			$lead->full_name = $request->first_name.' '.$request->last_name;
		}
		if($request->first_name){
			$leads->first_name = $request->first_name;
		}
		if($request->last_name){
			$leads->last_name = $request->last_name;
		}
		if($request->ar_first_name){
			$leads->ar_first_name = $request->ar_first_name;
		}
		if($request->ar_last_name){
			$leads->ar_last_name = $request->ar_last_name;
		}
		if($request->phone){
			$leads->phone = $request->phone;
		}
		if($request->religion){
			$leads->religion = $request->religion;
		}
		if($request->country_id){
			$leads->country_id = $request->country_id;
		}
		if($request->city_id){
			$leads->city_id = $request->city_id;
		}
		if($request->facebook){
			$leads->facebook = $request->facebook;
		}
		$leads->update();
		return response()->json([
			'status' => 200,
			'massege' => 'lead updated'
		]);
	}
	///////////////////////////////////////////////////////////////////////////////
	public function switch_leads(Request $request) {
		// dd($request->all());
		$rules = [
			// 'agent_id' => 'required|max:191',
			// 'leads' => 'required',
		];
		$validator = Validator::make($request->all(), $rules);
		$validator->SetAttributeNames([
			'agent_id' => trans('admin.agent'),
			'commercial_agent_id' => trans('admin.commercial_agent_id'),
			'leads' => trans('admin.leads'),
		]);
		if ($validator->fails()) {
			return back()->withInput()->withErrors($validator);
		} else {
			$leads = array_unique($request->leads);
			foreach ($leads as $lead) {
				$m = Lead::find($lead);
				DB::table('to_dos')->where('leads',$m->id)
					->where(function ($query) use ($m) {
						$query->where('user_id', '=', $m->agent_id)
							->orWhere('user_id', '=', $m->commercial_agent_id);
					})->delete();
				$r_agent = $m->agent_id;
				$c_agent = $m->commercial_agent_id;
				if($request->has('agent_id') && $request->agent_id != null){
					$m->agent_id = $request->agent_id;
					$m->created_at = \Carbon\Carbon::now()->toDateTimeString();
				}
				$m->user_id = auth()->user()->id;
				// $agent_lead = Lead::find($leads);
				// foreach ($agent_lead as  $val) {
				//     $m->agent_flag=$val->agent_id;
				// }
				if ($request->has('commercial_agent_id') && null != $request->commercial_agent_id) {
					$user = User::find($m->agent_id);
					$m->created_at = \Carbon\Carbon::now()->toDateTimeString();
					if ($user && $user->residential_commercial == 'commercial') {
						$m->agent_id = 0; // eslam is here
					}
					$m->commercial_agent_id = $request->commercial_agent_id;
				}
				$saved = $m->save();

				if(!empty($request->probability_status)){
					$updateCalls = call::where('lead_id',$lead)->first();
					// dd($updateCalls);
					$updateCalls->probability_status = 1;
					$updateCalls->update();
				}

				// $agent = User::where('id', $request->agent_id)->orWhere('id', $request->commercial_agent_id)->get();
				// $message = " Lead \" $m->first_name $m->first_name \" assigned to you .";
				// $url = url(adminPath() . '/leads/' . $m->id);
				// $leadqs = [];
				// $leadqs['data'] = $this->getleadd($m->id);
				// $leadqs['activityToBeOpened'] = "lead";
				// foreach ($agent as $a) {
				// 	foreach ($a->player as $p) {
				// 		$url2 = $url;
				// 		if ("ios" == $p->device || "android" == $p->device) {
				// 			$url2 = null;
				// 		}
				// 		sendOne($message, $p->player_id, $url2, $leadqs);
				// 	}
				// }
	
			}
			if($saved > 0 ){
				foreach ($request->leads as $lead) {
					$noti = new AdminNotification;
					$noti->user_id = Auth::user()->id;
					if(!empty($request->agent_id)){
						$noti->assigned_to = $request->agent_id;
					}elseif($request->commercial_agent_id){
						$noti->assigned_to = $request->commercial_agent_id;
					}
					$noti->type = 'switch';
					$noti->type_id = $lead ;
					$noti->status = 0;
					$noti->save();
				}
			}
		$body = "";
			$dataId = null;
			if (count($leads) > 1) {
				$data = 'bulk';
				$body = "Yohoo .. New bulk leads has been switched to you";
				// $dataId = $leads[$k];
				$content = [
					'type' => 'lead',
					'id' => $leads,
					'lead_id' => "",
					'content-available' => 1,
				];
			} else {
				$l = Lead::find($leads[0]);
				$data = __('admin.' . $l->prefix_name) . ' ' . $l->first_name;
				$body = 'Yohoo .. New lead ( ' . $data . ' ) has been switched to you';
				$dataId = $leads[0];
				$content = [
					'type' => 'lead',
					'id' => $leads,
					'content-available' => 1,
					'lead_id' => $l->id];
			}
			$agent = @User::find($request->agent_id);
			$agent_name = @$agent->name;
			$notification = auth()->user()->name . ' ' . __('admin.has_switched') . ' ' . $data . ' ' . __('admin.to') . ' ' . $agent_name;

		// if ($request->agent_id) {
		// 	$oldNoti = AdminNotification::where('type', 'switch')->where('type_id', $dataId)->where('assigned_to' , $r_agent)->get();
		// 	if (! $oldNoti->isEmpty() ) {
		// 		$oldNoti->first()->delete();
		// 	}
		// 	$not = new AdminNotification;
		// 	$not->user_id = auth()->user()->id;
		// 	$not->assigned_to = $request->agent_id;
		// 	$not->type = 'switch';
		// 	$not->type_id = $dataId;
		// 	$not->save();
		// }
		// if ($request->commercial_agent_id) {
		// 	$not = new AdminNotification;
		// 	$not->user_id = auth()->user()->id;
		// 	$not->assigned_to = $request->commercial_agent_id;
		// 	$not->type = 'switch';
		// 	$not->type_id = $dataId;
		// 	$not->save();
		// }
			/*
			$tokens = User::where('refresh_token', '!=', '')->where('id', $request->agent_id)->pluck('refresh_token')->toArray();
			$msg = [
				'title' => __('admin.leads', [], 'en'),
				'body' => $body,
				'image' => 'myIcon',
				'sound' => 'res_notif_sound'
			];
			try {
				$res = notify1($tokens, $msg, $content);
				$leadsData = @Lead::find($leads);
				$source = @LeadSource::find($leadsData[0]->lead_source_id)->name;
				foreach ($leadsData as $leadData) {
					if ($leadData->email) {
						if (filter_var($leadData->email, FILTER_VALIDATE_EMAIL)) {
							// Mail::send('admin.leads.lead_switch_lead', ['lead' => $leadData, 'agent' => $agent], function ($message) use ($leadData, $agent) {
							// $message->to(@$leadData->email)->subject('You have been switched to ' . $agent->name);
							// });
						}
					}
				}
				if (filter_var(@$agent->email, FILTER_VALIDATE_EMAIL)) {

				}
			} catch (\Swift_TransportException $e) {
				session()->flash('success', trans('admin.switched'));
				session()->flash('notification', $notification);
				session()->flash('assigned_to', $request->agent_id);
				return back();
			}
			*/
			session()->flash('success', trans('admin.switched'));
			session()->flash('notification', $notification);
			session()->flash('assigned_to', $request->agent_id);
		}
	}
///////////////////////////////////////////////////////////////////////////////////////////////
	public function update_lead(Request $request)
	{
		$new_cities = '';
		$id = $request->id;
		$type = $request->type;
		$value = $request->value;
		if ('birth_date' == $type) {
			$value = strtotime($request->value);
		}
		$lead = Lead::find($id);
		$lead->$type = $value;
		$lead->save();
		if ('nationality' == $type) {
			$value = Country::find($value)->name;
		}
		if ('industry_id' == $type) {
			$value = Industry::find($value)->name;
		}
		if ('religion' == $type) {
			$value = __('admin.' . $value);
		}
		if ('birth_date' == $type) {
			$value = date('Y/m/d', $value);
		}
		if ('facebook' == $type) {
			$value = '<a href="https://www.facebook.com/' . $value . '" target="_blank"><b><i class="fa fa-facebook" aria-hidden="true"></i></b></a>';
		}
		if ('country_id' == $type) {
			$new_cities = '';
			$new_cities .= '<option></option>';
			foreach (City::where('country_id', $value)->get() as $country) {
				$new_cities .= '<option value="' . $country->id . '">' . $country->name . '</option>';
			}
			$value = Country::find($value)->name;
		}
		if ('city_id' == $type) {
			$value = City::find($value)->name;
		}
		return response()->json([
			'value' => $value,
			'type' => $type,
			'new_cities' => $new_cities,
		]);
	}
	public function website_profile()
	{
		$lead = Lead::find(auth('lead')->user()->id);
		return view('website.profile', compact('lead'));
	}
	public function website_profile_update(Request $request)
	{
		$rules = [
			'first_name' => 'required|max:191',
			'last_name' => 'required|max:191',
			'email' => 'required|email',
			'phone' => 'required|numeric|unique:leads,phone,' . auth('lead')->user()->id . ',id',
			'image' => 'image',
		];
		$validator = Validator::make($request->all(), $rules);
		$validator->SetAttributeNames([
			'first_name' => trans('admin.first_name'),
			'last_name' => trans('admin.last_name'),
			'email' => trans('admin.email'),
			'phone' => trans('admin.phone'),
			'image' => trans('admin.image'),
		]);
		if ($validator->fails()) {
			return back()->withInput()->withErrors($validator);
		} else {
			$lead = Lead::find(auth('lead')->user()->id);
			$lead->first_name = $request->first_name;
			$lead->middle_name = $request->middle_name;
			$lead->last_name = $request->last_name;
			$lead->phone = $request->phone;
			$lead->email = $request->email;
			if ($request->has('image')) {
				$lead->image = $request->file('image')->store('uploads');
			}
			$lead->save();
			return back();
		}
	}
	public function change_password(Request $request)
	{
		$lead = Lead::find(auth('lead')->user()->id);
		if ($request->password == $request->confirm_password) {
			dump($request->current_password);
			if (Hash::check($request->current_password, $lead->password)) {
				$lead->password = bcrypt($request->password);
				$lead->save();
				return back();
			} else {
				return 'not';
			}
		} else {
			return back();
		}
	}
	public function lead_properties()
	{
		if (auth('lead')->user()) {
			$resale = ResaleUnit::where('lead_id', auth('lead')->user->id)->get();
			$rental = ResaleUnit::where('lead_id', auth('lead')->user->id)->get();
			return view('website.my_properties', compact('rental', 'resale'));
		} else {
			return redirect('lead_login');
		}
	}
	public function add_properties()
	{
		if (auth('lead')->user()) {
			$facilities = @Facility::all();
			$locations = Location::all();
			return view('website.add_properties', compact('facilities', 'locations'));
		} else {
			return redirect('lead_login');
		}
	}
	public function interested(Request $request)
	{
		if (auth('lead')->guest()) {
			$rules = [
				'first_name' => 'required|max:191',
				'last_name' => 'required|max:191',
				'phone' => 'required|numeric|unique:leads',
				'email' => 'required|email|unique:leads',
				'image' => 'image',
			];
			$validator = Validator::make($request->all(), $rules);
			$validator->SetAttributeNames([
				'first_name' => trans('admin.first_name'),
				'last_name' => trans('admin.last_name'),
				'middle_name' => trans('admin.middle_name'),
				'email' => trans('admin.email'),
				'phone' => trans('admin.phone'),
			]);
			if ($validator->fails()) {
				return back()->withInput()->withErrors($validator);
			} else {
				$lead = new Lead();
				$lead->first_name = $request->first_name;
				$lead->last_name = $request->last_name;
				$lead->phone = $request->phone;
				$lead->lead_source_id = 24;
				$lead->agent_id = $request->agent_id;
				$lead->user_id = $request->user_id;
				$lead->save();
				$interest = new Interested();
				$interest->lead_id = $lead->id;
				$interest->unit_id = $request->project_id;
				$interest->type = $request->type;
				$interest->save();
				$noti = new AdminNotification;
				$noti->user_id = 0;
				$noti->assigned_to = $lead->agent_id;
				$noti->type = 'interest';
				$noti->type_id = $interest->id;
				$noti->status = 0;
				$noti->save();
				session()->flash('success', trans('admin.thank_you'));
				return redirect(URL::previous().'/#thank-you')
				->with([
					'leadSource' =>  $lead->lead_source_id,
					'email' =>  $request->email,
					'first_name' => $request->first_name,
					'last_name' => $request->last_name,
					'phone' => $request->phone
					]);
			}
		} else {
			if (!Interested::where('lead_id', auth('lead')->user()->id)->where('unit_id', $request->project_id)->where('type', $request->type)->first()) {
				$interest = new Interested();
				$interest->lead_id = auth('lead')->user()->id;
				$interest->unit_id = $request->project_id;
				$interest->type = $request->type;
				$interest->save();
				$noti = new AdminNotification;
				$noti->user_id = 0;
				$noti->assigned_to = auth('lead')->user()->agent_id;
				$noti->type = 'interest';
				$noti->type_id = $interest->id;
				$noti->status = 0;
				$noti->save();
				session()->flash('success', trans('admin.thank_you'));
				return redirect(URL::previous().'/#thank-you')
				->with([
					'leadSource' =>  $lead->lead_source_id,
					'email' =>  $request->email,
					'first_name' => $request->first_name,
					'last_name' => $request->last_name,
					'phone' => $request->phone
					]);
				// return back();
			} else {
				session('error', 'already there');
				return back();
			}
		}
	}
	public function favorite()
	{
		$favorites = Favorite::where('lead_id', auth('lead')->user()->id)->get();
		return view('website.favorite_properties', compact('favorites'));
	}
	public function leads_ajax(Request $request)
	{
		/*if($request->seen=='seen'){
		$leads = Lead::where('agent_id', auth()->id())->where('seen','>',0)->get();
		}else{
		$leads = Lead::where('agent_id', auth()->id())->where('seen',0)->get();
		 */
		// $leads = Lead::orderBy('seen');
		$leads = Lead::where(function($query){
			$query->where('agent_id', auth()->id())->orWhere('commercial_agent_id', auth()->id());
		})->orderBy('created_at', 'desc')->orderBy('seen');
		if ($request->target) {
			if ("facebook" == $request->target) {
				$leads = $leads->where("lead_source_id", 7); // facebook
				$leads = $leads->get();
			} elseif ("coldCalls" == $request->target) {
				$leads = $leads->where("lead_source_id", 28); // Cold Calls
				$leads = $leads->get();
			} elseif ("followUp" == $request->target) {
				$leads = $leads->whereHas('lead_actions', function ($q) {
					$q->where("id", '>', 0);
				});
				$leads = $leads->get();
			} else {
				$coll = null;
				$lowest = [];
				$highest = [];
				$high = [];

				$switch = Lead::where("agent_id", auth()->user()->id)->whereRaw("agent_id <> agent_flag")->get(); // switched to me

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
				if ("lowest" == $request->target) {
					$coll = collect($lowest);
					$leads = $coll;
				} elseif ("high" == $request->target) {
					$coll = collect($high);
					$leads = $coll;
				} elseif ("highest" == $request->target) {
					$coll = collect($highest);
					$leads = $coll;
				} elseif ("switch" == $request->target) {
					$switch = collect($switch);
					$leads = $switch;
				}
			}
		} else {
			$leads = Lead::where('agent_id', auth()->id())->orderBy('created_at', 'desc')->orderBy('seen')->get();
		}

		foreach ($leads as $lead) {
			$seen = 'not_seen';
			$sColor = 'red';

			if ($lead->seen) {
				$seen = 'seen_without_action';
				$sColor = 'orange';
				$lead->seen = 1;
				if (DB::table('lead_actions')->where('lead_id', $lead->id)->count()) {
					$seen = 'seen_with_action';
					$sColor = 'green';
					$lead->seen = 2;
				}
			} else {
				$lead->seen = 0;
			}
			//$lead->seen = '<i class="fa fa-circle" aria-hidden="true" style="color: ' . $sColor . '"></i>';

			$lastCall = Call::where('lead_id', $lead->id)->orderBy('id', 'desc')->first();
			$lastMeeting = Meeting::where('lead_id', $lead->id)->orderBy('id', 'desc')->first();

			if (@$lastCall->created_at->timestamp > @$lastMeeting->created_at->timestamp) {
				@$leadProbability = $lastCall->probability;
			} else {
				@$leadProbability = $lastMeeting->probability;
			}
			if (!$leadProbability) {
				$leadProbability = 'Follow Up';
			}
			$lead->probability = __('admin.' . $leadProbability);
			$lead->checkbox = '<div class="checkbox">
									<label>
										<input class="switch_teams  checked" name="checked_leads[]"id="checked_leads" type="checkbox"
											   value="' . $lead->id . '">
										<span class="cr"><i class="cr-icon fa fa-check"></i></span>
									</label>
								</div>';
			$commercialAgents = User::where('residential_commercial', 'commercial')->pluck('id')->toArray();
			$residentialAgents = User::where('residential_commercial', 'residential')->pluck('id')->toArray();
			$color = '';
			if (DB::table('lead_actions')->whereIn('user_id', $commercialAgents)->where('lead_id', $lead->id)->count() > 0) {
				$color = 'color:green;';
			} else {
				$color = 'color:red';
			}
			$color2 = '';
			if (DB::table('lead_actions')->whereIn('user_id', $residentialAgents)->where('lead_id', $lead->id)->count() > 0) {
				$color2 = 'color:green;';
			} else {
				$color2 = 'color:red';
			}
			$lead->commercial_status = "<i class='fa fa-circle' aria-hidden='true' style='{$color}'></i>";
			$lead->personal_status = "<i class='fa fa-circle' aria-hidden='true' style='{$color2}'></i>";
			$lead->name = $lead->first_name . ' ' . $lead->last_name;
			$lead->email = '<a href="mailto:' . $lead->email . '">' . $lead->email . '</a>';
			// $lead->source = @LeadSource::find($lead->lead_source_id)->name;
			$ques = @Req::where('lead_id', $lead->id)->with('loc')->orderBy('created_at', 'desc')->first();
			$r = @$ques->loc;
			if (null != $r) {
				$lead->source = $r->en_name;
			} else {
				$lead->source = '';
			}

			$lead->agent = @Project::find($ques->project_id)->en_name;
			// $lead->agent = @User::find($lead->agent_id)->name;

			if (@Req::where('lead_id', $lead->id)->where('unit_type', 'residential')->where('unit_type', 'commercial')->count() > 0) {
				$leadType = __('admin.residential') . ' - ' . __('admin.commercial');
			} elseif (@Req::where('lead_id', $lead->id)->where('unit_type', 'residential')->where('unit_type', '!=', 'commercial')->count() > 0) {
				$leadType = __('admin.residential');
			} elseif (@Req::where('lead_id', $lead->id)->where('unit_type', '!=', 'residential')->where('unit_type', 'commercial')->count() > 0) {
				$leadType = __('admin.commercial');
			} else {
				$leadType = __('admin.residential');
			}

			$lead->type = $leadType;

			if ($lead->favorite) {
				$color = 'color: #caa42d';
			} else {
				$color = '';
			}

			$lead->fav = '<i class="fa fa-star Fav" id="Fav' . $lead->id . '" count="' . $lead->id . '" style="' . $color . '"></i>';

			if ($lead->hot) {
				$color = 'color: #dd4b39';
			} else {
				$color = '';
			}
			$lead->hot = '<i class="fa fa-fire Hot" id="Hot' . $lead->id . '" count="' . $lead->id . '" style="' . $color . '"></i>';
			$lead->option = '<select class="form-control"  onchange="' . "if(this.value=='del'){\$('#delete$lead->id').modal('show');} else{location = this.value;}" . '">
			<option value="#" disabled selected >Options</option>
			<option value="' . url(adminPath() . '/leads/' . $lead->id) . '">' . trans('admin.show') . '</option>
			<option value="' . url(adminPath() . '/leads/' . $lead->id . '/edit') . '">' . trans('admin.edit') . '</option>
			<option value="del" class="btn btn-danger btn-flat">' . trans('admin.delete') . '</option>
			</select>
				<div id="delete' . $lead->id . '" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">' . trans('admin.delete') . ' ' . trans('admin.lead') . '</h4>
							</div>
							<div class="modal-body">
								<p>' . trans('admin.delete') . ' ' . $lead->name . '</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default btn-flat"
										data-dismiss="modal">' . trans('admin.close') . '</button>
								<a class="btn btn-danger btn-flat" href="' . url(adminPath() . '/delete-lead/' . $lead->id) . '">' . trans('admin.delete') . '</a>
							</div>
						</div>
					</div>
				</div>
			';
			/*$lead->show = '<a href="' . url(adminPath() . '/leads/' . $lead->id) . '" class="btn btn-primary btn-flat">' . trans('admin.show') . '</a>';
							$lead->edit = '<a href="' . url(adminPath() . '/leads/' . $lead->id . '/edit') . '" class="btn btn-warning btn-flat"> ' . trans('admin.edit') . '</a>';
							$lead->delete = '<a data-toggle="modal" data-target="#delete' . $lead->id . '" class="btn btn-danger btn-flat">' . trans('admin.delete') . '</a>
								<div id="delete' . $lead->id . '" class="modal fade" role="dialog">
									<div class="modal-dialog">
										<!-- Modal content-->
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">' . trans('admin.delete') . ' ' . trans('admin.lead') . '</h4>
											</div>
											<div class="modal-body">
												<p>' . trans('admin.delete') . ' ' . $lead->name . '</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default btn-flat"
														data-dismiss="modal">' . trans('admin.close') . '</button>
												<a class="btn btn-danger btn-flat" href="' . url(adminPath() . '/delete-lead/' . $lead->id) . '">' . trans('admin.delete') . '</a>
											</div>
										</div>
									</div>
			*/
			$lead->hint = '<td><a onclick="showHintSpan(' . $lead->id . ')"><i class="fa fa-eye" aria-hidden="true"></a></i></td>';
			$agents_res = '';
			$agents = '';
			foreach (User::where('residential_commercial','residential')->get() as $agent) {
				$agents_res .= '<option value="' . $agent->id . '">' . $agent->name . '</option>';
			}
			foreach(User::where('residential_commercial','commercial')->get() as $agent){
				$agents .= '<option value="' . $agent->id . '">' . $agent->name . '</option>';
			}
			$lead->switch = '<a data-toggle="modal" data-target="#switch' . $lead->id . '" class="btn btn-x btn-success btn-flat">' . trans('admin.switch') . '</a>
					<div id="switch' . $lead->id . '" class="modal fade" role="dialog">
						<div class="modal-dialog">
							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">' . trans('admin.switch') . ' ' . trans('admin.lead') . '</h4>
								</div>
								<form action="' . url(adminPath() . '/switch_leads') . '" method="post">
								' . csrf_field() . '
								<div class="modal-body">
								<label> ' . trans('admin.personal') . ' ' . trans('admin.agent') . ' </label>
								   <div class="">
									<select class="select2" name="agent_id"
											data-placeholder="' . __('admin.agent') . '" style="width: 100%">
										<option></option>
										' . $agents_res . '
									</select>
									<input type="hidden" value="' . $lead->id . '" name="leads[]">
									</div>
								</div>
								<div class="modal-body">
								<label> ' . trans('admin.commercial') . ' ' . trans('admin.agent') . ' </label>
								   <div class="">
								<select class="select2" name="commercial_agent_id"
										data-placeholder="' . __('admin.agent') . '" style="width: 100%">
									<option></option>
									' . $agents . '
								</select>
								</div>
									<input type="hidden" value="' . $lead->id . '" name="leads[]">
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default btn-flat"
											data-dismiss="modal">' . trans('admin.close') . '</button>
									<button type="submit"
											class="btn btn-success btn-flat">' . trans('admin.switch') . '</button>
								</div>
								</form>
							</div>
						</div>
					</div>
					<script>
					$(".select2").select2();
		</script>';
		}
		return \DataTables::of($leads)->
			escapeColumns('')->
			make(true);
	}
	public function team_leads_ajax()
	{
		$leads = Lead::getTeamLeads();
		$commercialAgents = @\App\User::where('residential_commercial', 'commercial')->pluck('id')->toArray();
		$residentialAgents = @\App\User::where('residential_commercial', 'residential')->pluck('id')->toArray();
		foreach ($leads as $lead) {
			$lead->checkbox = '<div class="checkbox">
									<label>
										<input class="switch" name="checked_leads[]" type="checkbox"
											   value="' . $lead->id . '">
										<span class="cr"><i class="cr-icon fa fa-check"></i></span>
									</label>
								</div>';
			if (Auth()->user()->residential_commercial == 'residential') {
				if (DB::table('lead_actions')->whereIn('user_id', $residentialAgents)->where('lead_id', $lead->id)->count() > 0) {
					$lead->residential_commercial = '<i class="fa fa-circle " style="color:green;"></i>';
				} else {
					$lead->residential_commercial = '<i class="fa fa-circle "  style="color:red;"></i>';
					// code...
				}
			}
			if (Auth()->user()->residential_commercial == 'commercial') {
				if (DB::table('lead_actions')->whereIn('user_id', $commercialAgents)->where('lead_id', $lead->id)->count() > 0) {
					$lead->residential_commercial = '<i class="fa fa-circle "  count="" style="color:green;"></i>';
				} else {

					$lead->residential_commercial = '<i class="fa fa-circle "  count="" style=" color:red"></i>';
				}
			}

			$lead->name = @User::find($lead->agent_id)->name;
			$lead->name_com_agent = @User::find($lead->commercial_agent_id)->name;
			$lead->name_agent = $lead->first_name . ' ' . $lead->last_name;
			$lead->email = '<a href="mailto:' . $lead->email . '">' . $lead->email . '</a>';
			$lead->source = @LeadSource::find($lead->lead_source_id)->name;
			$lead->agent = @User::find($lead->agent_id)->name;
			if ($lead->favorite) {
				$color = 'color: #caa42d';
			} else {
				$color = '';
			}

			$lead->fav = '<i class="fa fa-star Fav" id="Fav' . $lead->id . '" count="' . $lead->id . '" style="' . $color . '"></i>';

			if ($lead->hot) {
				$color = 'color: #dd4b39';
			} else {
				$color = '';
			}
			// $lead->hot = '<i class="fa fa-eye Hot" id="Hot' . $lead->id . '" count="' . $lead->id . '" style="' . $color . '"></i>';
			$lead->hint = '<td><a onclick="showHintSpan(' . $lead->id . ')"><i class="fa fa-eye" aria-hidden="true"></a></i></td>';
			$lead->option = '<select class="form-control"  onchange="' . "if(this.value=='del'){\$('#delete$lead->id').modal('show');} else{location = this.value;}" . '">
			<option value="#" disabled selected >Options</option>
			<option value="' . url(adminPath() . '/leads/' . $lead->id) . '">' . trans('admin.show') . '</option>
			<option value="' . url(adminPath() . '/leads/' . $lead->id . '/edit') . '">' . trans('admin.edit') . '</option>
			<option value="del" class="btn btn-danger btn-flat">' . trans('admin.delete') . '</option>
			</select>
				<div id="delete' . $lead->id . '" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">' . trans('admin.delete') . ' ' . trans('admin.lead') . '</h4>
							</div>
							<div class="modal-body">
								<p>' . trans('admin.delete') . ' ' . $lead->name . '</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default btn-flat"
										data-dismiss="modal">' . trans('admin.close') . '</button>
								<a class="btn btn-danger btn-flat" href="' . url(adminPath() . '/delete-lead/' . $lead->id) . '">' . trans('admin.delete') . '</a>
							</div>
						</div>
					</div>
				</div>
			';
			/*            $lead->show = '<a href="' . url(adminPath() . '/leads/' . $lead->id) . '" class="btn btn-primary btn-flat">' . trans('admin.show') . '</a>';
										$lead->edit = '<a href="' . url(adminPath() . '/leads/' . $lead->id . '/edit') . '" class="btn btn-warning btn-flat"> ' . trans('admin.edit') . '</a>';
										$lead->delete = '<a data-toggle="modal" data-target="#delete' . $lead->id . '" class="btn btn-danger btn-flat">' . trans('admin.delete') . '</a>
											<div id="delete' . $lead->id . '" class="modal fade" role="dialog">
												<div class="modal-dialog">
													<!-- Modal content-->
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">' . trans('admin.delete') . ' ' . trans('admin.lead') . '</h4>
														</div>
														<div class="modal-body">
															<p>' . trans('admin.delete') . ' ' . $lead->name . '</p>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default btn-flat"
																	data-dismiss="modal">' . trans('admin.close') . '</button>
															<a class="btn btn-danger btn-flat" href="' . url(adminPath() . '/delete-lead/' . $lead->id) . '">' . trans('admin.delete') . '</a>
														</div>
													</div>
												</div>
			*/
			$agents_res = '';
			$agents = '';
			foreach (User::where('residential_commercial','residential')->get() as $agent) {
				$agents_res .= '<option value="' . $agent->id . '">' . $agent->name . '</option>';
			}
			foreach(User::where('residential_commercial','commercial')->get() as $agent){
				$agents .= '<option value="' . $agent->id . '">' . $agent->name . '</option>';
			}
			$lead->switch = '<a data-toggle="modal" data-target="#switch' . $lead->id . '" class="btn btn-x btn-success btn-flat">' . trans('admin.switch') . '</a>
					<div id="switch' . $lead->id . '" class="modal fade" role="dialog">
						<div class="modal-dialog">
			  <form action="' . url(adminPath() . '/switch_leads') . '" method="post">
			  ' . csrf_field() . '
							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">' . trans('admin.switch') . ' ' . trans('admin.lead') . '</h4>
								</div>
								<div class="modal-body">
								<label> ' . trans('admin.personal') . ' ' . trans('admin.agent') . ' </label>
								   <div class="">
									<select class="select2" name="agent_id"
											data-placeholder="' . __('admin.agent') . '" style="width: 100%">
										<option></option>
										' . $agents_res . '
									</select>
									<input type="hidden" value="' . $lead->id . '" name="leads[]">
									</div>
								</div>
								<div class="modal-body">
								<label> ' . trans('admin.commercial') . ' ' . trans('admin.agent') . ' </label>
								   <div class="">
								<select class="select2" name="agent_id"
										data-placeholder="' . __('admin.agent') . '" style="width: 100%">
									<option></option>
									' . $agents . '
								</select>
								</div>
									<input type="hidden" value="' . $lead->id . '" name="leads[]">
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default btn-flat"
											data-dismiss="modal">' . trans('admin.close') . '</button>
									<button type="submit"
											class="btn btn-success btn-flat">' . trans('admin.switch') . '</button>
								</div>

							</div>
			</form>
						</div>
					</div>
					<script>
					$(".select2").select2();
		</script>';
		}
		return \DataTables::of($leads)->
			escapeColumns('')->
			make(true);
	}
	public function leads_ind_ajax()
	{
		if (auth()->user()->type == 'admin') {
			$leads = @Lead::where('agent_id', 0)->orWhere('agent_id', null)->get();
			foreach ($leads as $lead) {
				$lead->checkbox = '<div class="checkbox">
									<label>
										<input class="switch_teams" name="checked_leads[]" type="checkbox"
											   value="' . $lead->id . '">
										<span class="cr"><i class="cr-icon fa fa-check"></i></span>
									</label>
								</div>';
				$lead->name = $lead->first_name . ' ' . $lead->last_name;
				$lead->email = '<a href="mailto:' . $lead->email . '">' . $lead->email . '</a>';
				$lead->source = @LeadSource::find($lead->lead_source_id)->name;
				$lead->option = '<select class="form-control"  onchange="' . "if(this.value=='del'){\$('#delete$lead->id').modal('show');} else{location = this.value;}" . '">
				<option value="#" disabled selected >Options</option>
				<option value="' . url(adminPath() . '/leads/' . $lead->id) . '">' . trans('admin.show') . '</option>
				<option value="' . url(adminPath() . '/leads/' . $lead->id . '/edit') . '">' . trans('admin.edit') . '</option>
				<option value="del" class="btn btn-danger btn-flat">' . trans('admin.delete') . '</option>
				</select>
					<div id="delete' . $lead->id . '" class="modal fade" role="dialog">
						<div class="modal-dialog">
							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">' . trans('admin.delete') . ' ' . trans('admin.lead') . '</h4>
								</div>
								<div class="modal-body">
									<p>' . trans('admin.delete') . ' ' . $lead->name . '</p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default btn-flat"
											data-dismiss="modal">' . trans('admin.close') . '</button>
									<a class="btn btn-danger btn-flat" href="' . url(adminPath() . '/delete-lead/' . $lead->id) . '">' . trans('admin.delete') . '</a>
								</div>
							</div>
						</div>
					</div>
				';
				/*              $lead->show = '<a href="' . url(adminPath() . '/leads/' . $lead->id) . '" class="btn btn-primary btn-flat">' . trans('admin.show') . '</a>';
													$lead->edit = '<a href="' . url(adminPath() . '/leads/' . $lead->id . '/edit') . '" class="btn btn-warning btn-flat"> ' . trans('admin.edit') . '</a>';
													$lead->delete = '<a data-toggle="modal" data-target="#delete' . $lead->id . '" class="btn btn-danger btn-flat">' . trans('admin.delete') . '</a>
													<div id="delete' . $lead->id . '" class="modal fade" role="dialog">
														<div class="modal-dialog">
															<!-- Modal content-->
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal">&times;</button>
																	<h4 class="modal-title">' . trans('admin.delete') . ' ' . trans('admin.lead') . '</h4>
																</div>
																<div class="modal-body">
																	<p>' . trans('admin.delete') . ' ' . $lead->name . '</p>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default btn-flat"
																			data-dismiss="modal">' . trans('admin.close') . '</button>
																	<a class="btn btn-danger btn-flat" href="' . url(adminPath() . '/delete-lead/' . $lead->id) . '">' . trans('admin.delete') . '</a>
																</div>
															</div>
														</div>
				*/
				$agents_res = '';
				$agents = '';
				foreach (User::where('residential_commercial','residential')->get() as $agent) {
					$agents_res .= '<option value="' . $agent->id . '">' . $agent->name . '</option>';
				}
				foreach(User::where('residential_commercial','commercial')->get() as $agent){
					$agents .= '<option value="' . $agent->id . '">' . $agent->name . '</option>';
				}
				$lead->switch = '<a data-toggle="modal" data-target="#switch' . $lead->id . '" class="btn btn-x btn-success btn-flat">' . trans('admin.switch') . '</a>
						<div id="switch' . $lead->id . '" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">' . trans('admin.switch') . ' ' . trans('admin.lead') . '</h4>
									</div>
									<form action="' . url(adminPath() . '/switch_leads') . '" method="post">
									' . csrf_field() . '
									<div class="modal-body">
									<label> ' . trans('admin.personal') . ' ' . trans('admin.agent') . ' </label>
									   <div class="">
										<select class="select2" name="agent_id"
												data-placeholder="' . __('admin.agent') . '" style="width: 100%">
											<option></option>
											' . $agents_res . '
										</select>
										<input type="hidden" value="' . $lead->id . '" name="leads[]">
										</div>
									</div>
									<div class="modal-body">
									<label> ' . trans('admin.commercial') . ' ' . trans('admin.agent') . ' </label>
									   <div class="">
									<select class="select2" name="agent_id"
											data-placeholder="' . __('admin.agent') . '" style="width: 100%">
										<option></option>
										' . $agents . '
									</select>
									</div>
										<input type="hidden" value="' . $lead->id . '" name="leads[]">
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default btn-flat"
												data-dismiss="modal">' . trans('admin.close') . '</button>
										<button type="submit"
												class="btn btn-success btn-flat">' . trans('admin.switch') . '</button>
									</div>
									</form>
								</div>
							</div>
						</div>
						<script>
						$(".select2").select2();
			</script>';
			}
			return \DataTables::of($leads)->
				escapeColumns('')->
				make(true);
		}
	}
	public function leads_fav_ajax()
	{
		if (auth()->user()->type != 'admin') {
			$leads = Lead::where('agent_id', auth()->user()->id)->where('favorite', 1)->get();
		} else {
			$leads = Lead::where('favorite', 1)->get();
		}
		foreach ($leads as $lead) {
			$lead->checkbox = '<div class="checkbox">
									<label>
										<input class="switch" name="checked_leads[]" type="checkbox"
											   value="' . $lead->id . '">
										<span class="cr"><i class="cr-icon fa fa-check"></i></span>
									</label>
								</div>';
			$lead->name = $lead->first_name . ' ' . $lead->last_name;
			$lead->email = '<a href="mailto:' . $lead->email . '">' . $lead->email . '</a>';
			$lead->source = @LeadSource::find($lead->lead_source_id)->name;
			$lead->option = '<select class="form-control"  onchange="' . "if(this.value=='del'){\$('#delete$lead->id').modal('show');} else{location = this.value;}" . '">
			<option value="#" disabled selected >Options</option>
			<option value="' . url(adminPath() . '/leads/' . $lead->id) . '">' . trans('admin.show') . '</option>
			<option value="' . url(adminPath() . '/leads/' . $lead->id . '/edit') . '">' . trans('admin.edit') . '</option>
			<option value="del" class="btn btn-danger btn-flat">' . trans('admin.delete') . '</option>
			</select>
				<div id="delete' . $lead->id . '" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">' . trans('admin.delete') . ' ' . trans('admin.lead') . '</h4>
							</div>
							<div class="modal-body">
								<p>' . trans('admin.delete') . ' ' . $lead->name . '</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default btn-flat"
										data-dismiss="modal">' . trans('admin.close') . '</button>
								<a class="btn btn-danger btn-flat" href="' . url(adminPath() . '/delete-lead/' . $lead->id) . '">' . trans('admin.delete') . '</a>
							</div>
						</div>
					</div>
				</div>
			';
			/*$lead->show = '<a href="' . url(adminPath() . '/leads/' . $lead->id) . '" class="btn btn-primary btn-flat">' . trans('admin.show') . '</a>';
							$lead->edit = '<a href="' . url(adminPath() . '/leads/' . $lead->id . '/edit') . '" class="btn btn-warning btn-flat"> ' . trans('admin.edit') . '</a>';
							$lead->delete = '<a data-toggle="modal" data-target="#delete' . $lead->id . '" class="btn btn-danger btn-flat">' . trans('admin.delete') . '</a>
								<div id="delete' . $lead->id . '" class="modal fade" role="dialog">
									<div class="modal-dialog">
										<!-- Modal content-->
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">' . trans('admin.delete') . ' ' . trans('admin.lead') . '</h4>
											</div>
											<div class="modal-body">
												<p>' . trans('admin.delete') . ' ' . $lead->name . '</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default btn-flat"
														data-dismiss="modal">' . trans('admin.close') . '</button>
												<a class="btn btn-danger btn-flat" href="' . url(adminPath() . '/delete-lead/' . $lead->id) . '">' . trans('admin.delete') . '</a>
											</div>
										</div>
									</div>
			*/
			$agents_res = '';
			$agents = '';
			foreach (User::where('residential_commercial','residential')->get() as $agent) {
				$agents_res .= '<option value="' . $agent->id . '">' . $agent->name . '</option>';
			}
			foreach(User::where('residential_commercial','commercial')->get() as $agent){
				$agents .= '<option value="' . $agent->id . '">' . $agent->name . '</option>';
			}
			$lead->switch = '<a data-toggle="modal" data-target="#switch' . $lead->id . '" class="btn btn-x btn-success btn-flat">' . trans('admin.switch') . '</a>
					<div id="switch' . $lead->id . '" class="modal fade" role="dialog">
						<div class="modal-dialog">
							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">' . trans('admin.switch') . ' ' . trans('admin.lead') . '</h4>
								</div>
								<form action="' . url(adminPath() . '/switch_leads') . '" method="post">
								' . csrf_field() . '
								<div class="modal-body">
								<label> ' . trans('admin.personal') . ' ' . trans('admin.agent') . ' </label>
								   <div class="">
									<select class="select2" name="agent_id"
											data-placeholder="' . __('admin.agent') . '" style="width: 100%">
										<option></option>
										' . $agents_res . '
									</select>
									<input type="hidden" value="' . $lead->id . '" name="leads[]">
									</div>
								</div>
								<div class="modal-body">
								<label> ' . trans('admin.commercial') . ' ' . trans('admin.agent') . ' </label>
								   <div class="">
								<select class="select2" name="agent_id"
										data-placeholder="' . __('admin.agent') . '" style="width: 100%">
									<option></option>
									' . $agents . '
								</select>
								</div>
									<input type="hidden" value="' . $lead->id . '" name="leads[]">
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default btn-flat"
											data-dismiss="modal">' . trans('admin.close') . '</button>
									<button type="submit"
											class="btn btn-success btn-flat">' . trans('admin.switch') . '</button>
								</div>
								</form>
							</div>
						</div>
					</div>
					<script>
					$(".select2").select2();
		</script>';
		}
		return \DataTables::of($leads)->
			escapeColumns('')->
			make(true);
	}
	public function leads_hot_ajax()
	{
		$leads = Lead::where('agent_id', auth()->user()->id)->where('hot', 1)->get();
		foreach ($leads as $lead) {
			$lead->checkbox = '<div class="checkbox">
									<label>
										<input class="switch" name="checked_leads[]" type="checkbox"
											   value="' . $lead->id . '">
										<span class="cr"><i class="cr-icon fa fa-check"></i></span>
									</label>
								</div>';
			$lead->name = $lead->first_name . ' ' . $lead->last_name;
			$lead->email = '<a href="mailto:' . $lead->email . '">' . $lead->email . '</a>';
			$lead->source = @LeadSource::find($lead->lead_source_id)->name;
			$lead->option = '<select class="form-control"  onchange="' . "if(this.value=='del'){\$('#delete$lead->id').modal('show');} else{location = this.value;}" . '">
			<option value="#" disabled selected >Options</option>
			<option value="' . url(adminPath() . '/leads/' . $lead->id) . '">' . trans('admin.show') . '</option>
			<option value="' . url(adminPath() . '/leads/' . $lead->id . '/edit') . '">' . trans('admin.edit') . '</option>
			<option value="del" class="btn btn-danger btn-flat">' . trans('admin.delete') . '</option>
			</select>
				<div id="delete' . $lead->id . '" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">' . trans('admin.delete') . ' ' . trans('admin.lead') . '</h4>
							</div>
							<div class="modal-body">
								<p>' . trans('admin.delete') . ' ' . $lead->name . '</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default btn-flat"
										data-dismiss="modal">' . trans('admin.close') . '</button>
								<a class="btn btn-danger btn-flat" href="' . url(adminPath() . '/delete-lead/' . $lead->id) . '">' . trans('admin.delete') . '</a>
							</div>
						</div>
					</div>
				</div>
			';
			/*            $lead->show = '<a href="' . url(adminPath() . '/leads/' . $lead->id) . '" class="btn btn-primary btn-flat">' . trans('admin.show') . '</a>';
										$lead->edit = '<a href="' . url(adminPath() . '/leads/' . $lead->id . '/edit') . '" class="btn btn-warning btn-flat"> ' . trans('admin.edit') . '</a>';
										$lead->delete = '<a data-toggle="modal" data-target="#delete' . $lead->id . '" class="btn btn-danger btn-flat">' . trans('admin.delete') . '</a>
											<div id="delete' . $lead->id . '" class="modal fade" role="dialog">
												<div class="modal-dialog">
													<!-- Modal content-->
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">' . trans('admin.delete') . ' ' . trans('admin.lead') . '</h4>
														</div>
														<div class="modal-body">
															<p>' . trans('admin.delete') . ' ' . $lead->name . '</p>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default btn-flat"
																	data-dismiss="modal">' . trans('admin.close') . '</button>
															<a class="btn btn-danger btn-flat" href="' . url(adminPath() . '/delete-lead/' . $lead->id) . '">' . trans('admin.delete') . '</a>
														</div>
													</div>
												</div>
			*/
			$agents_res = '';
			$agents = '';
			foreach (User::where('residential_commercial','residential')->get() as $agent) {
				$agents_res .= '<option value="' . $agent->id . '">' . $agent->name . '</option>';
			}
			foreach(User::where('residential_commercial','commercial')->get() as $agent){
				$agents .= '<option value="' . $agent->id . '">' . $agent->name . '</option>';
			}
			$lead->switch = '<a data-toggle="modal" data-target="#switch' . $lead->id . '" class="btn btn-x btn-success btn-flat">' . trans('admin.switch') . '</a>
					<div id="switch' . $lead->id . '" class="modal fade" role="dialog">
						<div class="modal-dialog">
							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">' . trans('admin.switch') . ' ' . trans('admin.lead') . '</h4>
								</div>
								<form action="' . url(adminPath() . '/switch_leads') . '" method="post">
								' . csrf_field() . '
								<div class="modal-body">
								<label> ' . trans('admin.personal') . ' ' . trans('admin.agent') . ' </label>
								   <div class="">
									<select class="select2" name="agent_id"
											data-placeholder="' . __('admin.agent') . '" style="width: 100%">
										<option></option>
										' . $agents_res . '
									</select>
									<input type="hidden" value="' . $lead->id . '" name="leads[]">
									</div>
								</div>
								<div class="modal-body">
								<label> ' . trans('admin.commercial') . ' ' . trans('admin.agent') . ' </label>
								   <div class="">
								<select class="select2" name="commercial_agent_id"
										data-placeholder="' . __('admin.agent') . '" style="width: 100%">
									<option></option>
									' . $agents . '
								</select>
								</div>
									<input type="hidden" value="' . $lead->id . '" name="leads[]">
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default btn-flat"
											data-dismiss="modal">' . trans('admin.close') . '</button>
									<button type="submit"
											class="btn btn-success btn-flat">' . trans('admin.switch') . '</button>
								</div>
								</form>
							</div>
						</div>
					</div>
					<script>
					$(".select2").select2();
		</script>';
		}
		return \DataTables::of($leads)->
			escapeColumns('')->
			make(true);
	}
	public function add_lead_request(Request $request) {
		$rules1 = [
			'lead_source' => 'required',
			'xls' => 'file|max:100|mimeTypes:' .
			'application/vnd.ms-office,' .
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,' .
			'application/vnd.ms-excel',
		];
		$validator1 = Validator::make($request->all(), $rules1);
		$validator1->SetAttributeNames([
			'lead_source' => trans('admin.lead_source'),
			'xls' => trans('admin.xls'),
		]);
		if ($validator1->fails()) {
			return back()->withInput()->withErrors($validator1);
		} else {
			$source = $request->lead_source;
			$path = $request->file('xls')->getRealPath();
			Excel::load($path, function ($reader) use ($source) {
				$array = $reader->toArray();
				foreach ($array as $item) {
					if (isset($item['phone'])) {
						$check1 = Lead::where('phone', $item['phone'])->get();
						if (count($check1) < 1) {
							$rules = [
								'first_name' => 'required|max:191',
								'last_name' => 'required|max:191',
								'gender' => 'required',
								'phone' => 'required',
								'campaign' => 'required',
							];
							$validator = Validator::make($item, $rules);
							if (!$validator->fails()) {
								$data = new Lead();
								if (isset($item['email'])) {
									$check2 = Lead::where('phone', $item['phone'])->get();
									if (count($check2) < 1) {
										$validator = Validator::make(
											['email' => 'required|email']
										);
										if (!$validator->fails()) {
											$data->email = $item['email'];
										}
									}
								}
								if (count($campaign = Campaign::where('en_name', $item['campaign'])->orWhere('ar_name', $item['campaign'])->first()) > 0) {
									$data->first_name = $item['first_name'];
									$data->last_name = $item['last_name'];
									$data->phone = $item['phone'];
									$data->lead_source_id = $source;
									$data->campain_id = $campaign->id;
									if ($item['gender'] == 'female') {
										$data->prefix_name = 'ms';
									} else {
										$data->prefix_name = 'mr';
									}
									$data->agent_id = Auth::user()->id;
									$data->user_id = 0;
									$data->save();
								}
							}
						}
					}
				}
			});
			return redirect(adminPath() . '/leads');
		}
	}
	public function formLead(Request $request) {
		$form = Form::find($request->form_id);
		$fields = json_decode($form->fields);
		$rules = [
			'prefix_name' => 'required',
			'first_name' => 'required|max:191',
			'last_name' => 'required|max:191',
			'phone' => 'required|numeric',
		];
		foreach ($fields as $field => $k) {
			if ($k) {
				if ($field == 'image') {
					$rules[$field] = 'required|image';
				} elseif ($field == 'email') {
					$rules[$field] = 'required|email';
				} else {
					$rules[$field] = 'required';
				}
			}
		}
		$validator = Validator::make($request->all(), $rules);
		$validator->SetAttributeNames([
			'prefix_name' => trans('admin.prefix_name'),
			'first_name' => trans('admin.first_name'),
			'last_name' => trans('admin.last_name'),
			'middle_name' => trans('admin.middle_name'),
			'email' => trans('admin.email'),
			'phone' => trans('admin.phone'),
			'address' => trans('admin.address'),
			'image' => trans('admin.image'),
			'club' => trans('admin.club'),
			'religion' => trans('admin.religion'),
			'birth_date' => trans('admin.birth_date'),
			'company' => trans('admin.company'),
			'school' => trans('admin.school'),
			'facebook' => trans('admin.facebook'),
		]);
		if ($validator->fails()) {
			return back()->withInput()->withErrors($validator);
		} else {
			if (Lead::where('phone', $request->phone)->count() > 0) {
				$lead = Lead::where('phone', $request->phone)->first();
				$lead->prefix_name = $request->prefix_name;
				$lead->first_name = $request->first_name;
				$lead->last_name = $request->last_name;
				$lead->middle_name = $request->middle_name;
				$lead->email = $request->email;
				$lead->phone = $request->phone;
				$lead->address = $request->address;
				$lead->club = $request->club;
				$lead->religion = $request->religion;
				$lead->company = $request->company;
				$lead->school = $request->school;
				$lead->facebook = $request->facebook;
				$lead->form_source_id = $request->form_id;
				if ($request->has('birth_date')) {
					$lead->birth_date = strtotime($request->birth_date);
				}
				$lead->lead_source_id = $form->lead_source_id;
				$lead->notes = $request->notes;
				if ($request->hasFile('image')) {
					$lead->image = uploads($request, 'image');
				} else {
					$lead->image = 'image.jpg';
				}
				$lead->save();
			} else {
				$lead = new Lead;
				$lead->prefix_name = $request->prefix_name;
				$lead->first_name = $request->first_name;
				$lead->last_name = $request->last_name;
				$lead->middle_name = $request->middle_name;
				$lead->email = $request->email;
				$lead->phone = $request->phone;
				$lead->address = $request->address;
				$lead->club = $request->club;
				$lead->religion = $request->religion;
				$lead->company = $request->company;
				$lead->school = $request->school;
				$lead->facebook = $request->facebook;
				$lead->birth_date = strtotime($request->birth_date);
				$lead->lead_source_id = $form->lead_source_id;
								$lead->form_source_id = $request->form_id;
				$lead->other_phones = json_encode([]);
				$lead->other_emails = json_encode([]);
				$lead->notes = $request->notes;
				$lead->user_id = 0;
				$lead->agent_id = 0;
				if ($request->hasFile('image')) {
					$lead->image = uploads($request, 'image');
				} else {
					$lead->image = 'image.jpg';
				}
				$lead->save();
			}
			session()->flash('success', trans('admin.created'));
			return redirect('/');
		}
	}
	public function filter_team_leads(Request $request) {
		$leads = Lead::where(function($q) use($request){
		$q->where('agent_id', $request->id)->orWhere('commercial_agent_id', $request->id);
		})->get();
		dd('ddddddddd');
		return view('admin.leads.filter_team', compact('leads'));
	}

	public function searchTeam(Request $r) {
		$agents = json_decode($r->agents);
		$q = $r->q;
		$teams = Lead::join('users', 'users.id', '=', 'leads.agent_id')
			->join('lead_sources', 'lead_sources.id', '=', 'leads.lead_source_id')
			->where('leads.first_name', 'LIKE', '%' . $q . '%')
			->orWhere('leads.last_name', 'LIKE', '%' . $q . '%')
			->orWhere('leads.email', 'LIKE', '%' . $q . '%')
			->orWhere('leads.phone', 'LIKE', '%' . $q . '%')
			->orWhere('users.name', 'LIKE', '%' . $q . '%')
			->orWhere('lead_sources.name', 'LIKE', '%' . $q . '%')
			->select('leads.id as id', 'leads.first_name as first_name', 'leads.last_name as last_name', 'leads.email as email', 'leads.phone as phone', 'leads.lead_source_id', 'leads.agent_id')->orderBy('id',"desc")->get();
			// Get current page from query string
		$currentPage  = isset($_GET['page']) ? (int) $_GET['page'] : 1;
		$perPage      = 10;
		$input = array($teams);
		$currentItems = array_slice($input, $perPage * ($currentPage - 1), $perPage, true);// if $items is an array
		$paginator = new LengthAwarePaginator($currentItems, count($teams),$perPage, $currentPage, ['path' => 'posts']);
		return view('admin.leads.team_search', ['teams' => $teams, 'paginator' => $paginator]);
	}
	public function getGroupAgents(Request $request) {
		$agents = GroupMember::where('group_id', $request->group_id)->get();
		return view('admin.leads.group_agents', ['agents' => $agents]);
	}

	public function filter_leads(Request $request) {
		// return 'hjkd';
		$query = new Lead;
		if (@$request->dateFrom and @$request->dateTo) {
			// dd($request->dateTo);
			$from = date('Y-m-d', strtotime($request->dateFrom));
			$to = date('Y-m-d', strtotime($request->dateTo));
			$query = $query->whereBetween('created_at', [$from, $to]);
		}
		if (@$request->location) {
			$requests = \App\Request::where('location', $request->location)->pluck('lead_id')->toArray();
			$query = $query->whereIn('id', $requests);
		}
		if (@$request->callStatus) {
			$calls = Call::where('call_status_id', $request->callStatus)->pluck('lead_id')->toArray();
			$query = $query->whereIn('id', $calls);
		}
		if (@$request->meetingStatus) {
			$meetings = Meeting::where('meeting_status_id', $request->meetingStatus)->pluck('lead_id')->toArray();
			$query = $query->whereIn('id', $meetings);
		}
		if (@$request->group_id != 0) {
			$agents = GroupMember::where('group_id', $request->group_id)->pluck('member_id')->toArray();
			$query = $query->whereIn('agent_id', $agents);
		}
		if (@$request->agent_id != 0) {
			$query = $query->where('agent_id', $request->agent_id)->orWhere('commercial_agent_id', $request->agent_id);
		} else {
			$users = [];
			$user_ids = [];
			if (auth()->user()->type == 'admin' or @Group::where('team_leader_id', auth()->id())->count()) {
				$teamLeads = Lead::getAgentLeads();
				foreach ($teamLeads as $lead) {
					if ($lead->agent_id != auth()->id()) {
						$users[] = User::find($lead->agent_id);
						$user_ids[] = $lead->agent_id;
					}
				}
			}
			$users = array_unique($users);
			$query = $query->whereIn('agent_id', $user_ids);
		}
		$leads = $query->orderBy("id","desc")->get();
		$commercialAgents = User::where('residential_commercial', 'commercial')->pluck('id')->toArray();
		$residentialAgents = User::where('residential_commercial', 'residential')->pluck('id')->toArray();
		$r_loca = $request->location;
		$r = @Location::find($r_loca)->en_name;
		foreach ($leads as $lead) {
			$ques_led = @Req::where('lead_id', $lead->id)->with('loc')->orderBy('created_at', 'desc')->first();
			$lastCall = Call::where('lead_id', $lead->id)->orderBy('id', 'desc')->first();
			$lastMeeting = Meeting::where('lead_id', $lead->id)->orderBy('id', 'desc')->first();
			if (@$lastCall->created_at->timestamp > @$lastMeeting->created_at->timestamp) {
				@$leadProbability = $lastCall->probability;
			} else {
				@$leadProbability = $lastMeeting->probability;
			}
			if (!$leadProbability) {
				$leadProbability = 'Follow Up';
			}
			$lead->agent = @Project::find($ques_led->project_id)->en_name;
			if (@Req::where('lead_id', $lead->id)->where('unit_type', 'residential')->where('unit_type', 'commercial')->count() > 0) {
				$leadType = __('admin.residential') . ' - ' . __('admin.commercial');
			} elseif (@Req::where('lead_id', $lead->id)->where('unit_type', 'residential')->where('unit_type', '!=', 'commercial')->count() > 0) {
				$leadType = __('admin.residential');
			} elseif (@Req::where('lead_id', $lead->id)->where('unit_type', '!=', 'residential')->where('unit_type', 'commercial')->count() > 0) {
				$leadType = __('admin.commercial');
			} else {
				$leadType = __('admin.residential');
			}
			$lead->type = $leadType;
			// dd($leads);
			if ($request->type == 'team') {
				return view('admin.leads.filter_team', compact('leads', 'commercialAgents', 'residentialAgents'));
			} else {
				return view('admin.leads.filtered', compact('leads', 'commercialAgents', 'residentialAgents', 'r', 'leadProbability'));
			}
		}
	}

	// New Dashboard Functions - Abed Said

	// Get My Leads
	public function getMyLeads(Request $request){
		
		if(auth()->user()->role->name == 'operation'){
			$obj = (object)[];
			$obj->data = [];
			return response()->json($obj);
		}
		$page = $request->query('page');
		$project_name = '';
		$query = new Lead;
		$leadInstance = new Lead;
		$leads = $query::select('id','first_name','last_name','lead_source_id','agent_id','commercial_agent_id','phone','created_at','favorite','hot','seen','phone_iso')->where('lead_source_id', '!=', '28' )->where(function($q){
			$q->where('agent_id', auth()->id())->orWhere('commercial_agent_id', auth()->id());
		})->orderBy('created_at', 'desc')->paginate(100);

		$commercialAgents = User::where('residential_commercial', 'commercial')->pluck('id')->toArray();
		$residentialAgents = User::where('residential_commercial', 'residential')->pluck('id')->toArray();

		foreach ($leads as $lead) {
			//$ques_led = @Req::where('lead_id', $lead->id)->with('loc')->orderBy('created_at', 'desc')->first();
			$lead->sourceName = @LeadSource::where('id',$lead->lead_source_id)->value('name');

			$lastCall = Call::select('created_at','probability')->where('lead_id', $lead->id)->orderBy('created_at', 'desc')->first();
			$lastMeeting = Meeting::select('created_at','probability')->where('lead_id', $lead->id)->orderBy('created_at', 'desc')->first();
			if (@$lastCall->created_at->timestamp > @$lastMeeting->created_at->timestamp) {
				@$leadProbability = $lastCall->probability;
			} else {
				@$leadProbability = $lastMeeting->probability;
			}
			if (!$leadProbability) {
				$leadProbability = 'Follow Up';
			}
			$lead->leadProbability = $leadProbability;
			if ($lead->seen) {
				$seen = 'seen_without_action';
				$sColor = 'orange';
				$lead->seen = 1;
				if (DB::table('lead_actions')->where('lead_id', $lead->id)->where(function($query) use ($lead){
					$query->where('user_id', $lead->agent_id)->orWhere('user_id', $lead->commercial_agent_id);
				})->count() > 0) {
					$seen = 'seen_with_action';
					$sColor = 'green';
					$lead->seen = 2;
				}
				else if (DB::table('lead_actions')->where('lead_id', $lead->id)->count()) {
					$seen = 'seen_with_action';
					$sColor = 'green';
					$lead->seen = 3;
				}
			} else {
				$lead->seen = 0;
			}
			$color = '';
			if (DB::table('lead_actions')->whereIn('user_id', $commercialAgents)->where('lead_id', $lead->id)->count() > 0) {
				$color = 1;
			} else {
				$color = 0;
			}
			$color2 = '';
			if (DB::table('lead_actions')->where('lead_id', $lead->id)->where(function($query) use ($residentialAgents, $commercialAgents){
				$query->whereIn('user_id', $residentialAgents)->orWhereIn('user_id', $commercialAgents);
			})->count() > 0) {
				$color2 = 1;
			} else {
				$color2 = 0;
			}
			$lead_tag = $leadInstance->getLeadFirstTag($lead->id);
			if($lead_tag != null){
				$lead->tag = $lead_tag;						
			}else{
				$lead->tag = "";
			}
			$lead->commercial_status = $color;
			$lead->personal_status = $color2;

			$ques_led = @Req::select('location','project_id')->where('lead_id', $lead->id)->orderBy('created_at', 'desc')->first();
			if($ques_led) {
				$lead->requestLocation =  @Location::where('id',$ques_led->location)->value('en_name');
				$project_name = @Project::where('id',$ques_led->project_id)->value('en_name');
				if($project_name!=null){
					$lead->projectName = $project_name;
				}
				else{
					$lead->projectName = '';
				}

			}

			/*if(count($lead->requests) > 1){
				$lastReq = end($lead->requests);
			}elseif(count($lead->requests) === 1) {$lastReq = $lead->requests[0];}


			/*if(count($lead->requests)>0){
				foreach($lead->requests as $req){
					if($req->project_id){
						$lead->requestLocation =  @Location::find($req->project_id)->en_name;
						$lead->projectName = @Project::find($req->project_id)->en_name;
						break;
					}
				}

			}*/
			// if (@Req::where('lead_id', $lead->id)->where('unit_type', 'residential')->where('unit_type', 'commercial')->count() > 0) {
			// 	$leadType = __('admin.residential') . ' - ' . __('admin.commercial');
			// }elseif
			if (@Req::where('lead_id', $lead->id)->where('unit_type', 'residential')->where('unit_type', 'commercial')->count() > 0) {
				$leadType = __('admin.residential') . ' - ' . __('admin.commercial');
			} elseif (@Req::where('lead_id', $lead->id)->where('unit_type', 'residential')->where('unit_type', '!=', 'commercial')->count() > 0) {
				$leadType = __('admin.residential');
			} elseif (@Req::where('lead_id', $lead->id)->where('unit_type', '!=', 'residential')->where('unit_type', 'commercial')->count() > 0) {
				$leadType = __('admin.commercial');
			} else {
				$leadType = 'N/A';
			}

			$lead->type = $leadType;
			// dd($leads);

		}
		return $leads;
	}


	// Get Archive
	public function getArchive(){
		$leads = \App\Archive::paginate('100');
		return $leads;
	}

	// Get Individual Leads
	public function getIndividualLeads()
	{
		if(auth()->user()->role->name == 'operation'){
			$obj = (object)[];
			$obj->data = [];
			return response()->json($obj);
		}
		if (auth()->user()->type == 'admin') {
			$leads = @Lead::select('id','first_name','last_name','email','phone','lead_source_id','created_at','phone_iso')->where('agent_id', 0)->where('commercial_agent_id', 0)->orderBy('id','desc')->paginate(100);
			$leadInstance = new Lead;
			foreach ($leads as $lead) {
				$lead_tag = $leadInstance->getLeadFirstTag($lead->id);
				if($lead_tag != null){
					$lead->tag = $lead_tag;						
				}else{
					$lead->tag = "";
				}
				$lead->source = @LeadSource::where('id',$lead->lead_source_id)->value('name');
				$ques_led = @Req::select('location','project_id')->where('lead_id', $lead->id)->orderBy('created_at', 'desc')->first();
				$requestObject = DB::table('requests')->where('lead_id', $lead->id)->select('location','project_id')->orderBy('created_at', 'desc')->first();
				if($requestObject) {
					$lead->requestLocation =  DB::table('locations')->where('id',$requestObject->location)->value(app()->getLocale().'_name');
					$project_name = DB::table('projects')->where('id',$requestObject->project_id)->value(app()->getLocale().'_name');
					if($project_name!=null){
						$lead->projectName = $project_name;
					}
					else{
						$lead->projectName = '';
					}
				}
			}
			return $leads;
		}
	}

	// Get Team Leads
	public function getTeamLeadsNew() {
		if(auth()->user()->role->name == 'operation'){
			$obj = (object)[];
			$obj->data = [];
			return response()->json($obj);
		}
		$commercialAgents = @\App\User::where('residential_commercial', 'commercial')->pluck('id')->toArray();
		$residentialAgents = @\App\User::where('residential_commercial', 'residential')->pluck('id')->toArray();

		/*$leads = Lead::select('leads.id as id', 'leads.first_name as first_name', 'leads.last_name as last_name', 'leads.email as email', 'leads.phone as phone', 'leads.lead_source_id', 'leads.agent_id')->orderBy('id',"desc")
			->paginate('10');*/
		$project_name = '';
		$leads = Lead::getTeamLeads();
		$leadInstance = new Lead;
		// dd($leads);
		foreach ($leads as $lead) {

			if (@User::find($lead->agent_id)->residential_commercial == 'residential')
				$lead->agentName = @User::find($lead->agent_id)->name;
			if (@User::find($lead->agent_id)->residential_commercial == 'commercial' )
				$lead->commercialAgentName = @User::find($lead->agent_id)->name;
			if ($lead->commercial_agent_id != 0)
				$lead->commercialAgentName = @User::find($lead->commercial_agent_id)->name;

			$lead->sourceName = @LeadSource::where('id',$lead->lead_source_id)->value('name');
			$lastCall = Call::select('created_at','probability')->where('lead_id', $lead->id)->orderBy('created_at', 'desc')->first();
			$lastMeeting = Meeting::select('created_at','probability')->where('lead_id', $lead->id)->orderBy('created_at', 'desc')->first();
			if (@$lastCall->created_at->timestamp > @$lastMeeting->created_at->timestamp) {
				@$leadProbability = $lastCall->probability;
			} else {
				@$leadProbability = $lastMeeting->probability;
			}
			if (!$leadProbability) {
				$leadProbability = 'Follow Up';
			}
			$lead->leadProbability = $leadProbability;
			// dd($lead->sourceName);
			if(Auth()->user()->residential_commercial == 'residential'){
				$actions = DB::table('lead_actions')->whereIn('user_id', $residentialAgents)->where('lead_id',$lead->id)->count();
				if($actions > 0) $lead->status = 1; else $lead->status = 0;
			}elseif (Auth()->user()->residential_commercial == 'commercial') {
				$actions = DB::table('lead_actions')->whereIn('user_id', $commercialAgents)->where('lead_id',$lead->id)->count();
				if($actions > 0) $lead->status = 1; else $lead->status = 0;
			}

			// retriving project name
			$ques_led = @Req::select('location','project_id')->where('lead_id', $lead->id)->orderBy('created_at', 'desc')->first();
			if($ques_led) {
				$lead->requestLocation =  @Location::where('id',$ques_led->location)->value('en_name');
				$project_name = @Project::where('id',$ques_led->project_id)->value('en_name');
				if(is_array(json_decode($ques_led->project_id)))
					$lead->projectName = @Project::where('id',json_decode($ques_led->project_id)[0])->value('en_name');
				elseif($ques_led->project_id != null)
					$lead->projectName = $project_name;
				else
					$lead->projectName = '';
			}
			// end of project name

			$color = '';
			if (DB::table('lead_actions')->whereIn('user_id', $commercialAgents)->where('lead_id', $lead->id)->count() > 0) {
				$color = 1;
			} else {
				$color = 0;
			}
			$color2 = '';
			if (DB::table('lead_actions')->whereIn('user_id', $residentialAgents)->where('lead_id', $lead->id)->count() > 0) {
				$color2 = 1;
			} else {
				$color2 = 0;
			}
			$lead_tag = $leadInstance->getLeadFirstTag($lead->id);
			if($lead_tag != null){
				$lead->tag = $lead_tag;						
			}else{
				$lead->tag = "";
			}
			$lead->commercial_status = $color;
			$lead->personal_status = $color2;
		}
			return $leads;
	}

	// Get Hot Leads
	public function getHotLeads()
	{
		if(auth()->user()->role->name == 'operation'){
			$obj = (object)[];
			$obj->data = [];
			return response()->json($obj);
		}
		$user_id = auth()->user()->id;
		$leads = DB::table('leads')->select('id','first_name','last_name','email','phone','lead_source_id','created_at','phone_iso')
		->where(function($query) use($user_id){
			$query->where('agent_id', $user_id)->orWhere('commercial_agent_id',$user_id);
		})
		->where('hot','1')->paginate(10);
		$leadInstance = new Lead;
		foreach ($leads as $lead) {
			$lead_tag = $leadInstance->getLeadFirstTag($lead->id);
			if($lead_tag != null){
				$lead->tag = $lead_tag;						
			}else{
				$lead->tag = "";
			}
			$lead->sourceName = @LeadSource::where('id',$lead->lead_source_id)->value('name');
		}
		return $leads;
	}

	// Get today Leads
	public function getTodayLeads()
	{
		if(auth()->user()->role->name == 'operation'){
			$obj = (object)[];
			$obj->data = [];
			return response()->json($obj);
		}
		if(auth()->user()->type == 'admin'){
			$leadids = DB::table('leads')->pluck('id');
		}else{
			$leadids = DB::table('leads')->where('agent_id', $user_id)->orWhere('commercial_agent_id',$user_id)->pluck('id');
		}
		$leads = Lead::select('id','first_name','last_name','email','phone','lead_source_id','created_at','phone_iso')->whereDate('created_at', Carbon::today())->where(function ($query) use($leadids){
				$query->whereIn('id',$leadids);
			})->paginate(100);
		$leadInstance = new Lead;
		foreach ($leads as $lead) {
			$lead_tag = $leadInstance->getLeadFirstTag($lead->id);
			if($lead_tag != null){
				$lead->tag = $lead_tag;						
			}else{
				$lead->tag = "";
			}
			$lead->sourceName = @LeadSource::where('id',$lead->lead_source_id)->value('name');
		}
		return $leads;
	}

	// Get Hot Leads
	public function getSeen()
	{
		if(auth()->user()->role->name == 'operation'){
			$obj = (object)[];
			$obj->data = [];
			return response()->json($obj);
		}
		$user_id = auth()->user()->id;
		$leads = Lead::select('id','first_name','last_name','email','phone','lead_source_id','created_at','phone_iso')->where("seen", 1)->where(function ($query) use($user_id){
				$query->where('agent_id', $user_id)->orWhere('commercial_agent_id',$user_id);
			})->paginate(100);
		$leadInstance = new Lead;	
		foreach ($leads as $lead) {
			$lead_tag = $leadInstance->getLeadFirstTag($lead->id);
			if($lead_tag != null){
				$lead->tag = $lead_tag;						
			}else{
				$lead->tag = "";
			}
			$lead->sourceName = @LeadSource::where('id',$lead->lead_source_id)->value('name');
		}

		return $leads;

	}
	// Get Hot Leads
	public function getNotSeen()
	{
		if(auth()->user()->role->name == 'operation'){
			$obj = (object)[];
			$obj->data = [];
			return response()->json($obj);
		}
		$user_id = auth()->user()->id;
		$leads = Lead::select('id','first_name','last_name','email','phone','lead_source_id','created_at','phone_iso')->where("seen", 0)->where(function ($query) use($user_id){
				$query->where('agent_id', $user_id)->orWhere('commercial_agent_id',$user_id);				
			})->paginate(100);
		$leadInstance = new Lead;	
		foreach ($leads as $lead) {
			$lead_tag = $leadInstance->getLeadFirstTag($lead->id);
			if($lead_tag != null){
				$lead->tag = $lead_tag;						
			}else{
				$lead->tag = "";
			}
			$lead->sourceName = @LeadSource::where('id',$lead->lead_source_id)->value('name');
		}

		return $leads;

	}

	// Get Cold Calls Leads
	public function getColdCalls()
	{
		if(auth()->user()->role->name == 'operation'){
			$obj = (object)[];
			$obj->data = [];
			return response()->json($obj);
		}
		$user_id = auth()->user()->id;
		$leads = Lead::select('id','first_name','last_name','email','phone','lead_source_id','favorite','hot','created_at','phone_iso')->where("lead_source_id", 28)->where(function($query) use($user_id){
			$query->where('agent_id', $user_id)->orWhere('commercial_agent_id',$user_id);
		})->paginate(100);
		$leadInstance = new Lead;
		foreach ($leads as $lead) {
			$lead_tag = $leadInstance->getLeadFirstTag($lead->id);
			if($lead_tag != null){
				$lead->tag = $lead_tag;						
			}else{
				$lead->tag = "";
			}
			$lead->sourceName = @LeadSource::where('id',$lead->lead_source_id)->value('name');
		}

		return $leads;

	}

	// Get today Cold Calls Leads
	public function getTodayColdCalls()
	{
		if(auth()->user()->role->name == 'operation'){
			$obj = (object)[];
			$obj->data = [];
			return response()->json($obj);
		}
		$user_id = auth()->user()->id;
		$leads = Lead::select('id','first_name','last_name','email','phone','lead_source_id','created_at','phone_iso')->whereDate('created_at', Carbon::today())
		->where(function($query) use($user_id){
			$query->where('agent_id', $user_id)->orWhere('commercial_agent_id',$user_id);
		})
		->where("lead_source_id", 28)->paginate(100);
		$leadInstance = new Lead;
		foreach ($leads as $lead) {
			$lead_tag = $leadInstance->getLeadFirstTag($lead->id);
			if($lead_tag != null){
				$lead->tag = $lead_tag;						
			}else{
				$lead->tag = "";
			}
			$lead->sourceName = @LeadSource::where('id',$lead->lead_source_id)->value('name');
		}

		return $leads;

	}

	// Get Favorite Leads
	public function getFavoriteLeads()
	{
		if(auth()->user()->role->name == 'operation'){
			$obj = (object)[];
			$obj->data = [];
			return response()->json($obj);
		}
		/*if (auth()->user()->type != 'admin') {
			$leads = Lead::where('agent_id', auth()->user()->id)->where('favorite', 1)->paginate('10');
		} else {
			$leads = Lead::where('favorite', 1)->paginate('10');
		}*/
		$user_id = auth()->user()->id;
		$leads = DB::table('leads')->select('id','first_name','last_name','email','phone','lead_source_id','created_at','phone_iso')
		->where(function($query) use($user_id){
			$query->where('agent_id', $user_id)->orWhere('commercial_agent_id',$user_id);
		})
		->where('favorite','1')->paginate(100);
		$leadInstance = new Lead;
		foreach ($leads as $lead) {
			$lead_tag = $leadInstance->getLeadFirstTag($lead->id);
			if($lead_tag != null){
				$lead->tag = $lead_tag;						
			}else{
				$lead->tag = "";
			}
			$lead->sourceName = @LeadSource::where('id',$lead->lead_source_id)->value('name');
		}

		return $leads;

	}

	public function getLeadData($id)
	{
		if(auth()->user()->role->name == 'operation'){
			$obj = (object)[];
			$obj->data = [];
			return response()->json($obj);
		}
		$lead = Lead::find($id);
		$leadInstance = new Lead;
		if ($lead) {
			if ($lead->image == 'image.jpg') {
				$lead->image = '';
			}

			// seen
			$action = LeadAction::where('lead_id',$id)->count();
			if($action > 0){
				$seen = 'seen_with_action';
				$sColor = 'green';
				$lead->seen = 3;
			}

			if (@$lead->agent->image == 'image.jpg') {
				@$lead->agent->image = '';
			}

			if (@$lead->commercialAgent->image == 'image.jpg') {
				@$lead->commercialAgent->image = '';
			}
			$calls = Call::where('lead_id', $id)->with('call_status')->orderBy('id', 'desc')->with('user')->get();
			// dd($calls);
			foreach ($calls as $call) {
				$call->project = array();
				$var = [];
				foreach (json_decode($call->projects)?: [] as $key => $value) {
					// if (count($call->project) == 0)
					// 	$call->project[0] = @\App\Project::find($value);
					// dd($call->project[0]);
					// $call->project[1] = @\App\Project::find($value);
					if (@\App\Project::where('id', $value)->exists())
						array_push($var, @\App\Project::find($value));
				}
				$call->project = $var;
				if($call->user == null){
					unset($call->user);
					$call['user'] = (object) [
							"name" => "",
					];
				}
			}
			// dd($calls); // [0]->project = json_decode($calls->projects)

			$meetings = Meeting::where('lead_id', $id)->with('meeting_status')->orderBy('id', 'desc')->with('user')->get();
			foreach ($meetings as $meeting) {
				$meeting->project = array();
				$var = [];
				$arr = is_array(json_decode($meeting->projects)) ? json_decode($meeting->projects) : [json_decode($meeting->projects)];
				foreach ($arr as $key => $value) {
				// foreach (json_decode($meeting->projects) as $key => $value) {
					// if (count($meeting->project) == 0)
					// 	$meeting->project[0] = @\App\Project::find($value);
					// dd($meeting->project[0]);
					// $meeting->project[1] = @\App\Project::find($value);
					if (@\App\Project::where('id', $value)->exists())
						array_push($var, @\App\Project::find($value));
				}
				$meeting->project = $var;
				// dd($meeting);
			}
			$voice_notes = VoiceNote::where('lead_id', $id)->orderBy('id', 'desc')->with('user')->get();
			$notes = LeadNote::where('lead_id', $id)->orderBy('id', 'desc')->with('user')->get();
			$requests = Req::where('lead_id', $id)->with('loc')->with('unittype')->orderBy('id', 'desc')->with('user')->get();
			// dd($requests);
			foreach ($requests as $request) {
				$request->project = array();
				$var = [];
				$arr = is_array(json_decode($request->project_id)) ? json_decode($request->project_id) : [json_decode($request->project_id)];
				foreach ($arr as $key => $value) {
					// if (count($request->project) == 0)
					// 	$request->project[0] = @\App\Project::find($value);
					// dd($request->project[0]);
					// $request->project[1] = @\App\Project::find($value);
					if (@\App\Project::where('id', $value)->exists())
						array_push($var, @\App\Project::find($value));
				}
				$request->project = $var;
			}
			foreach($meetings as $meeting) {
				if (@$meeting->user->image == 'image.jpg') {
					$meeting->image = '';
				}
			}


			foreach($calls as $call) {
				if (@$call->user->image == 'image.jpg') {
					$call->image = '';
				}
			}

			foreach($voice_notes as $note) {
				$note->user_name = @$note->user->name;
				$note->date = @\Carbon\Carbon::createFromTimeStamp(strtotime($note->created_at))->diffForHumans();
				if (@$note->user->image == 'image.jpg') {
					$note->image = '';
				}
			}

			foreach($notes as $note) {
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

			if (!$lead->seen && Lead::where('agent_id', auth()->id())->where('id', $lead->id)) {
				$lead->seen = 1;
				$lead->save();
			}

			$contacts = Contact::where('lead_id', $lead->id)->get();
			$tags = $leadInstance->getLeadTags($lead->id);
			
			$data = [
				'id' => $lead->id,
				'seen' => $lead->seen,
				'first_name' => $lead->first_name,
				'last_name' => $lead->last_name,
				'first_name_ar' => $lead->ar_first_name,
				'ar_last_name' => $lead->ar_last_name,
				'image' => $lead->image,
				'phone' => $lead->phone,
				// 'nationality' => $lead->nationality,
				'country_id' => $lead->country_id,
				'city_id' => $lead->city_id,
				'lead_source_id' => @$lead->lead_source_id,
				'lead_source_name' => @$lead->source->name,
				'lead_source' => @$lead->source->name,
				'reference' => $lead->reference,
				'title' => @$lead->title->name,
				'industry' => @$lead->industry->name,
				'email' => $lead->email,
				'status' => @$seen,
				'created_by' =>@ $lead->user->name,
				'created_at' => @$lead->created_at->format('Y-m-d H:i:s'),
				'updated_at' => @$lead->updated_at->format('Y-m-d H:i:s'),
				'r_agent' => [
					'name' => @$lead->agent->name,
					'image' => @$lead->agent->image,
					'type' => @$lead->agent->agentType->name,
					'residential_commercial' => @$lead->agent->residential_commercial,
				],
				'c_agent' => [
					'name' => @$lead->commercialAgent->name,
					'image' => @$lead->commercialAgent->image,
					'type' => @$lead->commercialAgent->agentType->name,
					'residential_commercial' => @$lead->commercialAgent->residential_commercial,
				],
				'calls' => $calls,
				'meetings' => $meetings,
				'voice_notes' => $voice_notes,
				'notes' => $notes,
				'documents' => @$lead->documents,
				'requests'  => $requests,
				'tags' => $tags,
				'favorite' => $lead->favorite,
				'hot' => $lead->hot,
				'lead_note' => $lead->notes
			];
			return ['status' => 'ok', 'lead' => $data,'contacts'=>$contacts];
		} else {
			return ['status' => 'not_found'];
		}
	}

	public function newLeadsFilter(Request $request, $reportType=null) {
		if(auth()->user()->role->name == 'operation'){
			$obj = (object)[];
			$obj->data = [];
			return response()->json($obj);
		}
		// TODO: refactor this
		ini_set('memory_limit', '-1');
		$projectName = '';
		$query = new Lead;
		$leadInstance = new Lead;
		// dd(\App\Lead::whereDate('created_at', '2018-11-19')->get());
		$id = Auth::user()->id;
		// dd($commercialAgents);
		if (@$request->leadSources) {
			$leadSources = Lead::where('lead_source_id', $request->leadSources)->distinct()->pluck('id')->toArray();
			$query = $query->whereIn('id', $leadSources);
		}
		if($request->teamLeadsTab){
			$leaderHasGroup = \App\Group::where('team_leader_id', $id)->first();
			if($leaderHasGroup && !$request->agent_id){
				$groupAgents = GroupMember::where('group_id', $leaderHasGroup->id)->groupBy('member_id')->pluck('member_id')->toArray();
				// if(count($groupAgents)>0){
				// 	$commercialAgents = @\App\User::where('residential_commercial', 'commercial')->whereIn('id',$groupAgents)->pluck('id')->toArray();
				// 	$residentialAgents = @\App\User::where('residential_commercial', 'residential')->whereIn('id',$groupAgents)->pluck('id')->toArray();
				// 	array_push($commercialAgents,$id);
				// 	array_push($residentialAgents,$id);
				// 	$query = $query->whereIn('commercial_agent_id', $commercialAgents)->orWhereIn('agent_id', $residentialAgents);
				// }
				array_push($groupAgents,$id);
				$leads = Lead::whereIn('commercial_agent_id',$groupAgents)->orWhereIn('agent_id', $groupAgents)->pluck('id');
				$query = $query->whereIn('id',$leads);
			}
		}
		if($request->coldCallsTab){
			$leadSources = Lead::where('lead_source_id', 28)->distinct()->pluck('id')->toArray();
			$query = $query->whereIn('id', $leadSources);
		}
		if($request->individualleadsTab){
			$individualLeads = Lead::where('agent_id',0)->orWhere('commercial_agent_id',0)->distinct()->pluck('id')->toArray();
			$query = $query->whereIn('id', $individualLeads);
		}
		if (@$request->location) {
			$requests = \App\Request::where('location', $request->location)->pluck('lead_id')->toArray();
			$query = $query->whereIn('id', $requests);
		}

		if (@$request->callStatus) {
			if($request->callStatus == 5){
				$calls = Call::where('call_status_id', $request->callStatus)->pluck('lead_id')->toArray();
				$query = $query->whereIn('id', $calls);
			}else{
				$callsNotInterested = Call::where('call_status_id',5)->pluck('lead_id');
				$calls = Call::where('call_status_id', $request->callStatus)->whereNotIn('lead_id',$callsNotInterested)->pluck('lead_id')->toArray();
				$query = $query->whereIn('id', $calls);
			}
			// dd($query);
		}

		if (@$request->meetingStatus) {
			$meetings = Meeting::where('meeting_status_id', $request->meetingStatus)->pluck('lead_id')->toArray();
			$query = $query->whereIn('id', $meetings);
		}
		if (@$request->phoneIso && $request->phoneIso != 'both') {
			$leadtempIds = DB::table('leads');
			if($request->phoneIso == 'national'){
				$leadtempIds = $leadtempIds->where('phone_iso','=','EG');
			}else{
				$leadtempIds = $leadtempIds->where('phone_iso','!=','EG');
			}
			$leadtempIds = $leadtempIds->pluck('id')->toArray();
			$query = $query->whereIn('id', $leadtempIds);
		}

		if (@$request->probability) {
			$probability = $request->probability;
			$callLeads = DB::table('leads as lead')
						->join('calls as call', function($join) use ($probability){
							$join->on('call.lead_id','=','lead.id');
							$join->where('call.probability','=',$probability);
						})
						->distinct('lead.id')
						->pluck('lead.id')->toArray();
			$meetingLeads = DB::table('leads as lead')
						->join('meetings as meeting', function($join) use ($probability){
							$join->on('meeting.lead_id','=','lead.id');
							$join->where('meeting.probability','=',$probability);
						})
						->distinct('lead.id')						
						->pluck('lead.id')->toArray();
			$leadIds = array_merge($callLeads,$meetingLeads);
			$query = $query->whereIn('id', $leadIds);
		}

		if (@$request->group_id != 0) {
			$agents = GroupMember::where('group_id', $request->group_id)->pluck('member_id')->toArray();
			$leads = Lead::whereIn('agent_id', $agents)->pluck('id');
			$query = $query->whereIn('id', $leads);
		}
		if (@$request->agent_id != 0) {
				$leads = Lead::where('agent_id',$request->agent_id)->orWhere('commercial_agent_id',$request->agent_id)->pluck('id');
				$query = $query->whereIn('id',$leads);
		} else {
			$users = [];
			$user_ids = [];
			if (auth()->user()->type == 'admin' or @Group::where('team_leader_id', auth()->id())->count()) {
				if(!$request->teamLeadsTab){
					$teamLeads = Lead::getAgentLeads();
					foreach ($teamLeads as $lead) {
						if ($lead->agent_id != auth()->id()) {
							$users[] = User::find($lead->agent_id);
							$user_ids[] = $lead->agent_id;
						}
					}
					$users = array_unique($users);
					$query = $query->where(function($q) use ($user_ids){
						$q->whereIn('agent_id', $user_ids)->orWhereIn('commercial_agent_id', $user_ids);
					});
				}
			}
		}
		$leadsIds = $query->distinct()->pluck('id');
		$leads = Lead::whereIn('id',$leadsIds);
		if (@$request->project) {
			//$requests = \App\Request::where('project_id','LIKE','%'.$request->project.'%')->distinct()->pluck('lead_id')->toArray();
			//$requests = DB::table('requests')->whereRaw("project_id REGEXP '". $regex . "'")->distinct()->pluck('lead_id')->toArray();
			$regex = '[[:<:]]' . $request->project . '[[:>:]]';       // To Match the whole string of project_id when Filtering from project_id array
			$requests = \App\Request::where('project_id','REGEXP',$regex)->distinct()->pluck('lead_id')->toArray();
			if(count($requests)>0){
				$projectName = \App\Project::where('id',$request->project)->value('en_name');
			}
			else{
				$projectName = null;
			}

			$leads = $leads->whereIn('id', $requests);

		}

		if($request->tags){
			$leadsWithSelectedTags = DB::table('lead_tag')->whereIn('tag_id',$request->tags)->distinct()->pluck('lead_id');
			$leads = $leads->whereIn('id',$leadsWithSelectedTags);
		}

		if($request->leadsNoAction || $request->leadsWithActions){
				// $leadsWithNoAction = DB::table('leads as lead')
				// 										 ->leftjoin('lead_actions as action','lead.id','=','action.lead_id')
				// 										 ->where('action.lead_id',null)
				// 										 ->pluck('lead.id');
				$leads2 = $leads;
				$leads2 = $leads2->distinct()->pluck('id')->toArray();
				$leadsWithActions = LeadAction::whereIn('lead_id',$leads2)->distinct()->pluck('lead_id')->toArray();
				$leadIds = [];
				if($request->leadsNoAction){
					$leadIds = array_diff($leads2,$leadsWithActions);
					$leadsActionType =  $request->leadsNoAction;
				}else{
					$leadIds = $leadsWithActions;
					$leadsActionType =  $request->leadsWithActions;
				}
				if($leadsActionType != 'both'){
					$users = User::where('residential_commercial',$leadsActionType)->pluck('id');
					if($leadsActionType == 'residential'){
						$leads = $leads->whereIn('agent_id',$users)->where('commercial_agent_id',0);
					}
					else{
						$leads = $leads->whereIn('commercial_agent_id',$users)->where('agent_id',0);
					}
				}
				$leads = $leads->whereIn('id',$leadIds);
		}

		if ($request->dateFrom && $request->dateTo ) {
				$leads = $leads->whereRaw("created_at >= ? AND created_at <= ?",array($request->dateFrom." 00:00:00", $request->dateTo." 23:59:59"));
		}
		if ($request->reportType) {
			$leads = $leads->orderBy("id","desc")->get();
		}
		else {
			$leads = $leads->orderBy("id","desc")->paginate(100);
		}
		$commercialAgents = User::where('residential_commercial', 'commercial')->pluck('id')->toArray();
		$residentialAgents = User::where('residential_commercial', 'residential')->pluck('id')->toArray();
		// $r_loca = $request->location;
		// $r = @Location::find($r_loca)->en_name;
		// dd($leads);
		foreach ($leads as $key => $lead) {
			$lead->sourceName = @LeadSource::find($lead->lead_source_id)->name;
			if (@User::find($lead->agent_id)->residential_commercial == 'residential')
				$lead->agentName = @User::find($lead->agent_id)->name;
			if (@User::find($lead->agent_id)->residential_commercial == 'commercial' )
				$lead->commercialAgentName = @User::find($lead->agent_id)->name;
			if ($lead->commercial_agent_id != 0)
				$lead->commercialAgentName = @User::find($lead->commercial_agent_id)->name;
			$reqProjectsIDs = Req::where('lead_id',$lead->id)->where('project_id','!=',null)->orderBy('id', 'desc')->value('project_id');
			if($projectName == ''){
					if($reqProjectsIDs != null){
						if(strpos($reqProjectsIDs,'[') || strpos($reqProjectsIDs,']')){
							$reqProjectsIDs = explode(",",substr($reqProjectsIDs, 1, -1));
							$latestProjectId = array_values(array_slice($reqProjectsIDs, -1))[0];
							$reqProject = Project::find($latestProjectId);
							if($reqProject){
								$lead->projectName = Project::find($latestProjectId)->en_name;
							}else{
								$lead->projectName = '';
							}
						}
						else{
							$reqProject = Project::find($reqProjectsIDs);
							if($reqProject){
								$lead->projectName = Project::find($reqProjectsIDs)->en_name;
							}else{
								$lead->projectName = '';
							}
						}
					}
					else{
						$lead->projectName = '';
					}
			}
			else if($projectName != null && $reqProjectsIDs != null){
					$lead->projectName = $projectName;
			}
			else{
					$lead->projectName = '';
			}
			if($request->location){
				$requestsCount = \App\Request::where([
					'location' => $request->location,
					'lead_id' => $lead->id	
				])->count();
				if($requestsCount > 0){
					$lead->requestLocation = Location::where('id',$request->location)->value('en_name');
				}
			}else{
				$requestsCount = \App\Request::where([
					['location','!=',null],
					['lead_id','=',$lead->id]
				])->orderBy('id','desc')->first();
				if($requestsCount != null){
					$lead->requestLocation = Location::where('id',$requestsCount->location)->value('en_name');
				}
			}
			//}
			// end of project name
			$lastCall = Call::where('lead_id', $lead->id)->orderBy('id', 'desc')->first();
			$lastMeeting = Meeting::where('lead_id', $lead->id)->orderBy('id', 'desc')->first();
			if (@$lastCall->created_at->timestamp > @$lastMeeting->created_at->timestamp) {
				@$leadProbability = $lastCall->probability;
			} else {
				@$leadProbability = $lastMeeting->probability;
			}
			if (!$leadProbability) {
				$leadProbability = 'Follow Up';
			}
			$lead->leadProbability = $leadProbability;
			if($request->tags){
				$lead_tag = $leadInstance->getLeadFirstTag($lead->id);
				if($lead_tag != null){
					$lead->tag = $lead_tag;
				}else{
					$lead->tag = "";
				}
			}
			//$lead->project = @Project::find($ques_led->project_id)->en_name;
			if (@Req::where('lead_id', $lead->id)->where('unit_type', 'residential')->where('unit_type', 'commercial')->count() > 0) {
				$leadType = __('admin.residential') . ' - ' . __('admin.commercial');
			} elseif (@Req::where('lead_id', $lead->id)->where('unit_type', 'residential')->where('unit_type', '!=', 'commercial')->count() > 0) {
				$leadType = __('admin.residential');
			} elseif (@Req::where('lead_id', $lead->id)->where('unit_type', '!=', 'residential')->where('unit_type', 'commercial')->count() > 0) {
				$leadType = __('admin.commercial');
			} else {
				$leadType = __('admin.residential');
			}
			// $color = '';
			// if (DB::table('lead_actions')->whereIn('user_id', $commercialAgents)->where('lead_id', $lead->id)->count() > 0) {
			// 	$color = 1;
			// } else {
			// 	$color = 0;
			// }
			// $color2 = '';
			// if (DB::table('lead_actions')->where('lead_id', $lead->id)->where(function($query) use ($residentialAgents, $commercialAgents){
			// 	$query->whereIn('user_id', $residentialAgents)->orWhereIn('user_id', $commercialAgents);
			// })->count() > 0) {
			// 	$color2 = 1;
			// } else {
			// 	$color2 = 0;
			// }
			// $lead->commercial_status = $color;
			// $lead->personal_status = $color2;

			if(!$request->leadsNoAction){
				if ($lead->seen) {
					$seen = 'seen_without_action';
					$sColor = 'orange';
					$lead->seen = 1;
					if (DB::table('lead_actions')->where('lead_id', $lead->id)->count()) {
						$seen = 'seen_with_action';
						$sColor = 'green';
						$lead->seen = 2;
					}
				} else {
					$lead->seen = 0;
				}
				$color = '';
				if (DB::table('lead_actions')->whereIn('user_id', $commercialAgents)->where('lead_id', $lead->id)->count() > 0) {
					$color = 1;
				} else {
					$color = 0;
				}
				$color2 = '';
				if (DB::table('lead_actions')->where('lead_id', $lead->id)->where(function($query) use ($residentialAgents, $commercialAgents){
					$query->whereIn('user_id', $residentialAgents)->orWhereIn('user_id', $commercialAgents);
				})->count() > 0) {
					$color2 = 1;
				} else {
					$color2 = 0;
				}
			}
			else{
					$color = 0;
					$color2 = 0;
			}
			$lead->commercial_status = $color;
			$lead->personal_status = $color2;

			$lead->type = $leadType;
			// dd($leads);

		}
		if ($request->reportType) {
			// dd('qqqqqqqqqqqq');
			// dd($leads->toArray());
			$this->exportReportLeads($leads->toArray());
		}
		else
			return $leads;
	}

	public function searchForLead(Request $request){
dd($request->all());
		$search = $request->searchInput;
		$teamLead = Group::where('team_leader_id', Auth::user()->id)->count();
		$commercialAgents = @\App\User::where('residential_commercial', 'commercial')->pluck('id')->toArray();
		$residentialAgents = @\App\User::where('residential_commercial', 'residential')->pluck('id')->toArray();
		if (Auth::user()->type === 'admin' ) {
			//return ['abed'];
			$leads = DB::table('leads')
			->where('first_name', 'LIKE', '%' . $search . '%')
			->orWhere('middle_name', 'LIKE', '%' . $search . '%')
			->orWhere('last_name', 'LIKE', '%' . $search . '%')
			->orWhere('ar_first_name', 'LIKE', '%' . $search . '%')
			->orWhere('ar_middle_name', 'LIKE', '%' . $search . '%')
			->orWhere('ar_last_name', 'LIKE', '%' . $search . '%')
			->orWhere('phone', 'LIKE', '%' . $search . '%')
			->orWhere('phone_iso', 'LIKE', '%' . $search . '%')
			->get();
			foreach ($leads as $key => $lead) {
				if (@User::find($lead->agent_id)->residential_commercial == 'residential')
				$lead->agentName = @User::find($lead->agent_id)->name;
			if (@User::find($lead->agent_id)->residential_commercial == 'commercial' )
				$lead->commercialAgentName = @User::find($lead->agent_id)->name;
			if ($lead->commercial_agent_id != 0)
				$lead->commercialAgentName = @User::find($lead->commercial_agent_id)->name;
				// $color = '';
				// if (DB::table('lead_actions')->whereIn('user_id', $commercialAgents)->where('lead_id', $lead->id)->count() > 0) {
				// 	$color = 1;
				// } else {
				// 	$color = 0;
				// }
				// $color2 = '';
				// if (DB::table('lead_actions')->whereIn('user_id', $residentialAgents)->where('lead_id', $lead->id)->count() > 0) {
				// 	$color2 = 1;
				// } else {
				// 	$color2 = 0;
				// }
				// $lead->commercial_status = $color;
				// $lead->personal_status = $color2;
				if ($lead->seen) {
					$seen = 'seen_without_action';
					$sColor = 'orange';
					$lead->seen = 1;
					if (DB::table('lead_actions')->where('lead_id', $lead->id)->count()) {
						$seen = 'seen_with_action';
						$sColor = 'green';
						$lead->seen = 2;
					}
				} else {
					$lead->seen = 0;
				}

				$color = '';
				if (DB::table('lead_actions')->whereIn('user_id', $commercialAgents)->where('lead_id', $lead->id)->count() > 0) {
					$color = 1;
				} else {
					$color = 0;
				}

				$color2 = '';
				if (DB::table('lead_actions')->where('lead_id', $lead->id)->where(function($query) use ($residentialAgents, $commercialAgents){
					$query->whereIn('user_id', $residentialAgents)->orWhereIn('user_id', $commercialAgents);
				})->count() > 0) {
					$color2 = 1;
				} else {
					$color2 = 0;
				}
				$lead->commercial_status = $color;
				$lead->personal_status = $color2;

			}

			return $leads;

		}elseif(Auth::user()->type != 'admin' && $teamLead){
			$groupId = Group::where('team_leader_id', Auth::user()->id)->first();
			$groupUsers = GroupMember::where('group_id',$groupId['id'])->pluck('member_id')->toArray();
			$id = Auth::user()->id;

			$team = array_unique($groupUsers);
			$query = new lead();

			$leaderHasGroup = \App\Group::where('team_leader_id', $id)->first();
			if($leaderHasGroup){
				$groupAgents = GroupMember::where('group_id', $leaderHasGroup->id)->pluck('member_id')->toArray();
				array_push($groupAgents,$id);
				if(count($groupAgents)>0){
					$commercialAgents = @\App\User::where('residential_commercial', 'commercial')->whereIn('id', $groupAgents)->get()->pluck('id')->toArray();
					$residentialAgents = @\App\User::where('residential_commercial', 'residential')->whereIn('id', $groupAgents)->get()->pluck('id')->toArray();
				}
			}

			$query = $query->where(function( $q ) use($commercialAgents, $residentialAgents){
				$q->whereIn('commercial_agent_id', $commercialAgents)->orWhereIn('agent_id', $residentialAgents);
			});

			$leads = $query->where(function($q) use ($search){
				$q->where('first_name', 'LIKE', '%' . $search . '%')
				->orWhere('middle_name', 'LIKE', '%' . $search . '%')
				->orWhere('last_name', 'LIKE', '%' . $search . '%')
				->orWhere('ar_first_name', 'LIKE', '%' . $search . '%')
				->orWhere('ar_middle_name', 'LIKE', '%' . $search . '%')
				->orWhere('ar_last_name', 'LIKE', '%' . $search . '%')
				->orWhere('phone', 'LIKE', '%' . $search . '%')
				->orWhere('phone_iso', 'LIKE', '%' . $search . '%');
			})->get();
			foreach ($leads as $key => $lead) {
				if (@User::find($lead->agent_id)->residential_commercial == 'residential')
				$lead->agentName = @User::find($lead->agent_id)->name;
				if (@User::find($lead->agent_id)->residential_commercial == 'commercial' )
				$lead->commercialAgentName = @User::find($lead->agent_id)->name;
				if ($lead->commercial_agent_id != 0)
				$lead->commercialAgentName = @User::find($lead->commercial_agent_id)->name;

				if ($lead->seen) {
					$seen = 'seen_without_action';
					$sColor = 'orange';
					$lead->seen = 1;
					if (DB::table('lead_actions')->where('lead_id', $lead->id)->count()) {
						$seen = 'seen_with_action';
						$sColor = 'green';
						$lead->seen = 2;
					}
				} else {
					$lead->seen = 0;
				}

				$color = '';
				if (DB::table('lead_actions')->whereIn('user_id', $commercialAgents)->where('lead_id', $lead->id)->count() > 0) {
					$color = 1;
				} else {
					$color = 0;
				}

				$color2 = '';
				if (DB::table('lead_actions')->where('lead_id', $lead->id)->where(function($query) use ($residentialAgents, $commercialAgents){
					$query->whereIn('user_id', $residentialAgents)->orWhereIn('user_id', $commercialAgents);
				})->count() > 0) {
					$color2 = 1;
				} else {
					$color2 = 0;
				}
				$lead->commercial_status = $color;
				$lead->personal_status = $color2;

			}
			return $leads;
		}
		else{

			$leads = DB::table('leads')
			->where(function($query) use ($request) {
				$query->where('agent_id', Auth::user()->id)->orWhere('commercial_agent_id', Auth::user()->id);
			})
			->where(function($query) use ($request) {
				$query
				->where('first_name', 'LIKE', '%' . $request->searchInput . '%')
				->orWhere('middle_name', 'LIKE', '%' . $request->searchInput . '%')
				->orWhere('last_name', 'LIKE', '%' . $request->searchInput . '%')
				->orWhere('ar_first_name', 'LIKE', '%' . $request->searchInput . '%')
				->orWhere('ar_middle_name', 'LIKE', '%' . $request->searchInput . '%')
				->orWhere('ar_last_name', 'LIKE', '%' . $request->searchInput . '%')
				->orWhere('phone', 'LIKE', '%' . $request->searchInput . '%')
				->orWhere('phone_iso', 'LIKE', '%' . $request->searchInput . '%');
			})
			->get();
			foreach ($leads as $key => $lead) {
				if (@User::find($lead->agent_id)->residential_commercial == 'residential')
				$lead->agentName = @User::find($lead->agent_id)->name;
			if (@User::find($lead->agent_id)->residential_commercial == 'commercial' )
				$lead->commercialAgentName = @User::find($lead->agent_id)->name;
			if ($lead->commercial_agent_id != 0)
				$lead->commercialAgentName = @User::find($lead->commercial_agent_id)->name;
				// $color = '';
				// if (DB::table('lead_actions')->whereIn('user_id', $commercialAgents)->where('lead_id', $lead->id)->count() > 0) {
				// 	$color = 1;
				// } else {
				// 	$color = 0;
				// }
				// $color2 = '';
				// if (DB::table('lead_actions')->whereIn('user_id', $residentialAgents)->where('lead_id', $lead->id)->count() > 0) {
				// 	$color2 = 1;
				// } else {
				// 	$color2 = 0;
				// }
				// $lead->commercial_status = $color;
				// $lead->personal_status = $color2;
				if ($lead->seen) {
					$seen = 'seen_without_action';
					$sColor = 'orange';
					$lead->seen = 1;
					if (DB::table('lead_actions')->where('lead_id', $lead->id)->count()) {
						$seen = 'seen_with_action';
						$sColor = 'green';
						$lead->seen = 2;
					}
				} else {
					$lead->seen = 0;
				}

				$color = '';
				if (DB::table('lead_actions')->whereIn('user_id', $commercialAgents)->where('lead_id', $lead->id)->count() > 0) {
					$color = 1;
				} else {
					$color = 0;
				}

				$color2 = '';
				if (DB::table('lead_actions')->where('lead_id', $lead->id)->where(function($query) use ($residentialAgents, $commercialAgents){
					$query->whereIn('user_id', $residentialAgents)->orWhereIn('user_id', $commercialAgents);
				})->count() > 0) {
					$color2 = 1;
				} else {
					$color2 = 0;
				}
				$lead->commercial_status = $color;
				$lead->personal_status = $color2;

			}
			return $leads;
		}


	}

	public function getPublicData(Request $request){
		$callStatus = @\App\CallStatus::select('id','name','has_next_action')->get();
		//$projects = Project::where('resale_units', $request->Unit)->first();
		//return $projects;
		$meetingStatus = \App\MeetingStatus::select('id','name')->get();
		$locations = @\App\Location::select('id','en_name')->get();
		$groups = @\App\Group::select('id','name')->get();
		$developers = @\App\Developer::select('id','en_name')->get();
		$districts = @\App\District::select('id','city_id','en_name')->get();
		$cities = @\App\City::select('id','country_id','name')->get();
		$projects = @\App\Project::select('id','en_name','type','location_id')->get();
		$unit_type= UnitType::select('id','usage','en_name')->get();
		$tags = Tag::select('id','en_name')->get();
		return ['callStatus' => $callStatus,'projects'=>$projects,'unit_type' => $unit_type,
		'meetingStatus'=>$meetingStatus,'locations'=>$locations,'groups'=>$groups,'developers' => $developers , 'districts' => $districts, 'cities' => $cities ,'tags' => $tags] ;

	}

	public function getAgents(){
		$commercialAgents = [];
		$residentialAgents = [];
		if(Auth::user()->type == 'admin'){
			$commercialAgents = @\App\User::select('id','name')->where('residential_commercial', 'commercial')->get()->toArray();
			$residentialAgents = @\App\User::select('id','name')->where('residential_commercial', 'residential')->get()->toArray();
		}else {
			$id = Auth::user()->id;
			$leaderHasGroup = \App\Group::select('id')->where('team_leader_id', $id)->first();
			if($leaderHasGroup){
				$groupAgents = GroupMember::where('group_id', $leaderHasGroup->id)->pluck('member_id')->toArray();
				array_push($groupAgents,$id);
				if(count($groupAgents)>0){
					$commercialAgents = @\App\User::select('id','name')->where('residential_commercial', 'commercial')->whereIn('id',$groupAgents)->get()->toArray();
					$residentialAgents = @\App\User::select('id','name')->where('residential_commercial', 'residential')->whereIn('id',$groupAgents)->get()->toArray();
				}
			}
		}

		return ['commercialAgents' => $commercialAgents,'residentialAgents'=>$residentialAgents];

	}

	public function checkUserGroupAndRoles(){
		$id = Auth::user()->id;
		$leaderHasGroup = \App\Group::where('team_leader_id', $id)->count();

		$permArray = ['switch_leads'=>0,
					'export_excel'=>0,
					'add_leads'=>0,
					'edit_leads'=>0,
					'show_all_leads'=>0,
					'send_cil'=>0,
					'calls'=>0,
					'meetings'=>0,
					'requests'=>0,

					'add_developers'=>0,
					'edit_developers'=>0,
					'delete_developers'=>0,
					'show_developers'=>0,
					'add_projects'=>0,
					'edit_projects'=>0,
					'delete_projects'=>0,
					'show_projects'=>0,
					'add_phases'=>0,
					'edit_phases'=>0,
					'delete_phases'=>0,
					'show_phases'=>0,
					'add_properties'=>0,
					'edit_properties'=>0,
					'delete_properties'=>0,
					'show_properties'=>0,
					'add_resale_units'=>0,
					'edit_resale_units'=>0,
					'delete_resale_units'=>0,
					'show_resale_units'=>0,
					'add_rental_units'=>0,
					'edit_rental_units'=>0,
					'delete_rental_units'=>0,
					'show_rental_units'=>0,
					'add_lands'=>0,
					'edit_lands'=>0,
					'delete_lands'=>0,
					'show_lands'=>0,
					'proposals'=>0,
					'marketing'=>0,

					'deals'=>0,
					'finance'=>0,
					];
		foreach($permArray as $key=>$value){
			$permArray[$key] = checkRole($key);
		}

		return ['leaderHasGroup' => $leaderHasGroup,'permArray'=>$permArray];

	}
	public function getUnitsTypesnew(Request $request)
	{

		// dd($request->all());
		$usage = $request->usage;
		// dd($usage);
		if($usage == 'residential'){
			$usage = 'personal';
		}
		$types = @\App\UnitType::where('usage', $usage)->get();
		return $types;
	}

	public function addToDo(Request $request){

		$todo = new ToDo;
		$todo->leads = $request->leads;
		$todo->description = $request->description;
		$todo->to_do_type = $request->to_do_type;
		$todo->due_date = strtotime($request->due_date);
		$todo->time = strtotime($request->time);
		$todo->user_id = auth()->user()->id;
		$todo->status = 'pending';
		$todo->save();

		return $todo;
	}

	public function getDevProjects($id)
	{
		$projects = @Project::where('developer_id', $id)->get();
		return $projects;
	}

	public function addCILRequest(Request $request){

		$rules = [
			"developer" => 'required',
			"project" => 'required',
		];
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return ["required"=>"false",'status'=>'501', $validator->errors()];
		}else{
			$cil = new Cil;
			$cil->lead_id = $request->lead_id;
			$cil->developer_id = $request->developer;
			$cil->status = 'not_sent';
			$cil->user_id = auth()->user()->id;
			$cil->project_id = $request->project;
			$saved = $cil->save();

			if($saved){
				$GetOPRole = Role::where('name','operation')->first();
				$getUsers = User::where('role_id',$GetOPRole->id)->get();
				// dd($getUsers);
				foreach ($getUsers as $user) {
					$userPlayer = Player::where('user_id',$user->id)->first();
					if(!empty($userPlayer)){
						// dd($userPlayer);
						$Omassege = "first massege send Notification";
						$this->signalHelper($userPlayer->player_id,$Omassege);
						$noti = new AdminNotification;
						$noti->user_id = Auth::user()->id;
						$noti->assigned_to = $user->id;
						$noti->type = 'cil';
						$noti->type_id = $request->lead_id;
						$noti->status = 0;
						$noti->save();	
					}
					// dd($userPlayer);
				}
			}

			$developer_excel = $cil->developer->xls_url;
			if($developer_excel != null){
				$path = $developer_excel;
				$extension = explode('.',$path)[1];
				if ($extension == "xls" || $extension == "xlsx" || $extension == "csv") {
					$fileName =  'excel_' . rand(0, 99999999999);
					$data = Excel::load($path, function($reader) {
					})
					->setFilename($fileName)
					->store($extension,'uploads/cils');
					$publicPath = 'uploads/cils/'. $fileName . '.' . $extension;
				}
				else{
					if ($extension == "doc") {
                        $phpWord = \PhpOffice\PhpWord\IOFactory::load($path, 'MsDoc');
                    } else if ($extension == "rtf") {
                        $phpWord = \PhpOffice\PhpWord\IOFactory::load($path, 'RTF');  
                    } else if ($extension == "docx") {
                        $phpWord = \PhpOffice\PhpWord\IOFactory::load($path);                        
                    }
					ob_clean();
					$fileName =  'word_' . rand(0, 99999999999) . '.' . $extension;
					$publicPath = 'uploads/cils/'. $fileName;
                    $phpWord->save($publicPath);
				}
			}
			else{
				$publicPath = null;
			}
			DB::table('cils_info')->insert([
				'cil_id' => $cil->id,
				'sheet' => $publicPath,
				'user_id' => auth()->user()->id,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			]);

			return $cil;
		}
	}

	public function getAllLeads(){
		// TODO: refactore
		ini_set('memory_limit', '-1');

		if(Auth::user()->type == 'admin'){
			$leads = Lead::all();
		}else {
			$leads = Lead::where('agent_id', Auth::user()->id)->orWhere('commercial_agent_id', Auth::user()->id)->get()->toArray();
		}
		$newLeadsArray  = [];
		foreach($leads as $lead){
			$newLeadsArray[$lead['id']] =  $lead['first_name'].' '.$lead['last_name'];
			// $newLeadsArray['id'] = $lead['id'];
		}
		return $newLeadsArray;
	}

	public function getAllLeadsAutocompleteList(Request $request)
	{
		$q = $request->query('q');
		$dbQuery = Lead::select(array('first_name', 'last_name', "id", "phone", "agent_id", "commercial_agent_id"));

		if(Auth::user()->type == 'admin'){
			$data = $dbQuery
			->where(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'LIKE', "%{$q}%")
			->orWhere("phone","LIKE", "%{$q}%")
			->orderBy('id', 'desc')
			->limit(25)
			->get();
		} else {
			$data = $dbQuery
			->where(function ($query) use ($q) {
				$query
				->where(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'LIKE', "%{$q}%")
				->where(function ($query) {
					$query
					->where("agent_id", Auth::user()->id)
					->orWhere("commercial_agent_id", Auth::user()->id);
				});
			})
			->orWhere(function ($query) use ($q) {
				$query
				->where("phone","LIKE", "%{$q}%")
				->where(function ($query) {
					$query
					->where("agent_id", Auth::user()->id)
					->orWhere("commercial_agent_id", Auth::user()->id);
				});
			})
			->orderBy('id', 'desc')
			->limit(25)
			->get();
		}

		return response()->json($data);
	}

	public function leadShortAdding(Request $request){
		$lead = new Lead;
		$leadInstance = new Lead;
		$leadFound = DB::table('leads')->where('phone','LIKE','%'.$request->phone.'%')->first();
		if(!$leadFound){
			$lead->first_name = $request->leadFirstName;
			$lead->last_name = $request->leadLastName;
			
			$contact = $leadInstance->reformPhone($request->phone);

			$lead->phone = $contact->phone;
			$lead->phone_iso = $contact->iso;
			$lead->lead_source_id = $request->sourceId;
			$lead->reference = $request->reference;
			$lead->notes = $request->notes;
			$lead->user_id = auth()->user()->id;

			if($request->checkIndividual == true){
				$lead->agent_id = 0;
				$lead->commercial_agent_id = 0;
			}
			else{
				if (auth()->user()->type == "agent" && auth()->user()->residential_commercial == "residential") {
					$lead->agent_id = auth()->user()->id;
				} elseif (auth()->user()->type == "agent" && auth()->user()->residential_commercial == "commercial") {
					$lead->commercial_agent_id = auth()->user()->id;
				}
	
				if ($request->has('r_agent')) {
					$lead->agent_id = $request->r_agent;
				} elseif ($request->has('c_agent')) {
					$lead->commercial_agent_id = $request->c_agent;
				}
			}
			
			$lead->save();
			if($request->request){
				if($request['request']){
					if($request['request']['projects']){
						foreach ($request['request']['projects'] as $project) {
							$lead_request = new Req;
							$lead_request->user_id = Auth::user()->id;
							$lead_request->lead_id = $lead->id;
							$lead_request->location = $request['request']['location'];
							$lead_request->request_type = $request['request']['request_type'];
							$lead_request->type = $request['request']['type'];
							$lead_request->unit_type = $request['request']['unit_type'];
							$lead_request->project_id = $project['id'];		
							$lead_request->save();
						}
					}else{
						$lead_request = new Req;
						$lead_request->user_id = Auth::user()->id;
						$lead_request->lead_id = $lead->id;
						$lead_request->location = $request['request']['location'];
						$lead_request->request_type = $request['request']['request_type'];
						$lead_request->type = $request['request']['type'];
						$lead_request->unit_type = $request['request']['unit_type'];
						$lead_request->project_id = null;		
						$lead_request->save();
					}
				}
			}
		}
		else{ 
			DB::table('leads')->where('phone',$request->phone)->update([
				'notes' => $request->notes,
				'created_at' => Carbon::now()
			]);
			if($request['request']){
				$lead_request = Req::where('lead_id',$leadFound->id)->orderBy('created_at','desc')->first();
				if(!$lead_request){
					$lead_request = new Req;
					$lead_request->lead_id = $leadFound->id;
				}
				$lead_request->user_id = Auth::user()->id;
				if($request['request']['location']){
					$lead_request->location = $request['request']['location'];
				}
				if($request['request']['request_type']){
					$lead_request->request_type = $request['request']['request_type'];
				}
				if($request['request']['type']){
					$lead_request->type = $request['request']['type'];
				}
				if($request['request']['unit_type']){
					$lead_request->unit_type = $request['request']['unit_type'];						
				}
				if($request['request']['projects']){
					$lead_request->project_id = $request['request']['projects']['id'];				
				}
				$lead_request->save();
			}
		}
		
		return $lead;
	}
	// Excel export from el senior eslam

	public function exportReportLeads($data)
	{
		// dd('sssss');
		// $data = Lead::get()->toArray();
		// $data = $this->newLeadsFilter($request)->toArray();
		// dd($data);
		// dd(\App\User::find($data[0]['commercial_agent'])->name);
		foreach ($data as $key => $value) {
		  //  dd($value);
			$residentialAgents = \App\User::find($value['agent_id']);
			if ($residentialAgents)
				$residentialAgents = $residentialAgents->name;
			$commercialAgents = \App\User::find($value['commercial_agent_id']);
			if ($commercialAgents)
				$commercialAgents = $commercialAgents->name;
			$call = \App\Call::where('lead_id', $value['id'])->first();
			$description = '';
			$call_status = '';
			if ($call)
			{
				$description = $call->description;
				$call_status = $call->call_status->name;
			}
			$data[$key] = [
							"first_name"=> $value['first_name'],
							"last_name"=> $value['last_name'],
							"phone"=> $value['phone'],
							"email"=> $value['email'],
							"project"=> $value['projectName'],
							"sourceName"=> $value['sourceName'],
							"residentialAgents"=> $residentialAgents,
							"commercialAgents"=> $commercialAgents,
							"call_status"=> $call_status,
							"description"=> $description,
						];
		}
		// dd($data);
		return \Excel::create('Leads_Report', function($excel) use ($data) {
			$excel->sheet('mySheet', function($sheet) use ($data)
			{
				$sheet->fromArray($data);
			});
		})->download('xls');
	}

	public function deleteNoActionLeads(){
			//$leadsWithNoAction = Call::whereNotIn('call_status_id',[4,6])->pluck('lead_id');
			$leadsWithUnAnsweredActions = DB::table('calls')
													 ->whereNotIn('call_status_id',[4,6])
													 ->groupBy('lead_id')
													 ->pluck('lead_id');
			$leadsWithNoAction = DB::table('leads as lead')
													 ->leftjoin('lead_actions as action','lead.id','=','action.lead_id')
													 ->where('action.lead_id',null)
													 ->pluck('lead.id');
		return DB::table('leads')->whereIn('id', $leadsWithUnAnsweredActions)->OrWhereIn('id',$leadsWithNoAction)->delete();
	}

	public function filterLeadsToDelete(){
			if(Auth::user()->type != 'admin'){
					return abort(404);
			}
			return view('admin.leads.filterLeadsToDelete');
	}

	public function deleteFilteredLeads(Request $request){
		$projectName = '';
		$query = new Lead;
		$id = Auth::user()->id;
		return $request;
		if ($request->leadSources) {
			$leadSources = Lead::where('lead_source_id', $request->leadSources)->distinct()->pluck('id');
			$query = $query->whereIn('id', $leadSources);
		}
		if ($request->callStatus) {
			$calls = Call::where('call_status_id', $request->callStatus)->pluck('lead_id');
			$query = $query->whereIn('id', $calls);
		}
		if ($request->meetingStatus) {
			$meetings = Meeting::where('meeting_status_id', $request->meetingStatus)->pluck('lead_id');
			$query = $query->whereIn('id', $meetings);
		}
		if ($request->group_id && $request->group_id != 0) {
			$agents = GroupMember::where('group_id', $request->group_id)->pluck('member_id');
			$leads = Lead::whereIn('agent_id', $agents)->orWhereIn('commercial_agent_id',$agents)->pluck('id');
			$query = $query->whereIn('id',$leads);
		}
		if ($request->agent_id && $request->agent_id != 0) {
				$leads = Lead::where('agent_id',$request->agent_id)->orWhere('commercial_agent_id',$request->agent_id)->pluck('id');
				$query = $query->whereIn('id',$leads);
		}
		if ($request->project) {
			$regex = '[[:<:]]' . $request->project . '[[:>:]]';       // To Match the whole string of project_id when Filtering from project_id array
			$requestLeads = \App\Request::where('project_id','REGEXP',$regex)->distinct()->pluck('lead_id');
			$query = $query->whereIn('id', $requestLeads);
		}
		if($request->leadsNoAction && $request->leadsNoAction!= null){
				//$query2 = $query;
				$leadsWithNoAction = DB::table('leads as lead')
														 ->leftjoin('lead_actions as action','lead.id','=','action.lead_id')
														 ->where('action.lead_id',null)
														 ->pluck('lead.id');
				if($request->leadsNoAction != 'both'){
					$users = User::where('residential_commercial',$request->leadsNoAction)->pluck('id');
						if($request->leadsNoAction == 'residential'){
							$leads = Lead::whereIn('agent_id',$users)->where('commercial_agent_id',0);
						}
						else{
							$leads = Lead::whereIn('commercial_agent_id',$users)->where('agent_id',0);
						}
						$query = $query->whereIn('id',$leads);
				}
				$query = $query->whereIn('id',$leadsWithNoAction);
		}

		if ($request->dateFrom && $request->dateTo ) {
				$query = $query->whereRaw("created_at >= ? AND created_at <= ?",array($request->dateFrom." 00:00:00", $request->dateTo." 23:59:59"));
		}
		return $query->delete();
	}

	public function getUnitLeads(Request $request){
		$user = auth()->user();
		$project_name = '';
		$query = new Lead;
		$leadInstance = new Lead;
		if($request->tab == 0){
			$table_name = "resale_units as unit";
		}else{
			$table_name = "rental_units as unit";
		}
		if($user->type == "admin"){
			$leads = DB::table('leads as lead')->join("$table_name",'lead.id','=','unit.lead_id')
			->select('lead.id','lead.first_name','lead.last_name','lead.lead_source_id','lead.agent_id','lead.commercial_agent_id','lead.phone','lead.created_at','lead.favorite','lead.hot','lead.seen')
			->orderBy('lead.created_at', 'desc')
			->distinct('lead.id')
			->paginate(100);
		}
		else{
			$leaderHasGroup = \App\Group::where('team_leader_id', $user->id)->first();
			if($leaderHasGroup){
				$groupAgents = GroupMember::where('group_id', $leaderHasGroup->id)->pluck('member_id')->toArray();
				array_push($groupAgents,$user->id);
				$leads = DB::table('leads as lead')->join("$table_name",'lead.id','=','unit.lead_id')
										->whereIn('lead.agent_id',$groupAgents)
										->orWhereIn('lead.commercial_agent_id',$groupAgents)
										->select('lead.id','lead.first_name','lead.last_name','lead.lead_source_id','lead.agent_id','lead.commercial_agent_id','lead.phone','lead.created_at','lead.favorite','lead.hot','lead.seen')
										->orderBy('lead.created_at', 'desc')
										->distinct('lead.id')
										->paginate(100);
			}
			else{
				$leads = DB::table('leads as lead')->join("$table_name",'lead.id','=','unit.lead_id')
										->where('lead.agent_id',$user->id)
										->orWhere('lead.commercial_agent_id',$user->id)
										->select('lead.id','lead.first_name','lead.last_name','lead.lead_source_id','lead.agent_id','lead.commercial_agent_id','lead.phone','lead.created_at','lead.favorite','lead.hot','lead.seen')
										->orderBy('lead.created_at', 'desc')
										->distinct('lead.id')
										->paginate(100);								
			}
		}

		$commercialAgents = User::where('residential_commercial', 'commercial')->pluck('id')->toArray();
		$residentialAgents = User::where('residential_commercial', 'residential')->pluck('id')->toArray();
		
		foreach ($leads as $lead) {
			$lead->sourceName = @LeadSource::where('id',$lead->lead_source_id)->value('name');

			$lastCall = Call::select('created_at','probability')->where('lead_id', $lead->id)->orderBy('created_at', 'desc')->first();
			$lastMeeting = Meeting::select('created_at','probability')->where('lead_id', $lead->id)->orderBy('created_at', 'desc')->first();
			if (@$lastCall->created_at->timestamp > @$lastMeeting->created_at->timestamp) {
				@$leadProbability = $lastCall->probability;
			} else {
				@$leadProbability = $lastMeeting->probability;
			}
			if (!$leadProbability) {
				$leadProbability = 'Follow Up';
			}
			$lead->leadProbability = $leadProbability;
			if ($lead->seen) {
				$seen = 'seen_without_action';
				$sColor = 'orange';
				$lead->seen = 1;
				if (DB::table('lead_actions')->where('lead_id', $lead->id)->where(function($query) use ($lead){
					$query->where('user_id', $lead->agent_id)->orWhere('user_id', $lead->commercial_agent_id);
				})->count() > 0) {
					$seen = 'seen_with_action';
					$sColor = 'green';
					$lead->seen = 2;
				}
				else if (DB::table('lead_actions')->where('lead_id', $lead->id)->count()) {
					$seen = 'seen_with_action';
					$sColor = 'green';
					$lead->seen = 3;
				}
			} else {
				$lead->seen = 0;
			}
			$color = '';
			if (DB::table('lead_actions')->whereIn('user_id', $commercialAgents)->where('lead_id', $lead->id)->count() > 0) {
				$color = 1;
			} else {
				$color = 0;
			}
			$color2 = '';
			if (DB::table('lead_actions')->where('lead_id', $lead->id)->where(function($query) use ($residentialAgents, $commercialAgents){
				$query->whereIn('user_id', $residentialAgents)->orWhereIn('user_id', $commercialAgents);
			})->count() > 0) {
				$color2 = 1;
			} else {
				$color2 = 0;
			}
			$lead_tag = $leadInstance->getLeadFirstTag($lead->id);
			if($lead_tag != null){
				$lead->tag = $lead_tag;						
			}else{
				$lead->tag = "";
			}
			$lead->commercial_status = $color;
			$lead->personal_status = $color2;

			$ques_led = @Req::select('location','project_id')->where('lead_id', $lead->id)->orderBy('created_at', 'desc')->first();
			if($ques_led) {
				$lead->requestLocation =  @Location::where('id',$ques_led->location)->value('en_name');
				$project_name = @Project::where('id',$ques_led->project_id)->value('en_name');
				if($project_name!=null){
					$lead->projectName = $project_name;
				}
				else{
					$lead->projectName = '';
				}
			}

			if (@Req::where('lead_id', $lead->id)->where('unit_type', 'residential')->where('unit_type', 'commercial')->count() > 0) {
				$leadType = __('admin.residential') . ' - ' . __('admin.commercial');
			} elseif (@Req::where('lead_id', $lead->id)->where('unit_type', 'residential')->where('unit_type', '!=', 'commercial')->count() > 0) {
				$leadType = __('admin.residential');
			} elseif (@Req::where('lead_id', $lead->id)->where('unit_type', '!=', 'residential')->where('unit_type', 'commercial')->count() > 0) {
				$leadType = __('admin.commercial');
			} else {
				$leadType = 'N/A';
			}

			$lead->type = $leadType;
			// dd($leads);
		}
		return $leads;
	}

	public function gitleadmassege(Request $request)
	{
		$Leadmassege = \App\Massage::where('lead_id',$request->id)->get();
		return $Leadmassege;
	}

	public function gitleadHistory(Request $request)
	{
		// $leadHistory = \App\Log::where('route','leads')->where('route_id',$request->id)->get();
		// $user = \App\User::find($log->user_id)->name;
		$leadHistory = DB::table("logs")
		->leftjoin("users","logs.user_id","=","users.id")
		->select("logs.route_id","logs.id as id","logs.en_title","logs.type","logs.ar_title","users.name","logs.created_at")
		->where("logs.route_id",$request->id)
		->get();
		return response()->json($leadHistory);
	}

	public function getleadcontracts(Request $request)
	{
		// dd($request->all());
		// $leadContract = \App\Contract::where('lead_id',$request->id)->get();
		$leadContract = DB::table("contracts as c")
		->leftjoin("users as u","c.user_id","=","u.id")
		->select("c.id as id","c.status","c.created_at","u.name")
		->where("c.lead_id",$request->id)
		->get();
		return ($leadContract);
	}
	
	public function FromrequestPage(Request $request)
	{
		// Location
		// unit type
		// dd($request->all());
		// $requestLead = Req::where('lead_id',$request->id)->get();
		
		$requestLead = DB::table('requests as request')
		->leftJoin('locations as location','request.location','=','location.id')
		->leftJoin('unit_types as unit','request.unit_type_id','=','unit.id')
		->select('request.id as id','location.en_name as location_name','unit.en_name as unit_name','request.created_at')
		->where('request.lead_id',$request->id)
		->GroupBy('request.lead_id')
		->get();
		return $requestLead;
		// dd($requestLead);
		// $requestData = 
	}

	protected function parsDate($pram){
        $date = Carbon::parse($pram);
        $res = ($date->format("Y/m/d"));
        return strtoupper($res);
	}

	public function getleadcontacts(Request $request)
	{
		$leadsContact = \App\Contact::where("lead_id",$request->id)->get();
		return $leadsContact;
	}

	public function addleadcontact(Request $request)
	{
		foreach ($request->data as $contact) {
			$decode_contact = json_decode($contact);
			$contact = new \App\Contact;
			$contact->name = $decode_contact->name;
			$contact->relation = $decode_contact->relation;
			$contact->phone = $decode_contact->phone;
			$contact->email = $decode_contact->email;
			$contact->lead_id = $request->lead_id;
			$contact->save();
		}
		return response()->json([
			'status' => 200,
			'massege' => "add successfully"
		],200);
	}
	public function getleadinterest(Request $request)
	{
		// dd($request->all());
		// $interest = \App\Interested::where('lead_id',$request->id)->get();
		$interest = DB::table('interesteds as in')
		->leftJoin('projects as project','in.unit_id','=','project.id')
		->select('in.id as id','in.type','in.lead_id','project.en_name','in.created_at')
		->where('in.lead_id',$request->id)
		->get();
		return $interest;
	}

	public function GetFavoriteLead(Request $request)
	{
		// dd($request->all());
		// $leadfavorite = \App\Favorite::where('lead_id',$request->id)->get();
		$leadfavorite = DB::table("favorites as f")
		->leftjoin("projects as pro","f.unit_id","=","pro.id")
		->select("f.id as id","f.type","pro.id as unitid","pro.cover","pro.en_name","pro.ar_name")
		->where("f.lead_id",$request->id)
		->get();
		//  dd($leadfavorite);
		return $leadfavorite;
	}

	public function Getcilslead(Request $request)
	{
		// $cils = \App\Cil::where('lead_id',$show->id)->get();
		$cils = DB::table("cils as c")
		->leftjoin("developers as d","c.developer_id","=","d.id")
		->select("c.id as id","c.status","c.lead_id","d.en_name","d.ar_name")
		->where("c.lead_id",$request->id)
		->get();
		return response()->json($cils);
	}

	public function GetleadSwitchHistory(Request $request)
	{
		$switchedlead = DB::table("admin_notifications as admin")
		->leftjoin("leads as lead","admin.assigned_to","=","lead.id")
		->leftjoin("users as user","admin.user_id","=","user.id")
		->select("admin.id as id","admin.type","lead.first_name","lead.last_name","user.name","admin.created_at")
		->where("type_id",$request->id)->where("admin.type","switch")
		->get();
		return $switchedlead;
	}

	public function GetleadInfo(Request $request){
		// $leadinfo = \App\Lead::find($request->id);
		// return $leadinfo;
		// $calls = \App\Call::where("lead_id",$request->id)->first();
		// dd($request->id);
		$calls = DB::table("calls as call")
		->leftjoin("call_statuses as status","call.call_status_id","=","status.id")
		->leftjoin("leads as lead","call.lead_id","=","lead.id")
		->leftjoin("contacts as con","lead.id","=","con.lead_id")
		->select("lead.id as lead_id","call.phone","lead.first_name","lead.last_name","con.id","con.name","status.name as status_name","call.duration","call.probability","call.created_at")
		->where("call.lead_id",$request->id)
		->get();
		return $calls;
	}
	
	public function editLeadsCalls(Request $request){
		// dd($request->all());
		$updateCalls = \App\Call::where("lead_id",$request->Lead_id)->first();
		$updateCalls->call_status_id = $request->call_status_id;
		$updateCalls->duration = $request->duration;
		$updateCalls->date = $request->created_at;
		$updateCalls->probability = $request->probability;
		$updateCalls->phone = $request->phone;
		$updateCalls->description = $request->description;
		$updateCalls->update();
		return response()->json("Updated");
	}

	public function Accalls(Request $request)
	{
	}
	public function Ac(Request $request)
	{
		# code...
	}
	public function convertLeadCC($id){
		$lead = Lead::where('id',$id)->first();
		$lead->lead_source_id = 45;
		$lead->created_at = Carbon::now();
		$lead->save();
	}

	public function upload_leads_excel(Request $request){
		ini_set('memory_limit', '-1');
		$count = 0;
		$leadInstance = new Lead;
        $rules = [
            'ExSheet' => 'required',
		];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            if($request->hasFile('ExSheet')){
                $extension = File::extension($request->ExSheet->getClientOriginalName());  
                if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                    $path = $request->ExSheet->getRealPath();
                    $data = Excel::load($path, function($reader) {
                    })->get();
                
                    if(!empty($data) && $data->count()){
                        if(is_array(json_decode($data[0]))){
                            $data = $data[0];
						}
					}
					$array = $data->toArray();
					$duplicatedLead = array();
					$national_leads_count = 0;
					$international_leads_count = 0;
					$duplicated_leads_count = 0;
					$wrong_numbers_count = 0;
					$assigned_agents = array();
					$unassigned_agents_count = 0;
					$updated_leads_count = 0;
					foreach ($array as $item) {
						$duplicate_insert = false;
						$update_date = false;
						$update_request = false;
						$unit1 = DB::table('unit_types')->where('id',$item['unit_type_id'])->value('id');
						$location = DB::table('locations')->where('id',$item['location_id'])->value('id');
						if($item['contact'] == null){
							continue;
						}
						$contact = $leadInstance->reformPhone($item['contact']);
						if($contact->iso == 'EG'){
							$national_leads_count += 1;
						}else{
							$international_leads_count += 1;
						}
						if($contact->phone == 'wrong_number'){
							$wrong_numbers_count += 1;
						}
						$lead_other_phones = $leadInstance->reformOtherPhones($item['other_phones']);
						if (isset($item['contact'])) {
							$lead = Lead::where('phone', $contact->phone)->orderBy('created_at','asc')->first();
							if (!in_array($item['agent_id'], $assigned_agents) && $item['agent_id'] != null){
								$assigned_agents[] = $item['agent_id']; 
							}
							$x = (int) @$item['request_type'];

							if (1 == $x) {
								// var_dump('residential'); die();
								$type = 'residential';
							} else if (2 == $x) {
								$type = 'commercial';
							} else if (3 == $x) {
								$type = 'land';
							} else {
								$type = 'residential';
							}

							$y = (int) @$item['type'];

							if (1 == $y) {
								$rtype = 'resale';
							} else if (2 == $y) {
								$rtype = 'rental';
							} else if (3 == $y) {
								$rtype = 'new_home';
							} else if (4 == $y) {
								$rtype = 'land';
							} else {
								$rtype = 'resale';
							}

							$z = (int) @$item['lead_type'];

							if (1 == $z) {
								$ltype = 'buyer';
							} else if (2 == $z) {
								$ltype = 'seller';
							} else {
								$ltype = 'buyer';
							}
							$checkType = self::checkTypeForAgent((int) $item['agent_id']);
							$agentId = (int) $item['agent_id'];
							if ($lead) {
								if($item['agent_id'] == null){
									$unassigned_agents_count += 1;
									if(auth()->user()->type == "agent" || auth()->user()->role_id == 6
										|| auth()->user()->agent_type_id == 7){
										$checkUserType = self::checkTypeForAgent((int) auth()->user()->id);
										if ($checkUserType == 'residential') {
											$lead->agent_id = auth()->user()->id;											
										} else if ($checkUserType == 'commercial') {
											$lead->commercial_agent_id = auth()->user()->id;	
										}
										$lead->save();
									}
									$update_date = true;
									$update_request = true;
									$updated_leads_count += 1;
								}
								else{
									if (($checkType == 'residential' && $lead->agent_id == $agentId) 
										|| ($checkType == 'commercial' && $lead->commercial_agent_id == $agentId)) {
										$update_date = true;
										$update_request = true;
										$updated_leads_count += 1;							
									}							
									else if($lead->agent_id == 0 || $lead->commercial_agent_id == 0){
										if($lead->agent_id == 0 && $checkType == 'residential' && $agentId != 0){
											DB::table('leads')->where('id',$lead->id)->update(['agent_id' => $agentId]);
											$update_request = true;
											$update_date = true;
											$updated_leads_count += 1;
										}
										else if($lead->commercial_agent_id == 0 && $checkType == 'commercial' && $agentId != 0){
											DB::table('leads')->where('id',$lead->id)->update(['commercial_agent_id' => $agentId]);
											$update_request = true;
											$update_date = true;
											$updated_leads_count += 1;
										}
										else{
											$duplicate_insert = true;
										}
									}else{
										$duplicate_insert = true;
									}
								}
								if($update_date == true){
									if (isset($item['date'])) {
										$date = strtotime($item['date']);
										$date = date('Y-m-d H:i:s', $date);
										DB::table('leads')->where('id',$lead->id)->update(['created_at' => $date]);
									}else{
										DB::table('leads')->where('id',$lead->id)->update(['created_at' => Carbon::now()]);
									}
								}
								if($update_request == true){
									DB::table('requests')->where('lead_id',$lead->id)->update([
										'location' => $location,
										'unit_type_id' => $unit1,
										'date' => $item['date'] != null ? $item['date']->timestamp : idate('Y'),
										'unit_type' => $type,
										'type' => $z,
										'notes' => $item['description'],
										'request_type' => $rtype,
										'project_id' => $item['compound_id'],
										'user_id' => Auth::user()->id
									]);	
								}
								if($duplicate_insert == true){
									$duplicated_leads_count += 1;
									foreach($lead->toArray() as $key => $value){
										$duplicatedLead["$key"] = $value;
									}
									$checkType = self::checkTypeForAgent((int) $item['agent_id']);
									$agentId = (int) $item['agent_id'];
									$duplicatedLead['lead_id'] = $lead->id;
									$duplicatedLead['address'] = $item['address'];
									if ($checkType == 'residential') {
										$duplicatedLead['agent_id'] = $agentId;
									} else if ($checkType == 'commercial') {
										$duplicatedLead['commercial_agent_id'] = $agentId;
									}
									$first_name = 'first_name';
									$last_name = ' .';
									if (isset(explode(' ', $item['lead_name'])[0])) {
										$first_name = explode(' ', $item['lead_name'])[0];
									}

									if (isset(explode(' ', $item['lead_name'])[1])) {
										$last_name = explode(' ', $item['lead_name'])[1] . ' ';
									}

									if (isset(explode(' ', $item['lead_name'])[2])) {
										$last_name .= explode(' ', $item['lead_name'])[2] . ' ';
									}

									if (isset(explode(' ', $item['lead_name'])[3])) {
										$last_name .= explode(' ', $item['lead_name'])[3] . ' ';
									}

									if (isset(explode(' ', $item['lead_name'])[4])) {
										$last_name .= explode(' ', $item['lead_name'])[4];
									}
									// $duplicatedLead['campaign_id'] = $item['campaign_id'];
									$duplicatedLead['phone'] = $item['contact'];
									$duplicatedLead['email'] = $item['lead_email'];
									$duplicatedLead['first_name'] = $first_name;
									$duplicatedLead['last_name'] = $last_name;
									$duplicatedLead['lead_source_id'] = $item['lead_source_id'];
									$duplicatedLead['notes'] = $item['notes'];
									$duplicatedLead['other_phones'] = $item['other_phones'];
									$duplicatedLead['reference'] = $item['reference'];

									
									$archive = DB::table('archives')->where('phone',$contact->phone)->value('id');
									if($archive != null){
										$duplicatedLead['archive_id'] = $archive;
									}else{
										$duplicatedLead['archive_id'] = null;
									}
									unset($duplicatedLead['id']);
									unset($duplicatedLead['requests']);
									unset($duplicatedLead['company_id']);
									unset($duplicatedLead['company_status']);
									unset($duplicatedLead['full_name']);						
									unset($duplicatedLead['gender']);						
									unset($duplicatedLead['mobile_number']);						
									unset($duplicatedLead['specilization_id']);
									$duplicatedPhoneCheck = DB::table('duplicates')->where('phone',$item['contact'])->count();
									if($duplicatedLead['phone'] != '' && $duplicatedLead['phone'] != null){
										if($duplicatedPhoneCheck == 0){
											DB::table('duplicates')->insert([$duplicatedLead]);
										}else{
											$duplicatedPhoneNumber = $duplicatedLead['phone'];
											unset($duplicatedLead['phone']);
											DB::table('duplicates')
											->where('phone',$duplicatedPhoneNumber)
											->orderBy('created_at','desc')
											->update([
												'lead_id' => $duplicatedLead['lead_id'],
												'address' => $duplicatedLead['address'],
												'agent_id' => $duplicatedLead['agent_id'],
												'commercial_agent_id' => $duplicatedLead['commercial_agent_id'],											
												'email' => $duplicatedLead['email'],
												'first_name' => $duplicatedLead['first_name'],
												'last_name' => $duplicatedLead['last_name'],
												'lead_source_id' => $duplicatedLead['lead_source_id'],
												'notes' => $duplicatedLead['notes'],
												'other_phones' => $duplicatedLead['other_phones'],
												'reference' => $duplicatedLead['reference'],
												'archive_id' => $duplicatedLead['archive_id'],
											]);
										}
									}
								}
								// $lead->save();
							
							} else {
								$first_name = 'first_name';
								$last_name = ' .';
								if (isset(explode(' ', $item['lead_name'])[0])) {
									$first_name = explode(' ', $item['lead_name'])[0];
								}

								if (isset(explode(' ', $item['lead_name'])[1])) {
									$last_name = explode(' ', $item['lead_name'])[1] . ' ';
								}

								if (isset(explode(' ', $item['lead_name'])[2])) {
									$last_name .= explode(' ', $item['lead_name'])[2] . ' ';
								}

								if (isset(explode(' ', $item['lead_name'])[3])) {
									$last_name .= explode(' ', $item['lead_name'])[3] . ' ';
								}

								if (isset(explode(' ', $item['lead_name'])[4])) {
									$last_name .= explode(' ', $item['lead_name'])[4];
								}

								$lead = new Lead();
								$lead->first_name = $first_name;
								$lead->last_name = $last_name;
								$lead->email = ($item['lead_email'] ? $item['lead_email'] : null);
								$lead->reference = @$item['reference'];

								$lead->phone = $contact->phone;
								$lead->phone_iso = $contact->iso;
								$lead->other_phones = $lead_other_phones;
								$lead->lead_source_id = $item['lead_source_id'] ? $item['lead_source_id'] : 0;
								$lead->campain_id = 0;
								if (isset($item['date'])) {
									$date = strtotime($item['date']);
									$lead->created_at = date('Y-m-d H:i:s', $date);
								}

								if($item['agent_id'] == null){
									$unassigned_agents_count += 1;
									if(auth()->user()->type == "agent" || auth()->user()->role_id == 6
										|| auth()->user()->agent_type_id == 7){
										$lead->agent_id = auth()->user()->id;
									}
								}else{
									$checkType = self::checkTypeForAgent((int) $item['agent_id']);
									$agentId = (int) $item['agent_id'];

									if ($checkType == 'residential') {
										$lead->agent_id = $agentId;
									} else if ($checkType == 'commercial') {
										$lead->commercial_agent_id = $agentId;
									}
								}
								
								$lead->user_id = Auth::user()->id;
								if (isset($item['title'])) {
									$lead->title_id = @$item['title'];
								}

								$lead->save();

								if (@$item['notes'] != '' and @ $item['notes']) {
									$note = new \App\LeadNote;
									$note->lead_id = $lead->id;
									$note->note = $item['notes'];
									$note->user_id = auth()->id();
									$note->save();
								}
							}

							$req = new Model;
							$req->lead_id = $lead->id;
							if ($location != null) {
								$req->location = $location;
							}
							if ($unit1 != null) {
								$req->unit_type_id = $unit1;
							}

							if (@$item['date']) {
								$req->date = @$item['date']->timestamp;
							} else {
								$req->date = idate('Y');
							}

							$req->unit_type = $type;
							$req->type = $z;

							$req->notes = @$item['description'];
							$req->request_type = $rtype;
							$req->project_id = @$item['compound_id'];

							$req->user_id = Auth::user()->id;
							$req->save();
							$count++;
						}
					}
					DB::table('lead_summaries')->insert([
						'national_leads_count' => $national_leads_count,
						'international_leads_count' => $international_leads_count,
						'duplicated_leads_count' => $duplicated_leads_count,
						'wrong_numbers_count' => $wrong_numbers_count,
						'assigned_agents_count' => count($assigned_agents),
						'unassigned_agents_count' => $unassigned_agents_count,
						'updated_leads_count' => $updated_leads_count,
						'created_at' => Carbon::now(),
						'updated_at' => Carbon::now(),
						'user_id' => auth()->user()->id
					]);
					return response()->json([
						'message' => "Successfully Inserted Leads"
					]);
				}
			}
		}
	}

	private static function checkTypeForAgent(int $agentId): string {
        $user = User::where('id', $agentId)->first();
        if ($user) {
            return $user->residential_commercial ?? $user->residential_commercial;
        }
        return "";
	}
	
	public function restore($id){
		$archive = Archive::where('id',$id)->first();
		$leadToBeRestored = array();
		foreach($archive->toArray() as $key => $value){
			$leadToBeRestored["$key"] = $value;
		}
		$leadToBeRestored['id'] = $archive->lead_id;
		unset($leadToBeRestored['lead_id']);
		DB::table('leads')->insert([$leadToBeRestored]);
		DB::table('archives')->where('id', $archive->id)->delete();
		return response()->json("Successfully Restoed Lead");
	}

	public function duplicated_leads(){
		return view('admin.leads.duplicated_leads');
	}

	public function getDuplicatedLeads(Request $request){
		if(auth()->user()->role->name == 'operation'){
			$obj = (object)[];
			$obj->data = [];
			return response()->json($obj);
		}
		$duplicated_leads = DB::table('duplicates')
								->select('id','lead_id','first_name','last_name','phone','agent_id','commercial_agent_id','created_at','phone_iso','archive_id')
								->paginate(100);
		foreach($duplicated_leads as $lead){
			$oldLead = Lead::where('id',$lead->lead_id)->first();
			$lead->old_agent_residential = DB::table('users')
										 ->where('id',$oldLead['agent_id'])
										 ->value('name');
										 
			$lead->old_agent_commercial = DB::table('users')
										->where('id',$oldLead['commercial_agent_id'])
										->value('name');
			$lead->new_agent_residential = DB::table('users')
										 ->where('id',$lead->agent_id)
										 ->value('name');
										 
			$lead->new_agent_commercial = DB::table('users')
										->where('id',$lead->commercial_agent_id)
										->value('name');
			if($lead->lead_id != null){
				$lead->lead_color = 1;
			}
			else{
				$lead->lead_color = 2;
			}
			if($lead->archive_id != null){
				$lead->archive_color = 1;
			}
			else{
				$lead->archive_color = 2;
			}
			
		}								
		return $duplicated_leads;
	}

	public function deleteDuplicateLead($id){
		DB::table('duplicates')->where('id',$id)->delete();
		return "duplicate lead Deleted Succussfully!";
	}

	public function deleteDuplicateLeads(Request $request){
		DB::table('duplicates')->whereIn('id',$request->all())->delete();
		return "selected duplicate leads Deleted Succussfully!";		
	}

	public function lead_summaries(){
		return view('admin.leads.lead_summaries');
	}
	
	public function getLeadSummaries(Request $request){
		if(auth()->user()->role->name == 'operation'){
			$obj = (object)[];
			$obj->data = [];
			return response()->json($obj);
		}
		$lead_summaries = DB::table('lead_summaries')->paginate(100);
		foreach($lead_summaries as $summary){
			$summary->inserted_by = DB::table('users')->where('id',$summary->user_id)->value('name');
		}
		return $lead_summaries;
	}

	public function deleteLeadsummaries(Request $request){
		DB::table('lead_summaries')->whereIn('id',$request->all())->delete();
		return "selected lead summaries Deleted Succussfully!";		
	}

	/**
	 * Reform all lead phones send duplicate phone leads to duplicates
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function reformLeadPhones(){
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 300); // 5 minutes

		$leadInstance = new Lead;
		$leads = Lead::all();
		foreach($leads as $lead){
			if (strpos($lead->phone, 'WN') !== false) {
				continue;
			}
			$leadDate = $lead->created_at->timestamp;
			$contact = $leadInstance->reformPhone($lead->phone);
			$lead_other_phones = $leadInstance->reformOtherPhones($lead->other_phones);
			$lead_phone = $contact->phone;
			$lead_phone_iso = $contact->iso;
			$first_phone_lead = Lead::where('phone',$lead_phone)->orderBy('created_at','asc')->first();
			if($first_phone_lead != null && $first_phone_lead->id != $lead->id){
				if($first_phone_lead->agent_id == $lead->agent_id && $first_phone_lead->commercial_agent_id == $lead->commercial_agent_id){
					DB::table('leads')->where('id',$first_phone_lead->id)->update(['created_at' => $lead->created_at]);				
					DB::table('requests')->where('lead_id',$lead->id)->update(['lead_id' => $first_phone_lead->id]);
					DB::table('leads')->where('id',$lead->id)->delete();
				}
				else if($first_phone_lead->agent_id == 0 || $first_phone_lead->commercial_agent_id == 0){
					if($first_phone_lead->agent_id == 0 && $lead->agent_id != 0){
						DB::table('leads')->where('id',$first_phone_lead->id)->update(['agent_id' => $lead->agent_id]);						
					}
					if($first_phone_lead->commercial_agent_id == 0 && $lead->commercial_agent_id != 0){
						DB::table('leads')->where('id',$first_phone_lead->id)->update(['commercial_agent_id' => $lead->commercial_agent_id]);						
					}
					DB::table('requests')->where('lead_id',$lead->id)->update(['lead_id' => $first_phone_lead->id]);
					DB::table('leads')->where('id',$lead->id)->delete();
				}
				else{
					$duplicatedLead = array();
					foreach($lead->toArray() as $key => $value){
						$duplicatedLead["$key"] = $value;
					}
					$duplicatedLead['lead_id'] = $first_phone_lead->id;
					$duplicatedLead['phone'] = $lead_phone;
					$duplicatedLead['phone_iso'] = $lead_phone_iso;
					$duplicatedLead['other_phones'] = $lead_other_phones;
					
					$archive = DB::table('archives')->where('phone',$lead_phone)->value('id');
					if($archive != null){
						$duplicatedLead['archive_id'] = $archive;
					}
					unset($duplicatedLead['id']);
					unset($duplicatedLead['requests']);
					unset($duplicatedLead['company_id']);
					unset($duplicatedLead['company_status']);
					unset($duplicatedLead['full_name']);						
					unset($duplicatedLead['gender']);						
					unset($duplicatedLead['mobile_number']);						
					unset($duplicatedLead['specilization_id']);						

					DB::table('duplicates')->insert([$duplicatedLead]);
					DB::table('leads')->where('id',$lead->id)->delete();
					DB::table('leads')->where('id',$first_phone_lead->id)
									->update([
											'phone' => $lead_phone,
											'phone_iso' => $lead_phone_iso,
											'other_phones' => $lead_other_phones
										]);

				}	
			}else{
				DB::table('leads')->where('id',$lead->id)
										->update([
												'phone' => $lead_phone,
												'phone_iso' => $lead_phone_iso,
												'other_phones' => $lead_other_phones
											]);
			}
			
		}
		return redirect(adminPath() . '/leads#/MyLeads/1');
	}

	/**
	 * Replace a certain Lead information with the duplicate information
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function replaceLeadWithDuplicated($id){
		$lead = array();
		$duplicatedLead = DB::table('duplicates')->where('id',$id)->first();
		foreach($duplicatedLead as $key => $value){
			$lead["$key"] = $value;
		}
		$lead_Id = DB::table('leads')->where('id',$duplicatedLead->lead_id)->value('id');
		unset($lead['id']);
		unset($lead['lead_id']);
		unset($lead['archive_id']);
		DB::table('leads')->where('id',$lead_Id)->update($lead);
		DB::table('duplicates')->where('id',$id)->delete();
		return response()->json("Successfully Replaced Lead With Duplicate");
	}

	/**
	 * Search functionality for duplicates
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function searchForDuplicate(Request $request){

		$search = $request->searchInput;
		$teamLead = Group::where('team_leader_id', Auth::user()->id)->count();
		if (Auth::user()->type === 'admin' ) {
			$duplicates = DB::table('duplicates')
			->where('first_name', 'LIKE', '%' . $search . '%')
			->orWhere('middle_name', 'LIKE', '%' . $search . '%')
			->orWhere('last_name', 'LIKE', '%' . $search . '%')
			->orWhere('ar_first_name', 'LIKE', '%' . $search . '%')
			->orWhere('ar_middle_name', 'LIKE', '%' . $search . '%')
			->orWhere('ar_last_name', 'LIKE', '%' . $search . '%')
			->orWhere('phone', 'LIKE', '%' . $search . '%')
			->orWhere('phone_iso', 'LIKE', '%' . $search . '%')
			->get();
			foreach ($duplicates as $key => $lead) {
				$oldLead = Lead::where('id',$lead->lead_id)->first();
				$lead->old_agent_residential = DB::table('users')
											->where('id',$oldLead['agent_id'])
											->value('name');
											
				$lead->old_agent_commercial = DB::table('users')
											->where('id',$oldLead['commercial_agent_id'])
											->value('name');
				$lead->new_agent_residential = DB::table('users')
											->where('id',$lead->agent_id)
											->value('name');
											
				$lead->new_agent_commercial = DB::table('users')
											->where('id',$lead->commercial_agent_id)
											->value('name');
				if($lead->lead_id != null){
					$lead->lead_color = 1;
				}
				else{
					$lead->lead_color = 2;
				}
				if($lead->archive_id != null){
					$lead->archive_color = 1;
				}
				else{
					$lead->archive_color = 2;
				}
			}
			return $duplicates;

		}elseif(Auth::user()->type != 'admin' && $teamLead){
			$groupId = Group::where('team_leader_id', Auth::user()->id)->first();
			$groupUsers = GroupMember::where('group_id',$groupId['id'])->pluck('member_id')->toArray();
			$id = Auth::user()->id;

			$team = array_unique($groupUsers);
			$query = DB::table('duplicates');

			$leaderHasGroup = \App\Group::where('team_leader_id', $id)->first();
			if($leaderHasGroup){
				$groupAgents = GroupMember::where('group_id', $leaderHasGroup->id)->pluck('member_id')->toArray();
				array_push($groupAgents,$id);
				if(count($groupAgents)>0){
					$commercialAgents = @\App\User::where('residential_commercial', 'commercial')->whereIn('id', $groupAgents)->get()->pluck('id')->toArray();
					$residentialAgents = @\App\User::where('residential_commercial', 'residential')->whereIn('id', $groupAgents)->get()->pluck('id')->toArray();
				}
			}

			$query = $query->where(function( $q ) use($commercialAgents, $residentialAgents){
				$q->whereIn('commercial_agent_id', $commercialAgents)->orWhereIn('agent_id', $residentialAgents);
			});

			$duplicates = $query->where(function($q) use ($search){
				$q->where('first_name', 'LIKE', '%' . $search . '%')
				->orWhere('middle_name', 'LIKE', '%' . $search . '%')
				->orWhere('last_name', 'LIKE', '%' . $search . '%')
				->orWhere('ar_first_name', 'LIKE', '%' . $search . '%')
				->orWhere('ar_middle_name', 'LIKE', '%' . $search . '%')
				->orWhere('ar_last_name', 'LIKE', '%' . $search . '%')
				->orWhere('phone', 'LIKE', '%' . $search . '%')
				->orWhere('phone_iso', 'LIKE', '%' . $search . '%');
			})->get();
			foreach ($duplicates as $key => $lead) {
				$oldLead = Lead::where('id',$lead->lead_id)->first();
				$lead->old_agent_residential = DB::table('users')
											->where('id',$oldLead['agent_id'])
											->value('name');
											
				$lead->old_agent_commercial = DB::table('users')
											->where('id',$oldLead['commercial_agent_id'])
											->value('name');
				$lead->new_agent_residential = DB::table('users')
											->where('id',$lead->agent_id)
											->value('name');
											
				$lead->new_agent_commercial = DB::table('users')
											->where('id',$lead->commercial_agent_id)
											->value('name');
				if($lead->lead_id != null){
					$lead->lead_color = 1;
				}
				else{
					$lead->lead_color = 2;
				}
				if($lead->archive_id != null){
					$lead->archive_color = 1;
				}
				else{
					$lead->archive_color = 2;
				}
			}
			return $duplicates;
		}
		else{
			$duplicates = DB::table('duplicates')
			->where(function($query) use ($request) {
				$query->where('agent_id', Auth::user()->id)->orWhere('commercial_agent_id', Auth::user()->id);
			})
			->where(function($query) use ($request) {
				$query
				->where('first_name', 'LIKE', '%' . $request->searchInput . '%')
				->orWhere('middle_name', 'LIKE', '%' . $request->searchInput . '%')
				->orWhere('last_name', 'LIKE', '%' . $request->searchInput . '%')
				->orWhere('ar_first_name', 'LIKE', '%' . $request->searchInput . '%')
				->orWhere('ar_middle_name', 'LIKE', '%' . $request->searchInput . '%')
				->orWhere('ar_last_name', 'LIKE', '%' . $request->searchInput . '%')
				->orWhere('phone', 'LIKE', '%' . $request->searchInput . '%')
				->orWhere('phone_iso', 'LIKE', '%' . $request->searchInput . '%');
			})
			->get();
			foreach ($duplicates as $key => $lead) {
				$oldLead = Lead::where('id',$lead->lead_id)->first();
				$lead->old_agent_residential = DB::table('users')
											->where('id',$oldLead['agent_id'])
											->value('name');
											
				$lead->old_agent_commercial = DB::table('users')
											->where('id',$oldLead['commercial_agent_id'])
											->value('name');
				$lead->new_agent_residential = DB::table('users')
											->where('id',$lead->agent_id)
											->value('name');
											
				$lead->new_agent_commercial = DB::table('users')
											->where('id',$lead->commercial_agent_id)
											->value('name');
				if($lead->lead_id != null){
					$lead->lead_color = 1;
				}
				else{
					$lead->lead_color = 2;
				}
				if($lead->archive_id != null){
					$lead->archive_color = 1;
				}
				else{
					$lead->archive_color = 2;
				}
			}
			return $leads;
		}
	}
	
	/**
	 * Replace original leads information with Selected Duplicate leads information
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function replaceDuplicateLeads(Request $request){
		$lead = array();
		$duplicatedLeads = DB::table('duplicates')->whereIn('id',$request->all())->get();
		foreach($duplicatedLeads as $duplicatedLead){
			foreach($duplicatedLead as $key => $value){
				$lead["$key"] = $value;
			}
			$lead_Id = DB::table('leads')->where('id',$duplicatedLead->lead_id)->value('id');
			unset($lead['id']);
			unset($lead['lead_id']);
			unset($lead['archive_id']);
			DB::table('leads')->where('id',$lead_Id)->update($lead);
			DB::table('duplicates')->where('id',$duplicatedLead->id)->delete();
		}
		return response()->json("Successfully Replaced Lead With Duplicate");
	}
	public function sendintrest(Request $request)
	{
		dd($request->all());
		$newintrest = new newintrest;
		$$newintrest->location_id = $request->location;
	}

	/**
	 * Search if input phone number is present in leads table
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function searchForLeadPhone(Request $request){
		$user = auth()->user();
		$lead = DB::table('leads')
			->where('phone', 'LIKE', '%' . $request->searchInput . '%')
			->select('first_name','last_name','agent_id','commercial_agent_id')
			->first();
		if($lead){
			if($user->type == "admin"){
				if($lead->agent_id != 0 && $lead->commercial_agent_id == 0){
					$agentName = DB::table('users')->where('id',$lead->agent_id)->value('name');					
				}
				else{
					$agentName = DB::table('users')->where('id',$lead->commercial_agent_id)->value('name');
				}
				return response()->json("Found , Lead Name is : " . $lead->first_name . " " . $lead->last_name . " , Agent Name is : " .$agentName);
			}
			else{
				return "Found";
			}
		}
		else{
			return "Not Found";
		}	
	}

	/**
	 * Bulk Delete Selected Leads
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteSelectedLeads(Request $request){
		$leadIds = $request->all();
		DB::table('leads')->whereIn('id',$leadIds)->delete();
		return response()->json("selected lead summaries Deleted Succussfully!");		
	}

	public function getRotationalLeads(){
		$user = auth()->user();
		$obj = (object)[];
		$obj->data = [];
		if($user->role->name == 'operation'){
			return response()->json($obj);
		}
		$callLeads = DB::table('leads as lead')
						->join('calls as call', function($join){
							$join->on('call.lead_id','=','lead.id');
							$join->where('call.probability','=','Rotation');
							$join->where('call.probability_status','=',0);
						})
						->distinct('lead.id')
						->pluck('lead.id')->toArray();
		$meetingLeads = DB::table('leads as lead')
						->join('meetings as meeting', function($join){
							$join->on('meeting.lead_id','=','lead.id');
							$join->where('meeting.probability','=','Rotation');
						})
						->distinct('lead.id')						
						->pluck('lead.id')->toArray();
		$leadIds = array_merge($callLeads,$meetingLeads);
		$leads = DB::table('leads as lead')			
					->leftjoin('lead_sources as source','lead.lead_source_id','=','source.id')
					->whereIn('lead.id',$leadIds)
					->select('lead.id','lead.first_name','lead.last_name','lead.email','lead.phone','lead.created_at','lead.phone_iso','source.name as sourceName');
		if($user->role->name == 'Agent Role'){
			$leads = $leads->where('agent_id',$user->id);
			return $leads->paginate(100);				
		}
		else if($user->role->name == 'Team Leader'){
			$leadergroupID = DB::table('groups')->where('team_leader_id',$user->id)->value('id');
			if($leadergroupID){
				$groupMembers = DB::table('group_members')->where('group_id',$leadergroupID)->pluck('member_id')->toArray();
				array_push($groupMembers, $user->id);
				$leads = $leads->whereIn('agent_id',$groupMembers);
				return $leads->paginate(100);				
			}
			else{
				return response()->json($obj);			
			}
		}
		else if($user->type == 'admin'){
			return $leads->paginate(100);
		}
		else{
			return response()->json($obj);
		}
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
        return response()->json([
            'status' => "ok",
            "massege" => 'sending one OneSignal'
        ]);
    }
}
