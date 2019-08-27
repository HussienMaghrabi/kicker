<?php

namespace App\Http\Controllers;

use App\LayoutImage;
use App\Phase;
use App\Phase_Facilities;
use App\PriceHistory;
use App\Project;
use App\Property;
use App\Property_images;
use Auth;
use Illuminate\Http\Request;
use Validator;
use DB;
use Carbon\Carbon;

class PhaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (checkRole('show_phases') or @auth()->user()->type == 'admin') {
            $phase = Phase::all();
            return view('admin.phases.index', ['title' => trans('admin.all') . ' ' . trans('admin.phases'), 'phase' => $phase]);
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
    public function create($id)
    {
        if (checkRole('add_phases') or @auth()->user()->type == 'admin') {
            $project = Project::find($id);
            if (null == $project) {
                return redirect('admin');
            }

            return view('admin.phases.create', ['title' => trans('admin.phases'), 'project' => $project]);
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request

     * public function store(Request $request)
     * {
     * $phase_id = $this  kjjkk kn->store_phase($request);
     * $this->store_facility($phase_id, $request);
     * return redirect(adminPath() . '/phases/' . $phase_id);
     * }
     *
     * /**
     * Display the specified resource.
     *
     * @param  \App\Phase $phase
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (checkRole('show_phases') or @auth()->user()->type == 'admin') {
            $phase = Phase::find($id);
            if (null == $phase) {
                return response()->json("There is no Phase with this id");
            }

            $properties = DB::table('properties as property')
                                ->leftjoin('unit_types as type','property.unit_id','=','type.id')
                                ->where('phase_id', $phase->id)
                                ->select('property.id','property.'.app()->getLocale().'_name as name','type.'.app()->getLocale().'_name as type','property.start_price')
                                ->get();
            $facilities = DB::table('phase__facilities as pf')
                                ->join('facilities as facility','pf.facility_id','=','facility.id')
                                ->where('phase_id', $id)->select('facility.id','facility.'.app()->getLocale().'_name as name')->get();
            return response()->json([
                'phase' => $phase,
                'properties' => $properties,
                'facilities' => $facilities
            ]);
            // return view('admin.phases.addproperty', ['title' => trans('admin.phase'), 'phase' => $phase, 'property' => $properties
            //     , 'facilities' => $facilities]);
        } else {
            return response()->json('Error: You dont have permission!!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Phase $phase
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (checkRole('edit_phases') or @auth()->user()->type == 'admin') {
            $phase = Phase::find($id);
            return view('admin.phases.edit', ['title' => trans('admin.edit') . ' ' . trans('admin.phase'), 'data' => $phase]);
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Phase $phase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $phase = Phase::find($id);
        $rules = [
            'en_name' => 'required|max:191',
            'ar_name' => 'required|max:191',
            'meter_price' => 'required|numeric',
            'area' => 'required|numeric',
            'facility' => 'required',
            'delivery_date' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'en_name' => trans('admin.name'),
            'ar_name' => trans('admin.name'),
            'meter_price' => trans('admin.meter_price'),
            'area' => trans('admin.area'),
            'facility' => trans('admin.facility'),
            'delivery_date' => trans('admin.delivery_date'),
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $phase->en_name = $request->en_name;
            $phase->ar_name = $request->ar_name;
            $phase->en_description = $request->en_description;
            $phase->ar_description = $request->ar_description;
            $phase->meter_price = $request->meter_price;
            $phase->area = $request->area;
            $date = Carbon::createFromFormat('D M d Y H:i:s e+',$request->delivery_date);
            $phase->delivery_date = Carbon::parse($date)->format('Y');
            $phase->meta_keywords = $request->meta_keywords;
            $phase->meta_description = $request->meta_description;
            $phase->save();
            Phase_Facilities::where('phase_id', $phase->id)->delete();
            $this->store_facility($phase->id, $request);

            $old_data = json_encode($phase);
            LogController::add_log(
                __('admin.updated', [], 'ar') . ' ' . $phase->ar_name,
                __('admin.updated', [], 'en') . ' ' . $phase->en_name,
                'phases/show',
                $phase->id,
                'update',
                auth()->user()->id,
                $old_data
            );

            return response()->json('Phase Updated Successfully!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Phase $phase
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request,$id)
    {
        if (checkRole('delete_phases') or @auth()->user()->type == 'admin') {
            $phase = Phase::find($id);
            if (null == $phase) {
                return response()->json('There is no Phase with this id');
            }

            $properties = Property::where('phase_id', $phase->id)->get();
            foreach ($properties as $property) {
                $images = Property_images::where('property_id', $property->id)->get();
                $layout = LayoutImage::where('property_id', $property->id)->get();
                foreach ($images as $image) {
                    if (@$image->images && file_exists('uploads/' . $image->images)) {
                        unlink('uploads/' . $image->images);
                    }
                }
                $pi = Property_images::where('property_id', $property->id);
                if ($pi) {
                    $pi->delete();
                }
                foreach ($layout as $image) {
                    if (@$image->images && file_exists('uploads/' . $image->images)) {
                        unlink('uploads/' . $image->images);
                    }
                }
                $lo = LayoutImage::where('property_id', $property->id);
                if ($lo) {
                    $lo->delete();
                }
                Property::destroy($property->id);
            }
            Phase::destroy($phase->id);
            return response()->json("Phase Deleted Successfully!!");
        } else {
            return response()->json("Error: You dont have permission!!");            
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'en_name' => 'required|max:191',
            'ar_name' => 'required|max:191',
            'meter_price' => 'required|numeric',
            'area' => 'required|numeric',
            'facility' => 'required',
            'project_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'en_name' => trans('admin.name'),
            'ar_name' => trans('admin.name'),
            'meter_price' => trans('admin.meter_price'),
            'area' => trans('admin.area'),
            'facility' => trans('admin.facility'),
        ]);
        if ($validator->fails()) {
            return response()->json("Validation Error: Please Check the required Inputs");
        } else {
            if ($request->hasFile('logo')) {
                if ($request->hasFile('promo')) {
                    $phase = new Phase;
                    $phase->en_name = $request->en_name;
                    $phase->ar_name = $request->ar_name;
                    $phase->en_description = $request->en_description;
                    $phase->ar_description = $request->ar_description;
                    $phase->meter_price = $request->meter_price;
                    $phase->area = $request->area;
                    $phase->meta_keywords = $request->meta_keywords;
                    $phase->meta_description = $request->meta_description;
                    $phase->project_id = $request->project_id;
                    $phase->logo = uploads($request, 'logo');
                    $phase->promo = uploads($request, 'promo');
                    $phase->user_id = auth()->user()->id;
                    $phase->delivery_date = $request->delivery_date;
                    $phase->save();
                    $this->store_facility($phase->id, $request);
                } else {
                    return response()->json("uploaded invalid promo");
                }
            } else {
                return response()->json('uploaded invalid logo');
            }
        }
        return response()->json('Phase Created Successfully!!');
    }

    private function store_facility($id, $request)
    {
        for ($i = 0; $i < count($request->facility); $i++) {
            $facility = $request->facility[$i];
            $pf = new Phase_Facilities();
            $pf->phase_id = $id;
            $pf->facility_id = $request->facility[$i];
            $pf->save();
        };
    }

    private function property_item($index, $id, $request)
    {
        $rules['code.' . $index] = 'required|max:191';
        $rules['en_name.' . $index] = 'required|max:191';
        $rules['ar_name.' . $index] = 'required|max:191';
        $rules['unit_id.' . $index] = 'required';
        $rules['start_price.' . $index] = 'required|numeric|min:0';
        $rules['meter_price.' . $index] = 'numeric|min:0';
        $rules['area_from.' . $index] = 'required|numeric|min:0';
        $rules['area_to.' . $index] = 'numeric';
        $rules['type.' . $index] = 'required';
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'code.' . $index => trans('admin.code'),
            'unit_id.' . $index => trans('admin.unit_type'),
            'start_price.' . $index => trans('admin.start_price'),
            'area_from.' . $index => trans('admin.area_from'),
            'area_to.' . $index => trans('admin.area_to'),
            'type.' . $index => trans('admin.type'),
        ]);
        if ($validator->fails()) {
            return $validator;
        } else {

            $property = new Property;
            $property->code = $request->code[$index];
            $property->phase_id = $id;
            $property->en_name = $request->en_name[$index];
            $property->ar_name = $request->ar_name[$index];
            $property->unit_id = $request->unit_id[$index];
            $property->start_price = $request->start_price[$index];
            $property->meter_price = $request->meter_price[$index];
            $property->area_from = $request->area_from[$index];
            $property->area_to = $request->area_to[$index];
            $property->en_description = $request->en_description[$index];
            $property->ar_description = $request->ar_description[$index];
            $property->type = $request->type[$index];
            if (null != $request->main) {
                $name = rand(0, 99999999999) . '.' . $request->main[$index]->getClientOriginalExtension();
                $request->main[$index]->move("uploads", $name);
                $property->main = $name;
            }
            $property->user_id = Auth::user()->id;
            $property->save();
            $price = new PriceHistory;
            $price->price = $request->start_price[$index];
            $price->property_id = $property->id;
            $price->save();

            if (null != $request->images) {
                if (count($request->images[$index])) {
                    $this->store_images($index, $property->id, $request);
                }
            }
            if (null != $request->layout) {
                if (count($request->layout[$index])) {
                    $this->store_layout($index, $property->id, $request);
                }
            }

            return 'done';
        }
    }

    public function store_property(Request $request)
    {
        if (null != $request->images) {
            $request->images = array_values($request->images);
            $request->layout = array_values($request->layout);
        }
        $id = $request->phase_id;
        $failed = 0;
        $failedmessage = '';
        for ($i = 0; $i < count($request->unit_id); $i++) {
            $validator = $this->property_item($i, $id, $request);
            if ('done' != $validator) {
                $failed++;
                $failedmessage = $validator;
                session()->flash('propertyErrors', $failed);
            } else {
                session()->flash('propertySuccess', count($request->unit_id) - $failed);
            }
        }
        if ($failed < 1) {
            return back();
        }

        return back()->withErrors($failedmessage);
    }

    private function store_images($index, $id, $request)
    {
        $files = $request->images[$index];
        foreach ($files as $file) {
            $images = new Property_images;
            $rules = ['images' => 'required|image|mimes:jpeg,jpg,png'];
            $validator = Validator::make(['images' => $file], $rules);
            if ($validator->passes()) {
                $name = rand(0, 99999999999) . '.' . $file->getClientOriginalExtension();
                $file->move("uploads", $name);
                $images->images = $name;
                $images->property_id = $id;
                $images->save();
            }
        }
    }

    private function store_layout($index, $id, $request)
    {
        $files = $request->layout[$index];
        foreach ($files as $file) {
            $images = new LayoutImage;
            $rules = ['layout' => 'required|image|mimes:jpeg,jpg,png'];
            $validator = Validator::make(['layout' => $file], $rules);
            if ($validator->passes()) {
                $name = rand(0, 99999999999) . '.' . $file->getClientOriginalExtension();
                $file->move("uploads", $name);
                $images->image = $name;
                $images->property_id = $id;
                $images->save();
            }
        }
    }

    public function website_show_phase($lang,$id)
    {
        $phase = Phase::find($id);
        $s = new HomeController();
        $search = $s->search_info();
        $project = new ProjectController;
        $featured = $project->featured_project();
        return view('website.phase', ['phase' => $phase, 'search' => $search, 'featured' => $featured]);
    }

    public function getPhases(){
        return DB::table('phases')->select('id',app()->getLocale().'_name as name')->get();
    }

    public function getPhaseFacilities(Request $request){
        $facilities = DB::table('phase__facilities as pf')
                                ->join('facilities as facility','pf.facility_id','=','facility.id')
                                ->where('phase_id', $request->phase_id)->select('facility.id','facility.'.app()->getLocale().'_name as name')->get();
        return $facilities;
    }
}
