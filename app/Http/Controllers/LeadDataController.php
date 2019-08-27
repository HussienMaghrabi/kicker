<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Lead;
use Validator;
use Carbon\Carbon;
use Auth;
use Excel;
use File;

class LeadDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lead_data = DB::table('lead_data as data')
            ->leftjoin('tags as tag','data.tag_id','=','tag.id')
            ->leftjoin('users as agent','data.agent_id','=','agent.id')
            ->leftjoin('users as c_agent','data.commercial_agent_id','=','c_agent.id')            
            ->select('data.id','data.lead_first_name','data.lead_last_name','agent.name as agent'
            ,'c_agent.name as c_agent','data.phone','data.comment','tag.en_name as tag','data.created_at')
            ->orderBy('data.id', 'desc')->paginate(100);
        return response()->json($lead_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
	 * Get Lead Data Page
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function get_lead_data(){
		return view('admin.leads.lead_data');		
	}
	
	public function lead_data_xls() {
        Excel::create('LeadData', function ($excel) {
            $excel->sheet('campaign', function ($sheet) {
                $sheet->loadView('admin.leads.lead_data_xls');
            });
        })->export('xls');
	}
    
    public function leads_data_upload(){
		return view('admin.leads.upload_lead_data');
	}

    public function leads_data_store(Request $request){
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
                        if (isset($item['contact'])) {
                            $contact = $leadInstance->reformPhone($item['contact']);
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
                            $other_phones = '';
                            $other_phones_xls = json_decode('['.$item['other_phones'].']');
                            foreach($other_phones_xls as $key => $phone){
                                if($key == count($other_phones_xls) - 1){
                                    $other_phones .= $phone;                                    
                                }else{
                                    $other_phones .= $phone . ",";
                                }
                            }
                            $other_phones = $other_phones == '' ? null : $other_phones;
                            DB::table('lead_data')->insert([
                                'lead_first_name' => $first_name,
                                'lead_last_name' => $last_name,
                                'phone' => $contact->phone,
                                'other_phones' => $other_phones,
                                'tag_id' => $item['tag_id'],
                                'comment' => $item['comment'],
                                'agent_id' => $item['agent_id'],
                                'commercial_agent_id' => $item['commercial_agent_id'],
                                'user_id' => auth()->user()->id,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                        }
                        else{
                            continue;
                        }
                    }
                    return response()->json("Inserted Lead Data Successfully!!");                                   
                }
                else{
                    return response()->json("Please Upload A valid file with one of the excel extensions : xlsx or xls or csv");                                   
                }
            }
            else{
                return response()->json("No Files Found");                                   
            }
            return response()->json("Leads Data Inserted Successfully!!");                                   
		}
    }

    /**
	 * Bulk Delete Selected Leads Data
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteLeadsData(Request $request){
		$leadsDataIds = $request->all();
		DB::table('lead_data')->whereIn('id',$leadsDataIds)->delete();
		return response()->json("selected leads data Deleted Succussfully!");		
    }
    
}
