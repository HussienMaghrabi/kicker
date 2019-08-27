<?php

namespace App\Http\Controllers;

use App\Lead;
use App\Massage;
use App\Request as req;
use Illuminate\Http\Request;

class MassageController extends Controller
{
    public function store(Request $request){
		if($request->user){
			$msg = new Massage;
			$msg->massage = $request->massage;
			$msg->lead_id = $request->user;
			$msg->save();
			session()->flash('success', trans('admin.thank_you'));
		}
		else{
			if(count(Lead::where('phone',$request->phone)->get())== 0 && count(Lead::where('email',$request->email)->get())== 0) {
				$lead = new Lead();
				$lead->first_name = $request->first_name;
				$lead->last_name = $request->last_name;
				$lead->phone = $request->phone;
				$lead->email = $request->email;
				$lead->lead_source_id = 24;
				$lead->save();
				$msg = new Massage;
				$msg->massage = $request->massage;
				$msg->lead_id = $lead->id;
				$msg->save();
				session()->flash('success', trans('admin.thank_you'));
			}
			else {
				$lead = null;
				if(count(Lead::where('phone',$request->phone)->first())> 0)
				{$lead =  Lead::where('phone',$request->phone)->first();}
				if(count(Lead::where('email',$request->email)->first())> 0)
				{$lead =  Lead::where('email',$request->email)->first();}
				$msg = new Massage;
				$msg->massage = $request->massage;
				$msg->lead_id = $lead->id;
				$msg->save();
				session()->flash('success', trans('admin.thank_you'));
			}
		}
		// return back();
		return redirect('/contact/#thank-you')
		->with([
			'leadSource' =>  $lead->lead_source_id,
			'email' =>  $request->email,
			'first_name' => $request->first_name,
			'last_name' => $request->last_name,
			'phone' => $request->phone
			]);
	}
	public function sendsubrequest(Request $request)
	{
		// dd($request->all());
		if($request->user){
			$msg = new Massage;
			$msg->massage = $request->massage;
			$msg->lead_id = $request->user;
			$msg->save();
			session()->flash('success', trans('admin.thank_you'));
		}
		else{
			if(count(Lead::where('phone',$request->phone)->get())== 0 && count(Lead::where('email',$request->email)->get())== 0) {
				$lead = new Lead();
				$cutName = explode(' ',$request->fullName);
				$lead->first_name = $cutName[0];
				if($cutName[1]){
					$lead->last_name = $cutName[1];
				}
				$lead->phone = $request->phone;
				$lead->email = $request->email;
				$lead->lead_source_id = 24;
				$lead->save();
				$msg = new Massage;
				$msg->massage = $request->massage;
				$msg->lead_id = $lead->id;
				$msg->save();
				session()->flash('success', trans('admin.thank_you'));
			}
			else {
				$lead = null;
				if(count(Lead::where('phone',$request->phone)->first())> 0)
				{$lead =  Lead::where('phone',$request->phone)->first();}
				if(count(Lead::where('email',$request->email)->first())> 0)
				{$lead =  Lead::where('email',$request->email)->first();}
				$msg = new Massage;
				$msg->massage = $request->massage;
				$msg->lead_id = $lead->id;
				$msg->save();
				session()->flash('success', trans('admin.thank_you'));
			}
			if($request->location_id){
				$a = new req;
				if($request->ContactTime == 1){
					$a->contact_time_from = "11 AM";
					$a->contact_time_to = "5 PM";
				}else{
					$a->contact_time_from = "5 PM";
					$a->contact_time_to = "11 PM";
				}
				$a->location = $request->location_id;
				$a->unit_type_id = $request->unit_type_id;
				$a->lead_id = $lead->id;
				$a->save();
			}
		}
		return back();
	}
}
