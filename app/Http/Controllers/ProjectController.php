<?php

namespace App\Http\Controllers;

use App\Developer;
use App\Favorite;
use App\Gallery;
use App\Gallery as Gimages;
use App\LayoutImage;
use App\Lead;
use App\LeadNotification;
use App\Location;
use App\Mail\TestMail;
use App\MainSlider;
use App\Phase;
use App\Project;
use App\ProjectTag;
use App\Property;
use App\Property_images;
use App\RecentViewed;
use App\UnitFacility;
use Auth;
use DB;
use Illuminate\Http\Request;
use Image;
use Mail;
use Validator;
use Carbon\Carbon;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (checkRole('show_projects') or @auth()->user()->type == 'admin') {
            $projects = DB::table('projects as project')
                ->leftjoin('developers as developer', 'project.developer_id', '=', 'developer.id')
                ->select(
                    'project.id',
                    'project.en_name',
                    'project.ar_name',
                    'project.logo',
                    'project.cover',
                    'project.delivery_date',
                    'project.installment_year',
                    'developer.logo as dev_logo'
                )
                ->get();
            foreach ($projects as $project) {
                $project->phases = DB::table('phases')->where('project_id', $project->id)->count();
            }
            return view('admin.projects.index_new', ['title' => trans('admin.projects'), 'projects' => $projects]);
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return back();
        }
        // if (checkRole('show_projects') or @auth()->user()->type == 'admin') {
        //     $project = Project::get();
        //     return view('admin.projects.index', ['title' => trans('admin.projects'), 'project' => $project]);
        // } else {
        //     session()->flash('error', __('admin.you_dont_have_permission'));
        //     return back();
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (checkRole('add_projects') or @auth()->user()->type == 'admin') {
            $location = Location::where('parent_id', '=', 0)->select(app()->getLocale() . '_name as title', 'id', 'lat', 'lng', 'zoom')->get();
            return view('admin.projects.create', ['title' => trans('admin.project'), 'location' => $location]);
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
    private function store_facility($id, $request)
    {
        for ($i = 0; $i < count($request->tags); $i++) {
            $pt = new ProjectTag();
            $pt->phase_id = $id;
            $pt->facility_id = $request->facility[$i];
            $pt->save();
        };
    }

    public function store(Request $request)
    {
        $leads = Lead::select('email')->get();
        // foreach ($leads as $lead) {
        //     if (filter_var($lead->email, FILTER_VALIDATE_EMAIL)) {
        //         Mail::to($lead->email)->queue(new TestMail(['test' => 'Happy new Year']));
        //     }
        // }
        $rules = [
            'en_name' => 'required|max:191',
            'ar_name' => 'required|max:191',
            'meter_price' => 'required|numeric',
            'area' => 'required|numeric',
            'area_to' => 'required|numeric',
            'lat' => 'required|numeric',
            'location' => 'required|numeric',
            'developer' => 'required|numeric',
            'logo' => 'required|image',
            'cover' => 'required|image',
            // 'map_marker' => 'required|image',
            'tags' => 'required',
            'facility' => 'required',
            'down_payment' => 'required|numeric',
            'installment_year' => 'required|numeric',
            'delivery_date' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'en_name' => trans('admin.en_name'),
            'ar_name' => trans('admin.ar_name'),
            'meter_price' => trans('admin.meter_price'),
            'area' => trans('admin.area'),
            'area_to' => trans('admin.area_to'),
            'lat' => trans('admin.map_location'),
            'developer' => trans('admin.developer'),
            'location' => trans('admin.location'),
            'logo' => trans('admin.logo'),
            'down_payment' => trans('admin.down_payment'),
            'installment_year' => trans('admin.installment_year'),
            'tags' => trans('admin.tags'),
            'cover' => trans('admin.cover'),
            // 'map_marker' => trans('admin.map_marker'),
            'facility' => trans('admin.facility'),
            'delivery_date' => trans('admin.delivery_date'),
        ]);

        if ($validator->fails()) {
            return response()->json("Validation Error");
            // return back()->withInput()->withErrors($validator);
        } else {
            if ($request->hasFile('logo')) {
                if ($request->hasFile('cover')) {
                    $project = new Project;
                    $project->en_name = $request->en_name;
                    $project->ar_name = $request->ar_name;
                    $project->en_description = $request->en_description;
                    $project->ar_description = $request->ar_description;
                    $project->meter_price = $request->meter_price;
                    $project->area = $request->area;
                    $project->area_to = $request->area_to;
                    $project->lat = $request->lat;
                    $project->lng = $request->lng;
                    $project->zoom = $request->zoom;
                    $project->developer_id = $request->developer;
                    $project->location_id = $request->location;
                    $project->down_payment = $request->down_payment;
                    $project->installment_year = $request->installment_year;
                    $project->featured = $request->featured;
                    $project->facebook = $request->facebook;
                    $project->vacation = $request->vacation;
                    $project->show_website = $request->show_website;
                    $project->type = $request->type;
                    $project->video = $request->video;
                    $date = Carbon::createFromFormat('D M d Y H:i:s e+',$request->delivery_date);
                    $project->delivery_date = Carbon::parse($date)->format('Y');
                    // $project->delivery_date = $request->delivery_date;
                    $project->logo = uploads($request, 'logo');
                    $project->cover = uploads($request, 'cover');
                    $project->website_cover = uploads($request, 'website_cover');
                    $project->meta_keywords = $request->meta_keywords;
                    $project->meta_description = $request->meta_description;

                    if ($request->has('developer_pdf')) {
                        $file_path = 'uploads/' . $project->developer_pdf;
                        @unlink($file_path);
                        $project->developer_pdf = uploads($request, 'developer_pdf');
                    }
                    if ($request->has('broker_pdf')) {
                        $file_path = 'uploads/' . $project->broker_pdf;
                        @unlink($file_path);
                        $project->broker_pdf = uploads($request, 'broker_pdf');
                    }
                    if ('1' == $request->mobile) {
                        $project->mobile = 1;
                    } else {
                        $project->mobile = 0;
                    }
                    if ($request->hasFile('map_marker')) {
                        $project->map_marker = uploads($request, 'map_marker');
                    }
                    $project->user_id = Auth::user()->id;
                    if ('1' == $request->main_slider) {
                        $project->on_slider = 1;
                    }
                    $project->user_id = auth()->user()->id;

                    if ('1' == $request->main_slider) {
                        if ($request->has('project_slider')) {
                            $file_path = 'uploads/' . $project->website_slider;
                            @unlink($file_path);
                            $project->website_slider = uploads($request, 'project_slider');
                        }
                    }

                    $project->save();
                    $logo = Image::make('uploads/' . $project->logo)->resize(34, 34);
                    $marker = Image::make('uploads/marker.png');
                    $marker->insert($logo, 'margin-top', 8, 10);
                    $marker->save('uploads/marker/' . $project->id . '.png');
                    $project->map_marker = 'marker/' . $project->id . '.png';
                    $project->save();
                    $old_data = json_encode($project);
                    LogController::add_log(
                        __('admin.created', [], 'ar') . ' ' . $project->ar_name,
                        __('admin.created', [], 'en') . ' ' . $project->en_name,
                        'projects',
                        $project->id,
                        'create',
                        auth()->user()->id,
                        $old_data
                    );

                    for ($i = 0; $i < count($request->tags); $i++) {
                        $tag = new ProjectTag;
                        $tag->tag_id = $request->tags[$i];
                        $tag->project_id = $project->id;
                        $tag->save();
                    }
                    if ('on' == $request->main_slider) {
                        $slider = new MainSlider();
                        $image = $request->project_slider;
                        $slider->image = $image->store('main_slider');
                        $slider->unit_id = $project->id;
                        $slider->type = $request->type;
                        $slider->save();
                    }

                    if ($request->has('gallery')) {
                        foreach ($request->gallery as $img) {
                            $gallery = new Gallery;
                            $gallery->image = $img->store('gallery');
                            $gallery->project_id = $project->id;
                            $gallery->save();
                        }
                    }
                    foreach ($request->facility as $facility) {
                        $this->addfacility($project->id, $facility, 'project');
                    }
                } else {
                    return back()->withInput()->withErrors('uploaded invalid logo');
                }

                $leads = Lead::where('refresh_token', '!=', '')->get();
                $tokens = Lead::where('refresh_token', '!=', '')->pluck('refresh_token')->toArray();
                $projectss = [];
                foreach ($leads as $lead) {
                    $notify = new LeadNotification;
                    $notify->type = 'projects';
                    $notify->type_id = $project->id;
                    $projectss[] = $project->id;
                    $notify->ar_title = __('admin.new_project', [], 'ar');
                    $notify->en_title = __('admin.new_project', [], 'en');
                    $notify->ar_body = $project->ar_name;
                    $notify->en_body = $project->en_name;
                    $notify->lead_id = $lead->id;
                    $notify->user_id = auth()->user()->id;
                    $notify->save();
                }
                $msg = [
                    'title' => __('admin.new_project', [], 'en'),
                    'body' => $project->en_name,
                    'image' => 'myIcon', /*Default Icon*/
                    'sound' => 'mySound' /*Default sound*/
                ];
                $data = [
                    'type' => 'project',
                    'id' => $projectss,
                ];
                notify($tokens, $msg, $data);

                return response()->json("Project Created Successfully!!");
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        if (checkRole('show_projects') or @auth()->user()->type == 'admin') {
            $location_id = $project->location_id;
            $full_location = "";
            while ('0' != $location_id) {
                $location = Location::where('id', $location_id)->select(app()->getLocale() . '_name as title', 'parent_id')->first();

                $location_id = $location->parent_id;
                $full_location .= $location->title . ' -';
            }
            $phases = Project::join('phases', 'phases.project_id', 'projects.id')
                ->where('projects.id', $project->id)
                ->select('phases.'.app()->getLocale() . '_name as name', 'phases.id')->get();
            $project->developerName = $project->developer->{app()->getLocale().'_name'};
            unset($project->developer);
            return response()->json([
                'location' => trim($full_location, '-'),
                'project' => $project,
                'phases' => $phases
            ]);
            // return view('admin.projects.show', ['title' => trans('admin.project'), 'location' => trim($full_location, '-'), 'project' => $project, 'phases' => $phases]);
        } else {
            return response()->json('Error : you dont have permission!!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        if (checkRole('edit_projects') or @auth()->user()->type == 'admin') {
            $location = Location::where('parent_id', '=', 0)->select(app()->getLocale() . '_name as title', 'id', 'lat', 'lng', 'zoom')->get();
            $facilities = DB::table('unit_facilities as unit')
            ->join('facilities as facility','unit.facility_id','=','facility.id')
            ->where([
                ['unit.type','=','project'],
                ['unit.unit_id','=',$project->id]
            ])
            ->select('facility.id','facility.'.app()->getLocale().'_name as name')->get();
            return response()->json([
                'location' => $location,
                'project' => $project,
                'facilities' => $facilities
            ]);
            // return view('admin.projects.edit', ['title' => trans('admin.project'), 'location' => $location, 'project' => $project, 'facilities' => $facilities]);
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $rules = [
            'en_name' => 'required|max:191',
            'ar_name' => 'required|max:191',
            'meter_price' => 'required|numeric',
            'area' => 'required|numeric',
            'area_to' => 'required|numeric',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'zoom' => 'required|numeric',
            'location' => 'required|numeric',
            'developer' => 'required|numeric',
            'tags' => 'required',
            'down_payment' => 'required|numeric',
            'installment_year' => 'required|numeric',
            'delivery_date' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'en_name' => trans('admin.en_name'),
            'ar_name' => trans('admin.ar_name'),
            'meter_price' => trans('admin.meter_price'),
            'area' => trans('admin.area'),
            'area_to' => trans('admin.area_to'),
            'lat' => trans('admin.lat'),
            'lng' => trans('admin.ang'),
            'zoom' => trans('admin.zoom'),
            'developer' => trans('admin.developer'),
            'location_id' => trans('admin.location'),
            'logo' => trans('admin.logo'),
            'tags' => trans('admin.tags'),
            'down_payment' => trans('admin.down_payment'),
            'installment_year' => trans('admin.installment_year'),
            'delivery_date' => trans('admin.delivery_date'),
        ]);
        $fa1 = UnitFacility::where('unit_id', $project->id)->where('type', 'project')->pluck('id');
        foreach (UnitFacility::where('unit_id', $project->id)->where('type', 'project')->get() as $f) {
            $f->delete();
        }
        if (null != $request->facility) {
            foreach ($request->facility as $facility) {
                $this->addfacility($project->id, $facility, 'project');
            }
        }

        if ($validator->fails()) {
            return response()->json("Validation Error");
        } else {
            $old_data = json_encode($project);
            if ($request->has('logo')) {
                $file_path = 'uploads/' . $project->logo;
                @unlink($file_path);
                $project->logo = uploads($request, 'logo');
            }

            if ($request->has('cover')) {
                $file_path = 'uploads/' . $project->cover;
                @unlink($file_path);
                $project->cover = uploads($request, 'cover');
            }

            if ($request->has('map_marker')) {
                $file_path = 'uploads/' . $project->map_marker;
                @unlink($file_path);
                $project->map_marker = uploads($request, 'map_marker');
            }

            if ($request->has('website_cover')) {
                $file_path = 'uploads/' . $project->website_cover;
                @unlink($file_path);
                $project->website_cover = uploads($request, 'website_cover');
            } elseif ($request->has('old_website_cover')) {
                $project->website_cover = $request->old_website_cover;
            }
            $project->en_name = $request->en_name;
            $project->ar_name = $request->ar_name;
            $project->en_description = $request->en_description;
            $project->ar_description = $request->ar_description;
            $project->meter_price = $request->meter_price;
            $project->delivery_date = $request->delivery_date;
            $project->area = $request->area;
            $project->area_to = $request->area_to;
            $project->video = $request->video;
            $project->lat = $request->lat;
            $project->lng = $request->lng;
            $project->zoom = $request->zoom;
            $project->featured = $request->featured;
            $project->facebook = $request->facebook;
            $project->vacation = $request->vacation;
            $project->down_payment = $request->down_payment;
            $project->installment_year = $request->installment_year;
            $project->type = $request->project_type;
            $project->developer_id = $request->developer;
            $project->show_website = $request->show_website;
            $project->location_id = $request->location;
            $project->meta_keywords = $request->meta_keywords;
            $project->meta_description = $request->meta_description;
            $project->mobile = $request->mobile;
            if ($request->hasFile('gallery')) {
                foreach ($request->gallery as $img) {
                    $gallery = new Gallery;
                    $gallery->image = upload($img, 'gallery');
                    $gallery->project_id = $project->id;
                    $gallery->save();
                }
            }

            if ($request->has('developer_pdf')) {
                $file_path = 'uploads/' . $project->developer_pdf;
                @unlink($file_path);
                $project->developer_pdf = uploads($request, 'developer_pdf');
            }

            if ($request->has('broker_pdf')) {
                $file_path = 'uploads/' . $project->broker_pdf;
                @unlink($file_path);
                $project->broker_pdf = uploads($request, 'broker_pdf');
            }

            if ('1' == $request->on_slider) {
                $project->on_slider = 1;
            } else {
                $project->on_slider = 0;
            }

            $project->mobile = $request->mobile;

            if ('1' == $request->on_slider) {
                $project->on_slider = 1;
            } else {
                $project->on_slider = 0;
            }

            if ('1' == $request->on_slider) {
                if ($request->has('project_slider')) {
                    $file_path = 'uploads/' . $project->website_slider;
                    @unlink($file_path);
                    $project->website_slider = uploads($request, 'project_slider');
                }
            }

            $project->save();

            $new_data = json_encode($project);
            LogController::add_log(
                __('admin.updated', [], 'ar') . ' ' . $project->ar_name,
                __('admin.updated', [], 'en') . ' ' . $project->en_name,
                'projects',
                $project->id,
                'update',
                auth()->user()->id,
                $old_data,
                $new_data
            );

            ProjectTag::where('project_id', $project->id)->delete();
            for ($i = 0; $i < count($request->tags); $i++) {
                $tag = new ProjectTag;
                $tag->tag_id = $request->tags[$i];
                $tag->project_id = $project->id;
                $tag->save();
            }

            return response()->json("Project Updated Successfully!!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if (checkRole('delete_projects') or @auth()->user()->type == 'admin') {
            $phases = Phase::where('project_id', $project->id)->get();
            if (null == $phases) {
                return response()->json("Error: Project doesnt have Phases");
            }

            foreach ($phases as $phase) {
                $properties = Property::where('phase_id', $phase->id)->get();
                foreach ($properties as $property) {
                    $images = Property_images::where('property_id', $property->id)->get();
                    $layout = LayoutImage::where('property_id', $property->id)->get();
                    foreach ($images as $image) {
                        @unlink('uploads/' . $image->images);
                    }
                    Property_images::where('property_id', $property->id)->delete();
                    foreach ($layout as $image) {
                        @unlink('uploads/' . $image->image);
                        $image->delete();
                    }
                    $property->delete();
                }
                $phase->delete();
                Favorite::where('unit_id', $project->id)->where('type', 'project')->delete();
                RecentViewed::where('unit_id', $project->id)->where('type', 'project')->delete();
                UnitFacility::where('unit_id', $project->id)->where('type', 'project')->delete();
            }
            $images = Gimages::where('project_id', '=', $project->id)->get();
            foreach ($images as $image) {
                @unlink('uploads/' . $image->image);
                $image->delete();
            }
            ProjectTag::where('project_id', $project->id)->delete();

            $old_data = json_encode($project);
            LogController::add_log(
                __('admin.deleted', [], 'ar') . ' ' . $project->ar_name,
                __('admin.deleted', [], 'en') . ' ' . $project->en_name,
                'projects',
                $project->id,
                'delete',
                auth()->user()->id,
                $old_data
            );

            $project->delete();
            return response()->json("Project Deleted Successfully!!");
        } else {
            return response()->json("Error: you dont have permission!!");            
        }
    }

    public function project_featured($id)
    {
        $p = Project::find($id);
        $p->featured = 1;
        $p->save();
        return back();
    }

    public function project_un_featured($id)
    {
        $p = Project::find($id);
        $p->featured = 0;
        $p->save();
        return back();
    }

    public function website_show($lang, $id)
    {
        $array = explode('-', $id);
        $id = end($array);
        $project = Project::find($id);
        $resale = DB::table("resale_units as resale")
        ->leftjoin("projects as project","resale.project_id","=","project.id")
        ->leftjoin("developers as developer","project.developer_id","=","developer.id")
        ->where("project.id",$id)
        ->select("project.id as id","project.cover","project.meter_price","project.area","project.installment_year","project.delivery_date","project.down_payment","project.en_name","project.ar_name","project.created_at","location_id","project.website_cover","project.logo")
        ->groupBy("project.id")
        ->get();
        $home = new HomeController();
        $search = $home->search_info();
        $project_feat = new ProjectController;
        $featured = $project_feat->featured_project();
        $tags = DB::table('project_tags')->selectRaw('project_id,count(*) as count')->groupBy('project_id')->orderBy('count', 'DESC')->limit(5)->where('project_id', '!=', $id)->get();
        $share = url('project/' . $project->id);
        $keyword = $project->meta_keywords;
        $description = $project->description;
        return view('website.project', ['project' => $project, 'resale' => $resale , 'keyword' => $keyword, 'description' => $description, 'tags' => $tags, 'search' => $search, 'title' => $project->{app()->getLocale() . '_name'}, 'featured' => $featured, 'share_description' => $project->meta_description]);
    }

    public function addfacility($unit_id, $facility_id, $type)
    {
        $facility = new UnitFacility();
        $facility->unit_id = $unit_id;
        $facility->facility_id = $facility_id;
        $facility->type = $type;
        $facility->save();
    }

    public function featured_project()
    {
        $featured = Project::where('featured', 1)->orderby('priority')->limit(3)->get();
        return $featured;
    }

    public function get_developer_projects(Request $request)
    {
        $projects = new Project();
        if ($request->min_price) {
            //            dump('1');
            $projects = $projects->where('meter_price', '>=', $request->min_price);
        }
        if ($request->max_price) {
            //            dump('2');
            $projects = $projects->where('meter_price', '<=', $request->max_price);
        }

        if ($request->max_area) {
            //            dump('3');
            $projects = $projects->where('area_to', '<=', $request->max_area);
        }
        if ($request->min_area) {
            //            dump('4');
            $projects = $projects->where('area', '>=', $request->min_area);
        }
        if ($request->max_down_payment) {
            //            dump('5');
            $projects = $projects->where('down_payment', '<=', $request->max_down_payment);
        }
        if ($request->min_down_payment) {
            //            dump('6');
            $projects = $projects->where('down_payment', '>=', $request->min_down_payment);
        }
        if ($request->installment) {
            //            dump('7');
            $projects = $projects->where('installment_year', $request->installment);
        }
        if ('all' != $request->dev && $request->dev) {
            //            dump('8');
            $projects = $projects->where('developer_id', $request->dev);
        }
        if ('all' != $request->location && $request->location) {
            //            dump('9');
            $projects = $projects->where('location_id', $request->location);
        }
        $projects = $projects->get();
        return view('admin.projects.get_projects', ['projects' => $projects]);
    }

    public function sort_project()
    {
        $featured_projects = Project::where('show_website', 1)->orderby('featured_priority')->get();
        $mobile_projects = Project::where('mobile', 1)->orderby('mobile_priority')->get();
        return response()->json([
            'web_projects' => $featured_projects,
            'mobile_projects' => $mobile_projects,
        ],200);
        // return view('admin.sort_project', compact('featured_projects', 'mobile_projects'));
    }

    public function save_sorted(Request $request)
    {
        // dd($request->new_mobile_data);
        // dd(json_decode($request->social_url,true));
        $i = 0;
        foreach ($request->new_data as $key => $value) {
            $project = json_decode($value);
            $i++;
            $current = Project::find($project->id);
            $current->featured_priority = $i;
            // return $current->id.'=>'.$current->en_name.'=>'. $i;
            $current->update();
        }
        
        foreach ($request->new_mobile_data as $key => $value) {
            $project = json_decode($value);
            $i++;
            $current = Project::find($project->id);
            $current->mobile_priority = $i;
            // return $current->id.'=>'.$current->en_name.'=>'. $i;
            $current->update();
        }

        return response()->json([
            'data' => 'success sort'
        ],200);
    }

    // public function save_sorted_mob(Request $request)
    // {
    //     $i = 0;
    //     foreach ($request->projects as $project) {
    //         $i++;
    //         $current = Project::find($project);
    //         $current->mobile_priority = $i;
    //         $current->save();
    //     }
    // }

    public function change_markers()
    {
        // dd("any");
        $projects = Project::all();
        foreach ($projects as $project) {
            if (file_exists('uploads/' . $project->logo)) {
                $logo = Image::make('uploads/' . @$project->logo)->resize(34, 34);
                $marker = Image::make('uploads/marker.png');
                $marker->insert($logo, 'margin-top', 8, 10);
                $marker->save('uploads/marker/' . $project->id . '.png');
                $project->map_marker = 'marker/' . $project->id . '.png';
                $project->save();
            }
        }
        return redirect(adminPath() . '/projects');
    }

    public function image_post(Request $request)
    {
        Gallery::find($request->id)->delete();
        return ['status' => 'ok'];
    }

    public function get_notification()
    {
        return view('admin.notification.get_note', ['title' => 'Notification']);
    }

    public function getProjectsInfoWithPaginate(Request $request)
    {
        $projects = DB::table('projects as project')
            ->leftjoin('developers as developer', 'project.developer_id', '=', 'developer.id')
            ->leftjoin('locations as location','project.location_id','=','location.id')
            ->select(
                'project.id',
                'project.en_name',
                'project.ar_name',
                'project.logo',
                'project.cover',
                'project.delivery_date',
                'project.installment_year',
                'developer.logo as dev_logo',
                'location.en_name as locationName'
            )
            ->paginate(10);
        foreach ($projects as $project) {
            $project->phases = DB::table('phases')->where('project_id', $project->id)->count();
        }
        $installment_years = DB::table('projects')->groupBy('installment_year')->pluck('installment_year')->toArray();
        return response()->json([
            'projects' => $projects,
            'installment_years' => $installment_years
        ]);
    }

    public function getProjectPhotos($id){
        return DB::table('galleries')->where('project_id',$id)->select('id','image')->get();
    }
    public function getProjectsHasBanners()
    {
        $projects = Project::where('on_slider',1)->select('id','en_name','ar_name','on_slider','website_slider')->get();
        $projects->count();
        // dd($projects);
        if($projects){
            return response()->json(
                   $projects
            ,200);
        }else{
            return response()->json(
                    'No one have a banner'
            ,404);
        }
    }

    public function getprojectsfeature()
    {
        $projects = Project::where('featured',1)->select('id','en_name','ar_name','featured')->get();
        $projects->count();
        // dd($projects);
        if($projects){
            return response()->json(
                   $projects
            ,200);
        }else{
            return response()->json(
                    'No one have a banner'
            ,404);
        }
    }

    public function removeBannerByID($id)
	{
		$project = Project::find($id);
		$project->on_slider = 0;
		$project->update();
		return response()->json('Removed',200);
	}
    public function removefeatureByID($id)
	{
		$project = Project::find($id);
		$project->featured = 0;
		$project->update();
		return response()->json('Removed',200);
    }
    
    public function filterProjects(Request $request)
    {
        $projects = DB::table('projects as project')
            ->leftjoin('developers as developer', 'project.developer_id', '=', 'developer.id');
        if ($request->developer_id && $request->developer_id != null) {
            $projects = $projects->where('developer.id', '=', $request->developer_id);
        }
        if ($request->min_price && $request->min_price != null) {
            $projects = $projects->where('meter_price','>=',$request->min_price);
        }
        if ($request->max_price && $request->max_price != null) {
            $projects = $projects->where('meter_price','<=',$request->max_price);
        }
        if ($request->min_area && $request->min_area != null) {
            $projects = $projects->where('area','>=',$request->min_area);
        }
        if ($request->max_area && $request->max_area != null) {
            $projects = $projects->where('area_to','<=',$request->max_area);
        }
        if ($request->min_down_payment && $request->min_down_payment != null) {
            $projects = $projects->where('down_payment','>=',$request->min_down_payment);
        }
        if ($request->max_down_payment && $request->max_down_payment != null) {
            $projects = $projects->where('down_payment','<=',$request->max_down_payment);
        }
        if ($request->installment_years && $request->installment_years != null) {
            $projects = $projects->where('installment_year','=',$request->installment_years);
        }
        if ($request->location && $request->location != null) {
            $projects = $projects->where('location_id','=',$request->location);
        }
        
        $projects = $projects->select(
                'project.id',
                'project.en_name',
                'project.ar_name',
                'project.logo',
                'project.cover',
                'project.delivery_date',
                'project.installment_year',
                'developer.logo as dev_logo'
            )
            ->paginate(10);
        foreach ($projects as $project) {
            $project->phases = DB::table('phases')->where('project_id', $project->id)->count();
        }
        return $projects;
    }

    public function getAllProjects(){
        return DB::table('projects')->select('id',app()->getLocale().'_name as name')->get();
    }
    
}
