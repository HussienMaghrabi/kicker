<?php

namespace App\Http\Controllers;

use App\LayoutImage;
use App\PriceHistory;
use App\Property;
use App\PropertyFacility;
use App\Property_images;
use Auth;
use Illuminate\Http\Request;
use Validator;
use DB;
use File;


class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (checkRole('show_properties') or @auth()->user()->type == 'admin') {
            $sources = Property::all();
            return view('admin.properties.index', ['title' => trans('admin.all') . ' ' . trans('admin.properties'), 'property' => $sources]);
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
        if (checkRole('add_properties') or @auth()->user()->type == 'admin') {
            return view('admin.properties.create', ['title' => trans('admin.add') . ' ' . trans('admin.property')]);
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
            'unit_id' => 'required',
            'start_price' => 'required|numeric|min:0',
            'area_from' => 'required|numeric|min:0',
            // 'facility' => 'required',
            'area_to' => 'numeric|min:' . $request->area_from . '',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'unit_id' => trans('admin.unit_type'),
            'start_price' => trans('admin.start_price'),
            'area_from' => trans('admin.area_from'),
            'area_to' => trans('admin.area_to'),
            // 'facility' => trans('admin.facility'),
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $property = new Property;
            $property->en_name = $request->en_name;
            $property->ar_name = $request->ar_name;
            $property->unit_id = $request->unit_id;
            $property->start_price = $request->start_price;
            $property->meter_price = $request->meter_price;
            $property->area_from = $request->area_from;
            $property->area_to = $request->area_to;
            $property->en_description = $request->en_description;
            $property->ar_description = $request->ar_description;
            $property->phase_id = $request->phase_id;
            $property->portal_id = $request->portal_id;

            if ($request->has('main_image')) {
                $extension = File::extension($request->main_image->getClientOriginalName()); 
                $name =  rand(0, 99999999999) . '.' . $extension;
                $property->main = $name;
				$request->file('main_image')->storeAs('uploads',$name);
			}
            $property->user_id = Auth::user()->id;
            $property->save();

            $old_data = json_encode($property);
            LogController::add_log(
                __('admin.created', [], 'ar') . ' ' . __('admin.property', [], 'ar'),
                __('admin.created', [], 'en') . ' ' . __('admin.property', [], 'en'),
                'properties',
                $property->id,
                'create',
                auth()->user()->id,
                $old_data
            );
            if($request->images){
                for ($i = 0; $i < count($request->images); $i++) {
                    $ss = uploads($request, 'images.' . $i);
                    if (null != $ss) {
                        $images = new Property_images;
                        $images->images = $ss;
                        $images->property_id = $property->id;
                        $images->save();
                    }
                }
            }
            // if($request->facility){
            //     for ($i = 0; $i < count($request->facility); $i++) {
            //         $pc = new PropertyFacility();
            //         $pc->property_id = $property->id;
            //         $pc->facility_id = $request->facility[$i];
            //         $pc->save();
            //     }
            // }
            return response()->json('Property Saved Successfully!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        if (checkRole('show_properties') or @auth()->user()->type == 'admin') {
            $images = Property_images::where('property_id', $property->id)->get();
            $layout = LayoutImage::where('property_id', $property->id)->get();
            $prices = PriceHistory::where('property_id', $property->id)->orderByRaw('created_at DESC')->get();
            $unitTypes = DB::table('unit_types')->select('id',app()->getLocale().'_name as name')->get();
            $property->propertyType = DB::table('unit_types')->where('id',$property->unit_id)->value(app()->getLocale().'_name as name');

            return response()->json([
                'images' => $images,
                'layout' => $layout,
                'prices' => $prices,
                'unitTypes' => $unitTypes,
                'property' => $property
            ]);
            // return view('admin.properties.show', ['title' => trans('admin.show') . ' ' . trans('admin.property'), 'images' => $images, 'layout' => $layout, 'prices' => $prices, 'property' => $property]);
        } else {
            return response()->json('Error: you dont have permission!!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Property $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        if (checkRole('edit_properties') or @auth()->user()->type == 'admin') {
            return view('admin.properties.edit', ['title' => trans('admin.edit') . ' ' . trans('admin.property'), 'data' => $property]);
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Property $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        $rules = [
            'en_name' => 'required|max:191',
            'ar_name' => 'required|max:191',
            'unit_id' => 'required',
            'start_price' => 'required|numeric|min:0',
            'meter_price' => 'numeric|min:0',
            'area_from' => 'required|numeric|min:0',
            'area_to' => 'numeric',
            'type' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'en_name' => trans('admin.en_name'),
            'ar_name' => trans('admin.ar_name'),
            'unit_id' => trans('admin.unit_type'),
            'start_price' => trans('admin.start_price'),
            'area_from' => trans('admin.area_from'),
            'area_to' => trans('admin.area_to'),
            'type' => trans('admin.type'),
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $old_data = json_encode($property);
            if ($property->start_price != $request->start_price) {
                $price = new PriceHistory;
                $price->price = $request->start_price;
                $price->property_id = $property->id;
                $price->save();
            }
            $property->en_name = $request->en_name;
            $property->ar_name = $request->ar_name;
            $property->unit_id = $request->unit_id;
            $property->start_price = $request->start_price;
            $property->meter_price = $request->meter_price;
            $property->area_from = $request->area_from;
            $property->area_to = $request->area_to;
            $property->en_description = $request->en_description;
            $property->ar_description = $request->ar_description;
            $property->type = $request->type;
            if ($request->has('main_image')) {
                $extension = File::extension($request->main_image->getClientOriginalName());
                $name =  rand(0, 99999999999) . '.' . $extension;
                $property->main = $name;
				$request->file('main_image')->storeAs('uploads',$name);
			}
            $property->save();

            $new_data = json_encode($property);
            LogController::add_log(
                __('admin.updated', [], 'ar') . ' ' . __('admin.property', [], 'ar'),
                __('admin.updated', [], 'en') . ' ' . __('admin.property', [], 'en'),
                'properties',
                $property->id,
                'update',
                auth()->user()->id,
                $old_data,
                $new_data
            );

            if($request->images){
                for ($i = 0; $i < count($request->images); $i++) {
                    $ss = uploads($request, 'images.' . $i);
                    if (null != $ss) {
                        $images = new Property_images;
                        $images->images = $ss;
                        $images->property_id = $property->id;
                        $images->save();
                    }
                }
            }
            return response()->json("Property Updated Successfully!!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        if (checkRole('delete_properties') or @auth()->user()->type == 'admin') {
            $images = Property_images::where('property_id', $property->id)->get();
            $layout = LayoutImage::where('property_id', $property->id)->get();
            foreach ($images as $image) {
                unlink('uploads/' . $image->images);
            }
            Property_images::where('property_id', $property->id)->delete();
            foreach ($layout as $image) {
                unlink('uploads/' . $image->images);
            }
            LayoutImage::where('property_id', $property->id)->delete();

            $old_data = json_encode($property);
            LogController::add_log(
                __('admin.deleted', [], 'ar') . ' ' . __('admin.property', [], 'ar'),
                __('admin.deleted', [], 'en') . ' ' . __('admin.property', [], 'en'),
                'properties',
                $property->id,
                'delete',
                auth()->user()->id,
                $old_data
            );

            $property->delete();
            return response()->json("Property Deleted Successfully!!");
        } else {
            return response()->json("Error: You dont have permission!!");            
        }
    }
}
