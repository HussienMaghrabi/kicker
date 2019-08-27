<?php

namespace App\Http\Controllers;

use App\Facility;
use App\Group;
use App\GroupMember;
use App\UnitFacility;
use Image;
use App\Setting;
use App\RentalUnit;
use App\ResalImage;
use App\RentalImage;
use App\Project;
use App\Location;
use Illuminate\Support\Facades\DB;
use App\UnitType;
use Illuminate\Http\Request;

use Validator;

class RentalUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    return view('admin.rental.index');
        if (checkRole('show_rental_units') or @auth()->user()->type == 'admin') {
            if(auth()->user()->type=="admin"){
                $groups = \App\Group::get()->pluck('team_leader_id')->toArray();
                $groupMembers = \App\GroupMember::get();
                $users = $groupMembers->pluck('member_id')->toArray();
                array_push($users,$groups);
                $oRentalUnit = RentalUnit::where('privacy','public')->whereHas('lead',function($q) use ($users){
                    $q->whereIn('agent_id',$users)->orWhereIn('commercial_agent_id',$users);
                })->get();
            }elseif(\App\Group::where('team_leader_id',auth()->user()->id)->count()>0){
                $leader=\App\Group::where('team_leader_id',auth()->user()->id)->first()->id;
                $groupMembers = \App\GroupMember::where('group_id', $leader)->get();
                $users = $groupMembers->pluck('member_id')->toArray();
                $oRentalUnit = RentalUnit::where('privacy','public')->orWhere(function ($q) use ($users){
                    $q->whereHas('lead',function($q) use ($users){
                    $q->whereIn('agent_id',$users)->orWhereIn('commercial_agent_id',$users);
                })->where('privacy','!=','only_me');})->get();
            }else{
                $group_id=\App\GroupMember::where('member_id',auth()->user()->id)->first();
                $users=\App\GroupMember::where('group_id',$group_id->group_id)->get();
                $oRentalUnit = RentalUnit::where('privacy','public')->orWhere(function ($q) use ($users){
                    $q->whereHas('lead',function($q) use ($users){
                    $q->whereIn('agent_id',$users)->orWhereIn('commercial_agent_id',$users);
                })->where('privacy','team_only');})->get();
            }
            $meRentalUnit = RentalUnit::where('privacy', 'only_me')->orWhere('privacy', 'team_only')->whereHas('lead',function($q){
                $q->where('agent_id',auth()->user()->id)->orWhere('commercial_agent_id',auth()->user()->id);
            })->orWhere('agent_id',auth()->user()->id)->get();
            return view('admin.rental.index', ['title' => trans('admin.all') . ' ' . trans('admin.rental_unites'),
            'meUnits' => $meRentalUnit,
            'othersUnits' => $oRentalUnit,]);
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (checkRole('add_rental_units') or @auth()->user()->type == 'admin') {
            return view('admin.rental.create', ['title' => trans('admin.add') . ' ' . trans('admin.rental_unites')]);
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return back();
        }
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
            'ar_title' => 'required',
            'en_title' => 'required',
            'ar_description' => 'required',
            'en_description' => 'required',
            'lead_id' => 'required',
            'phone' => 'required',
            'type_id' => 'required',
            'area' => 'required',
            'rooms' => 'required',
            'delivery_date' => 'required',
            'rent' => 'required',
            'en_address' => 'required',
            'ar_address' => 'required',
            'image' => 'required',
            'facility' => 'required',
            'privacy' => 'required',
        ];

        if ($request->privacy == 'custom') {
            $rules['agents'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'ar_title' => trans('admin.title'),
            'en_title' => trans('admin.title'),
            'ar_description' => trans('admin.ar_description'),
            'en_description' => trans('admin.en_description'),
            'lead_id' => trans('admin.lead'),
            'phone' => trans('admin.phone'),
            'type_id' => trans('admin.type'),
            'area' => trans('admin.area'),
            'rooms' => trans('admin.rooms'),
            'delivery_date' => trans('admin.date'),
            'rent' => trans('admin.rent'),
            'address_ar' => trans('admin.address'),
            'address_en' => trans('admin.address'),
            'image' => trans('admin.image'),
			'facility' => trans('admin.facility'),
            'privacy' => trans('admin.privacy'),
            'agents' => trans('admin.agents'),
		]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $rental_unite = new RentalUnit;
            $rental_unite->type = $request->usage;
            $rental_unite->unit_type_id = $request->type_id;
            $rental_unite->project_id = $request->project_id;
            $rental_unite->lead_id = $request->lead_id;
            $rental_unite->lead_id = $request->lead_id;
            $rental_unite->rent = $request->rent;
            $rental_unite->delivery_date = $request->delivery_date;
            $rental_unite->finishing = $request->finishing;
            $rental_unite->location = $request->location;
            $rental_unite->ar_description = $request->ar_description;
            $rental_unite->en_description = $request->en_description;
            $rental_unite->ar_title = $request->ar_title;
            $rental_unite->en_title = $request->en_title;
            $rental_unite->ar_address = $request->ar_address;
            $rental_unite->en_address = $request->en_address;
            $rental_unite->en_address = $request->en_address;
            $rental_unite->phone = $request->phone;
            $rental_unite->area = $request->area;
            $rental_unite->view = $request->view;
            $rental_unite->rooms = $request->rooms;
            $rental_unite->meta_keywords = $request->meta_keywords;
            $rental_unite->meta_description = $request->meta_description;
            $rental_unite->bathrooms = $request->bathrooms;
            if ($request->has('other_phones')) {
                $rental_unite->other_phones = json_encode($request->other_phones);
            }else{
                $rental_unite->other_phones = '[]';
            }
            if ($request->has('ar_notes')) {
                $rental_unite->ar_notes = $request->ar_notes;
            }
            if($request->has('en_notes')){
                $rental_unite->en_notes = $request->en_notes;
            }
            $rental_unite->floors = $request->floor;
            $rental_unite->availability = 'available';
            $rental_unite->lng = $request->lng;
            $rental_unite->lat = $request->lat;
            $rental_unite->zoom = $request->zoom;
            $rental_unite->user_id = auth()->user()->id;

            $rental_unite->privacy = $request->privacy;
            $rental_unite->agent_id = auth()->user()->id;
            if ($request->privacy == 'custom') {
                $rental_unite->custom_agents = json_encode($request->agents);
            }


            $set = Setting::first();
            if ($request->hasFile('image')) {
                $rental_unite->image = upload($request->image, 'rental_unit');
                $watermark = Image::make('uploads/'.$set->watermark)->resize(50, 50);
                $image = Image::make('uploads/'.$rental_unite->image);
                $image->insert($watermark, 'bottom-right', 10, 10);
                $image->save("uploads/rental_unit/watermarked_resale".rand(0,99999999999).".jpg");
                $rental_unite->watermarked_image = $watermarked = $image->dirname.'/'.$image->basename;
            }

//            $rental_unite->image = $request->file('image')->store('units');

            $rental_unite->save();

            $old_data = json_encode($rental_unite);
            LogController::add_log(
                __('admin.created', [], 'ar') . ' ' . $rental_unite->ar_title,
                __('admin.created', [], 'en') . ' ' . $rental_unite->en_title,
                'rental_units',
                $rental_unite->id,
                'create',
                auth()->user()->id,
                $old_data
            );

            if ($request->has('images')) {
                foreach ($request->images as $img) {
                    $other_image_model = new RentalImage;
                    $other_image = upload($img, 'rental_unit');
                    $watermark = Image::make('uploads/'.$set->watermark)->resize(50, 50);
                    $image = Image::make('uploads/'.$other_image);
                    $image->insert($watermark, 'bottom-right', 10, 10);
                    $image->save("uploads/rental_unit/other_watermarked_resale".rand(0,99999999999).".jpg");
                    $other_watermarked_images = $image->dirname.'/'.$image->basename;
                    $other_image_model->unit_id = $rental_unite->id;
                    $other_image_model->image = $other_image;
                    $other_image_model->watermarked_image = $other_watermarked_images;
                    $other_image_model->save();
                }
            }
			$project = new ProjectController();
			foreach ($request->facility as $facility) {

				$project->addfacility($rental_unite->id, $facility, 'rental');

			}
            return redirect(adminPath() . '/rental_units/' . $rental_unite->id);

        }
    }

    public function sort_rental()
    {
        $rentale_web = RentalUnit::orderby('order_web')->get();
        $rentale_mobile = RentalUnit::orderby('order_mobile')->get();
        return response()->json([
            'web_rental' => $rentale_web,
            'mobile_rentale' => $rentale_mobile
        ],200);
        // return view('admin.sort_project', compact('featured_projects', 'mobile_projects'));
    }
    public function save_sorted(Request $request)
    {
        // dd($request->all());
        // dd($request->new_mobile_data);
        // dd(json_decode($request->social_url,true));
        $i = 0;
        foreach ($request->new_data as $key => $value) {
            $project = json_decode($value);
            $i++;
            $current = RentalUnit::find($project->id);
            $current->order_web = $i;
            // return $current->id.'=>'.$current->en_name.'=>'. $i;
            $current->update();
        }
        
        foreach ($request->new_mobile_data as $key => $value) {
            $project = json_decode($value);
            $i++;
            $current = RentalUnit::find($project->id);
            $current->order_mobile = $i;
            // return $current->id.'=>'.$current->en_name.'=>'. $i;
            $current->update();
        }

        return response()->json([
            'data' => 'success sort'
        ],200);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\RentalUnit $rentalUnit
     * @return \Illuminate\Http\Response
     */
    public function show(RentalUnit $rentalUnit)
    {
        if (checkRole('show_rental_units') or @auth()->user()->type == 'admin') {
            // return view('admin.rental.show', ['unit' => $rentalUnit, 'title' => trans('admin.show') . ' ' . trans('admin.rental_unites')]);
            $rentalUnit->project = DB::table('projects')->where('id',$rentalUnit->project_id)->select('en_name','ar_name')->first();
            $rentalUnit->unit_type = DB::table('unit_types')->where('id',$rentalUnit->unit_type_id)->select('en_name','ar_name')->first();
            $rentalUnit->locationOnMap = DB::table('locations')->where('id',$rentalUnit->location)->select('en_name','ar_name')->first();
            if(auth()->user()->type == "admin" || $rentalUnit->agent_id == auth()->user()->id){
                $rentalUnit->lead = DB::table('leads')->where('id',$rentalUnit->lead_id)->select('id','first_name','last_name','phone','image')->first();
            }
            $rentalLead = $rentalUnit->lead;
            if($rentalLead){
                $rentalUnitAgent = DB::table('leads as lead')->join('users as user', function($join) use($rentalLead)
                {
                    $join->on(function($query) use ($rentalLead) {
                        $query->on('lead.agent_id', '=', 'user.id');
                        $query->orOn('lead.commercial_agent_id', '=','user.id');
                    });
                })->where('lead.id','=',$rentalLead->id)->select('user.id as agent_id')->first();
                if($rentalUnitAgent){
                    if($resaleUnitAgent->agent_id){
                        $rentalUnit->agent = DB::table('users')->where('id',$rentalUnitAgent->agent_id)->select('name','phone','image')->first();
                    }
                    $rentalUnit->sliderImages = DB::table('rental_images')->where('unit_id',$rentalUnit->id)->select('id','image','watermarked_image')->get();
                    $rentalUnit->user = DB::table('users')->where('id',$rentalUnit->user_id)->value('name');
                }
            }
            
            return response()->json($rentalUnit);
        } else {
            return response()->json("Error : you dont have permission");                        
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RentalUnit $rentalUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(RentalUnit $rentalUnit)
    {
        if (checkRole('edit_rental_units') or @auth()->user()->type == 'admin') {
            $facilities = UnitFacility::where('type', 'resale')->where('unit_id', $rentalUnit->id)->pluck('facility_id')->toArray();
            $images = DB::table('rental_images')->where('unit_id',$rentalUnit->id)->get();
            foreach($images as $image){
                $count = count(explode("/",$image->image));
                $image->name = explode("/",$image->image)[$count-1];
            }
            $leads = DB::table('leads')->select('id','first_name','last_name')->get();
            $allFacilities = DB::table('facilities')->select('id','en_name')->get();
            $allLocations = DB::table('locations')->select('id','en_name')->get();
            if($rentalUnit->lead_id != null || $rentalUnit->lead_id > 0){
                $leadInfo = DB::table('leads')->where('id',$rentalUnit->lead_id)->select('id','first_name','last_name','phone')->first();
                $leadInfo->name = $leadInfo->first_name . " " . $leadInfo->last_name;
                unset($leadInfo->first_name);
                unset($leadInfo->last_name);
            }else{
                $leadInfo = "";
            }

            $count = count(explode("/",$rentalUnit->image));
            $rentalUnit->image = ['name' => explode("/",$rentalUnit->image)[$count-1]];
            
            $agentLeads = DB::table('leads as lead')->join('users as user', function($join)
            {
                $join->on(function($query){
                    $query->on('lead.agent_id', '=', 'user.id');
                    $query->orOn('lead.commercial_agent_id', '=','user.id');
                });
            })
            ->select('lead.id','lead.first_name','lead.last_name','lead.agent_id','lead.commercial_agent_id','user.name as agentName')->get();

            if($rentalUnit->other_phones == null){
                $rentalUnit->other_phones = "[]";
            }
    		return response()->json([
                'title' => trans('admin.show') . ' ' . trans('admin.rental_unit'),
                'unit' => $rentalUnit,
                'facilities' => $facilities ,
                'agentLeads' => $agentLeads,
                'images' => $images,
                'leads' => $leads,
                'lead' => $leadInfo,
                'allFacilities' => $allFacilities,
                'allLocations' => $allLocations,
            ]);
        } else {
            return response()->json("Error : you dont have permission");            
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\RentalUnit $rentalUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RentalUnit $rentalUnit)
    {
        $rules = [
            // 'ar_title' => 'required',
            'en_title' => 'required',
            // 'ar_description' => 'required',
            'en_description' => 'required',
            'lead_id' => 'required',
            // 'phone' => 'required',
            'type_id' => 'required',
            'area' => 'required',
            'rooms' => 'required',
            'delivery_date' => 'required',
            'rent' => 'required',
            // 'en_address' => 'required',
            // 'ar_address' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'ar_title' => trans('admin.title'),
            'en_title' => trans('admin.title'),
            'ar_description' => trans('admin.ar_description'),
            'en_description' => trans('admin.en_description'),
            'lead_id' => trans('admin.lead'),
            'phone' => trans('admin.phone'),
            'type_id' => trans('admin.type'),
            'area' => trans('admin.area'),
            'rooms' => trans('admin.rooms'),
            'delivery_date' => trans('admin.date'),
            'rent' => trans('admin.rent'),
            'address_ar' => trans('admin.address'),
            'address_en' => trans('admin.address'),
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $old_data = json_encode($rentalUnit);
            $rentalUnit->type = $request->usage;
            $rentalUnit->unit_type_id = $request->type_id;
            $rentalUnit->project_id = $request->project_id;
            $rentalUnit->lead_id = $request->lead_id;
            $rentalUnit->lead_id = $request->lead_id;
            $rentalUnit->rent = $request->rent;
            $rentalUnit->delivery_date = $request->delivery_date;
            $rentalUnit->finishing = $request->finishing;
            $rentalUnit->location = $request->location;
            $rentalUnit->ar_description = $request->ar_description;
            $rentalUnit->en_description = $request->en_description;
            $rentalUnit->ar_title = $request->ar_title;
            $rentalUnit->en_title = $request->en_title;
            $rentalUnit->ar_address = $request->ar_address;
            $rentalUnit->en_address = $request->en_address;
            $rentalUnit->en_address = $request->en_address;
            $rentalUnit->phone = $request->phone;
            $rentalUnit->area = $request->area;
            $rentalUnit->rooms = $request->rooms;
            $rentalUnit->view = $request->view;
            $rentalUnit->meta_keywords = $request->meta_keywords;
            $rentalUnit->meta_description = $request->meta_description;
            $rentalUnit->bathrooms = $request->bathrooms;
            if ($request->has('other_phones')) {
                $rentalUnit->other_phones = json_encode($request->other_phones);
            }else{
                $rentalUnit->other_phones = '[]';
            }
            $rentalUnit->floors = $request->floor;
            $rentalUnit->availability = 'available';
            $rentalUnit->lng = $request->lng;
            $rentalUnit->lat = $request->lat;
            $rentalUnit->zoom = $request->zoom;
            $rentalUnit->user_id = auth()->user()->id;
            $set = Setting::first();
            if ($request->hasFile('image')) {
                $rental_image = upload($request->image, 'rental_unit');
                $watermark = Image::make('uploads/'.$set->watermark)->resize(50, 50);
                $image = Image::make('uploads/'.$rental_image);
                $image->insert($watermark, 'bottom-right', 10, 10);
                $image->save("uploads/rental_unit/watermarked_resale".rand(0,99999999999).".jpg");
                $rentalUnit->watermarked_image = $watermarked = $image->dirname.'/'.$image->basename;
                $rentalUnit->image = 'uploads/' . $rental_image;
            }

//            $rentalUnit->image = $request->file('image')->store('units');

            $rentalUnit->save();

            $new_data = json_encode($rentalUnit);
            LogController::add_log(
                __('admin.updated', [], 'ar') . ' ' . $rentalUnit->ar_title,
                __('admin.updated', [], 'en') . ' ' . $rentalUnit->en_title,
                'rental_units',
                $rentalUnit->id,
                'update',
                auth()->user()->id,
                $old_data,
                $new_data
            );

            if ($request->has('images')) {
                foreach ($request->images as $img) {
                    $other_image_model = new RentalImage;
                    $other_image = upload($img, 'rental_unit');
                    $watermark = Image::make('uploads/'.$set->watermark)->resize(50, 50);
                    $image = Image::make('uploads/'.$other_image);
                    $image->insert($watermark, 'bottom-right', 10, 10);
                    $image->save("uploads/rental_unit/other_watermarked_resale".rand(0,99999999999).".jpg");
                    $other_watermarked_images = $image->dirname.'/'.$image->basename;
                    $other_image_model->unit_id = $rentalUnit->id;
                    $other_image_model->image = 'uploads/' . $other_image;
                    $other_image_model->watermarked_image = $other_watermarked_images;
                    $other_image_model->save();
                }
            }
			$fa1 = UnitFacility::where('unit_id', $rentalUnit->id)->where('type', 'resale')->pluck('id');
			$p = new ProjectController();

			foreach (UnitFacility::where('unit_id', $rentalUnit->id)->where('type', 'resale')->get() as $f) {
				$f->delete();
			}
			foreach ($request->facility as $facility) {
				$p->addfacility($rentalUnit->id,$facility,'resale');
			}
            session()->flash('success', trans('admin.created'));
            return redirect(adminPath() . '/rental_units/' . $rentalUnit->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RentalUnit $rentalUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy($rentalUnit)
    {
      $rentalUnit = RentalUnit::find($rentalUnit);
        if (checkRole('delete_rental_units') or @auth()->user()->type == 'admin') {
            $old_data = json_encode($rentalUnit);
            LogController::add_log(
                __('admin.deleted', [], 'ar') . ' ' . $rentalUnit->ar_title,
                __('admin.deleted', [], 'en') . ' ' . $rentalUnit->en_title,
                'rental_units',
                $rentalUnit->id,
                'delete',
                auth()->user()->id,
                $old_data
            );
            UnitFacility::where('unit_id',$rentalUnit->id)->where('type','rental')->delete();
            $rentalUnit->delete();
            return back();
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return back();
        }
    }

    public function delete_rental_image(Request $request)
    {
        $img = RentalImage::find($request->id);
        @unlink('uploads/'.$img->image);
        @unlink($img->watermarked_image);
        $img->delete();
        return response()->json([
            'status' => true,
        ]);
    }
        public function newRentalFilter(Request $request, $reportType=null) {
    $query = new RentalUnit;
    if (@$request->dateFrom and @$request->dateTo) {
      // dd($request->dateTo);
      $from = date('Y-m-d', strtotime($request->dateFrom));
      $to = date('Y-m-d', strtotime($request->dateTo));
      $query = $query->whereBetween('created_at', [$from, $to]);
    }
    if (@$request->location) {
      $requests = Location::where('id', $request->location)->pluck('id')->toArray();
      $query = $query->whereIn('location', $requests);
    }
        if (@$request->typee) {
      $requests = RentalUnit::where('type', $request->typee)->pluck('id')->toArray();  
       $query = $query->whereIn('id', $requests);
      // return $query;
    }
     if (@$request->project) {
      $requests = Project::where('id', $request->project)->pluck('id')->toArray();  
       $query = $query->whereIn('project_id', $requests);
       
    }
    if (@$request->unit_typee) {
      $requests = UnitType::where('id', $request->unit_typee)->pluck('id')->toArray();  
       $query = $query->whereIn('unit_type_id', $requests);
      // return $query;
    }
    if ($request->reportType) {
      $leads = $query->orderBy("id","desc")->get();
    }
    else {
      $leads = $query->orderBy("id","desc")->paginate('10000');
    }

    /*$r_loca = $request->location;
    $r = @Location::find($r_loca)->en_name;*/
   

    if ($request->reportType) {
   
      $this->exportReportLeads($leads);
    }
    else
      return $leads;
  }
    public function exportReportLeads($data)
  {
   
    foreach ($data as $key => $value) {
      $data[$key] = [
              "first_name"=> $value['first_name'],
              "last_name"=> $value['last_name'],
              "phone"=> $value['phone'],
              "email"=> $value['email'],
              "location"=> $value['location'],
              "sourceName"=> $value['sourceName'],
              "created_at"=> $value['created_at'],
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

	public function website_show($lang,$id){
		$array = explode('-', $id);
		$id = end($array);
		$home = new HomeController();
		$search = $home->search_info();
		$rental = RentalUnit::find($id);
		$project = new ProjectController;
		$featured = $project->featured_project();
		$keyword = $rental->meta_keywords;
		$description = $rental->description;
		return view('website.rental', ['rental' => $rental,'search'=>$search,'keyword'=>$keyword ,'description'=>$description ,'featured'=>$featured]);
    }
    
    public function editRental(Request $request){
        $rules = [
            // 'ar_title' => 'required',
            'en_title' => 'required',
            // 'ar_description' => 'required',
            'en_description' => 'required',
            'lead_id' => 'required',
            // 'phone' => 'required',
            'type' => 'required',
            'area' => 'required',
            'rooms' => 'required',
            'delivery_date' => 'required',
            'rent' => 'required',
            // 'en_address' => 'required',
            // 'ar_address' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'ar_title' => trans('admin.title'),
            'en_title' => trans('admin.title'),
            'ar_description' => trans('admin.ar_description'),
            'en_description' => trans('admin.en_description'),
            'lead_id' => trans('admin.lead'),
            'phone' => trans('admin.phone'),
            'type' => trans('admin.type'),
            'area' => trans('admin.area'),
            'rooms' => trans('admin.rooms'),
            'delivery_date' => trans('admin.date'),
            'rent' => trans('admin.rent'),
            'address_ar' => trans('admin.address'),
            'address_en' => trans('admin.address'),
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $rentalID = $request->id;
            $rentalUnit = RentalUnit::find($rentalID);
            $old_data = json_encode($rentalUnit);
            $rentalUnit->type = $request->type;
            $rentalUnit->unit_type_id = $request->type_id;
            $rentalUnit->project_id = $request->project_id;
            if($request->lead_id){
                $rentalUnit->lead_id = $request->lead_id;
            }
            $rentalUnit->rent = $request->rent;
            $rentalUnit->delivery_date = $request->delivery_date;
            $rentalUnit->finishing = $request->finishing;
            $rentalUnit->location = $request->location;
            $rentalUnit->ar_description = $request->ar_description;
            $rentalUnit->en_description = $request->en_description;
            $rentalUnit->ar_title = $request->ar_title;
            $rentalUnit->en_title = $request->en_title;
            $rentalUnit->ar_address = $request->ar_address;
            $rentalUnit->en_address = $request->en_address;
            $rentalUnit->en_address = $request->en_address;
            $rentalUnit->phone = $request->phone;
            $rentalUnit->area = $request->area;
            $rentalUnit->rooms = $request->rooms;
            $rentalUnit->view = $request->view;
            $rentalUnit->meta_keywords = $request->meta_keywords;
            $rentalUnit->meta_description = $request->meta_description;
            $rentalUnit->bathrooms = $request->bathrooms;
            if ($request->has('other_phones')) {
                $rentalUnit->other_phones = json_encode($request->other_phones);
            }else{
                $rentalUnit->other_phones = '[]';
            }
            $rentalUnit->floors = $request->floor;
            $rentalUnit->availability = 'available';
            $rentalUnit->lng = $request->lng;
            $rentalUnit->lat = $request->lat;
            $rentalUnit->zoom = $request->zoom;
            $rentalUnit->user_id = auth()->user()->id;
            $set = Setting::first();
            if ($request->hasFile('image')) {
                $rental_image = upload($request->image, 'rental_unit');
                $watermark = Image::make('uploads/'.$set->watermark)->resize(50, 50);
                $image = Image::make('uploads/'.$rental_image);
                $image->insert($watermark, 'bottom-right', 10, 10);
                $image->save("uploads/rental_unit/watermarked_resale".rand(0,99999999999).".jpg");
                $rentalUnit->watermarked_image = $watermarked = $image->dirname.'/'.$image->basename;
                $rentalUnit->image = 'uploads/' . $rental_image;
            }

//            $rentalUnit->image = $request->file('image')->store('units');

            $rentalUnit->save();

            $new_data = json_encode($rentalUnit);
            LogController::add_log(
                __('admin.updated', [], 'ar') . ' ' . $rentalUnit->ar_title,
                __('admin.updated', [], 'en') . ' ' . $rentalUnit->en_title,
                'rental_units',
                $rentalUnit->id,
                'update',
                auth()->user()->id,
                $old_data,
                $new_data
            );

            if ($request->has('images')) {
                foreach ($request->images as $img) {
                    $other_image_model = new RentalImage;
                    $other_image = upload($img, 'rental_unit');
                    $watermark = Image::make('uploads/'.$set->watermark)->resize(50, 50);
                    $image = Image::make('uploads/'.$other_image);
                    $image->insert($watermark, 'bottom-right', 10, 10);
                    $image->save("uploads/rental_unit/other_watermarked_resale".rand(0,99999999999).".jpg");
                    $other_watermarked_images = $image->dirname.'/'.$image->basename;
                    $other_image_model->unit_id = $rentalUnit->id;
                    $other_image_model->image = 'uploads/' . $other_image;
                    $other_image_model->watermarked_image = $other_watermarked_images;
                    $other_image_model->save();
                }
            }
			$fa1 = UnitFacility::where('unit_id', $rentalUnit->id)->where('type', 'resale')->pluck('id');
			$p = new ProjectController();

			foreach (UnitFacility::where('unit_id', $rentalUnit->id)->where('type', 'resale')->get() as $f) {
				$f->delete();
            }
            if($request->facility){
                foreach ($request->facility as $facility) {
                    $p->addfacility($rentalUnit->id,$facility,'resale');
                }
            }
			
            session()->flash('success', trans('admin.created'));
            return redirect(adminPath() . '/rental_units/' . $rentalUnit->id);
        }
    }
}
