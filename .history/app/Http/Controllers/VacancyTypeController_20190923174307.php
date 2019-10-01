<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\vacancy_type;
use Auth;
use DB;
use Validator;

class VacancyTypeController extends Controller
{
    public function index()
    {
        return vacancy_type::vacancyType();
    }
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'name' => trans('admin.en_name'),
        ]);
        if ($validator->fails()) {
            return 'have error in requirement';
            // return back()->withInput()->withErrors($validator);
        } else {
            vacancy_type::create($request->all());
        }
    }
    public function distroy($id)
    {
        dd($id);
        $type = vacancy_type::find($id);
        $type->delete();
        return "type is deleted";
    }
    public function getAll()
    {
        return vacancy_type::All_types();
    }
}
