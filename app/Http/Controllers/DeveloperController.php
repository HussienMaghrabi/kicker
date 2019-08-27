<?php

namespace App\Http\Controllers;

use App\Competitor;
use App\Developer;
use App\DeveloperContact;
use App\Project;
use Auth;
use Illuminate\Http\Request;
use Validator;
use DB;
use Excel;
use File;
use Carbon\Carbon;


class DeveloperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (checkRole('show_developers') or @auth()->user()->type == 'admin') {
            $developer = Developer::all();
            return view('admin.developers.dev', ['title' => trans('admin.all') . ' ' . trans('admin.developers'), 'developer' => $developer]);
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
        if (checkRole('add_developers') or @auth()->user()->type == 'admin') {
            return view('admin.developers.create', ['title' => trans('admin.add') . ' ' . trans('admin.developer')]);
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
            'en_name' => 'required|max:191',
            'en_description' => 'required',
            'logo' => 'required|image',
            'phone' => 'required|numeric',
            'email' => 'required|email|max:191',
            'xls' => 'file|max:500|mimeTypes:' .
                'application/vnd.ms-office,' .
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,' .
                'application/vnd.ms-excel',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'name' => trans('admin.name'),
            'en_description' => trans('admin.description'),
            'logo' => trans('admin.logo'),
            'phone' => trans('admin.phone'),
            'email' => trans('admin.email'),
            'xls' => trans('admin.xls'),
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            if ($request->hasFile('logo')) {
                $developer = new Developer;
                $developer->en_name = $request->en_name;
                $developer->en_description = $request->en_description;
                $developer->ar_name = $request->ar_name;
                $developer->phone = $request->ar_name;
                $developer->ar_name = $request->ar_name;
                $developer->phone = $request->phone;
                $developer->email = $request->email;
                $developer->ar_description = $request->ar_description;
                $developer->facebook = $request->facebook;
                $developer->featured = $request->featured;
                // $developer->mail_temp = $request->mail_temp;
                $developer->logo = uploads($request, 'logo');
                $developer->website_cover = uploads($request, 'website_cover');
                $developer->user_id = Auth::user()->id;
                // for ($i = 0; $i < count($request->contact_name); $i++) {
                //     $contact = new DeveloperContact;
                //     $contact->developer_id = $developer->id;
                //     $contact->name = $request->contact_name[$i];
                //     $contact->email = $request->contact_email[$i];
                //     $contact->phone = $request->contact_phone[$i];
                //     $contact->save();
                // }
                if ($request->hasFile('xls')) {
                    $developer->xls_url = uploads($request, 'xls');
                }
                $developer->save();
            } else {
                return back()->withInput()->withErrors('uploaded invalid logo');
            }

            session()->flash('success', trans('admin.created'));

            $old_data = json_encode($developer);
            LogController::add_log(
                __('admin.created', [], 'ar') . ' ' . $developer->ar_name,
                __('admin.created', [], 'en') . ' ' . $developer->en_name,
                'developers',
                $developer->id,
                'create',
                auth()->user()->id,
                $old_data
            );
            
            return response()->json([
                "status"=>"ADDED"
            ],200);
            // return redirect(adminPath() . '/developers');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Developer $developer
     * @return \Illuminate\Http\Response
     */
    public function show(Developer $developer)
    {
        // return view('admin.developers.edit', ['title' => trans('admin.all') . ' ' . trans('admin.developers'), 'developer' => $developer]);        
        if (checkRole('show_developers') or @auth()->user()->type == 'admin') {
            return response()->json($developer);
        } else {
            return response()->json("Error : you dont have permission!!");            
        }
    }

    public function website_show($lang, $id)
    {
        // $index = explode('-', $id);
        // $developer = Developer::find(end($index));
        // return view('website.developer', ['developer' => $developer]);
        $index = explode('-', $id);
        $Newid = end($index);
        $developer = Developer::find(end($index));

        $resale = DB::table("resale_units as resale")
            ->leftjoin("projects as project", "resale.project_id", "=", "project.id")
            ->leftjoin("developers as developer", "project.developer_id", "=", "developer.id")
            ->where("developer.id", $Newid)
            ->select("project.id as id", "project.cover", "project.meter_price", "project.en_name", "project.ar_name", "project.created_at", "location_id", "project.logo")
            ->groupBy("project.id")
            ->limit(3)
            ->get();

        $rental = DB::table("rental_units as rent")
            ->leftjoin("projects as project", "rent.project_id", "=", "project.id")
            ->leftjoin("developers as developer", "project.developer_id", "=", "developer.id")
            ->where("developer.id", $Newid)
            ->select("project.id as id", "project.cover", "project.meter_price", "project.en_name", "project.ar_name", "project.created_at", "location_id", "project.logo")
            ->groupBy("project.id")
            ->limit(3)
            ->get();

        $projects = project::where("developer_id", $Newid)->select("id", "cover", "logo", "meter_price", "en_name", "ar_name", "created_at", "location_id")->limit(3)
            ->get();

        return view('website.developerTest', ['developer' => $developer, 'resaleprojects' => $resale, 'rentals' => $rental, 'projects' => $projects]);
    }
    public function website_showPage($lang, $id)
    {
        $index = explode('-', $id);
        $Newid = end($index);
        $developer = Developer::find(end($index));

        $resale = DB::table("resale_units as resale")
        ->leftjoin("projects as project","resale.project_id","=","project.id")
        ->leftjoin("developers as developer","project.developer_id","=","developer.id")
        ->where("developer.id",$Newid)
        ->select("project.id as id","project.cover","project.meter_price","project.area","project.installment_year","project.delivery_date","project.down_payment","project.en_name","project.ar_name","project.created_at","location_id","project.logo")
        ->groupBy("project.id")
        ->get();
        $rental = DB::table("rental_units as rent")
        ->leftjoin("projects as project","rent.project_id","=","project.id")
        ->leftjoin("developers as developer","project.developer_id","=","developer.id")
        ->where("developer.id",$Newid)
        ->select("project.id as id","project.cover","project.meter_price","project.area","project.installment_year","project.delivery_date","project.down_payment","project.en_name","project.ar_name","project.created_at","location_id","project.logo")
        ->groupBy("project.id")
        ->get();

        $projects = project::where("developer_id",$Newid)
        ->select("id as id","cover","meter_price","area","installment_year","delivery_date","down_payment","en_name","ar_name","created_at","location_id","logo")
        ->get();

        return view('website.developerTest', ['developer' => $developer,'resaleprojects'=>$resale,'rentals' => $rental , 'projects'=>$projects]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Developer $developer
     * @return \Illuminate\Http\Response
     */
    public function edit(Developer $developer)
    {
        if (checkRole('edit_developers') or @auth()->user()->type == 'admin') {
            return view('admin.developers.edit', ['title' => trans('admin.developer'), 'developer' => $developer]);
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Developer $developer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $developer = Developer::find($id);
        // return $developer;
        if (checkRole('delete_developers') or @auth()->user()->type == 'admin') {
            $old_data = json_encode($developer);
            LogController::add_log(
                __('admin.deleted', [], 'ar') . ' ' . __('admin.proposal', [], 'ar'),
                __('admin.deleted', [], 'en') . ' ' . __('admin.proposal', [], 'en'),
                'developers',
                $developer->id,
                'delete',
                auth()->user()->id,
                $old_data
            );

            $file_path = url('/uploads/' . $developer->logo);
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            DeveloperContact::where('developer_id', $developer->id)->delete();
            $developer->delete();
            return response()->json("Developer Deleted Successfully!!");
        } else {
            return response()->json("Error , you dont have permission!!");            
        }
    }

    public function projects_facebook()
    {
        if (checkRole('marketing') or @auth()->user()->type == 'admin') {
            $projects = Project::where('featured', 1)->get();
            $data = [];
            foreach ($projects as $project) {
                $data[] = self::get_facebook_posts($project->facebook);
            }
            return view('admin.developers.facebook', ['data' => $data]);
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return back();
        }
    }

    public function developers_facebook()
    {
        if (checkRole('marketing') or @auth()->user()->type == 'admin') {
            $developers = Developer::where('featured', 1)->get();
            $data = [];
            foreach ($developers as $developer) {
                $data[] = self::get_facebook_posts($developer->facebook);
            }
            return view('admin.developers.facebook', ['data' => $data]);
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return back();
        }
    }

    public function competitors_facebook()
    {
        if (checkRole('marketing') or @auth()->user()->type == 'admin') {
            $competitors = Competitor::where('featured', 1)->get();
            $data = [];
            foreach ($competitors as $competitor) {
                $data[] = self::get_facebook_posts($competitor->facebook);
            }
            return view('admin.developers.facebook', ['data' => $data]);
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return back();
        }
    }

    public function get_facebook_posts($page)
    {
        if (checkRole('marketing') or @auth()->user()->type == 'admin') {
            $response = null;
            require_once base_path() . '/vendor/autoload.php';
            $fb = new \Facebook\Facebook([
                'app_id' => '349245955813674',
                'app_secret' => '089007a225b9730c9bc0bba4699a1a7f',
            ]);
            try {
                // Returns a `FacebookFacebookResponse` object
                $response = $fb->get(
                    '/' . $page . '?fields=posts.limit(10){full_picture,message,created_time,attachments{subattachments}},picture{url},name',
                    '349245955813674|089007a225b9730c9bc0bba4699a1a7f'
                );
            } catch (\Facebook\Exceptions\FacebookExceptionsFacebookResponseException $e) {
                die('Caught exception: ' .  $e->getMessage() . "\n");
            } catch (\Facebook\Exceptions\FacebookExceptionsFacebookSDKException $e) {
                die('Caught exception: ' .  $e->getMessage() . "\n");
            } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                die('Caught exception: ' .  $e->getMessage() . "\n");
            }
            if ($response != null) {
                $graphNode = $response->getGraphNode();
            } else {
                $graphNode = '';
            }
            $data = json_decode($graphNode);
            return $data;
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return back();
        }
    }

    public function getDevelopers()
    {
        $developers = Developer::all();
        return response()->json([
            'data' => $this->devcolection($developers),
        ]);
    }
    private function devcolection($pram)
    {
        return array_map([$this, 'returndev'], $pram->toArray());
    }
    private function returndev($pram)
    {
        return [
            'id' => $pram['id'],
            'name' => $pram['en_name']
        ];
    }

    public function updateDeveloper(Request $request,Developer $developer){
        $rules = [
            'en_name' => 'required|max:191',
            'en_description' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email|max:191',
            // 'xls' => 'file|max:1000' .
            //     'application/vnd.ms-office,' .
            //     'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,' .
            //     'application/vnd.ms-excel',
        ];

        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'name' => trans('admin.name'),
            'en_description' => trans('admin.description'),
            'image' => trans('admin.logo'),
            'phone' => trans('admin.phone'),
            'email' => trans('admin.email'),
            // 'xls' => trans('admin.xls'),
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $old_data = json_encode($developer);
            $file_path = 'uploads/' . $developer->logo;
            // return 'sheno';
            if ($request->hasFile('image')) {
                if ($request->file('image')->isValid()) {
                    if (file_exists($file_path)) {
                        @unlink($file_path);
                    }
                    $developer->logo = uploads($request, 'image');
                }
            }
            if ($request->has('website_cover')) {
                $file_path2 = 'uploads/' . $developer->website_cover;
                if ($request->hasFile('website_cover')) {
                    if ($request->file('website_cover')->isValid()) {
                        if (file_exists($file_path2)) {
                            @unlink($file_path2);
                        }
                        $developer->website_cover = uploads($request, 'website_cover');
                    }
                }
            } else {
                $developer->website_cover = $request->old_website_cover;
            }
            $developer->en_name = $request->en_name;
            $developer->en_description = $request->en_description;
            $developer->ar_name = $request->ar_name;
            $developer->ar_description = $request->ar_description;
            $developer->phone = $request->phone;
            $developer->email = $request->email;
            $developer->facebook = $request->facebook;
            $developer->featured = $request->featured;
            $developer->cil_expire_date = $request->cil_expire_date;
            $developer->message = $request->message;
            $file_path2 = 'uploads/' . $developer->xls_url;
            if ($request->hasFile('xls')) {
                $extension = File::extension($request->xls->getClientOriginalName());
                $path = $request->xls->getRealPath();
                $publicPath = 'uploads/' . explode('/', $path)[2] . '.' . $extension;
                if ($extension == "xls" || $extension == "xlsx" || $extension == "csv") {
                    if ($request->file('xls')->isValid()) {
                        if (file_exists($publicPath)) {
                            @unlink($publicPath);
                        }
                    }
                    $data = Excel::load($path, function ($reader) { })->store($extension, 'uploads/');
                } else {
                    if ($request->file('xls')->isValid()) {
                        if (file_exists($publicPath)) {
                            @unlink($publicPath);
                        }
                    }
                    if ($extension == "doc") {
                        $phpWord = \PhpOffice\PhpWord\IOFactory::load($path, 'MsDoc');
                    } else if ($extension == "rtf") {
                        $phpWord = \PhpOffice\PhpWord\IOFactory::load($path, 'RTF');                    
                    } else if ($extension == "docx") {
                        $phpWord = \PhpOffice\PhpWord\IOFactory::load($path);                        
                    }
                    ob_clean();
                    $phpWord->save($publicPath);
                }
                $developer->xls_url = $publicPath;
            }
            $developer->mail_temp = $request->mail_temp;
            $developer->save();
            DeveloperContact::where('developer_id', $developer->id)->delete();
            if($request->contacts){
                foreach($request->contacts as $requestContact) {
                    $requestContact = json_decode($requestContact);
                    $contact = new DeveloperContact;
                    $contact->developer_id = $developer->id;
                    $contact->name = $requestContact->contact_name;
                    $contact->email = $requestContact->contact_email;
                    $contact->phone = $requestContact->contact_phone;
                    $contact->save();
                }
            }

            $new_data = json_encode($developer);
            LogController::add_log(
                __('admin.updated', [], 'ar') . ' ' . $developer->ar_name,
                __('admin.updated', [], 'en') . ' ' . $developer->en_name,
                'developers',
                $developer->id,
                'update',
                auth()->user()->id,
                $old_data,
                $new_data
            );
            return response()->json("Developer Updated Successfully!!");
        }
    }
}
