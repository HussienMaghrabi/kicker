<?php

namespace App\Http\Controllers;
use App\User;
use App\Group;
use App\GroupMember;
use App\Project;
use App\ResaleUnit;
use App\RentalUnit;
use App\ResalImage;
use App\RentalImage;
use App\Setting;
use App\UnitFacility;
use App\Location;
use App\UnitType;
use App\Lead;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Image;
use Excel;
use File;
use Validator;
use Carbon\Carbon;

class ResaleUnitController extends Controller
{
    public function index()
    {
        return view('admin.resale_units.index-new');
        if (checkRole('show_resale_units') || @auth()->user()->type == 'admin') {
            if(auth()->user()->type=="admin"){
                $groups = \App\Group::get()->pluck('team_leader_id')->toArray();
                $groupMembers = \App\GroupMember::get();
                $users = $groupMembers->pluck('member_id')->toArray();
                array_push($users,$groups);
                $oResaleUnit = ResaleUnit::where('privacy','public')->whereHas('lead',function($q) use ($users){
                    $q->whereIn('agent_id',$users)->orWhereIn('commercial_agent_id',$users);
                })->get();
            }elseif(\App\Group::where('team_leader_id',auth()->user()->id)->count()>0){
                $leader=\App\Group::where('team_leader_id',auth()->user()->id)->first()->id;
                $groupMembers = \App\GroupMember::where('group_id', $leader)->get();
                $users = $groupMembers->pluck('member_id')->toArray();
                $oResaleUnit = ResaleUnit::where('privacy','public')->orWhere(function ($q) use ($users){
                    $q->whereHas('lead',function($q) use ($users){
                    $q->whereIn('agent_id',$users)->orWhereIn('commercial_agent_id',$users);
                })->where('privacy','!=','only_me');})->get();
            }else{
                $group_id=\App\GroupMember::where('member_id',auth()->user()->id)->first();
                $users=\App\GroupMember::where('group_id',$group_id->group_id)->get();
                $oResaleUnit = ResaleUnit::where('privacy','public')->orWhere(function ($q) use ($users){
                    $q->whereHas('lead',function($q) use ($users){
                    $q->whereIn('agent_id',$users)->orWhereIn('commercial_agent_id',$users);
                })->where('privacy','team_only');})->get();
            }
            $meResaleUnit = ResaleUnit::where('privacy', 'only_me')->orWhere('privacy', 'team_only')->whereHas('lead',function($q){
                $q->where('agent_id',auth()->user()->id)->orWhere('commercial_agent_id',auth()->user()->id);
            })->get();
            // if($request->has('api') && $request->api == true)
            //     return ['meUnits' => $meResaleUnit, 'othersUnits' => $oResaleUnit];
            return view('admin.resale_units.index', [
                'title' => trans('admin.resale_units'),
                'meUnits' => $meResaleUnit,
                'othersUnits' => $oResaleUnit,
            ]);
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return back();
        }
    }

    public function create()
    {
        if (checkRole('add_resale_units') or @auth()->user()->type == 'admin') {
            return view('admin.resale_units.create', ['title' => trans('admin.add_resale_unit')]);
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return back();
        }
    }

    public function store(Request $request)
    {
        dd($request->hasFile('image'));
        if ('personal' == $request->type) {
            $rules = [
                'ar_title' => 'required',
                'en_title' => 'required',
                'type' => 'required',
                'unit_type_id' => 'required',
                'total' => 'required',
                'payment_method' => 'required',
                // 'agent_id' => 'required',
                'privacy' => 'required',
                'finishing' => 'required',
                'image' => 'required',
                // 'ar_address' => 'required',
                // 'en_address' => 'required',
                // 'ar_description' => 'required',
                // 'en_description' => 'required',
                'lng' => 'required',
                'lat' => 'required',
                'zoom' => 'required',
                // 'lead_id' => 'required',

                //             'phone' => 'required',
                'area' => 'required',
                'price' => 'required',
                //             'rooms' => 'required',
                //             'bathrooms' => 'required',
                'due_now' => 'required|numeric',
                //             'view' => 'required',
                // 'facility' => 'required',

            ];
        } else {
            $rules = [
                'ar_title' => 'required',
                'en_title' => 'required',
                'type' => 'required',
                'unit_type_id' => 'required',
                'total' => 'required',
                'payment_method' => 'required',
                'privacy' => 'required',
                'finishing' => 'required',
                'image' => 'required',
                'ar_address' => 'required',
                'en_address' => 'required',
                'ar_description' => 'required',
                'en_description' => 'required',
                'lng' => 'required',
                'price' => 'required',
                'lat' => 'required',
                'zoom' => 'required',
                'lead_id' => 'required',
                'due_now' => 'required|numeric',
            ];
        }

        if ('custom' == $request->privacy) {
            $rules['agents'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'type' => trans('admin.type'),
            'total' => trans('admin.total'),
            'finishing' => trans('admin.finishing'),
            'ar_description' => trans('admin.ar_description'),
            'en_description' => trans('admin.en_description'),
            'ar_title' => trans('admin.ar_title'),
            'en_title' => trans('admin.en_title'),
            'ar_address' => trans('admin.ar_address'),
            'en_address' => trans('admin.en_address'),
            'phone' => trans('admin.phone'),
            'area' => trans('admin.area'),
            'price' => trans('admin.price'),
            'rooms' => trans('admin.rooms'),
            'bathrooms' => trans('admin.bathrooms'),
            'lng' => trans('admin.lng'),
            'lat' => trans('admin.lat'),
            'zoom' => trans('admin.zoom'),
            'image' => trans('admin.image'),
            'due_now' => trans('admin.due_now'),
            'payment_method' => trans('admin.payment_method'),
            'view' => trans('admin.view'),
            'facility' => trans('admin.facility'),
            'privacy' => trans('admin.privacy'),
            'lead_id' => trans('admin.lead_id'),
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()],   400);
            // return back()->withInput()->withErrors($validator);
        } else {

            $unit = new ResaleUnit;
            $unit->type = $request->type;
            $unit->unit_type_id = $request->unit_type_id;
            $unit->project_id = $request->project_id;
            $unit->lead_id = $request->lead_id;
            $unit->original_price = $request->original_price;
            $unit->payed = $request->payed;
            $unit->rest = $request->rest;
            $unit->total = $request->total;
            $unit->delivery_date = $request->delivery_date;
            $unit->finishing = $request->finishing;
            $unit->location = $request->location;
            $unit->ar_notes = $request->ar_notes;
            $unit->en_notes = $request->en_notes;
            $unit->ar_description = $request->ar_description;
            $unit->en_description = $request->en_description;
            $unit->ar_title = $request->ar_title;
            $unit->en_title = $request->en_title;
            $unit->due_now = $request->due_now;
            $unit->ar_address = $request->ar_address;
            $unit->en_address = $request->en_address;
            $unit->youtube_link = $request->youtube_link;
            $unit->phone = $request->phone;
            $unit->lead_id = $request->lead_id;
            $unit->featured = $request->featured;
            $unit->meta_keywords = $request->meta_keywords;
            $unit->meta_description = $request->meta_description;
            $unit->priority = 0;
            if ($request->has('other_phones')) {
                $unit->other_phones = json_encode($request->other_phones);
            } else {
                $unit->other_phones = json_encode([]);
            }
            if ($request->has('maintenance')) {
                $unit->maintenance = $request->maintenance;
            }
            if ($request->has('transfer')) {
                $unit->transfer = $request->transfer;
            }
            if ($request->has('bua')) {
                $unit->bua = $request->bua;
            }
            if ($request->has('villa')) {
                $unit->villa = $request->villa;
            }
            $unit->area = $request->area;
            $unit->price = $request->price;
            $unit->rooms = $request->rooms;
            $unit->bathrooms = $request->bathrooms;
            $unit->floors = $request->floors;
            $unit->lng = $request->lng;
            $unit->lat = $request->lat;
            $unit->zoom = $request->zoom;
            $unit->privacy = $request->privacy;
            $unit->agent_id = auth()->user()->id;
            if ('custom' == $request->privacy) {
                $unit->custom_agents = json_encode($request->agents);
            }

            $set = Setting::first();

            // dd($request->hasFile('image'));
            if ($request->hasFile('image')) {
                dd($request->image);
                $unit->image = upload($request->image, 'resale_unit');
                $watermark = Image::make('uploads/' . $set->watermark)->resize(50, 50);
                $image = Image::make('uploads/' . $unit->image);
                $image->insert($watermark, 'bottom-right', 10, 10);
                $image->save("uploads/resale_unit/watermarked_resale" . rand(0, 99999999999) . ".jpg");
                $unit->watermarked_image = $image->dirname . '/' . $image->basename;
            }
            $unit->payment_method = $request->payment_method;
            $unit->view = $request->view;
            $unit->availability = 'available';
            $unit->user_id = auth()->user()->id;
            $unit->save();

            $old_data = json_encode($unit);
            LogController::add_log(
                __('admin.created', [], 'ar') . ' ' . $unit->ar_title,
                __('admin.created', [], 'en') . ' ' . $unit->en_title,
                'resale_units',
                $unit->id,
                'create',
                auth()->user()->id,
                $old_data
            );

            if ($request->has('other_images')) {
                foreach ($request->other_images as $img) {
                    $other_image_model = new ResalImage;
                    $other_image = upload($img, 'resale_unit');
                    $watermark = Image::make('uploads/' . $set->watermark)->resize(50, 50);
                    $image = Image::make('uploads/' . $other_image);
                    $image->insert($watermark, 'bottom-right', 10, 10);
                    $image->save("uploads/resale_unit/other_watermarked_resale" . rand(0, 99999999999) . ".jpg");
                    $other_watermarked_images = $image->dirname . '/' . $image->basename;
                    $other_image_model->unit_id = $unit->id;
                    $other_image_model->image = $other_image;
                    $other_image_model->watermarked_image = $other_watermarked_images;
                    $other_image_model->save();
                }
            }
            $project = new ProjectController();
            foreach ($request->facility as $facility) {
                $project->addfacility($unit->id, $facility, 'resale');
            }
            session()->flash('success', trans('admin.created'));
            return response(['unitId'=> $unit->id],   200);
        }
    }

    public function show(ResaleUnit $resaleUnit)
    {
        if (checkRole('show_resale_units') or @auth()->user()->type == 'admin') {
            // return view('admin.resale_units.show', ['title' => trans('admin.show_resale_unit'), 'unit' => $resaleUnit]);
            $resaleUnit->project = DB::table('projects')->where('id',$resaleUnit->project_id)->select('en_name','ar_name')->first();
            $resaleUnit->unit_type = DB::table('unit_types')->where('id',$resaleUnit->unit_type_id)->select('en_name','ar_name')->first();
            $resaleUnit->locationOnMap = DB::table('locations')->where('id',$resaleUnit->location)->select('en_name','ar_name')->first();
            if(auth()->user()->type == "admin" || $resaleUnit->agent_id == auth()->user()->id){
                $resaleUnit->lead = DB::table('leads')->where('id',$resaleUnit->lead_id)->select('id','first_name','last_name','phone','image')->first();
            }
            $resaleLead = $resaleUnit->lead;
            if($resaleLead){
                $resaleUnitAgent = DB::table('leads as lead')->join('users as user', function($join) use($resaleLead)
                {
                    $join->on(function($query) use ($resaleLead) {
                        $query->on('lead.agent_id', '=', 'user.id');
                        $query->orOn('lead.commercial_agent_id', '=','user.id');
                    });
                })->where('lead.id','=',$resaleLead->id)->select('user.id as agent_id')->first();
                if($resaleUnitAgent){
                    if($resaleUnitAgent->agent_id){
                        $resaleUnit->agent = DB::table('users')->where('id',$resaleUnitAgent->agent_id)->select('name','phone','image')->first();
                    }
                    $resaleUnit->sliderImages = DB::table('resal_images')->where('unit_id',$resaleUnit->id)->select('id','image','watermarked_image')->get();
                    $resaleUnit->user = DB::table('users')->where('id',$resaleUnit->user_id)->value('name');
                }
            }
            
            return response()->json($resaleUnit);
        } else {
            return response()->json("Error : you dont have permission");            
        }
    }

    public function edit(ResaleUnit $resaleUnit)
    {
        if (checkRole('edit_resale_units') or @auth()->user()->type == 'admin') {
            $images = DB::table('resal_images')->where('unit_id',$resaleUnit->id)->select('id','image')->get();
            foreach($images as $image){
                $count = count(explode("/",$image->image));
                $image->name = explode("/",$image->image)[$count-1];
            }
            $leads = DB::table('leads')->select('id','first_name','last_name')->get();
            $allFacilities = DB::table('facilities')->select('id','en_name')->get();
            $allLocations = DB::table('locations')->select('id','en_name')->get();
            $facilities = UnitFacility::where('type', 'resale')->where('unit_id', $resaleUnit->id)->pluck('facility_id')->toArray();
            $leadInfo = [];
            if($resaleUnit->lead_id != null){
                $leadInfo = DB::table('leads')->where('id',$resaleUnit->lead_id)->select('id','first_name','last_name','phone')->first();
                if($leadInfo){
                    $leadInfo->name = $leadInfo->first_name . " " . $leadInfo->last_name;
                    unset($leadInfo->first_name);
                    unset($leadInfo->last_name);
                }
            }
            
            $count = count(explode("/",$resaleUnit->image));
            $resaleUnit->image = ['name' => explode("/",$resaleUnit->image)[$count-1]];
            return response()->json([
                'title' => trans('admin.edit_resale_unit'),
                'unit' => $resaleUnit,
                'facilities' => $facilities ,
                'images' => $images,
                'lead' => $leadInfo,
                'leads' => $leads,
                'allFacilities' => $allFacilities,
                'allLocations' => $allLocations,
            ]);
        } else {
            return response()->json("Error : you dont have permission");            
        }
    }

    public function update(Request $request, ResaleUnit $resaleUnit)
    {
        ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 300); // 5 minutes
        if ('personal' == $request->type) {
            $rules = [
                'type' => 'required',
                'total' => 'required',
                'unit_type_id' => 'required',
                'finishing' => 'required',
                // 'ar_description' => 'required',
                'en_description' => 'required',
                // 'ar_title' => 'required',
                'en_title' => 'required',
                // 'ar_address' => 'required',
                // 'en_address' => 'required',
                // 'phone' => 'required',
                'area' => 'required',
                'price' => 'required',
                'rooms' => 'required',
                'bathrooms' => 'required',
                // 'lng' => 'required',
                // 'lat' => 'required',
                'due_now' => 'required|numeric',
                // 'zoom' => 'required',
                'payment_method' => 'required',
                'view' => 'required',
                'lead_id' => 'required',
            ];
        } else {
            $rules = [
                'type' => 'required',
                'total' => 'required',
                'finishing' => 'required',
                // 'ar_description' => 'required',
                'en_description' => 'required',
                // 'ar_title' => 'required',
                'en_title' => 'required',
                // 'ar_address' => 'required',
                // 'en_address' => 'required',
                // 'phone' => 'required',
                'due_now' => 'required|numeric',
                'area' => 'required',
                'price' => 'required',
                // 'lng' => 'required',
                // 'lat' => 'required',
                // 'zoom' => 'required',
                'payment_method' => 'required',
                'view' => 'required',
                'lead_id' => 'required',
            ];
        }
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'type' => trans('admin.type'),
            'total' => trans('admin.total'),
            'finishing' => trans('admin.finishing'),
            'ar_description' => trans('admin.ar_description'),
            'en_description' => trans('admin.en_description'),
            'ar_title' => trans('admin.ar_title'),
            'en_title' => trans('admin.en_title'),
            'ar_address' => trans('admin.ar_address'),
            'en_address' => trans('admin.en_address'),
            'phone' => trans('admin.phone'),
            'area' => trans('admin.area'),
            'price' => trans('admin.price'),
            'rooms' => trans('admin.rooms'),
            'bathrooms' => trans('admin.bathrooms'),
            'lng' => trans('admin.lng'),
            'lat' => trans('admin.lat'),
            'zoom' => trans('admin.zoom'),
            'due_now' => trans('admin.due_now'),
            'payment_method' => trans('admin.payment_method'),
            'view' => trans('admin.view'),
            'lead_id' => trans('admin.lead'),
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $old_data = json_encode($resaleUnit);
            $resaleUnit->type = $request->type;
            $resaleUnit->unit_type_id = $request->unit_type_id;
            $resaleUnit->project_id = $request->project_id;
            $resaleUnit->lead_id = $request->lead_id;
            $resaleUnit->original_price = $request->original_price;
            $resaleUnit->payed = $request->payed;
            $resaleUnit->rest = $request->rest;
            $resaleUnit->total = $request->total;
            $resaleUnit->delivery_date = $request->delivery_date;
            $resaleUnit->finishing = $request->finishing;
            $resaleUnit->location = $request->location;
            $resaleUnit->ar_notes = $request->ar_notes;
            $resaleUnit->en_notes = $request->en_notes;
            $resaleUnit->ar_description = $request->ar_description;
            $resaleUnit->en_description = $request->en_description;
            $resaleUnit->ar_title = $request->ar_title;
            $resaleUnit->en_title = $request->en_title;
            $resaleUnit->due_now = $request->due_now;
            $resaleUnit->ar_address = $request->ar_address;
            $resaleUnit->en_address = $request->en_address;
            $resaleUnit->youtube_link = $request->youtube_link;
            $resaleUnit->phone = $request->phone;
            $resaleUnit->featured = $request->featured;
            $resaleUnit->meta_keywords = $request->meta_keywords;
            $resaleUnit->meta_description = $request->meta_description;
            $resaleUnit->priority = 0;
            if ($request->has('other_phones')) {
                $resaleUnit->other_phones = json_encode($request->other_phones);
            } else {
                $resaleUnit->other_phones = '[]';
            }
            $resaleUnit->area = $request->area;
            $resaleUnit->price = $request->price;
            $resaleUnit->rooms = $request->rooms;
            $resaleUnit->bathrooms = $request->bathrooms;
            $resaleUnit->floors = $request->floors;
            $resaleUnit->lng = $request->lng;
            $resaleUnit->lat = $request->lat;
            $resaleUnit->zoom = $request->zoom;

            $set = Setting::first();
            if ($request->hasFile('image')) {
                $resale_image = upload($request->image, 'resale_unit');
                $watermark = Image::make('uploads/' . $set->watermark)->resize(50, 50);
                $image = Image::make('uploads/' . $resale_image);
                $image->insert($watermark, 'bottom-right', 10, 10);
                $image->save("uploads/resale_unit/watermarked_resale" . rand(0, 99999999999) . ".jpg");
                $resaleUnit->watermarked_image = $watermarked = $image->dirname . '/' . $image->basename;
                $resaleUnit->image = 'uploads/' . $resale_image;
            }
            $resaleUnit->payment_method = $request->payment_method;
            $resaleUnit->view = $request->view;
            $resaleUnit->availability = 'available';
            $resaleUnit->agent_id = $request->agent_id;
            $resaleUnit->user_id = auth()->user()->id;
            $resaleUnit->save();

            $new_data = json_encode($resaleUnit);
            LogController::add_log(
                __('admin.updated', [], 'ar') . ' ' . $resaleUnit->ar_title,
                __('admin.updated', [], 'en') . ' ' . $resaleUnit->en_title,
                'resale_units',
                $resaleUnit->id,
                'update',
                auth()->user()->id,
                $old_data,
                $new_data
            );
            $fa1 = UnitFacility::where('unit_id', $resaleUnit->id)->where('type', 'resale')->pluck('id');
            $p = new ProjectController();

            foreach (UnitFacility::where('unit_id', $resaleUnit->id)->where('type', 'resale')->get() as $f) {
                $f->delete();
            }
            if (null != $request->facility) {
                foreach ($request->facility as $facility) {
                    $p->addfacility($resaleUnit->id, $facility, 'resale');
                }
            }

            if ($request->has('other_images')) {
                foreach ($request->other_images as $img) {
                    $other_image_model = new ResalImage;
                    $other_image = upload($img, 'resale_unit');
                    $watermark = Image::make('uploads/' . $set->watermark)->resize(50, 50);
                    $image = Image::make('uploads/' . $other_image);
                    $image->insert($watermark, 'bottom-right', 10, 10);
                    $image->save("uploads/resale_unit/other_watermarked_resale" . rand(0, 99999999999) . ".jpg");
                    $other_watermarked_images = $image->dirname . '/' . $image->basename;
                    $other_image_model->unit_id = $resaleUnit->id;
                    $other_image_model->image = 'uploads/' . $other_image;
                    $other_image_model->watermarked_image = $other_watermarked_images;
                    $other_image_model->save();
                }
            }
            return response()->json("Successfully Updated Resale Unit");
            // session()->flash('success', trans('admin.updated'));
            // return redirect(adminPath() . '/resale_units/' . $resaleUnit->id);
        }
    }

    public function sort_resale()
    {
        $featured_resale = ResaleUnit::orderby('order_web')->get();
        $mobile_resale = ResaleUnit::where('mobile', 1)->orderby('order_mobile')->get();
        return response()->json([
            'web_resale' => $featured_resale,
            'mobile_resale' => $mobile_resale,
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
            $current = ResaleUnit::find($project->id);
            $current->order_web = $i;
            // return $current->id.'=>'.$current->en_name.'=>'. $i;
            $current->update();
        }
        
        foreach ($request->new_mobile_data as $key => $value) {
            $project = json_decode($value);
            $i++;
            $current = ResaleUnit::find($project->id);
            $current->order_mobile = $i;
            // return $current->id.'=>'.$current->en_name.'=>'. $i;
            $current->update();
        }

        return response()->json([
            'data' => 'success sort'
        ],200);
    }


    public function destroy($id)
    {
        $resaleUnit = ResaleUnit::find($id);
        if (checkRole('delete_resale_units') or @auth()->user()->type == 'admin') {
            $old_data = json_encode($resaleUnit);
            LogController::add_log(
                __('admin.deleted', [], 'ar') . ' ' . $resaleUnit->ar_title,
                __('admin.deleted', [], 'en') . ' ' . $resaleUnit->en_title,
                'resale_units',
                $resaleUnit->id,
                'delete',
                auth()->user()->id,
                $old_data
            );
            $resaleUnit->delete();
            session()->flash('success', trans('admin.deleted'));
            UnitFacility::where('unit_id', $resaleUnit->id)->where('type', 'rental')->delete();
            $resaleUnit->delete();
            return redirect(adminPath() . '/resale_units');
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return back();
        }
    }

    public function reorder()
    {
        $units = ResaleUnit::where('featured', 1)->orderBy('priority')->get();
        $projects = Project::where('featured', 1)->orderBy('priority')->get();
        return view('admin.resale_units.reorder_units', ['title' => __('admin.reorder'), 'units' => $units, 'projects' => $projects]);
    }

    public function reorder_post(Request $request)
    {
        $i = 1;
        foreach ($request->order as $order) {
            $unit = ResaleUnit::find($order);
            $unit->priority = $i;
            $unit->save();
            $i++;
        }
        return 'true';
    }

    public function reorder_projects(Request $request)
    {
        $i = 1;
        foreach ($request->order as $order) {
            $project = Project::find($order);
            $project->priority = $i;
            $project->save();
            $i++;
        }
        return 'true';
    }

    public function delete_resale_image(Request $request)
    {
        $img = ResalImage::find($request->id);
        @unlink('uploads/' . $img->image);
        @unlink($img->watermarked_image);
        $img->delete();
        return response()->json([
            'status' => true,
        ]);
    }

    public function website_show($lang,$id)
    {
        $array = explode('-', $id);
        $id = end($array);
        $resale = ResaleUnit::find($id);
        $home = new HomeController();
        $search = $home->search_info();
        $project = new ProjectController;
        $featured = $project->featured_project();
        $keyword = $resale->meta_keywords;
        $description = $resale->description;
        return view('website.resale', ['resale' => $resale, 'keyword' => $keyword, 'search' => $search, 'description' => $description, 'featured' => $featured, 'title' => $resale->{app()->getLocale() . '_title'}]);
    }

    public function confirm($id)
    {
        $unit = ResaleUnit::find($id);
        $unit->confirmed = 0;
        $unit->save();
        return back();
    }

    // New Resale Impelmentation

    public function createUnit(){
        return view('admin.resale_units.create-new');
    }

    public function storeUnitResale(Request $request)
    {
        // dd($request->all());
        if($request->uniteAddType == 'resale'){
            $unit = new ResaleUnit;
            // $other_image_model = new ResalImage;
            $unit->original_price = $request->originalPrice;
            $unit->payed = $request->paid;
            $unit->rest = $request->rest;
            $unit->total = $request->total;
            $unit->price = $request->price;
            $unit->payment_method = $request->payment_method;
            $unit->due_now = $request->due_now;
        }
        elseif($request->uniteAddType == 'rentel'){
            $unit = new RentalUnit;
            // $other_image_model = new RentalImage;
            $unit->priod_type = $request->periodType;
            $unit->value_ensure = $request->valueEnsure;
            $unit->value_of_rent = $request->valueOfRent;
        }


            $unit->privacy = $request->privacy;
            $unit->lead_id = $request->lead_id;
            $unit->agent_id = auth()->user()->id;
            $unit->phone = $request->phone;
            $unit->ar_title = $request->ar_title;
            $unit->en_title = $request->en_title;
            $unit->ar_description = $request->ar_description;
            $unit->en_description = $request->en_description;
            $unit->ar_notes = $request->ar_notes;
            $unit->en_notes = $request->en_notes;

            $unit->type = $request->type;
            $unit->unit_type_id = $request->unit_type_id;
            $unit->view = $request->view;
            $unit->area = $request->area;
            $unit->delivery_date = $request->delivery_date;
            $unit->project_id = $request->project_id;
            $unit->bua = $request->bua;
            $unit->villa = $request->landArea;


            $unit->rooms = $request->rooms;
            $unit->bathrooms = $request->bathrooms;
            $unit->floors = $request->floors;
            $unit->finishing = $request->finishing;
            $unit->lng = $request->lng;
            $unit->lat = $request->lat;
            $unit->zoom = $request->zoom;
            $unit->location_number = $request->loc_num;

            $unit->location = $request->locationId;
            //$unit->country = $request->country;
            //$unit->city = $request->city;
            $unit->ar_address = $request->ar_address;
            $unit->en_address = $request->en_address;
            $unit->status = 'done';

            if ($request->image) {
                // $this->saveSingleImage($unit,$request->dropFiles1,'uploads/resale_unit/watermarked_resale','watermarked_image');
                $exploded = explode(',',$request->image);
                $image = base64_decode($exploded[1]);
                $file = finfo_open();
                $mime_type = finfo_buffer($file, $image, FILEINFO_MIME_TYPE);

                $type =explode("image/",  $mime_type);
                $path = "uploads/resale_unit/";
                $filename = $path . time() .'.'.$type[1];
                file_put_contents($filename, $image);

                $unit->image = $filename;
            }

            $unit->availability = 'available';
            $unit->user_id = auth()->user()->id;
            $unit->save();


            if ($request->other_images) {
                foreach ($request->other_images as $k => $img) {
                    // dump($img);
                    $exploded = explode(',',$img);
                    $image = base64_decode($exploded[1]);
                    $file = finfo_open();
                    $mime_type = finfo_buffer($file, $image, FILEINFO_MIME_TYPE);

                    $type =explode("image/",  $mime_type);
                    $path = "uploads/resale_unit/other_watermarked_resale";
                    $filename = $path . (time() + $k) .'.'.$type[1];
                    file_put_contents($filename, $image);


                    if($request->uniteAddType == 'resale')
                        $other_image_model = new ResalImage;
                    elseif($request->uniteAddType == 'rentel')
                        $other_image_model = new RentalImage;
                    $other_image_model->unit_id = $unit->id;
                    $other_image_model->image = $filename;
                    $other_image_model->watermarked_image = $filename;
                    $other_image_model->save();
                }
            }
        return $unit;
    }

    public function storeUnitResaleSteps(Request $request,$step=1,$id=null)
    {
        if($request->uniteAddType == 'resale'){
            if ($id){
                $unit = ResaleUnit::find($id);
                $other_image_model = new ResalImage;
            }
            else{
                $unit = new ResaleUnit;
            }

            if ($step == 5 && $unit) {
                $unit->original_price = $request->original_price;
                $unit->payed = $request->payed;
                $unit->rest = $request->rest;
                $unit->total = $request->total;
                $unit->price = $request->price;
                $unit->payment_method = $request->payment_method;
                $unit->due_now = $request->due_now;
                $unit->save();
                return ["status"=>"ok",'data'=>$unit];
            }
        }elseif($request->uniteAddType == 'rental'){
            if ($id){
                $unit = RentalUnit::find($id);
                $other_image_model = new RentalImage;
            }
            else
                $unit = new RentalUnit;

            if ($step == 5 && $unit) {
                $unit->priod_type = $request->periodType;
                $unit->value_ensure = $request->valueEnsure;
                $unit->value_of_rent = $request->valueOfRent;
                $unit->save();
                return ["status"=>"ok",'data'=>$unit];
            }
        }
        // if($request->uniteAddType == 'resale'){
            if($step == 1){
                // dd('sss');
                // $unit = new ResaleUnit;
                // dd($request->privacy);
                $unit->privacy = $request->privacy;
                $unit->lead_id = $request->lead_id;
                $unit->agent_id = $request->agent_id;
                $unit->phone = $request->phone;
                $unit->ar_description = $request->ar_description;
                $unit->en_description = $request->en_description;
                $unit->ar_notes = $request->ar_notes;
                $unit->en_notes = $request->en_notes;
                $unit->user_id = $request->user_id;
                $unit->save();
                return ["status"=>"ok",'data'=>$unit];
            }elseif($step == 2){
                // $unit = ResaleUnit::find($id);
                if($unit){
                    $unit->type = $request->type;
                    $unit->unit_type_id = $request->unit_type_id;
                    $unit->project_id = $request->project_id;
                    $unit->view = $request->view;
                    $unit->area = $request->area;
                    $unit->rooms = $request->rooms;
                    $unit->bathrooms = $request->bathrooms;
                    $unit->floors = $request->floors;
                    $unit->delivery_date = $request->delivery_date;
                    $unit->finishing = $request->finishing;
                    $unit->bua = $request->bua;
                    $unit->villa = $request->landArea;
                    $unit->save();
                    return ["status"=>"ok",'data'=>$unit];
                }
            }elseif($step == 3) {
                // $unit = ResaleUnit::find($id);
                if($unit){
                    $unit->lng = $request->lng;
                    $unit->lat = $request->lat;
                    $unit->zoom = $request->zoom;

                    $unit->location = $request->location;
                    $unit->ar_address = $request->ar_address;
                    $unit->en_address = $request->en_address;
                    $unit->save();
                    return ["status"=>"ok",'data'=>$unit];
                }
            }elseif($step == 4) {
                // $unit = ResaleUnit::find($id);
                if($unit){
                    /*if ($request->other_images) {
                        foreach ($request->other_images as $img) {
                            $this->saveMultiplePhotos($unit,$request->other_images,'uploads/resale_unit/other_watermarked_resale','other_images');
                        }
                        return ["status"=>"ok",'data'=>$unit];
                    }*/
                    if ($request->image) {
                        // dd('weqewqe');
                        // $this->saveSingleImage($unit,$request->dropFiles1,'uploads/resale_unit/watermarked_resale','watermarked_image');
                        $exploded = explode(',',$request->image);
                        $image = base64_decode($exploded[1]);
                        $file = finfo_open();
                        $mime_type = finfo_buffer($file, $image, FILEINFO_MIME_TYPE);
                        
                        $type =explode("image/",  $mime_type);
                        $path = "uploads/resale_unit/";
                        $filename = $path . time() .'.'.$type[1];
                        file_put_contents($filename, $image);

                        $unit->image = $filename;
                    }

                    if ($request->other_images) {
                        foreach ($request->other_images as $img) {
                            $exploded = explode(',',$img);
                            $image = base64_decode($exploded[1]);
                            $file = finfo_open();
                            $mime_type = finfo_buffer($file, $image, FILEINFO_MIME_TYPE);

                            $type =explode("image/",  $mime_type);
                            $path = "uploads/resale_unit/other_watermarked_resale";
                            $filename = $path . time() .'.'.$type[1];
                            file_put_contents($filename, $image);

                            $other_image_model->unit_id = $unit->id;
                            $other_image_model->image = $filename;
                            $other_image_model->watermarked_image = $filename;
                            $other_image_model->save();
                        }
                    }
                    $unit->save();
                    return ["status"=>"ok",'data'=>$unit];
                }

            }/*elseif($step == 5) {
                $unit = ResaleUnit::find($id);
                if($unit){
                    $unit->original_price = $request->original_price;
                    $unit->payed = $request->payed;
                    $unit->rest = $request->rest;
                    $unit->total = $request->total;
                    $unit->price = $request->price;
                    $unit->payment_method = $request->payment_method;
                    $unit->due_now = $request->due_now;
                    $unit->availability = 'available';
                    $unit->save();
                    return ["status"=>"ok",'data'=>$unit];
                }
            }

            return $unit;*/
       /* }elseif($request->uniteAddType == 'rentel'){
        }*/
    }

    public function newResaleFilter(Request $request, $reportType=null) {
        $query = new ResaleUnit;
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
         if (@$request->project) {
          $requests = Project::where('id', $request->project)->pluck('id')->toArray();
           $query = $query->whereIn('project_id', $requests);

        }
        if (@$request->unit_typee) {
          $requests = UnitType::where('id', $request->unit_typee)->pluck('id')->toArray();
           $query = $query->whereIn('unit_type_id', $requests);
          // return $query;
        }
        if (@$request->typee) {
          $requests = ResaleUnit::where('type', $request->typee)->pluck('id')->toArray();
           $query = $query->whereIn('id', $requests);
          // return $query;
        }
         $resale = $query->orderBy("id","desc")->paginate('10000');
       /* if ($request->reportType) {
          $leads = $query->orderBy("id","desc")->get();
        }
        else {
          $leads = $query->orderBy("id","desc")->paginate('10000');
        }*/

        /*$r_loca = $request->location;
        $r = @Location::find($r_loca)->en_name;*/


        /*if ($request->reportType) {

          $this->exportReportLeads($leads);
        }
        else*/
          return $resale;
    }

    /*public function newResaleFilter(Request $request, $reportType=null) {
        $query = new ResaleUnit;
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
        // $r_loca = $request->location;
        // $r = @Location::find($r_loca)->en_name;

        if ($request->reportType) {

          $this->exportReportLeads($leads);
        }
        else
          return $leads;
    }*/
    public function exportReportLeads($data) {

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

    // This is the query to reform resale images that point to false ids that is not present in resale units table
    //
    //delete from resal_images where unit_id in 
    //(SELECT image.unit_id as resale_id FROM resal_images as image 
    //left join resale_units as unit on image.unit_id = unit.id where unit.id is null)

    public function updateWebsiteResaleShow($id){
        $resaleunit = ResaleUnit::find($id);
        $resaleunit->website_show = !$resaleunit->website_show;
        $resaleunit->save();
        return response()->json("Successfully Updated Resale show on website");
    }

    public function getUploadResalePage(){
        return view('admin.resale_units.upload_resale');
    }

    public function uploadResaleExcel(Request $request){
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
					foreach ($array as $item) {
                        $leadID = null;
						if($item['privacy'] == null || $item['en_title'] == null || $item['en_description'] == null){
                            continue;
                        }
                        if (isset($item['contact'])) {
						    $contact = $leadInstance->reformPhone($item['contact']);
                            $leadID = DB::table('leads')->where('phone', $contact->phone)->value('id');
							if ($leadID == null) {
								$first_name = '';
                                $last_name = '';
                                if (isset(explode(' ', $item['lead_name'])[0])) {
                                    $first_name = explode(' ', $item['lead_name'])[0];
                                }
                                for($i=1;$i<count(explode(' ', $item['lead_name']));$i++){
                                    if (isset(explode(' ', $item['lead_name'])[$i])) {
										$last_name .= explode(' ', $item['lead_name'])[$i] . ' ';
									}
                                }
                                $checkType = self::checkTypeForAgent((int) $item['agent_id']);
                                if($checkType == "commercial"){
                                    $checkType .= "_agent_id";
                                }else{
                                    $checkType = "agent_id";
                                }
								$agentId = (int) $item['agent_id'];
                                $leadID = DB::table('leads')->insertGetId([
                                    'first_name' => $first_name,
                                    'last_name' => $last_name,
                                    'phone' => $contact->phone,
                                    'phone_iso' => $contact->iso,
                                    'email' => $item['lead_email'],
                                    "$checkType" => $item['agent_id'],
                                    'lead_source_id' => $item['lead_source_id'],
                                    'user_id' => auth()->user()->id,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ]);
							}
                        }
                        if (strpos($item['type'], 'commercial') !== false) {
                            $item['type'] = "commercial";
                        }else if (strpos($item['type'], 'personal') !== false) {
                            $item['type'] = "personal";
                        }

                        if (strpos($item['finishing'], 'finished') !== false) {
                            $item['finishing'] = "finished";
                        }else if (strpos($item['finishing'], 'semi_finished') !== false) {
                            $item['finishing'] = "semi_finished";
                        }else if (strpos($item['finishing'], 'not_finished') !== false) {
                            $item['finishing'] = "not_finished";
                        }

                        if (strpos($item['payment_method'], 'cash') !== false) {
                            $item['payment_method'] = "cash";
                        }else if (strpos($item['payment_method'], 'installment') !== false) {
                            $item['payment_method'] = "installment";
                        }else if (strpos($item['payment_method'], 'cash_or_installment') !== false) {
                            $item['payment_method'] = "cash_or_installment";
                        }

                        if (strpos($item['view'], 'main_street') !== false) {
                            $item['view'] = "main_street";
                        }else if (strpos($item['view'], 'bystreet') !== false) {
                            $item['view'] = "bystreet";
                        }else if (strpos($item['view'], 'garden') !== false) {
                            $item['view'] = "garden";
                        }else if (strpos($item['view'], 'corner') !== false) {
                            $item['view'] = "corner";
                        }else if (strpos($item['view'], 'sea_or_river') !== false) {
                            $item['view'] = "sea_or_river";
                        }

                        DB::table('resale_units')->insert([
                            'lead_id' => $leadID,
                            'location_number' => $item['location_number'],
                            'maintenance' => $item['maintenance'],
                            'transfer' => $item['transfer'],
                            'bua' => $item['bua'],
                            'villa' => $item['villa'],
                            'type' => $item['type'],
                            'unit_type_id' => $item['unit_type_id'],
                            'project_id' => $item['project_id'],
                            'agent_id' => $item['agent_id'],
                            'original_price' => $item['original_price'],
                            'payed' => $item['payed'],
                            'rest' => $item['rest'],
                            'total' => $item['total'],
                            'delivery_date' => $item['delivery_date'],
                            'finishing' => $item['finishing'],
                            'location' => $item['location'],
                            'ar_notes' => $item['ar_notes'],
                            'en_notes' => $item['en_notes'],
                            'ar_description' => $item['ar_description'],
                            'en_description' => $item['en_description'],
                            'ar_title' => $item['ar_title'],
                            'en_title' => $item['en_title'],
                            'ar_address' => $item['ar_address'],
                            'en_address' => $item['en_address'],
                            'area' => $item['area'],
                            'price' => $item['price'],
                            'rooms' => $item['rooms'],
                            'bathrooms' => $item['bathrooms'],
                            'floors' => $item['floors'],
                            'payment_method' => $item['payment_method'],
                            'view' => $item['view'],
                            'availability' => $item['availability'],
                            'due_now' => $item['due_now'],
                            'website_show' => $item['website_show'],
                            'confirmed' => $item['confirmed'],
                            'privacy' => $item['privacy'],
                            'user_id' => auth()->user()->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                        
					}
					return response()->json([
						'message' => "Successfully Inserted Resale Units"
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

    public function resaleXls() {
        Excel::create('Request', function ($excel) {
            $excel->sheet('campaign', function ($sheet) {
                $sheet->loadView('admin.resale_units.xls');
            });
        })->export('xls');
    }

    public function editResale(Request $request){
        ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 300); // 5 minutes
        if ('personal' == $request->type) {
            $rules = [
                'type' => 'required',
                'total' => 'required',
                'unit_type_id' => 'required',
                'finishing' => 'required',
                // 'ar_description' => 'required',
                'en_description' => 'required',
                // 'ar_title' => 'required',
                'en_title' => 'required',
                // 'ar_address' => 'required',
                // 'en_address' => 'required',
                // 'phone' => 'required',
                'area' => 'required',
                'price' => 'required',
                'rooms' => 'required',
                'bathrooms' => 'required',
                // 'lng' => 'required',
                // 'lat' => 'required',
                'due_now' => 'required|numeric',
                // 'zoom' => 'required',
                'payment_method' => 'required',
                'view' => 'required',
                'lead_id' => 'required',
            ];
        } else {
            $rules = [
                'type' => 'required',
                'total' => 'required',
                'finishing' => 'required',
                // 'ar_description' => 'required',
                'en_description' => 'required',
                // 'ar_title' => 'required',
                'en_title' => 'required',
                // 'ar_address' => 'required',
                // 'en_address' => 'required',
                // 'phone' => 'required',
                'due_now' => 'required|numeric',
                'area' => 'required',
                'price' => 'required',
                // 'lng' => 'required',
                // 'lat' => 'required',
                // 'zoom' => 'required',
                'payment_method' => 'required',
                'view' => 'required',
                'lead_id' => 'required',
            ];
        }
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'type' => trans('admin.type'),
            'total' => trans('admin.total'),
            'finishing' => trans('admin.finishing'),
            'ar_description' => trans('admin.ar_description'),
            'en_description' => trans('admin.en_description'),
            'ar_title' => trans('admin.ar_title'),
            'en_title' => trans('admin.en_title'),
            'ar_address' => trans('admin.ar_address'),
            'en_address' => trans('admin.en_address'),
            'phone' => trans('admin.phone'),
            'area' => trans('admin.area'),
            'price' => trans('admin.price'),
            'rooms' => trans('admin.rooms'),
            'bathrooms' => trans('admin.bathrooms'),
            'lng' => trans('admin.lng'),
            'lat' => trans('admin.lat'),
            'zoom' => trans('admin.zoom'),
            'due_now' => trans('admin.due_now'),
            'payment_method' => trans('admin.payment_method'),
            'view' => trans('admin.view'),
            'lead_id' => trans('admin.lead'),
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $resaleID = $request->id;
            $resaleUnit = ResaleUnit::find($resaleID);
            $old_data = json_encode($resaleUnit);
            $resaleUnit->type = $request->type;
            $resaleUnit->unit_type_id = $request->unit_type_id;
            $resaleUnit->project_id = $request->project_id;
            $resaleUnit->lead_id = $request->lead_id;
            $resaleUnit->original_price = $request->original_price;
            $resaleUnit->payed = $request->payed;
            $resaleUnit->rest = $request->rest;
            $resaleUnit->total = $request->total;
            $resaleUnit->delivery_date = $request->delivery_date;
            $resaleUnit->finishing = $request->finishing;
            $resaleUnit->location = $request->location;
            $resaleUnit->ar_notes = $request->ar_notes;
            $resaleUnit->en_notes = $request->en_notes;
            $resaleUnit->ar_description = $request->ar_description;
            $resaleUnit->en_description = $request->en_description;
            $resaleUnit->ar_title = $request->ar_title;
            $resaleUnit->en_title = $request->en_title;
            $resaleUnit->due_now = $request->due_now;
            $resaleUnit->ar_address = $request->ar_address;
            $resaleUnit->en_address = $request->en_address;
            $resaleUnit->youtube_link = $request->youtube_link;
            $resaleUnit->phone = $request->phone;
            $resaleUnit->featured = $request->featured;
            $resaleUnit->meta_keywords = $request->meta_keywords;
            $resaleUnit->meta_description = $request->meta_description;
            $resaleUnit->priority = 0;
            if ($request->has('other_phones')) {
                $resaleUnit->other_phones = json_encode($request->other_phones);
            } else {
                $resaleUnit->other_phones = '[]';
            }
            $resaleUnit->area = $request->area;
            $resaleUnit->price = $request->price;
            $resaleUnit->rooms = $request->rooms;
            $resaleUnit->bathrooms = $request->bathrooms;
            $resaleUnit->floors = $request->floors;
            $resaleUnit->lng = $request->lng;
            $resaleUnit->lat = $request->lat;
            $resaleUnit->zoom = $request->zoom;

            $set = Setting::first();
            if ($request->hasFile('image')) {
                $resale_image = upload($request->image, 'resale_unit');
                $watermark = Image::make('uploads/' . $set->watermark)->resize(50, 50);
                $image = Image::make('uploads/' . $resale_image);
                $image->insert($watermark, 'bottom-right', 10, 10);
                $image->save("uploads/resale_unit/watermarked_resale" . rand(0, 99999999999) . ".jpg");
                $resaleUnit->watermarked_image = $watermarked = $image->dirname . '/' . $image->basename;
                $resaleUnit->image = 'uploads/' . $resale_image;
            }
            $resaleUnit->payment_method = $request->payment_method;
            $resaleUnit->view = $request->view;
            $resaleUnit->availability = 'available';
            $resaleUnit->agent_id = $request->agent_id;
            $resaleUnit->user_id = auth()->user()->id;
            $resaleUnit->save();

            $new_data = json_encode($resaleUnit);
            LogController::add_log(
                __('admin.updated', [], 'ar') . ' ' . $resaleUnit->ar_title,
                __('admin.updated', [], 'en') . ' ' . $resaleUnit->en_title,
                'resale_units',
                $resaleUnit->id,
                'update',
                auth()->user()->id,
                $old_data,
                $new_data
            );
            $fa1 = UnitFacility::where('unit_id', $resaleUnit->id)->where('type', 'resale')->pluck('id');
            $p = new ProjectController();

            foreach (UnitFacility::where('unit_id', $resaleUnit->id)->where('type', 'resale')->get() as $f) {
                $f->delete();
            }
            if (null != $request->facility) {
                foreach ($request->facility as $facility) {
                    $p->addfacility($resaleUnit->id, $facility, 'resale');
                }
            }
            
            if ($request->has('other_images')) {
                $otherImages = $request->other_images;
                foreach ($otherImages as $img) {
                    $other_image_model = new ResalImage;
                    $other_image = upload($img, 'resale_unit');
                    $watermark = Image::make('uploads/' . $set->watermark)->resize(50, 50);
                    $image = Image::make('uploads/' . $other_image);
                    $image->insert($watermark, 'bottom-right', 10, 10);
                    $image->save("uploads/resale_unit/other_watermarked_resale" . rand(0, 99999999999) . ".jpg");
                    $other_watermarked_images = $image->dirname . '/' . $image->basename;
                    $other_image_model->unit_id = $resaleUnit->id;
                    $other_image_model->image = 'uploads/' . $other_image;
                    $other_image_model->watermarked_image = $other_watermarked_images;
                    $other_image_model->save();
                }
            }
            return response()->json("Successfully Updated Resale Unit");
            // session()->flash('success', trans('admin.updated'));
            // return redirect(adminPath() . '/resale_units/' . $resaleUnit->id);
        }
    }
    public function getresalefeature()
    {
        $Resale = ResaleUnit::where('featured',1)->select('id','en_title as en_name','ar_title as ar_name','featured')->get();
        $Resale->count();
        // dd($Resale);
        if($Resale){
            return response()->json(
                   $Resale
            ,200);
        }else{
            return response()->json(
                    'No one have a banner'
            ,404);
        }
    }
    public function removefeatureResaleByID($id)
    {
        $Resale = ResaleUnit::find($id);
		$Resale->featured = 0;
		$Resale->update();
		return response()->json('Removed',200);

    }
}
