<?php

namespace App\Http\Controllers;
use App\Form;
use Illuminate\Http\Request;
use Validator;
use Auth ;
use DB ;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $forms = Form::get();
        
        // return response()->json($forms);
       
        $forms = DB::table('forms as form')
        ->leftjoin('lead_sources as leadSource','form.lead_source_id','=','leadSource.id')
        ->select('form.id','form.en_title','form.type','leadSource.name as leadSourceName')
        ->paginate(100);


        //   $leadSourceName = DB::table('forms as form')
        //   ->join('lead_sources as leadSource','form.lead_source_id','=','leadSource.id')
        //   ->select('leadSource.name')
        //   ->value('leadSource.name');

        return $forms;

        // return view('admin.forms.index', ['forms' => $forms, 'title' => __('admin.form')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fields = $this->fields();
        return view('admin.forms.create', ['title' => __('admin.form'), 'fields' => $fields]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $rules = [
            'lead_source_id' => 'required',
            'ar_title' => 'required|max:191',
            'en_title' => 'required|max:191',
            'type' => 'required',
            'background' => 'required|image',
        ];
        // if ($request->type == 'project') {
        //     $rules['developer_id'] = 'required';
        //     $rules['project_id'] = 'required';
        // } else if ($request->type == 'event') {
        //     $rules['event_id'] = 'required';
        // } else if ($request->type == 'campaign') {
        //     $rules['campaign_id'] = 'required';
        // }
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'lead_source_id' => trans('admin.lead_source'),
            'ar_title' => trans('admin.ar_title'),
            'en_title' => trans('admin.en_title'),
            'type' => trans('admin.type'),
            'background' => trans('admin.background'),
        ]);

        if ($validator->fails()) {
            return response()->json("Validation Error");
            // return back()->withInput()->withErrors($validator);
        } else {
            $form = new Form;
            $form->lead_source_id = $request->lead_source_id;
            $fields = [];
            // foreach ($request->fields as $k => $v) {
            //     $fields[$request->fields[$k]] = $request->required[$k];
            // }
            if ($request->has('fields')) {
                $form->fields = json_encode($fields);
            } else {
                $form->fields = json_encode([]);
            }
            if ($request->type == 'project') {
                $form->developer_id = $request->developer_id;
                $form->project_id = $request->project_id;
                $form->phase_id = $request->phase_id;
            } else if ($request->type == 'event') {
                $form->event_id = $request->event_id;
            } else if ($request->type == 'campaign') {
                $form->campaign_id = $request->campaign_id;
            }
            $form->ar_title = $request->ar_title;
            $form->en_title = $request->en_title;
            $form->type = $request->type;
            $form->status = 1;
            if ($request->hasFile('background')) {
                $form->background = upload($request->background, 'form');
            }
            $form->user_id = auth()->user()->id;
            $form->save();

            session()->flash('success', trans('admin.created'));

            $old_data = json_encode($form);
            LogController::add_log(
                __('admin.created', [], 'ar') . ' ' . $form->ar_title,
                __('admin.created', [], 'en') . ' ' . $form->en_title,
                'forms',
                $form->id,
                'create',
                auth()->user()->id,
                $old_data
            );
            // return redirect(adminPath() . '/forms/' . $form->id);
            return response()->json(['status' => 'Added' ],200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Form $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        $form->leadSource = $form->lead_source;
        $form->projectInfo = $form->project;
        return response()->json($form);
        // return view('admin.forms.show', ['form' => $form, 'title' => __('admin.form')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Form $form
     * @return \Illuminate\Http\Response
     */
    public function edit(Form $form)
    {
        $fields = $this->fields();
        return view('admin.forms.edit', ['form' => $form, 'fields' => $fields, 'title' => __('admin.form')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Form $form
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Form $form)
    {
        $rules = [
            'lead_source_id' => 'required',
            'ar_title' => 'required|max:191',
            'en_title' => 'required|max:191',
            'type' => 'required',
        ];
        if ($request->type == 'project') {
            $rules['developer_id'] = 'required';
            $rules['project_id'] = 'required';
            $rules['phase_id'] = 'required';
        } else if ($request->type == 'event') {
            $rules['event_id'] = 'required';
        } else if ($request->type == 'campaign') {
            $rules['campaign_id'] = 'required';
        }
        $validator = Validator::make($request->all(), $rules);
        $validator->SetAttributeNames([
            'lead_source_id' => trans('admin.lead_source'),
            'ar_title' => trans('admin.ar_title'),
            'en_title' => trans('admin.en_title'),
            'type' => trans('admin.type'),
            'background' => trans('admin.background'),
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $old_data = json_encode($form);
            $form->lead_source_id = $request->lead_source_id;
            $fields = [];
            // foreach ($request->fields as $k => $v) {
            //     $fields[$request->fields[$k]] = $request->required[$k];
            // }
            if ($request->has('fields')) {
                $form->fields = json_encode($fields);
            } else {
                $form->fields = json_encode([]);
            }
            if ($request->type == 'project') {
                $form->developer_id = $request->developer_id;
                $form->project_id = $request->project_id;
                $form->phase_id = $request->phase_id;
            } else if ($request->type == 'event') {
                $form->event_id = $request->event_id;
            } else if ($request->type == 'campaign') {
                $form->campaign_id = $request->campaign_id;
            }
            $form->ar_title = $request->ar_title;
            $form->en_title = $request->en_title;
            $form->type = $request->type;
            if ($request->hasFile('background')) {
                @unlink('uploads/' . $form->background);
                $form->background = upload($request->background, 'form');
            }
            $form->save();

            session()->flash('success', trans('admin.updated'));

            $new_data = json_encode($form);
            LogController::add_log(
                __('admin.updated', [], 'ar') . ' ' . $form->ar_title,
                __('admin.updated', [], 'en') . ' ' . $form->en_title,
                'forms',
                $form->id,
                'update',
                auth()->user()->id,
                $old_data,
                $new_data
            );
            return redirect(adminPath() . '/forms/' . $form->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Form $form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {
        @unlink('uploads/' . $form->background);
        $old_data = json_encode($form);
        LogController::add_log(
            __('admin.deleted', [], 'ar') . ' ' . $form->ar_title,
            __('admin.deleted', [], 'en') . ' ' . $form->en_title,
            'forms',
            $form->id,
            'delete',
            auth()->user()->id,
            $old_data
        );
        $form->delete();
        // session()->flash('success', trans('admin.deleted'));
        // return redirect(adminPath() . '/forms');
        return response()->json([ "status" => "done"],200);

    }

    private function fields()
    {
        return [
            'middle_name',
            'email',
            'phone',
            'club',
            'religion',
            'birth_date',
            'address',
            'company',
            'school',
            'image',
            'facebook',
        ];
    }
    public function searchForm(Request $request){
        $search = $request->searchInput;
        if (Auth::user()->type === 'admin' ) {
            $forms = DB::table('forms')
            ->join('lead_sources as lead','forms.lead_source_id','=','lead.id')
			->where('forms.id', 'LIKE', '%' . $search . '%')
            ->orWhere('forms.en_title', 'LIKE', '%' . $search . '%')  
            ->orWhere('forms.type', 'LIKE', '%' . $search . '%')   
            ->select('forms.id','forms.en_title','forms.type','lead.name as leadSourceName')
            ->get();
            return $forms;
        }

    }
    public function getFormsInputs(){
        $leadsources = DB::table('lead_sources')->select('id','name as leadSourceName')->get();
        
        return response()->json($leadsources);
    }


}
