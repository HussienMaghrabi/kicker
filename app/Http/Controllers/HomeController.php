<?php

namespace App\Http\Controllers;

ini_set('memory_limit', '-1');

use App\AdminNotification;
use App\ClosedDeal;
use App\Contract;
use App\DealAgents;
use App\Event;
use App\Favorite;
use App\Form;
use App\Group;
use App\HubPhone;
use App\HubSocial;
use App\Income;
use App\Collection;
use App\Lead;
use App\LeadDocument;
use App\LeadSource;
use App\Location;
use App\Outcome;
use App\OutSubCat;
use App\Player;
use App\ProdcastEvent;
use App\ProdeventStatus;
use App\Project;
use App\Property;
use App\Proposal;
use App\RentalUnit;
use App\Request as Model;
use App\ResaleUnit;
use App\Role;
use App\Setting;
use App\UnitType;
use App\User;
use App\Employee;
use Auth;
use Carbon\Carbon;
use Config;
use Excel;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Facades\DB;
use Redirect;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Facility;


//use Intervention\Image\Facades\Image;

class HomeController extends Controller {
    private static $allLocation = [];
    private static $allTeam = [];
    
    public function login_post(Request $request) {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames([
            'email' => trans('admin.email'),
            'password' => trans('admin.password'),
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            if (auth()->attempt(
                            [
                        'email' => $request->input('email'),
                        'password' => $request->input('password')
                            ], $request->input('remember')
                    )) {
                if (@\App\AgentToken::where('user_id', auth()->user()->id)->first() == null) {
                    $agentToken = new \App\AgentToken();
                    $agentToken->token = md5(uniqid(auth()->user()->email, true));
                    $agentToken->user_id = auth()->user()->id;
                    $agentToken->login = 1;
                    $agentToken->save();
                }
                LogController::add_log(
                        __('admin.logged_in', [], 'ar'), __('admin.logged_in', [], 'en'), 'logged_in', 1, 'log', auth()->user()->id
                );

                if (auth()->user()->type == 'employee' || auth()->user()->type == 'admin') {
                    auth()->user()->last_seen_dash = strtotime(date('d-m-y H:i:s'));
                }

                auth()->user()->save();
                $passw = $request->input('password');
                $use_id = auth()->user()->id;
                $user = user::where('email',$request->input('email'))->first();
                $employee = employee::where('personal_mail',$user->email)->first();
                if(empty($employee)){
                    $emp = new employee;
                    $emp->user_id = $user->id;
                    $emp->en_first_name = $user->name;
                    $emp->en_last_name = $user->name;
                    $emp->marital_status = 'single';
                    $emp->gender = 'mail';
                    $emp->phone = $user->phone;
                    $emp->personal_mail = $user->email;
                    $emp->save();
                }
                // return redirect(adminPath() . '/')->with(['passw' => $passw, 'use_id' => $use_id]);
                return redirect(adminPath() . '/vue/dashboard')->with(['passw' => $passw, 'use_id' => $use_id]);
            } else {
                session()->flash('login_error', trans('admin.fails_login'));
                return back();
            }
        }
    }

    public function login() {
        if(auth()->user()){
            return redirect(adminPath());
        }else{
            $title = Setting::first()->title;
            return view('admin.login', ['title' => $title]);
        }
    }

    public function logout(Request $request) {
        Player::where('player_id', $request->player_id)->update(['status' => 0]);
        LogController::add_log(
                __('admin.logged_out', [], 'ar'), __('admin.logged_out', [], 'en'), 'logged_out', 0, 'log', auth()->user()->id
        );
        auth()->logout();
        return redirect(adminPath() . '/login');
    }

    public function lang($lang) {
        session()->put('lang', $lang);
        return back();
    }

    public function inventory() {
        $resale = ResaleUnit::where('availability', 'available')->get();
        $newHomes = Property::all();
        $rental = RentalUnit::where('availability', 'available')->get();

        return view('admin.inventory', [
            'title' => trans('admin.inventory'),
            'resale' => $resale,
            'newHomes' => $newHomes,
            'rental' => $rental
        ]);
    }

    public static function getLocations($id) {
        $locations = Location::where('parent_id', $id)->get();
        foreach ($locations as $location) {
            array_push(self::$allLocation, $location->id);
            self::getLocations($location->id);
        }
    }

    public static function getChildren($id) {
        self::getLocations($id);
        return self::$allLocation;
    }

    public function all_finances() {
        // $incomes = Income::all();
        // $outcomes = Outcome::all();
        
        $incomes = DB::table('incomes as income')
                   ->leftjoin('banks','income.bank_id','=','banks.id')
                   ->select('banks.name as bankName','income.id','income.name','income.description','income.payment_method'
                   ,'income.value','income.date','income.source','income.status')
                   ->get();

        $outcomes = DB::table('outcomes as outcome')
                    ->leftjoin('banks','outcome.bank_id','=','banks.id')
                    ->select('banks.name as bankName','outcome.id','outcome.name','outcome.description','outcome.payment_method'
                    ,'outcome.value','outcome.date','outcome.status')
                    ->get();

        // $bank = DB::table('incomes as income')
        //        ->join('banks','income.bank_id','=','banks.id')
        //        ->select('banks.name as bankName')
        //        ->get();

        // return view('admin.finances.index', ['title' => trans('admin.finances'), 'incomes' => $incomes, 'outcomes' => $outcomes]);
        return response()->json([
            "income"=>$incomes,
            "outcome"=>$outcomes,
        ]);
    }

    public function all_Collections() {
        $collections = DB::table('incomes as income')
                       ->select('income.id','income.name','income.description','income.value','income.date','income.status')
                       ->get();
                       
        return response()->json([
            "collections"=>$collections,
        ]);
    }

    public function all_Collected() {
        $collected = DB::table('incomes as income')
                       ->where('status','collected')
                       ->select('income.id','income.name','income.description','income.value','income.date','income.status')
                       ->get();
                       
        return response()->json([
            "collected"=>$collected,
        ]);
    }

    public function all_Dues_Paid() {
        $paid = DB::table('outcomes as outcome')
        ->where('status','paid')
        ->select('outcome.id','outcome.name','outcome.description','outcome.value','outcome.date','outcome.status')
        ->get();

        return response()->json([
            "paid"=>$paid,
        ]);
    }

    public function all_Dues() {
        $dues = DB::table('outcomes as outcome')
                ->select('outcome.id','outcome.name','outcome.description','outcome.value','outcome.date','outcome.status')
                ->get();

        return response()->json([
            "dues"=>$dues,
        ]);
    }

    

    public function favorite(Request $request) {
        $id = $request->unit_id;
        $type = $request->type;
        $lead = $request->lead;
        $var = Favorite::where('type', $type)
                ->where('unit_id', $id)
                ->where('lead_id', $lead)
                ->count();
        if ($var > 0) {
            $response = 'delete';
            $delete = Favorite::where('unit_id', $id)
                    ->where('type', $type)
                    ->where('lead_id', $lead)
                    ->first();
            $delete->delete();
        } else {
            $response = 'add';
            $fav = new Favorite;
            $fav->unit_id = $id;
            $fav->type = $type;
            $fav->lead_id = $lead;
            $fav->save();
        }
        return response()->json([
                    'status' => 'true',
                    'response' => $response,
        ]);
    }

    public function unfavorite($type, $id, $lead) {
        $fav = Favorite::where('unit_id', $id)->where('lead_id', $lead)->where('type', $type)->first();
        $fav->delete();
        return back();
    }

    public function settings_menu() {
        //return view('admin.new_admin_layout.Setting');
        return view('admin.settings_menu', ['title' => __('admin.settings')]);
    }

    public function search_info() {
        $project_min_price = Project::min('meter_price');
        $resale_min_price = ResaleUnit::min('price');
        $rental_min_price = RentalUnit::min('rent');
        $project_max_price = Project::max('meter_price');
        $resale_max_price = ResaleUnit::max('price');
        $rental_max_price = RentalUnit::max('rent');
        $rental_personal_max_price = RentalUnit::where('type', 'personal')->max('rent');
        $rental_personal_min_price = RentalUnit::where('type', 'personal')->min('rent');
        $rental_personal_max_area = RentalUnit::where('type', 'personal')->max('area');
        $rental_personal_min_area = RentalUnit::where('type', 'personal')->min('area');
        $rental_commercial_max_price = RentalUnit::where('type', 'commercial')->max('rent');
        $rental_commercial_min_price = RentalUnit::where('type', 'commercial')->min('rent');
        $rental_commercial_max_area = RentalUnit::where('type', 'commercial')->max('area');
        $rental_commercial_min_area = RentalUnit::where('type', 'commercial')->min('area');
        $resale_personal_max_price = ResaleUnit::where('type', 'personal')->max('price');
        $resale_personal_min_price = ResaleUnit::where('type', 'personal')->min('price');
        $resale_personal_max_area = ResaleUnit::where('type', 'personal')->max('area');
        $resale_personal_min_area = ResaleUnit::where('type', 'personal')->min('area');
        $resale_commercial_max_price = ResaleUnit::where('type', 'commercial')->max('price');
        $resale_commercial_min_price = ResaleUnit::where('type', 'commercial')->min('price');
        $resale_commercial_max_area = ResaleUnit::where('type', 'commercial')->max('area');
        $resale_commercial_min_area = ResaleUnit::where('type', 'commercial')->min('area');
        $project_personal_max_price = Project::where('type', 'personal')->max('meter_price');
        $project_personal_min_price = Project::where('type', 'personal')->min('meter_price');
        $project_personal_max_area = Project::where('type', 'personal')->max('area');
        $project_personal_min_area = Project::where('type', 'personal')->min('area');
        $project_commercial_max_price = Project::where('type', 'commercial')->max('meter_price');
        $project_commercial_min_price = Project::where('type', 'commercial')->min('meter_price');
        $project_commercial_max_area = Project::where('type', 'commercial')->max('area');
        $project_commercial_min_area = Project::where('type', 'commercial')->min('area');

        $project_min_area = Project::min('area');
        $resale_min_area = ResaleUnit::min('area');
        $rental_min_area = RentalUnit::min('area');
        $project_max_area = Project::max('area');
        $resale_max_area = ResaleUnit::max('area');
        $rental_max_area = RentalUnit::max('area');

        $location = Location::all();
        $facilities = Facility::get();
        if (app()->getLocale() == 'en') {
            $unit_type = UnitType::select('id', 'en_name as name')->get()->toArray();
            $facilities = Facility::select('id', 'en_name as name')->get()->toArray();
            $location = Location::select('id', 'en_name as name')->get()->toArray();
        }
        if (app()->getLocale() == 'ar') {
            $unit_type = UnitType::select('id', 'en_name as name')->get()->toArray();
            $facilities = Facility::select('id', 'ar_name as name')->get()->toArray();
            $location = Location::select('id', 'ar_name as name')->get()->toArray();
        }
        $search['region'] = $location;
        $search['unit_type'] = $unit_type;
        $search['facilities'] = $facilities;
        $search['data'] = [
            'project_min_price' => $project_min_price, 'resale_min_price' => $resale_min_price,
            'rental_min_price' => $rental_min_price, 'project_max_price' => $project_max_price,
            'resale_max_price' => $resale_max_price, 'rental_max_price' => $rental_max_price, 'project_min_area' => $project_min_area,
            'resale_min_area' => $resale_min_area, 'rental_min_area' => $rental_min_area, 'project_max_area' => $project_max_area,
            'resale_max_area' => $resale_max_area, 'rental_max_area' => $rental_max_area,
            'rental_personal_max_price' => $rental_personal_max_price,
            'rental_personal_min_price' => $rental_personal_min_price,
            'rental_personal_min_area' => $rental_personal_min_area,
            'rental_personal_max_area' => $rental_personal_max_area,
            'rental_commercial_max_price' => $rental_commercial_max_price,
            'rental_commercial_min_price' => $rental_commercial_min_price,
            'rental_commercial_min_area' => $rental_commercial_min_area,
            'rental_commercial_max_area' => $rental_commercial_max_area,
            'resale_personal_max_price' => $resale_personal_max_price,
            'resale_personal_min_price' => $resale_personal_min_price,
            'resale_personal_min_area' => $resale_personal_min_area,
            'resale_personal_max_area' => $resale_personal_max_area,
            'resale_commercial_max_price' => $resale_commercial_max_price,
            'resale_commercial_min_price' => $resale_commercial_min_price,
            'resale_commercial_min_area' => $resale_commercial_min_area,
            'resale_commercial_max_area' => $resale_commercial_max_area,
            'project_personal_max_price' => $project_personal_max_price,
            'project_personal_min_price' => $project_personal_min_price,
            'project_personal_min_area' => $project_personal_min_area,
            'project_personal_max_area' => $project_personal_max_area,
            'project_commercial_max_price' => $project_commercial_max_price,
            'project_commercial_min_price' => $project_commercial_min_price,
            'project_commercial_min_area' => $project_commercial_min_area,
            'project_commercial_max_area' => $project_commercial_max_area,
        ];
        return $search;
    }

    public function tempHome() {
        return view('tempHome');
    }

    public function home() {
        // dd(session()->get('lang'));
        return redirect('/admin');
        // if (\App\Setting::first()->maintenance) {
        //     return Redirect::to('temp-Home')->send();
        // }
        // $search = $this->search_info();
        // $events = Event::orderBy('id', 'desc')->get();
        // $resale = DB::table('resale_units as unit')
        //                     ->where('unit.type', 'personal')
        //                     ->join('projects as project','unit.project_id','=','project.id')
        //                     ->select('unit.*','project.en_name as project_en_name','project.ar_name as project_ar_name')
        //                     ->paginate(6);
        // $resaleCount = DB::table('resale_units')
        //                     ->where('type', 'personal')
        //                     ->count();
        // return view('website.home', compact('search', 'events', 'resale','resaleCount'));
    }

    public function search(Request $request) {
        $location_id = $request->location;
        if (null == $location_id) {
            $location_id = 0;
        }
        $lead_id = 1;
        $min_price = (double) $request->min_price;
        $max_price = (double) $request->max_price;
        $min_area = (double) $request->min_area;
        $max_area = (double) $request->max_area;
        $locations = HomeController::getChildren($location_id);
        array_push($locations, (int) $location_id);
        $request->facility;
        $lang = app()->getLocale();
        $type = $request->type;
        $facilities = $request->facility;
        $data = [];
        if (null != $request->unit_type) {
            $unit_types = $request->unit_type;
        } else {
            $unit_types = UnitType::select('id')->get()->toArray();
        }
        if ('project' == $type) {
            $properties = Project::leftJoin('locations', 'locations.id', '=', 'projects.location_id')->whereIn('projects.location_id', $locations)->where(function ($query) use ($min_price, $max_price) {
                        $query->where('projects.meter_price', '>=', $min_price)->where('projects.meter_price', '<=', $max_price);
                    })->where(function ($query) use ($min_area, $max_area) {
                        $query->where('projects.area', '>=', $min_area)->where('projects.area', '<=', $max_area);
                    })->where(function ($query) use ($request) {
                        $query->where('projects.en_name', 'like', '%' . $request->keyword . '%')->orwhere('projects.ar_name', 'like', '%' . $request->keyword . '%');
                    })->where('projects.show_website', 1)->select('projects.id as id')->get();

            $ids = [];
            foreach ($properties as $row) {
                array_push($ids, $row->id);
            }

            $ids = array_unique($ids);
            if (null == $facilities) {
                $projects = Project::whereIn('id', $ids)->get();
            } else {
                $ids2 = [];
                $items = Project::leftJoin('unit_facilities', 'unit_facilities.unit_id', 'projects.id')->where('unit_facilities.type', 'project')->whereIn('unit_facilities.facility_id', $facilities)->select('projects.id as id')->get();
                foreach ($items as $item) {
                    array_push($ids2, $item->id);
                }

                $ids3 = array_unique($ids2);

                $projects = Project::whereIn('id', $ids3)->whereIn('id', $ids)->get();
            }
            foreach ($projects as $row) {
                $favorite = 'false';
                $num = Favorite::where('unit_id', '=', $row->id)->where('lead_id', '=', $lead_id)->where('type', '=', 'project')->count();
                if ($num > 0) {
                    $favorite = 'true';
                }

                $location = Location::find($row->location_id)->{$lang . '_name'};
                $location = Location::find($row->location_id)->{$lang . '_name'};
                array_push($data, [
                    "id" => $row->id, "title" => $row->{$lang . '_name'}, 'price' => $row->meter_price,
                    'home_image' => $row->logo, 'image' => $row->cover, 'payment' => $row->down_payment,
                    'lat' => $row->lat, 'lng' => $row->lng, 'zoom' => $row->zoom,
                    'installment_year' => $row->installment_year,
                    'location' => $location, 'favorite' => $favorite, 'area' => $row->area,
                    'description' => $row->{$lang . '_description'},
                    'marker' => $row->map_marker, 'cover' => $row->cover
                ]);
            }

            $type1 = 'project';
        } else if ('resale' == $type) {
            $resales = ResaleUnit::leftJoin('locations', 'locations.id', '=', 'resale_units.location')->whereIn('resale_units.unit_type_id', $unit_types)->where(function ($query) use ($locations, $location_id) {
                        $query->whereIn('resale_units.location', $locations)->orwhere('resale_units.location', $location_id);
                    })->where(function ($query) use ($min_price, $max_price) {
                        $query->where('resale_units.price', '>=', $min_price)->where('resale_units.price', '<=', $max_price);
                    })->where(function ($query) use ($min_area, $max_area) {
                        $query->where('resale_units.area', '>=', $min_area)->where('resale_units.area', '<=', $max_area);
                    })->where(function ($query) use ($request) {
                        $query->where('resale_units.en_title', 'like', '%' . $request->keyword . '%')->orwhere('resale_units.ar_title', 'like', '%' . $request->keyword . '%');
                    })->where('resale_units.availability', 'available')->select(
                            'resale_units.id as id', 'resale_units.en_title as en_name', 'resale_units.ar_title as ar_name', 'resale_units.price as price', 'resale_units.area as area', 'locations.en_name as location_en_name', 'locations.ar_name as location_ar_name', 'resale_units.unit_type_id as unit_type', 'resale_units.area as area', 'resale_units.rooms as rooms', 'resale_units.bathrooms as bathrooms', 'resale_units.image as image', 'resale_units.other_images as other_images', 'resale_units.lat', 'resale_units.lng', 'resale_units.zoom', 'resale_units.en_description', 'resale_units.ar_description'
                    )
                    ->get();
            foreach ($resales as $resale) {
                $favorite = 'false';
                $num = Favorite::where('unit_id', '=', $resale->id)->where('lead_id', '=', $lead_id)->where('type', '=', 'resale')->count();
                if ($num > 0) {
                    $favorite = 'true';
                }

                array_push($data, [
                    'id' => $resale->id, 'location' => $resale->{'location_' . $lang . '_name'},
                    'home_image' => $resale->image, 'other_images' => json_decode($resale->other_images),
                    'title' => $resale->{$lang . '_name'}, 'price' => $resale->price, 'area' => $resale->area,
                    'rooms' => $resale->rooms, 'bathrooms' => $resale->bathrooms, 'favorite' => $favorite,
                    'lat' => $resale->lat, 'lng' => $resale->lng, 'zoom' => $resale->zoom,
                    'description' => $resale->{$lang . '_description'},
                ]);
            }
            $type1 = "resale";
        } else if ('rental' == $type) {
            $rentals = RentalUnit::leftJoin('locations', 'locations.id', '=', 'rental_units.location')->whereIn('rental_units.unit_type_id', $unit_types)->where(function ($query) use ($locations, $location_id) {
                        $query->whereIn('rental_units.location', $locations)->orwhere('rental_units.location', $location_id);
                    })->where(function ($query) use ($min_price, $max_price) {
                        $query->where('rental_units.rent', '>=', $min_price)->where('rental_units.rent', '<=', $max_price);
                    })->where(function ($query) use ($min_area, $max_area) {
                        $query->where('rental_units.area', '>=', $min_area)->where('rental_units.area', '<=', $max_area);
                    })->where(function ($query) use ($request) {
                        $query->where('rental_units.en_title', 'like', '%' . $request->keyword . '%')->orwhere('rental_units.ar_title', 'like', '%' . $request->keyword . '%');
                    })->where('rental_units.availability', 'available')->select(
                            'rental_units.id as id', 'rental_units.en_title as en_name', 'rental_units.ar_title as ar_name', 'rental_units.rent as price', 'rental_units.area as area', 'locations.en_name as location_en_name', 'locations.ar_name as location_ar_name', 'rental_units.unit_type_id as unit_type', 'rental_units.area as area', 'rental_units.rooms as rooms', 'rental_units.bathrooms as bathrooms', 'rental_units.image as image', 'rental_units.other_images as other_images', 'rental_units.lat', 'rental_units.lng', 'rental_units.zoom', 'rental_units.en_description', 'rental_units.ar_description'
                    )
                    ->get();
            foreach ($rentals as $rental) {
                $favorite = 'false';
                $num = Favorite::where('unit_id', '=', $rental->id)->where('lead_id', '=', $lead_id)->where('type', '=', 'resale')->count();
                if ($num > 0) {
                    $favorite = 'true';
                }

                array_push($data, [
                    'id' => $rental->id, 'location' => $rental->{'location_' . $lang . '_name'},
                    'home_image' => $rental->image, 'other_images' => json_decode($rental->other_images),
                    'title' => $rental->{$lang . '_name'}, 'price' => $rental->price, 'area' => $rental->area,
                    'rooms' => $rental->rooms, 'bathrooms' => $rental->bathrooms, 'favorite' => $favorite,
                    'lat' => $rental->lat, 'lng' => $rental->lng, 'zoom' => $rental->zoom,
                    'description' => $rental->{$lang . '_description'},
                ]);
            }
            $type1 = "rental";
        }
        $search = $this->search_info();
        return view('website.search_result', compact('data', 'type1', 'search'));
    }

    public function sitemap() {
        // dd('any');
        $base_url = url('/');
        $beginning = '<?xml version="1.0" encoding="UTF-8"?>

<urlset xmlns="' . $base_url . '">';

        $events = '';

        foreach (Event::all() as $event) {
            $events .= '
   <url>

      <loc>' . $base_url . '/en/events/' . $event->id . '/' . str_slug($event->{app()->getLocale() . '_title'}) . '</loc>

      <lastmod>' . date('Y-m-d') . '</lastmod>

   </url>
';
        }

        $resales = '';

        foreach (ResaleUnit::all() as $resale) {
            $resales .= '
   <url>

      <loc>' . $base_url . '/en/resale/' . $resale->id . '/' . str_slug($resale->{app()->getLocale() . '_title'}) . '</loc>

      <lastmod>' . date('Y-m-d') . '</lastmod>

   </url>
';
        }

        $rentals = '';

        foreach (RentalUnit::all() as $rental) {
            $rentals .= '
   <url>

      <loc>' . $base_url . '/en/rental/' . $rental->id . '/' . str_slug($rental->{app()->getLocale() . '_title'}) . '</loc>

      <lastmod>' . date('Y-m-d') . '</lastmod>

   </url>
';
        }

        $new_homes = '';

        foreach (Property::all() as $new_home) {
            $new_homes .= '
   <url>

      <loc>' . $base_url . '/en/new_home/' . $new_home->id . '/' . str_slug($new_home->{app()->getLocale() . '_name'}) . '</loc>

      <lastmod>' . date('Y-m-d') . '</lastmod>

   </url>
';
        }

        $projects = '';

        foreach (Project::all() as $project) {
            $projects .= '
   <url>

      <loc>' . $base_url . '/en/projects/' . $project->id . '/' . str_slug($project->{app()->getLocale() . '_name'}) . '</loc>

      <lastmod>' . date('Y-m-d') . '</lastmod>

   </url>
';
        }

        $middle = $events . $resales . $rentals . $new_homes . $projects;

        $ending = '</urlset>';
        $txt = $beginning . $middle . $ending;
        $path = public_path('sitemap.xml');
        $newpath = $_SERVER['HTTP_HOST'].'/sitemap.xml';
        $file = fopen($path, 'wb');
        $is_written = fwrite($file, $txt);
        fclose($file);
        if ($is_written > 0) {
            $set = Setting::find(1);
            $set->refresh_sitemap = strtotime(date('Y-m-d'));
            $set->save();
            return response()->json([
                'status' => true,
                'sitemap' => $newpath,
                'date' => date('Y-m-d'),
            ]);
        } else {
            return response()->json([
                        'status' => false,
            ]);
        }
    }
    public function dashboard(Request $request) {
        // DB::enableQueryLog();
        return view('admin.dashboardd');
        $salesM = $salesD = $leadsD = $leads = $deals = $arr1 = $max = $projects = $sources = $projectSumLeads = $inventory = $callStatus = $groups = $leadTeamCount = $event_note = null;

        $arr = [];

        if ($request->startDate && $request->endDate) {

        } else {
            $request->startDate = date('Y-m-d', strtotime('01/01'));
            $request->endDate = date('Y-m-d', strtotime('12/31'));
        }
        $orderDesk = @\App\UserEdit::where('user_id', auth()->user()->id)->where('type', 'deskEdit')->first()->data;
        $event = ProdcastEvent::count();
        $event_note = null;
        $check_user = ProdeventStatus::select('prot_event_id')->where('user_id', Auth()->User()->id)->get();
        $callArray = array();
        $mettingArray = array();
        $proMeetingCall = array();
        if (auth()->user()->type == 'admin') {
            $today = Carbon::now();

            foreach ($check_user as $key => $value_check) {
                for($i=0;$i<$event;$i++){
                    $event_note = ProdcastEvent::select('title_event_en','description_event_en')->whereDate('date_event', '>=', Carbon::now()->toDateString())->where('id', $value_check->prot_event_id)->get();
                }
            }

            $month = date('Y-m');
            $day = date('Y-m-d');
            $salesM = ClosedDeal::where('created_at', '>=', $month . '-01 00:00:00')->sum('price');
            $salesD = ClosedDeal::where('created_at', '>=', $day . ' 00:00:00')->sum('price');
            $leadsD = Lead::where('created_at', '>=', $day . ' 00:00:00')->count();
            // dd( $request->user_id);
            $todayLeads = Lead::whereDate('created_at', Carbon::today())->where('agent_id', auth()->user()->id)->count();
            $seen = Lead::where("seen", 1)->where('agent_id', auth()->user()->id)->count();
            $notSeen = Lead::where("seen", 0)->where('agent_id', auth()->user()->id)->count();
            // dd(DB::getQuerylog());
            $leads = Lead::count();
            $deals = Proposal::where('status', 'pending')->sum('price');
            $deals = number_format($deals);
            $agents = User::select('id')->where('type', '!=', 'employee')->get();
            $agentData = [];
            $salesM = number_format($salesM);
            $salesD = number_format($salesD);
            foreach ($agents as $agent) {
                $main = ClosedDeal::where('agent_id', $agent->id)->sum('agent_commission');
                $sub = DealAgents::where('agent_id', $agent->id)->sum('agent_commission');
                $agentData[$agent->id] = $main + $sub;
            }
            $agentData = array_sort($agentData);
            $arr = [];
            foreach ($agentData as $k => $v) {
                $arr[] = $v . '||' . $k;
            }
            $arr = array_reverse($arr);
            $i = count($arr);
            if ($i >= 10) {
                $i = 10;
            }
            $arr1 = [];
            for ($x = 0; $x < $i; $x++) {
                $arr1[] = $arr[$x];
            }
            $maxArr = [];
            foreach ($agentData as $data) {
                $maxArr[] = $data;
            }
            $max = max($maxArr);
            //$not=DB::table('project_requests')->raw("select id,name,null as type,null as type_id, updated_at, '1' as projects  union select  id, null as name,type,type_id,updated_at, '0' as projects from admin_notifications where created_at >= ? orWhere status = 0 ",[date('Y-m-d H:i:s', strtotime('-1 month', time()))])->get();

            $info = Setting::first();
            //Require Optimization
            // $projects = Project::select('id','en_name')->has('request')->withcount('request')->where('created_at', '>', $request->startDate)
            //                 ->where('created_at', '<', $request->endDate)->orderBy('request_count', 'desc')->limit(10)->get();
            $projects = [];
            foreach (Project::select('id','en_name')->get() as $k => $project) {
                $callsCount = \App\Call::where('projects', 'like', "%$project->id%")->count();
                $meetingsCount = \App\Meeting::where('projects', 'like', "%$project->id%")->count();
                if ($callsCount > 0 || $meetingsCount > 0) {
                    $callArray[$k]['project'] = $project->en_name . $project->id;
                    $callArray[$k]['count'] = $callsCount;

                    $mettingArray[$k]['project'] = $project->en_name;
                    $mettingArray[$k]['count'] = $meetingsCount;
                }
            }

            $proMeetingCall = ['meetings' => $mettingArray, 'calls' => $callArray];

            // Requires Optimization
            // $sources = LeadSource::has('leads')->withcount(['leads' => function ($q) use ($request) {
            //                 $q->where('created_at', '>', $request->startDate)->where('created_at', '<', $request->endDate);
            //             }])->orderBy('leads_count', 'desc')->limit(8)->get();
            $sources = [];

            $inventory = new ResaleUnit;
            $inventory = $inventory->where('created_at', '>', $request->startDate)->where('created_at', '<', $request->endDate)
                    ->sum('price');
            $callStatus = new \App\CallStatus;
            $callStatus = $callStatus->select('id','name')->has('calls')->withCount(['calls' => function ($q) use ($request) {
                            $q->where('created_at', '>', $request->startDate)->where('created_at', '<', $request->endDate);
                        }])->get();

            $groups = \App\Group::select('id','name','team_leader_id','parent_id')->with('groupMembers')->with('children')->get();
            $count = 0;
            $leadTeamCount = [[]];
            foreach ($groups as $key => $group) {
                $leadTeamCount[$key]['name'] = $group->name;
                $a = 0;
                foreach ($group->groupMembers as $member) {
                    if ($member->member) {
                        $a += Lead::where(
                                        function ($q) use ($member) {
                                    $q->where('agent_id', $member->member->id)->orWhere('commercial_agent_id', $member->member->id);
                                }
                                )->where('created_at', '>', $request->startDate)->where('created_at', '<', $request->endDate)->count();
                    }
                }
                $leadTeamCount[$key]['count'] = $a;
            }

            return view('admin.dashboard', [
                'title' => $info->title,
                'salesM' => $salesM,
                'salesD' => $salesD,
                'leadsD' => $leadsD,
                'leads' => $leads,
                'deals' => $deals,
                'chart' => $arr1,
                'max' => $max,
                'projects' => $projects,
                'sources' => $sources,
                'projectSum' => $projectSumLeads,
                'inventory' => $inventory,
                'callStatus' => $callStatus,
                'groups' => $groups,
                'leadTeamCount' => $leadTeamCount,
                'startDate' => $request->startDate,
                'endDate' => $request->endDate,
                'event_note' => $event_note,
                'orderDesk' => $orderDesk,
                'proMeetingCall' => $proMeetingCall,
                'todayLeads' => $todayLeads,
                'seen' => $seen,
                'notSeen' => $notSeen,
            ]);
        } else {
            $month = date('Y-m');
            $day = date('Y-m-d');
            $salesM = ClosedDeal::where('created_at', '>=', $month . '-01 00:00:00')->where('agent_id', auth()->id())->sum('price');
            $salesD = ClosedDeal::where('created_at', '>=', $day . ' 00:00:00')->where('agent_id', auth()->id())->sum('price');
            $leadsD = Lead::where('created_at', '>=', $day . ' 00:00:00')->where('agent_id', auth()->id())->count();
            $todayLeads = Lead::whereDate('created_at', Carbon::today())->where('agent_id', auth()->user()->id)->count();
            $seen = Lead::where("seen", 1)->where('agent_id', auth()->user()->id)->count();
            $notSeen = Lead::where("seen", 0)->where('agent_id', auth()->user()->id)->count();
            $leads = Lead::where('agent_id', auth()->id())->count();
            foreach ($check_user as $key => $value_check) {
                for($i=0;$i<$event;$i++){
                    $event_note = ProdcastEvent::select('title_event_en','description_event_en')->whereDate('date_event', '>=', Carbon::now()->toDateString())->where('id', $value_check->prot_event_id)->get();
                }
            }

            $groups = null;

            if (\App\Group::where('team_leader_id', auth()->user()->id)->count() > 0) {
                $groups = \App\Group::select('id','name','team_leader_id','parent_id')->with('groupMembers')->get();
                $group_id = \App\Group::where('team_leader_id', auth()->user()->id)->value('id');
                $groupMembers = \App\GroupMember::where('group_id', $group_id);
                $ids = $groupMembers->pluck('member_id')->toArray();
                // $projects = Project::has('request')->withCount([
                //                     'request' => function ($qa) use ($ids) {
                //                         $qa->whereHas(
                //                                 'lead', function ($q) use ($ids) {
                //                                     $q->whereIn('agent_id', $ids)->orWhereIn('commercial_agent_id', $ids);
                //                                 }
                //                         );
                //                     }
                //                 ])->where('created_at', '>', $request->startDate)
                //                 ->where('created_at', '<', $request->endDate)->orderBy('request_count', 'desc')->limit(10)->get();
                $projects = [];
                foreach (Project::select('id','en_name')->get() as $k => $project) {
                    $scallCount = \App\Call::whereHas('lead', function ($q) use ($ids) {
                                $q->whereIn('agent_id', $ids)->orWhereIn('commercial_agent_id', $ids);
                            })->where('projects', 'like', "%$project->id%")->count();
                    $smeetingCount = \App\Meeting::whereHas('lead', function ($q) use ($ids) {
                                $q->whereIn('agent_id', $ids)->orWhereIn('commercial_agent_id', $ids);
                            })->where('projects', 'like', "%$project->id%")->count();
                    if ($scallCount > 0 || $smeetingCount > 0) {
                        $callArray[$k]['project'] = $project->en_name . $project->id;
                        $callArray[$k]['count'] = $scallCount;

                        $mettingArray[$k]['project'] = $project->en_name;
                        $mettingArray[$k]['count'] = $smeetingCount;
                    }
                }
                $proMeetingCall = ['meetings' => $mettingArray, 'calls' => $callArray];

                $projectSumLeads = \App\Request::whereHas('lead', function ($q) use ($ids) {
                            $q->whereIn('agent_id', $ids)->orWhereIn('commercial_agent_id', $ids);
                        })->count();
                // $sources = LeadSource::has('leads')->withcount(['leads' => function ($q) use ($request, $ids) {
                //                 $q->where(function ($qa) use ($ids) {
                //                             $qa->whereIn('agent_id', $ids)->orWhereIn('commercial_agent_id', $ids);
                //                         })->where('created_at', '>', $request->startDate)->where('created_at', '<', $request->endDate);
                //             }])->limit(8)->get();
                $sources = [];
                $callStatus = new \App\CallStatus;
                $callStatus = $callStatus->select('id','name')->has('calls')->withCount(['calls' => function ($q) use ($request, $ids) {
                                $q->whereIn('user_id', $ids)->where('created_at', '>', $request->startDate)->where('created_at', '<', $request->endDate);
                            }])->get();
                $count = 0;
                $leadTeamCount = [[]];
                $a = 0;

                foreach ($groupMembers->select('id','group_id','member_id')->get() as $k => $member) {
                    if($member->member){
                        $leadTeamCount[$k]['name'] = $member->member->name;
                        $a = Lead::where(
                                        function ($q) use ($member, $ids) {
                                    $q->where('agent_id', $member->member_id)->orWhere('commercial_agent_id', $member->member_id);
                                }
                                )->where('created_at', '>', $request->startDate)->where('created_at', '<', $request->endDate)->count();
                        $leadTeamCount[$k]['count'] = $a;
                    }
                    else{
                        $teamLeaderId = Group::where('id',$member->group_id)->value('team_leader_id');
                        $teamLeader = User::where('id',$teamLeaderId)->value('name');
                        $leadTeamCount[$k]['name'] = $teamLeader;
                        $leadTeamCount[$k]['count'] = 1;
                    }
                    // $check = $groupMembers->where('member_id',auth()->user()->id)->first();
                    // if($check){
                    //   $leadTeamCount[$k]['name'] = auth()->user()->name;
                    // }
                }
            } else {

                $groups = \App\Group::select('id','name','team_leader_id','parent_id')->with('groupMembers')->get();
                $memberr = auth()->user()->id;
                // $projects = Project::has('request')->withCount([
                //                     'request' => function ($qa) use ($memberr) {
                //                         $qa->whereHas(
                //                                 'lead', function ($q) use ($memberr) {
                //                                     $q->where('agent_id', $memberr)->orWhere('commercial_agent_id', $memberr);
                //                                 }
                //                         );
                //                     }
                //                 ])->where('created_at', '>', $request->startDate)
                //                 ->where('created_at', '<', $request->endDate)->orderBy('request_count', 'desc')->limit(10)->get();
                $projects = [];
                $projectSumLeads = \App\Request::whereHas('lead', function ($q) use ($memberr) {
                            $q->where('agent_id', $memberr)->orWhere('commercial_agent_id', $memberr);
                        })->count();
                foreach (Project::select('id','en_name')->get() as $k => $project) {
                    $scallCount = \App\Call::whereHas('lead', function ($q) use ($memberr) {
                                $q->where('agent_id', $memberr)->orWhere('commercial_agent_id', $memberr);
                            })->where('projects', 'like', "%$project->id%")->count();
                    $smeetingCount = \App\Meeting::whereHas('lead', function ($q) use ($memberr) {
                                $q->where('agent_id', $memberr)->orWhere('commercial_agent_id', $memberr);
                            })->where('projects', 'like', "%$project->id%")->count();
                    if ($scallCount > 0 || $smeetingCount > 0) {
                        $callArray[$k]['project'] = $project->en_name . $project->id;
                        $callArray[$k]['count'] = $scallCount;
                        // $callArray[$k]['val'] = $scall->get();

                        $mettingArray[$k]['project'] = $project->en_name;
                        $mettingArray[$k]['count'] = $smeetingCount;
                        // $mettingArray[$k]['val'] = $smeeting->get();
                    }
                }
                $proMeetingCall = ['meetings' => $mettingArray, 'calls' => $callArray];
                // $sources = LeadSource::has('leads')->withcount(['leads' => function ($q) use ($request, $memberr) {
                //                 $q->where(function ($qa) use ($memberr) {
                //                             $qa->where('agent_id', $memberr)->orWhere('commercial_agent_id', $memberr);
                //                         })->where('created_at', '>', $request->startDate)->where('created_at', '<', $request->endDate);
                //             }])->limit(8)->get();
                $sources = [];
                $callStatus = new \App\CallStatus;
                $callStatus = $callStatus->select('id','name')->has('calls')->withCount(['calls' => function ($q) use ($request, $memberr) {
                                $q->where('user_id', $memberr)->where('created_at', '>', $request->startDate)->where('created_at', '<', $request->endDate);
                            }])->get();
                $leadTeamCount = null;
            }
            if (auth()->user()->flag == '1') {
                $uses = User::Find(auth()->user()->id);
                return view('admin.changepass', compact('uses'));
            } else {
                return view('admin.dashboard', [
                    'title' => Setting::first()->title,
                    'salesM' => $salesM,
                    'salesD' => $salesD,
                    'leadsD' => $leadsD,
                    'leads' => $leads,
                    'groups' => $groups,
                    'leadTeamCount' => $leadTeamCount,
                    'event_note' => $event_note,
                    'startDate' => $request->startDate,
                    'endDate' => $request->endDate,
                    'sources' => $sources,
                    'callStatus' => $callStatus,
                    'projects' => $projects,
                    'projectSum' => $projectSumLeads,
                    'orderDesk' => $orderDesk,
                    'proMeetingCall' => $proMeetingCall,
                    'todayLeads' => $todayLeads,
                    'seen' => $seen,
                    'notSeen' => $notSeen,
                ]);
            }
        }
    }

    public function about_page() {
        $about = Setting::first();
        return view('website.about', ['about' => $about]);
    }

    public function new_homes_properties() {
        $search = $this->search_info();
        $project = new ProjectController;
        $featured = $project->featured_project();
        $projects = Project::where('type', 'personal')->where('show_website', 1)->orderBy('id', 'DESC')->paginate(6);
        $all_projects = Project::where('type', 'personal')->where('show_website', 1)->get();
        return view('website.new_homes_properties', ['projects' => $projects, 'search' => $search, 'featured' => $featured, 'title' => __('admin.new_homes'), 'all_projects' => $all_projects]);
    }

    public function resale_properties() {
        $search = $this->search_info();
        $project = new ProjectController;
        $featured = $project->featured_project();
        // $resale = ResaleUnit::where('type', 'personal')->paginate(6);
        $resale = DB::table('resale_units as unit')
                            ->where('unit.type', 'personal')
                            ->where('status', 'done')
                            ->join('projects as project','unit.project_id','=','project.id')
                            ->select('unit.*','project.en_name as project_en_name','project.ar_name as project_ar_name')
                            ->paginate(6);
        // return $resale;
        $all_projects = ResaleUnit::where('type', 'personal')->get();
        return view('website.resale_properties', ['resale' => $resale, 'search' => $search, 'featured' => $featured, 'title' => __('admin.resale'), 'all_projects' => $all_projects]);
    }

    public function rental_properties() {
        $search = $this->search_info();
        $project = new ProjectController;
        $featured = $project->featured_project();
        $rental = RentalUnit::where('type', 'personal')->where('status','done')->paginate(6);
        // return $rental;
        $all_projects = RentalUnit::where('type', 'personal')->get();
        return view('website.rental_properties', ['rental' => $rental, 'search' => $search, 'featured' => $featured, 'title' => __('admin.rental'), 'all_projects' => $all_projects]);
    }

    public function new_homes_commercial() {
        $search = $this->search_info();
        $project = new ProjectController;
        $featured = $project->featured_project();
        $properties = Project::where('type', 'commercial')->where('show_website', 1)->orderBy('id', 'Desc')->paginate(6);
        $all_projects = Project::where('type', 'commercial')->where('show_website', 1)->get();
        return view('website.new_homes_commercial', ['projects' => $properties, 'search' => $search, 'featured' => $featured, 'title' => __('admin.new_homes'), 'all_projects' => $all_projects]);
    }

    public function resale_commercial() {
        $search = $this->search_info();
        $project = new ProjectController;
        $featured = $project->featured_project();
        $resale = ResaleUnit::where('type', 'commercial')->where('status','done')->paginate(6);
        // return $resale;
        $all_projects = ResaleUnit::where('type', 'commercial')->get();
        return view('website.resale_commercial', ['resale' => $resale, 'search' => $search, 'all_projects' => $all_projects, 'featured' => $featured, 'title' => __('admin.resale')]);
    }

    public function rental_commercial() {
        $search = $this->search_info();
        $project = new ProjectController;
        $featured = $project->featured_project();
        $rental = RentalUnit::where('type', 'commercial')->where('status','done')->paginate(6);
        // return $rental;
        $all_projects = RentalUnit::where('type', 'commercial')->get();
        return view('website.rental_commercial', ['rental' => $rental, 'search' => $search, 'featured' => $featured, 'title' => __('admin.rental'), 'all_projects' => $all_projects]);
    }

    public function location() {
        return view('website.locations');
    }

    public function news() {
        $search = $this->search_info();
        $project = new ProjectController;
        $featured = $project->featured_project();
        $events = Event::orderBy('id', 'asc')->paginate(5);
        return view('website.news', compact('events', 'search', 'featured'));
    }

    public function single_news($lang,$id) {
        $array = explode('-', $id);
        $id = end($array);
        $search = $this->search_info();
        $project = new ProjectController;
        $featured = $project->featured_project();
        $single_news = Event::find($id);
        return view('website.single_news', compact('single_news', 'search', 'featured'));
    }

    public function contact() {
        $contact = Setting::first();
        $phones = HubPhone::all();
        $socials = HubSocial::all();
        return view('website.contact', compact('contact', 'phones', 'socials'));
    }

    public static function get_roles() {
        if (auth()->user()->type != 'admin') {
            $role = Role::find(auth()->user()->role_id);
            return json_decode($role->roles);
        } else {
            return true;
        }
    }

    public function seo(Request $request) {
        $rules = [
            'seo' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            session()->flash('error', trans('admin.error'));
            return back();
        } else {
            $setting = Setting::first();
            $setting->seo = $request->seo;
            $setting->save();
            session()->flash('success', trans('admin.success'));
            return back();
        }
    }

    public function send_mail() {
        return view('admin.send_mail', ['title' => __('admin.send_mail')]);
    }

    public function mail_post(Request $request) {
        $txt = $request->message;
        $path = base_path('resources/views/mail.blade.php');
        $file = fopen($path, 'wb');
        fwrite($file, $txt);
        fclose($file);
        Config::set('mail.username', auth()->user()->email);
        Config::set('mail.password', decryptHelper(auth()->user()->email_password));
        $mail = auth()->user()->email;
        $name = auth()->user()->name;
        if (Setting::first()->mail_provider == 'gmail') {
            Config::set('mail.port', 587);
            Config::set('mail.host', 'smtp.gmail.com');
        } else if (Setting::first()->mail_provider == 'cpanel') {
            Config::set('mail.port', 26);
            Config::set('mail.host', 'mail.propertz.net');
            // Config::set('mail.encryption', 'ssl');
        } else if (Setting::first()->mail_provider == 'outlook') {
            Config::set('mail.port', 587);
            Config::set('mail.host', 'smtp-mail.outlook.com');
            // Config::set('mail.encryption', 'ssl');
        }
        // Mail::send('mail', [], function ($message) use ($request, $mail, $name) {
        //   $message->from($mail, $name)->to($request->lead_id)->subject($request->subject);
        // });

        session()->flash('success', trans('admin.sent'));

        return back();
    }

    public function inbox() {
        if (auth()->user()->email_password != '') {
            try {
                $email = auth()->user()->email;
                $password = decryptHelper(auth()->user()->email_password);
                $data = [];
                $type = Setting::first()->mail_provider;
                if ('cpanel' == $type) {
                    $mailbox = imap_open("{mail.propertz.net:110/pop3/notls}INBOX", $email, $password);
                } else if ('gmail' == $type) {
                    $mailbox = imap_open("{imap.gmail.com:993/ssl}INBOX", $email, $password);
                } else if ('outlook' == $type) {
                    $mailbox = imap_open("{imap-mail.outlook.com:993/ssl}INBOX", $email, $password);
                }

                $messages = imap_search($mailbox, 'ALL');
                if ($messages) {
                    $arr = array_reverse($messages);

                    $data = [];
                    if (count($arr) < 10) {
                        $x = count($arr);
                    } else {
                        $x = 10;
                    }
                    for ($i = 0; $i < $x; $i++) {
                        $data[] = imap_fetch_overview($mailbox, $arr[$i], 0)[0];
                    }
                }
                imap_close($mailbox);
            } catch (\ErrorException $e) {
                return redirect(adminPath() . '/');
            }
        } else {
            return redirect(adminPath() . '/');
        }
        return view('admin.inbox', ['title' => __('admin.inbox'), 'messages' => $data]);
    }

    public static function lead_inbox($mail) {
        if (auth()->user()->email_password != '') {
            try {
                $email = auth()->user()->email;
                $password = decryptHelper(auth()->user()->email_password);
                $data = [];
                $type = Setting::first()->mail_provider;
                if ('cpanel' == $type) {
                    $mailbox = imap_open("{mail.propertz.net:110/pop3/notls}", $email, $password);
                } else if ('gmail' == $type) {
                    $mailbox = imap_open("{imap.gmail.com:993/ssl}", $email, $password);
                } else if ('outlook' == $type) {
                    $mailbox = imap_open("{imap-mail.outlook.com:993/ssl}", $email, $password);
                }
                $messages = imap_search($mailbox, 'FROM "' . $mail . '"');
                if ($messages) {
                    $arr = array_reverse($messages);

                    $data = [];
                    if (count($arr) < 10) {
                        $x = count($arr);
                    } else {
                        $x = 10;
                    }
                    for ($i = 0; $i < $x; $i++) {
                        $data[] = imap_fetch_overview($mailbox, $arr[$i], 0)[0];
                    }
                }
                imap_close($mailbox);
            } catch (\ErrorException $e) {
                return redirect(adminPath() . '/');
            }
        } else {
            $data = [];
        }
        return $data;
    }

    public function get_mail($id) {
        if (auth()->user()->email_password != '') {
            try {
                $yourEmail = auth()->user()->email;
                $yourEmailPassword = decryptHelper(auth()->user()->email_password);

                $type = Setting::first()->mail_provider;
                if ('cpanel' == $type) {
                    $mailbox = imap_open("{mail.propertz.net:110/pop3/notls}INBOX", $yourEmail, $yourEmailPassword);
                } else if ('gmail' == $type) {
                    $mailbox = imap_open("{imap.gmail.com:993/ssl}INBOX", $yourEmail, $yourEmailPassword);
                } else if ('outlook' == $type) {
                    $mailbox = imap_open("{imap-mail.outlook.com:993/ssl}", $email, $password);
                }

                $message = imap_qprint(imap_fetchbody($mailbox, $id, 2));
                imap_close($mailbox);
            } catch (\ErrorException $e) {
                return redirect(adminPath() . '/');
            }
        } else {
            $message = [];
        }
        return view('admin.mail', ['data' => $message]);
    }

    public static function count_mails() {
        // if (auth()->user()->email_password != '' and decrypt(auth()->user()->email_password) != null) {
        //     try {
        //         $yourEmail         = auth()->user()->email;
        //         $yourEmailPassword = decrypt(auth()->user()->email_password);
        //         $type              = Setting::first()->mail_provider;
        //         if ($type == 'cpanel') {
        //             $mailbox = imap_open("{mail.propertz.net:110/pop3/notls}INBOX", $yourEmail, $yourEmailPassword);
        //         } else if ($type == 'gmail') {
        //             $mailbox = imap_open("{imap.gmail.com:993/ssl}INBOX", $yourEmail, $yourEmailPassword);
        //         } else if ('outlook' == $type) {
        //   $mailbox = imap_open("{imap-mail.outlook.com:993/ssl}", $email, $password);
        // }
        //         $messages = imap_search($mailbox, 'UNSEEN');
        //         imap_close($mailbox);
        //     } catch (\ErrorException $e) {
        //         return 0;
        //     }
        //     if (!$messages) {
        //         $count = 0;
        //     } else {
        //         $count = count($messages);
        //     }
        // } else {
        //     $count = 0;
        // }
        // return $count;
    }

    public function send_unit(Request $request) {
        if ('resale' == $request->type) {
            Config::set('mail.username', auth()->user()->email);
            Config::set('mail.password', decryptHelper(auth()->user()->email_password));
            $mail = auth()->user()->email;
            $name = auth()->user()->name;
            $unit = ResaleUnit::find($request->unit_id);
            /*            Mail::send('admin.send_resale', ['unit' => $unit, 'lang' => $request->lang], function ($message) use ($request, $mail, $name, $unit) {
              $message->from($mail, $name)->to($request->lead)->subject($unit->{$request->lang . '_title'});
              }); */
        }
        session()->flash('success', trans('admin.sent'));

        return back();
    }

    public function add_property(Request $request) {

        if ('personal' == $request->type) {
            $rules = [
                'type' => 'required',
                'total' => 'required',
                'unit_type_id' => 'required',
                'finishing' => 'required',
                'ar_description' => 'required',
                'en_description' => 'required',
                'ar_title' => 'required',
                'en_title' => 'required',
                'ar_address' => 'required',
                'en_address' => 'required',
                'phone' => 'required',
                'area' => 'required',
                'price' => 'required',
                'rooms' => 'required',
                'bathrooms' => 'required',
                'lng' => 'required',
                'lat' => 'required',
                'zoom' => 'required',
                'image' => 'required',
                'due_now' => 'required|numeric',
                'payment_method' => 'required',
                'view' => 'required',
            ];
        } else {
            $rules = [
                'type' => 'required',
                'total' => 'required',
                'finishing' => 'required',
                'ar_description' => 'required',
                'en_description' => 'required',
                'ar_title' => 'required',
                'en_title' => 'required',
                'ar_address' => 'required',
                'en_address' => 'required',
                'phone' => 'required',
                'area' => 'required',
                'price' => 'required',
                'lng' => 'required',
                'lat' => 'required',
                'zoom' => 'required',
                'image' => 'required|image',
                'payment_method' => 'required',
                'view' => 'required',
                'due_now' => 'required|numeric',
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
            'image' => trans('admin.image'),
            'due_now' => trans('admin.due_now'),
            'payment_method' => trans('admin.payment_method'),
            'view' => trans('admin.view'),
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
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
            $unit->featured = $request->featured;
            $unit->meta_keywords = $request->meta_keywords;
            $unit->meta_description = $request->meta_description;
            $unit->priority = 0;
            if ($request->has('other_phones')) {
                $unit->other_phones = json_encode($request->other_phones);
            } else {
                $unit->other_phones = '[]';
            }
            $unit->area = $request->area;
            $unit->price = $request->price;
            $unit->rooms = $request->rooms;
            $unit->bathrooms = $request->bathrooms;
            $unit->floors = $request->floors;
            $unit->lng = $request->lng;
            $unit->lat = $request->lat;
            $unit->zoom = $request->zoom;

            $set = Setting::first();
            if ($request->hasFile('image')) {
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
            $unit->user_id = $request->user_id;
            $unit->save();

            $old_data = json_encode($unit);
            LogController::add_log(
                    __('admin.created', [], 'ar') . ' ' . $unit->ar_title, __('admin.created', [], 'en') . ' ' . $unit->en_title, 'resale_units', $unit->id, 'create', auth()->user()->id, $old_data
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

            session()->flash('success', trans('admin.created'));
            return redirect('/');
        }
    }

    public function test5() {
        $projects = Project::all();
        foreach ($projects as $row) {
            $row->featured = 0;
            $row->show_website = 0;
            $row->mobile = 0;
            $row->save();
        }
    }

    public function guide() {
        $agents = User::select('id', 'name')->get()->toArray();
        $location = Location::select('id', 'ar_name', 'en_name')->get()->toArray();
        $projects = Project::select('id', 'en_name', 'ar_name')->get()->toArray();
        $unit_type = UnitType::select('id', 'en_name', 'ar_name')->get()->toArray();
        $lead_source = LeadSource::select('id', 'name')->get()->toArray();
        $lead_types = ['Buyer', 'Seller'];
        $types = ['Residential', 'Commercial', 'Land'];
        $reqtypes = ['resale', 'rental', 'new_home', 'land'];
        $count = count($agents);
        if ($count < count($location)) {
            $count = count($location);
        }

        if ($count < count($projects)) {
            $count = count($projects);
        }

        if ($count < count($unit_type)) {
            $count = count($unit_type);
        }

        if ($count < count($lead_source)) {
            $count = count($lead_source);
        }

        if ($count < count($types)) {
            $count = count($types);
        }

        if ($count < count($lead_types)) {
            $count = count($lead_types);
        }

        if ($count < count($reqtypes)) {
            $count = count($reqtypes);
        }

        Excel::create('guide', function ($excel) use ($agents, $location, $projects, $unit_type, $lead_source, $count, $types, $lead_types, $reqtypes) {
            $excel->sheet('campaign', function ($sheet) use ($agents, $location, $projects, $unit_type, $lead_source, $count, $types, $lead_types, $reqtypes) {
                $sheet->loadView('admin.xlsguide', [
                    'agents' => $agents, 'location' => $location,
                    'projects' => $projects, 'unit_type' => $unit_type, 'lead_source' => $lead_source, 'types' => $types, 'lead_types' => $lead_types, 'reqtypes' => $reqtypes, 'count' => $count
                ]);
            });
        })->export('xls');
    }

    public function xls() {
        Excel::create('Request', function ($excel) {
            $excel->sheet('campaign', function ($sheet) {
                $sheet->loadView('admin.xls_request');
            });
        })->export('xls');
    }

    public function xls1(Request $request) {

    	ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        //=TEXT(A1, "mm/dd/yyyy")
        $path = $request->file('xls')->getRealPath();
        $count = 0;
        Excel::load($path, function ($reader) use (&$count) {
            $array = $reader->toArray();

            foreach ($array as $item) {

                $prefix = '';
                if (str_split($item['contact'])[0] == '1') {
                    $prefix = '0';
                } else if (str_split($item['contact'])[0] != '0' and str_split($item['contact'])[0] != '1' and str_split($item['contact'])[0] != '+') {
                    $prefix = '00';
                }
                $phone = $prefix . @$item['contact'];

                if (isset($item['contact'])) {
                    $lead = Lead::where('phone', $phone)->first();

                    if ($lead) {
                        $checkType = self::checkTypeForAgent((int) $item['agent_id']);
                        $agentId = (int) $item['agent_id'];

                        if ($checkType == 'residential') {
                            $lead->agent_id = $agentId;
                        } else if ($checkType == 'commercial') {
                            $lead->commercial_agent_id = $agentId;
                        }


                        if ($lead->agent_id == 0 && $checkType == 'residential') {
                            $lead->agent_id = $agentId;
                        } else if ($lead->commercial_agent_id == 0 && $checkType == 'commercial') {
                            $lead->commercial_agent_id = $agentId;
                        }
                        $lead->save();
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

                        $prefix = '';
                        if (str_split($item['contact'])[0] == '1') {
                            $prefix = '0';
                        } else if (str_split($item['contact'])[0] != '0' and str_split($item['contact'])[0] != '1' and str_split($item['contact'])[0] != '+') {
                            $prefix = '00';
                        }

                        $lead->phone = $prefix . @$item['contact'];
                        $lead->lead_source_id = $item['lead_source_id'] ? $item['lead_source_id'] : 0;
                        $lead->campain_id = 0;
                        if (isset($item['date'])) {
                            $date = strtotime($item['date']);
                            $lead->created_at = date('Y-m-d H:i:s', $date);
                        }


                        $checkType = self::checkTypeForAgent((int) $item['agent_id']);

                        $agentId = (int) $item['agent_id'];

                        if ($checkType == 'residential') {
                            $lead->agent_id = $agentId;
                        } else if ($checkType == 'commercial') {
                            $lead->commercial_agent_id = $agentId;
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

                    //if (strtolower($item['request_type']) == 'buy') {

                    $unit1 = @UnitType::find($item['unit_type_id']);

                    $location = @Location::find($item['location_id']);

                    $req = new Model;
                    $req->lead_id = $lead->id;
                    if ($location) {
                        $req->location = @$location->id;
                    }
                    if ($unit1) {
                        $req->unit_type_id = @$unit1->id;
                    }

                    if (@$item['date']) {
                        $req->date = @$item['date']->timestamp;
                    } else {
                        $req->date = idate('Y');
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

                    $req->unit_type = $type;
                    $req->type = $z;

                    $req->notes = @$item['description'];
                    $req->request_type = $rtype;
                    $req->project_id = @$item['compound_id'];

                    $req->user_id = Auth::user()->id;
                    $req->save();
                    $count++;

                    //}
                }
            }
        });
        return $count . ' has been added';
    }

    public function xls1oldhotpatch(Request $request) {
        //=TEXT(A1, "mm/dd/yyyy")
        $path = $request->file('xls')->getRealPath();
        $count = 0;
        Excel::load($path, function ($reader) use (&$count) {
            $array = $reader->toArray();
            // dd(json_encode(Auth::user()));
            // return response()->json("[Auth::user()]");
            // dd([$array, Auth::user()]);

            foreach ($array as $item) {

                $prefix = '';
                if (str_split($item['contact'])[0] == '1') {
                    $prefix = '0';
                } else if (str_split($item['contact'])[0] != '0' and str_split($item['contact'])[0] != '1' and str_split($item['contact'])[0] != '+') {
                    $prefix = '00';
                }
                $phone = $prefix . @$item['contact'];

                if (isset($item['contact'])) {
                    $lead = Lead::where('phone', $phone)->first();

                    if ($lead) {
                        $checkType = self::checkTypeForAgent((int) $item['agent_id']);
                        $agentId = (int)$item['agent_id'];

                        if ($checkType == 'residential') {
                            $lead->agent_id = $agentId;
                        } else if ($checkType == 'commercial') {
                            $lead->commercial_agent_id = $agentId;
                        }
                        if ($lead->agent_id == 0 && $checkType == 'residential') {
                            $lead->agent_id = $agentId;
                        } else if ($lead->commercial_agent_id == 0 && $checkType == 'commercial') {
                            $lead->commercial_agent_id = $agentId;
                        }

                        $lead->save();
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

                        $prefix = '';
                        if (str_split($item['contact'])[0] == '1') {
                            $prefix = '0';
                        } else if (str_split($item['contact'])[0] != '0' and str_split($item['contact'])[0] != '1' and str_split($item['contact'])[0] != '+') {
                            $prefix = '00';
                        }

                        $lead->phone = $prefix . @$item['contact'];
                        $lead->lead_source_id = $item['lead_source_id'] ? $item['lead_source_id'] : 0;
                        $lead->campain_id = 0;
                        if (isset($item['date'])) {
                            $date = strtotime($item['date']);
                            $lead->created_at = date('Y-m-d H:i:s', $date);
                        }

                        $checkType = self::checkTypeForAgent((int) $item['agent_id']);
                        $agentId = (int) $item['agent_id'];

                        if ($checkType == 'residential') {
                            $lead->agent_id = $agentId;
                        } else if ($checkType == 'commercial') {
                            $lead->commercial_agent_id = $agentId;
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

                    //if (strtolower($item['request_type']) == 'buy') {

                    $unit1 = @UnitType::find($item['unit_type_id']);

                    $location = @Location::find($item['location_id']);

                    $req = new Model;
                    $req->lead_id = $lead->id;
                    if ($location) {
                        $req->location = @$location->id;
                    }
                    if ($unit1) {
                        $req->unit_type_id = @$unit1->id;
                    }

                    if (@$item['date']) {
                        $req->date = @$item['date']->timestamp;
                    } else {
                        $req->date = idate('Y');
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

                    $req->unit_type = $type;
                    $req->type = $z;

                    $req->notes = @$item['description'];
                    $req->request_type = $rtype;
                    $req->project_id = @$item['compound_id'];

                    $req->user_id = Auth::user()->id;
                    $req->save();
                    $count++;

                    //}
                }
            }
        });
        return $count . ' has been added';
    }

    /*
     * switch lang for website
     */

     public function switch($lang)
     {
        Session::put('lang', $lang);
        return redirect()->back();
     }


    /**
     * check for user agent
     *
     *
     *
     */
    private static function checkTypeForAgent(int $agentId): string {
        $user = User::where('id', $agentId)->first();
        if ($user) {
            return $user->residential_commercial ?? $user->residential_commercial;
        }
        return "";
    }

    public function form($slug) {
        $id = explode('-', $slug);
        $id = end($id);
        $form = Form::find($id);
        return view('form', [
            'form' => $form,
            'title' => $form->{app()->getLocale() . '_title'},
            'id' => $id,
        ]);
    }

    public function contract($url) {
        $contract = Contract::where('url', $url);
        if ($contract->count() == 1) {
            $contract = $contract->first();
            $title = $contract->title;
            return view('contract', compact('contract', 'title'));
        } else {
            return 404;
        }
    }

    public function confirmContract(Request $request) {
        $img = base64_decode($request->img);
        $filename = md5(date('dmYhisA'));
        $filename = rand(0, 9999999999) . $filename;

        $fullname = 'uploads/' . $filename . '.png';
        file_put_contents($fullname, $img);
        $contract = Contract::find($request->id);
        $contract->signature = $fullname;
        $contract->save();

        return response()->json([
                    'status' => 1,
                    'img' => $request->files,
        ]);
    }

    public function contractForm(Request $request) {
        $rules = [
            'id' => 'required',
            'lead_name' => 'required|max:191',
            'signature_name' => 'required|max:191',
            'docs' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'id' => trans('admin.id'),
            'lead_name' => trans('admin.lead_name'),
            'signature_name' => trans('admin.signature_name'),
            'docs' => trans('admin.files'),
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $contract = Contract::find($request->id);
            $contract->lead_name = $request->lead_name;
            $contract->signature_name = $request->signature_name;
            $contract->status = 1;

            $contract->save();
            foreach ($request->docs as $doc) {
                $file = new LeadDocument;
                $file->lead_id = $contract->lead_id;
                $file->title = $contract->title;
                $file->file = upload($doc, 'contract');
                $file->user_id = 0;
                $file->contract_id = $contract->id;
                $file->save();
            }

            session()->flash('success', trans('admin.created'));

            return redirect('/');
        }
    }

    public static function getTeam($id) {
        $groups = Group::where('parent_id', $id)->get();
        foreach ($groups as $group) {
            array_push(self::$allTeam, $group->id);
            self::getTeam($group->id);
        }
    }

    public static function myTeam($id) {
        self::getTeam($id);
        $users = self::$allTeam;
        return array_unique($users);
    }

    public function notificationStatus(Request $request) {
        $status = 0;
        $not = AdminNotification::find($request->id);
        if ($not) {
            $not->status = 1;
            $not->save();
            $status = 1;
        }

        return response([
            'status' => $status,
        ]);
    }

    public function unread(Request $request) {

        $not = AdminNotification::find($request->id);
        $status = $not->status;
        $msg = '';
        $not->status = $not->status ? 0 : 1;
        $not->save();
        $status ? $msg = 'read' : $msg = 'unread';
        return response([
            'status' => $msg,
        ]);
    }

    public function get_sub_cats(Request $request) {
        $subs = OutSubCat::where('out_cat_id', $request->cat)->get();
        return view('admin.finances.get_subs', compact('subs'));
    }

    public function push_player(Request $request) {
        if (count(Player::where('player_id', $request->id)->get()) < 1) {
            $player = new Player;
            $player->user_id = Auth::user()->id;
            $player->player_id = $request->id;
            $player->device = "web";
            $player->save();
            echo 1;
        }
    }

    // public function send event to member
    // shenawy
    public function send_event(Request $request) {
        //dd($request);
        $prodcastevents = new ProdcastEvent;
        $prodcastevents->date_event = $request->date_event;
        $prodcastevents->title_event_en = $request->title_event;
        $prodcastevents->description_event_en = $request->description_event;
        $prodcastevents->save();
        if ($request->member_select_event == '') {
            $groups = Group::with('groupMembers')->whereIn('id', $request->team_select_event)->get();
            foreach ($groups as $group) {
                // code...
                foreach ($group->groupMembers as $member) {
                    $prodeventstatus = new ProdeventStatus;
                    $prodeventstatus->user_id = $member->id;
                    $prodeventstatus->prot_event_id = $prodcastevents->id;
                    $prodeventstatus->group_id = $member->group_id;
                    $prodeventstatus->save();
                }
            }
        } else if ($request->team_select_event >= $request->member_select_event) {
            foreach ($request->team_select_event as $val_team) {
                $prodeventstatus = new ProdeventStatus;
                $prodeventstatus->group_id = $val_team;
                $prodeventstatus->prot_event_id = $prodcastevents->id;
                foreach ($request->member_select_event as $value_memebr) {
                    $prodeventstatus->user_id = $value_memebr;
                }
                $prodeventstatus->save();
            }
        } else {
            foreach ($request->member_select_event as $value_memebr) {
                $prodeventstatus = new ProdeventStatus;
                $prodeventstatus->user_id = $value_memebr;
                $prodeventstatus->prot_event_id = $prodcastevents->id;
                foreach ($request->team_select_event as $val_team) {
                    $prodeventstatus->group_id = $val_team;
                }
                $prodeventstatus->save();
            }
        }
        foreach (\App\Group::where('parent_id', 0)->get() as $admin) {
            $notify = new AdminNotification;
            $notify->type = 'broadcast_event';
            $notify->type_id = $prodcastevents->id;
            $notify->status = 0;
            $notify->user_id = auth()->user()->id;
            $notify->assigned_to = $admin->team_leader_id;
            $notify->save();
        }
        return ['status' => 'success'];
    }

    // public function get memebr
    public function get_member($id) {

        $member_id = explode(',', $id);

        $groups = Group::with('groupMembers')->whereIn('id', $member_id)->get();

        return $groups;
    }

    // function send note of event

    public function send_note(Request $request, $id) {
        $accpts = $request->accept;
        $status_event = ProdeventStatus::where('user_id', $id)->get();
        foreach ($status_event as $value) {
            $id_ev = $value->id;
            $status_event_chang = ProdeventStatus::find($id_ev);
            $status_event_chang->accept = $accpts;
            $status_event_chang->save();
        }
        return ['status' => 'work'];
    }

    public function events() {
        $events = ProdcastEvent::orderBy('id', 'DESC')->get();
        return view('admin.event_req', ['events' => $events]);
    }

    public function show_event($id) {
        $show_events = ProdeventStatus::where('prot_event_id', $id)->with('users_event')->get();
        return view('admin.show_event', ['show_events' => $show_events]);
    }

    public function getAgentNames(){
  		$leadObjects = [];
  		if(auth()->user()){
  			$leads = User::select('id','name')->get();
  			for($i=0;$i<count($leads);$i++){
  				$leadObjects[$i]['id'] = $leads[$i]->id;
  				$leadObjects[$i]['name'] = $leads[$i]->name;
  			}
  		}
  		return $leadObjects;
  	}

    public function getLeadName(){
  		$leadObjects = [];
  		if(auth()->user()){
  			$leads = Lead::select('id','first_name','last_name')->get();
  			for($i=0;$i<count($leads);$i++){
  				$leadObjects[$i]['id'] = $leads[$i]->id;
  				$leadObjects[$i]['name'] = $leads[$i]->first_name . " " . $leads[$i]->last_name;
  			}
  		}
  		return $leadObjects;
  	}
    public function getLeadsByAgentId(){
  		$agentsObjects = [];
  		$agents = Lead::where('agent_id',auth()->user()->id)
  		->select('id','first_name','last_name')->get();
  		for($i=0;$i<count($agents);$i++){
  			$agentsObjects[$i]['id'] = $agents[$i]->id;
  			$agentsObjects[$i]['name'] = $agents[$i]->first_name . " " . $agents[$i]->last_name;
  		}
  		return $agentsObjects;
      }
      
      public function submitview()
      {
          $locations = location::where("on_show",1)->select('id','en_name','ar_name')->get();
          $unitTypes = UnitType::where("on_show",1)->select()->get('id','ar_name','en_name');
          $setting = \App\setting::first();
          return view("website.submitPage",['setting' => $setting ,'locations' => $locations , 'unitTypes' => $unitTypes]);
      }

      public function DistrictsProject($lang,$district)
      {
          $title = $district.' projects';
          if($district == 'east'){
             $projects = project::where('location_id',3)->paginate(6);
          }
          elseif($district == 'west'){
            $projects = project::where('location_id',4)->paginate(6);
        }
          elseif($district == 'north'){
            $projects = project::where('location_id',5)->paginate(6);
          }
          elseif($district == 'redsea'){
            $projects = project::where('location_id',11)->orWhere('location_id',12)->orWhere('location_id',14)->orWhere('location_id',8)->paginate(10);
          }
          elseif($district == 'Newcapital'){
            $projects = project::orWhere('location_id',2)->paginate(6);
        }
          elseif($district == 'mostkblCity'){
            $projects = project::orWhere('location_id',28)->paginate(6);
        }
        $project = new ProjectController;
        $search = $this->search_info();
        $featured = $project->featured_project();
        return view('website.districtproject',['featured'=>$featured,'search'=>$search,'projects' => $projects,'title'=>$title]);
      }

      public function request_unit()
      {
        $units_type = UnitType::select('id','ar_name','en_name')->get();
        $projects = project::select('id','ar_name','en_name')->get();
        return view('website.request_units',['units_type'=>$units_type,'projects'=> $projects]);
      }
      public function add_request_unit(Request $request)
      {
        $data = $request->all();
        $rules = [
            'f_name' => 'required',
            'l_name' => 'required',
            'email' => 'required|email|unique:leads,email',
            'phone' => 'required|integer|unique:leads,phone',
            'password' => 'required|confirmed',
            'unitName_en' => 'required',
            'unit_en_description' => 'required',
            'price' => 'required',
            'unit_type_id' => 'required',
            'type_id' => 'required',
            'unit_type' => 'required',
            'size' => 'required',
            'room' => 'required',
            'bathroom' => 'required',
            'finish' => 'required',
            'view' => 'required',
            'project_id' => 'required',
            'location' => 'required',
            'en_address' => 'required',
        ];
        $messages = [
            'f_name.required' => trans('admin.f_name_req'),
            'l_name.required' => trans('admin.l_name_req'),
            'email.required'  => trans('admin.email_req'),
            'email.email'     => trans('admin.email_email'),
            'email.unique'     => trans('admin.email_unique'),
            'phone.required'  => trans('admin.phone_req'),
            'phone.integer'    => trans('admin.phone_num'),
            'phone.unique'    => trans('admin.phone_unique'),
            'password.required'    => trans('admin.pass_req'),
            'password.confirmed'    => trans('admin.password_con'),


            'price' => trans('admin.price_req'),
            'price.integer' => trans('admin.price_integer'),
            'unitName_en.required' => trans('admin.unit_name_en_req'),
            'unit_en_description.required' => trans('admin.unit_disc_en_req'),
            
            // 'image.required' => trans('admin.image_req'),
            // 'image.image' => trans('admin.image_img'),

            'unit_type_id.required' => trans('admin.unit_t_id_req'),
            'type_id.required'      => trans('admin.type_id_req'),
            'size.required' => trans('admin.size_choice'),
            'room.required' => trans('admin.room_choice'),
            'bathroom.required' => trans('admin.bathroom_choice'),
            'finish.required' => trans('admin.finish'),
            'view.required' => trans('admin.view_choioce'),
            'project_id.required' => trans('admin.project_id_req'),
            'location.required' => trans('admin.location'),
            'en_address.required' => trans('admin.en_address_req'),

        ];
        $Validator = Validator::make($data, $rules, $messages);
        if ($Validator->fails()) {
            return redirect()->back()->withErrors($Validator)->withInput(Input::all());
        } else {
            if(!empty($request->email)){
                $lead = new Lead;
                $lead->gender = $request->gender;
                $lead->first_name = $request->f_name;
                $lead->last_name = $request->l_name;
                $lead->full_name = $request->first_name.' '.$request->l_name;
                $lead->email = $request->email;
                $lead->phone = $request->phone;
                $lead->password = bcrypt($request->password);
                $lead->save();
            }
            if($request->unit_type == 'resale'){
                $resale = new ResaleUnit;
                $resale->en_title = $request->unitName_en;
                $resale->ar_title = $request->unitName_ar;
                $resale->en_description = $request->unit_en_description;
                $resale->ar_description = $request->unit_ar_description;
                $resale->type = $request->type_id;
                $resale->unit_type_id = $request->unit_type_id;
                $resale->price = $request->price;
                $resale->area = $request->size;
                $resale->rooms = $request->room;
                $resale->bathrooms = $request->bathroom;
                $resale->finishing = $request->finish;
                $resale->view = $request->view;
                $resale->project_id = $request->project_id;
                $resale->youtube_link = $request->video;
                $resale->location = $request->location;
                $resale->lng = $request->lng;
                $resale->lat = $request->lat;
                $resale->zoom = $request->zoom;
                $resale->lead_id = $lead->id;
                $resale->status = 'pending';
                if($request->image){
                    $filenameWithExt = $request->file('image')->getClientOriginalName();
                    // get just fill name
                    $filename = pathinfo($filenameWithExt , PATHINFO_FILENAME);
                    // get file ext
                    $extension = $request->file('image')->getClientOriginalExtension();
                    // file name to store
                    $fileNameToStore= $filename.'_'.time().'.'.$extension;
                    // upload image
                    // $public_path = public_path('/images/eventImages');
                    $destinationPath = 'uploads/resale_unit';
                    $path = $destinationPath.'/'.$fileNameToStore;
                    $upload = $request->file('image')->move($destinationPath,$fileNameToStore);
                    $resale->image = $path;
                }
                $resale->save();
            }elseif($request->unit_type == 'rental'){
                $rental = new RentalUnit;
                $rental->en_title = $request->unitName_en;
                $rental->ar_title = $request->unitName_ar;
                $rental->en_description = $request->unit_en_description;
                $rental->ar_description = $request->unit_ar_description;
                $rental->type = $request->type_id;
                $rental->unit_type_id = $request->unit_type_id;
                $rental->rent = $request->price;
                $rental->area = $request->size;
                $rental->rooms = $request->room;
                $rental->bathrooms = $request->bathroom;
                $rental->finishing = $request->finish;
                $rental->view = $request->view;
                $rental->project_id = $request->project_id;
                $rental->youtube_link = $request->video;
                $rental->location = $request->location;
                $rental->lng = $request->lng;
                $rental->lat = $request->lat;
                $rental->zoom = $request->zoom;
                $rental->lead_id = $lead->id;
                $rental->status = 'pending';
                if($request->image){
                    $filenameWithExt = $request->file('image')->getClientOriginalName();
                    // get just fill name
                    $filename = pathinfo($filenameWithExt , PATHINFO_FILENAME);
                    // get file ext
                    $extension = $request->file('image')->getClientOriginalExtension();
                    // file name to store
                    $fileNameToStore= $filename.'_'.time().'.'.$extension;
                    // upload image
                    // $public_path = public_path('/images/eventImages');
                    $destinationPath = 'uploads/resale_unit';
                    $path = $destinationPath.'/'.$fileNameToStore;
                    $upload = $request->file('image')->move($destinationPath,$fileNameToStore);
                    $rental->image = $path;
                }
                $rental->save();
            }
        }
        return back()->with('success',trans('admin.thank_you'));
    }
      public function Showcareers()
      {
          $vacancy = DB::table('vacancies as v')
          ->leftjoin('job_titles as j','v.job_title_id','=','j.id')
          ->select('v.id as id','v.en_name','v.ar_name','v.status','v.en_description','v.ar_description','type','v.created_at','v.updated_at','j.en_name as job_en_name','j.ar_name as job_ar_name')
          ->where('v.status',0)
          ->paginate(9);
          return view('website.careers',['data' => $vacancy]);
      }
      public function intrest_job($lang,$id)
      {
        $vacancy = DB::table('vacancies as v')
        ->leftjoin('job_titles as j','v.job_title_id','=','j.id')
        ->leftjoin('job_categories as cat','j.job_category_id','=','cat.id')
        ->select('v.id as id','v.en_name','v.ar_name','v.status','v.en_description','v.ar_description','type','v.created_at','v.updated_at','j.en_name as job_en_name','j.ar_name as job_ar_name','j.id as title_id','cat.id as category_id','cat.en_name as cat_name_en','cat.ar_name as cat_name_ar')
        ->where('v.id',$id)
        ->first();
          return view('website.intrest_jobs',['data' => $vacancy]);
      }
      public function storeApp(Request $request)
      {
        $data = $request->all();
        $rules = [
            'f_name' => 'required',
            'l_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'location' => 'required',
            'website' => 'required',
            'linkprofile' => 'required',
        ];
        $messages = [
            'f_name.required' => trans('admin.f_name'),
            'l_name.required' => trans('admin.l_name'),
            'email.required' => trans('admin.email'),
            'email.email' => trans('admin.email'),
        ];
        $Validator = Validator::make($data, $rules, $messages);
        if ($Validator->fails()) {
            return redirect()->back()->withErrors($Validator)->withInput(Input::all());
        } else {
                $application = new \App\Application();

                if ($request->hasfile('cv')) {
                    // get file name with ext
                    $filenameWithExt = $request->file('cv')->getClientOriginalName();
                    // get just fill name
                    $filename = pathinfo($filenameWithExt , PATHINFO_FILENAME);
                    // get file ext
                    $extension = $request->file('cv')->getClientOriginalExtension();
                    // file name to store
                    $fileNameToStore= $filename.'_'.time().'.'.$extension;
                    // upload cv
                    $destinationPath = 'uploads';
                    $spath = "CVs";
                    $mixpath = $destinationPath.'/'.$spath;
                    $path = $spath.'/'.$fileNameToStore;
                    $upload = $request->file('cv')->move($mixpath,$fileNameToStore);
                    $application->cv = $path;
                }
                $application->first_name = $request->f_name;
                $application->last_name = $request->l_name;
                $application->email = $request->email;
                $application->phone = $request->phone;
                $application->location = $request->location;
                $application->linkedin = $request->linkprofile;
                $application->website = $request->website;
                $application->vacancy_id = $request->vacancy_id;
                $application->job_title_id = $request->job_title_id;
                $application->job_category_id = $request->job_category_id;
                $application->applied_date = $request->created_at;
                $application->save();
            // $application->acceptness = 
        }
            return back()->with('success',trans('admin.thank_you'));
      }
      public function all_developers()
      {
          $developers = \App\Developer::paginate(8);
          return view('website.all_developers',['developers' => $developers]);
      }
      public function testpopup()
      {
          return view('website.testpop');
      }
      public function getMasterView(){
            return view('admin.master');
      }
      public function changeAssistantStatus(Request $request){
        //   dd($request->all());
          $changeStatus = User::where('id',Auth::user()->id)->first();
          if($request->on_show == 'hide')
            $changeStatus->assistant = 1; // for change status to hide
          else{
            $changeStatus->assistant = 0; // for change status to show
        }
          $changeStatus->update();
          return 'changed';
      }
      public function getUserHowLogin(){
        $User = User::where('id',Auth::user()->id)->first();
        return response()->json($User);
      }

      public function filterIncomeFinances(Request $request){

            // return($request);
            $incomes = DB::table('incomes as income')
                    ->leftjoin('banks','income.bank_id','=','banks.id');
                    
            if($request->fromDate && $request->fromDate != null && $request->toDate && $request->toDate != null){

                $from = date('Y-m-d', strtotime($request->fromDate));
                $to = date('Y-m-d', strtotime($request->toDate));
                $incomes = $incomes->whereBetween('income.date', [$from, $to]);
            }

            $incomes = $incomes->select('banks.name as bankName','income.id','income.name','income.description','income.payment_method'
                    ,'income.value','income.date','income.source','income.status')
                    ->get();       
        
            return $incomes;
       }
     
       public function filterOutcomeFinances(Request $request){
          
            // return($request);
            $outcomes = DB::table('outcomes as outcome')
                    ->leftjoin('banks','outcome.bank_id','=','banks.id');
                    
            if($request->fromDate && $request->fromDate != null && $request->toDate && $request->toDate != null){

                $from = date('Y-m-d', strtotime($request->fromDate));
                $to = date('Y-m-d', strtotime($request->toDate));
                $outcomes = $outcomes->whereBetween('outcome.date', [$from, $to]);
            }

            $outcomes = $outcomes->select('banks.name as bankName','outcome.id','outcome.name','outcome.description','outcome.payment_method'
                    ,'outcome.value','outcome.date','outcome.status')
                    ->get();       
        
            return $outcomes;
   }

}
