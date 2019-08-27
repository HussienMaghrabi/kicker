<?php

namespace App\Http\Controllers;

use App\Cil;
use App\User;
use App\Player;
use App\Setting;
use Illuminate\Http\Request;
use Webklex\IMAP\Client;
use Carbon\Carbon;
use DataTables;
use Excel;
use File;
use Illuminate\Support\Facades\DB;
use OneSignal;


class CilController extends Controller
{
    public function __construct()
    {

    }
    public function index()
    {
        // self::updateCilsStatus();
        return view('admin.cils.index_new', ['title' => trans('admin.Cils')]);
    }

    /**
     * Display a listing of all cils
     *
     * @return \Illuminate\Http\Response
     */
    public function getCils()
    {
        // self::updateCilsStatus();
        $cils = DB::table('cils as cil')->leftjoin('leads as lead', 'cil.lead_id', '=', 'lead.id')
            ->join('users as user', 'cil.user_id', '=', 'user.id')
            ->leftjoin('users as sender', 'cil.sender_id', '=', 'sender.id')
            ->join('projects as project', 'cil.project_id', '=', 'project.id')
            ->join('developers as developer', 'cil.developer_id', '=', 'developer.id');
        $user = auth()->user();
        $teamLeaderGroupID = DB::table('groups')->where('team_leader_id',$user->id)->value('id');
        if($user->type != "admin" && $teamLeaderGroupID != null){
            $members = DB::table('group_members')->where('group_id',$teamLeaderGroupID)->distinct()->pluck('member_id')->toArray();
            array_push($members,$user->id);
            $cils = $cils->whereIn('cil.user_id',$members);
        }
        else if($user->type == "agent"){
            $cils = $cils->where('cil.user_id',$user->id);
        }
        $cils = $cils->select(
            'cil.id',
            'lead.first_name as lead_first_name',
            'lead.last_name as lead_last_name',
            'project.en_name as project',
            'developer.en_name as developer',
            'user.name as user',
            'cil.status',
            'cil.replies_status',
            'sender.name as sender_name',
            'cil.created_at',
            'cil.sent_date',
            'cil.expire_on'
        )->orderBy('cil.id', 'desc')->paginate(100);
        foreach($cils as $cil){
            if($cil->status == 'not_sent'){
                $cil->status = "Waiting To Send";
            }
        }
        return response()->json($cils);
    }

    public function create()
    {

    }
    public function show($cil)
    {
        $cil = \App\Cil::find($cil);
        return view('admin.cils.show',['cils'=>$cil]);
    }
    public function show_vie($cil)
    {
        $cil = \App\Cil::find($cil);
        $developer_excel = $cil->developer->xls_url;
        if($developer_excel != null){
        }else{
            return view('admin.leads.cil',['cils'=>$cil]);
        }
    }
    public function store(Request $request)
    {
    }
    public function sendCils(Request $request)
    {
        // dd($request->all());
        // send notfication
        // end send notfication

        if(checkRole('send_cil') != '1'){
            return response()->json("permission denied");
        }
        $cils=Cil::whereIn('id',$request->cils)->get();
        $ccEmails = DB::table('cils_emails')->pluck('email')->toArray();
        $cils_mail_settings = DB::table('cils_mail_settings')->first();
        $settings = \App\Setting::first();
        $cil_email= $settings->cil_email;
        $cil_from_name = $settings->title;
        $company_phone = DB::table('hub_phones')->value('phone');
        foreach($cils as $cil){
            $cilInfo = DB::table('cils_info')->where('cil_id',$cil->id)->orderBy('id','desc')->first();
            $path = $cilInfo->sheet;
            // dd($path);
            if(file_exists($path))
            {
                $extension = explode('.',$path)[1];
                if ($extension == "xls" || $extension == "xlsx" || $extension == "csv") {
                    $cil_info_path = $sheet;
                    $count = count(explode('/',$cil_info_path));
                    $fileName = explode('.',explode('/',$cil_info_path)[$count-1])[0];
                    $data = Excel::load($cil_info_path, function($reader) use($cil){
                        $sheet = $reader->getActiveSheet();
                        $items = $sheet->getCellByColumnAndRow(0,0);
                        $parent = $items->getParent();
                        $cells = $parent->getCellList();
                        foreach($cells as $key => $cell){
                            $cellValue = $parent->getCacheData($cell);
                            if($parent->getCacheData($cell) == '$sender_name'){
                                $sheet->setCellValue($cell, auth()->user()->name);
                            }
                        }
                    })
                    ->setFilename($fileName)
                    ->store($extension,'uploads/cils');
                }
                else{
                    if ($extension == "doc") {
                        $phpWord = \PhpOffice\PhpWord\IOFactory::load($path, 'MsDoc');
                    } else if ($extension == "rtf") {
                        $phpWord = \PhpOffice\PhpWord\IOFactory::load($path, 'RTF');
                    } else if ($extension == "docx") {
                        $phpWord = \PhpOffice\PhpWord\IOFactory::load($path);
                    }
                    $elements = $phpWord->getSections()[0]->getElements();
                    foreach ($elements as $key => $element){
                        $tableClass = '\PhpOffice\PhpWord\Element\Table';
                        if ($element instanceof $tableClass){
                            foreach ($element->getRows() as $row){
                                foreach ($row->getCells() as $ky => $cell){
                                    foreach ($cell->getElements() as $k => $cEl){
                                        $textClass = 'PhpOffice\PhpWord\Element\Text';
                                        $textRunClass = 'PhpOffice\PhpWord\Element\TextRun';
                                        if ($cEl instanceof $textClass){
                                            $cellValue = $cEl;  
                                        }
                                        elseif ($cEl instanceof $textRunClass){
                                            if (count($cEl->getElements())>0 and $cEl->getElements()[0] instanceof $textClass){
                                                $cellValue = $cEl->getElements()[0];
                                            }
                                        }
                                        $cellValueText = $cellValue->getText();
                                        if($cellValueText == '$sender_name'){
                                            $cellValue->setText(auth()->user()->name);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    unlink($path);
                    $phpWord->save($path);
                }
            }
            $message = $cils_mail_settings->message;
            $developer_xls = $cil->developer->xls_url;
            if($developer_xls != null){
                $message .= $cil->developer->message;
                $resultExcelSheet = $path;
            }
            else{
                $cilInstance = new Cil;
                $resultExcelSheet = $cilInstance->getCilInfoXls($cil,$cil_from_name);
            }
            // if($cil->developer->message != null){
                                
            // }
            $message .= $cils_mail_settings->signature;
            if($cil->developer->email){
                if (strpos($message, '$developer_name') !== false) {
                    $message = str_replace('$developer_name',$cil->developer->{app()->getLocale().'_name'},$message);
                }
                if($cil->lead != null){
                    if (strpos($message, '$lead_first_name') !== false && strpos($message, '$lead_last_name') !== false) {
                        $message = str_replace('$lead_first_name,$lead_last_name',$cil->lead->first_name.' '.$cil->lead->last_name,$message);
                    }
                    else if (strpos($message, '$lead_first_name') !== false) {
                        $message = str_replace('$lead_first_name',$cil->lead->first_name,$message);
                    }
                    else if (strpos($message, '$lead_last_name') !== false) {
                        $message = str_replace('$lead_last_name',$cil->lead->last_name,$message);
                    }
                }
                if (strpos($message, '$lead_creation_date') !== false) {
                    $message = str_replace('$lead_creation_date',$cil->lead->created_at,$message);
                }
                if (strpos($message, '$lead_address') !== false) {
                    $message = str_replace('$lead_address',$cil->lead->address,$message);
                }
                if (strpos($message, '$lead_phone') !== false) {
                    $message = str_replace('$lead_phone',$cil->lead->phone,$message);
                }
                if (strpos($message, '$lead_agent') !== false) {
                    $message = str_replace('$lead_agent',$cil->lead->agent->name,$message);
                }
                if (strpos($message, '$project_name') !== false) {
                    $message = str_replace('$project_name',$cil->project->{app()->getLocale().'_name'},$message);
                }
                if (strpos($message, '$project_address') !== false && $cil->project->location != null){
                    $message = str_replace('$project_address',$cil->project->location->{app()->getLocale().'_name'},$message);
                }
                if (strpos($message, '$sender_name') !== false){
                    $message = str_replace('$sender_name',auth()->user()->name,$message);
                }
                if (strpos($message, '$sender_title') !== false){
                    $message = str_replace('$sender_title',auth()->user()->agentType->name,$message);
                }
                if (strpos($message, '$sender_mobile') !== false){
                    $message = str_replace('$sender_mobile',auth()->user()->phone,$message);
                }
                if (strpos($message, '$website_name') !== false){
                    $message = str_replace('$website_name',$cil_from_name,$message);
                }
                if (strpos($message, '$company_phone') !== false){
                    $message = str_replace('$company_phone',$company_phone,$message);
                }
                if (strpos($message, '$sender_email') !== false){
                    $message = str_replace('$sender_email',auth()->user()->email,$message);
                }
                $cil_user_email = $cil->user->email;
                if(!in_array($cil_user_email,$ccEmails)){
                    array_push($ccEmails,$cil_user_email);
                }
                foreach($cil->developer->contact as $developer_contact){
                    if(!in_array($developer_contact->email,$ccEmails) && $developer_contact->email != '' && $developer_contact->email != null){
                        array_push($ccEmails,$developer_contact->email);
                    }
                }
                try{
                    \Mail::send([], [], function ($mailMessage) use ($cil,$cil_email,$cil_from_name,$message,$ccEmails,$resultExcelSheet) {
                        $mailMessage->to($cil->developer->email)
                        ->subject('CIL_'.$cil->id.'_'.$cil->project->{app()->getLocale().'_name'}.'_'.$cil->developer->{app()->getLocale().'_name'})
                        ->cc($ccEmails)
                        ->attach(public_path($resultExcelSheet))
                        ->setBody($message, 'text/html');
                        $mailMessage->from($cil_email,$cil_from_name);
                    });
                    DB::table('cils')->where('id',$cil->id)->update([
                        'status'=>'WDR',
                        'replies_status' => 3,
                        'sender_id' => auth()->user()->id,
                        'sent_date' => Carbon::now()
                    ]);
                }
                catch(\Exception $e){
                    return $e;
                }
            }else{
                try{
                    \Mail::send('admin.leads.cil', ['cils'=>$cil], function ($message) use ($cil,$cil_email,$cil_from_name,$ccEmails,$resultExcelSheet) {
                        $message->to($cil->developer->email)
                        ->subject('CIL')
                        ->cc($ccEmails);
                        $message->from($cil_email,$cil_from_name);
                    });
                    DB::table('cils')->where('id',$cil->id)->update([
                        'status'=>'WDR',
                        'replies_status' => 3,
                        'sender_id' => auth()->user()->id,
                        'sent_date' => Carbon::now()
                    ]);
                }
                catch(\Exception $e){
                    return $e;
                }
            }
        }
        return response()->json("Email Sent Successfully!!");


    }
    public function mails(){
        $oClient = new  Client([
            'host'          => 'mail.theaddress-eg.com',
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => false,
            'username'      => 'test@theaddress-eg.com',
            'password'      => '123asdqwe',
            'protocol'      => 'imap'
        ]);
        $oClient->connect();
        $oFolder = $oClient->getFolder('inbox');
        $oFolder->query()->all()->get();
        $mails = $oFolder->search()
        ->since(Carbon::now()->subDays(14))->get()
        ->paginate($perPage = 5, $page = null, 1);
        //$mails = $oFolder->query()->all()->get();;
        return view('admin.cils.mails', ['title' => trans('admin.mails'), 'mails' => $mails]);
    }
    public function cil_change_status(Request $request,$id)
    {
        $cil = Cil::find($id);
        $cil->status = $request->type;
        $cil->save();
        return response()->json([
            'status' => $request->type,
            'id' => $id
        ]);
    }

    public function export_xsl(Request $request){
        $cil = \App\Cil::find($request->cil_id);
        $cilInfo = DB::table('cils_info')->where('cil_id',$cil->id)->first();
        $cilInfoSheet = $cilInfo->sheet;
        if($cilInfoSheet == null){
            return redirect(adminPath() . '/vue/cils');
        }
        $fileName = explode('/',$cilInfoSheet)[1];
        if($cilInfoSheet != null){
            $path = $cilInfoSheet;

            $extension = explode('.',$path)[1];
            if ($extension == "xls" || $extension == "xlsx" || $extension == "csv") {
                $data = Excel::load($cilInfoSheet, function($reader){
                })->download($extension);
            }
            else{
                // return $path;

                if ($extension == "doc") {
                    $phpWord = \PhpOffice\PhpWord\IOFactory::load($path, 'MsDoc');
                } else if ($extension == "rtf") {
                    $phpWord = \PhpOffice\PhpWord\IOFactory::load($path, 'RTF');                    
                } else if ($extension == "docx") {
                    $phpWord = \PhpOffice\PhpWord\IOFactory::load($path);                        
                }
                $new_name = rand(0, 99999999999) . "." . $extension;
                $new_path = 'uploads/' . $new_name;
                $cil_info_path = 'uploads/cils/' . $new_name;
                $phpWord->save($new_path);
                $phpWord->save($cil_info_path);
                unlink($path);
                DB::table('developers')->where('id',$cil->developer->id)->update(['xls_url' => $new_path]);
                DB::table('cils_info')->where('cil_id',$cil->id)
                                      ->orderBy('id','desc')
                                      ->take(1)
                                      ->update(['sheet' => $cil_info_path]);
                header('Pragma: no-cache');
                // Mark file as already expired for cache; mark with RFC 1123 Date Format up to
                // 1 year ahead for caching (ex. Thu, 01 Dec 1994 16:00:00 GMT)
                header('Expires: 0');
                // Forces cache to re-validate with server
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                // DocX Content Type
                header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                // Tells browser we are sending file
                header('Content-Disposition: attachment; filename="' . $new_name . '"');
                // Tell proxies and gateways method of file transfer
                header('Content-Transfer-Encoding: binary');
                // Indicates the size to receiving browser
                header('Content-Length: '.filesize($new_path));
                // Send the file:
                readfile($new_path);
                // End the session. BE CAREFUL; YOU NEED TO DO THIS THROUGH YOUR FRAMEWORK:
                session_write_close();
            }

        }
    }

    public function destroy($id)
    {
        $cil = Cil::find($id);
        if (auth()->user()->type == 'admin' || $cil->user_id == auth()->user()->id) {
            $cil->delete();
            DB::table('cils_info')->where('cil_id',$cil->id)->delete();
            session()->flash('success', trans('admin.deleted'));
            return response()->json("Successfully Deleted Cil!!");
        } else {
            session()->flash('error', __('admin.you_dont_have_permission'));
            return response()->json("Something went Wrong!!");            
        }
    }

    public function getCilData($id){
        $cil = Cil::find($id);
        $cilData = DB::table('cils_info')->where('cil_id',$cil->id)->first();
        $cilData->introduced_by = $cil->user->name;
        $cilData->date = Carbon::parse($cil->created_at)->format('Y-m-d');
        unset($cilData->sheet);
        unset($cilData->id);
        unset($cilData->cil_id);
        unset($cilData->created_at);
        unset($cilData->updated_at);
        unset($cilData->user_id);
        
        if($cil->lead != null){
            $cilData->lead_first_name = $cil->lead->first_name;
            $cilData->lead_last_name = $cil->lead->last_name;
            $cilData->lead_address = $cil->lead->address;
            // $cilData->lead_company = $cil->lead->company;
        }
        return response()->json($cilData);
    }

    public function updateCilData(Request $request){
        $cil = Cil::find($request->cil_id);
        $cilData = $request->cil;
        $cilInfo = DB::table('cils_info')->where('cil_id',$cil->id)->orderBy('id','desc')->first();
        $broker_company = DB::table('settings')->value('title');
        $sheet = $cilInfo->sheet;
        DB::table('cils_info')->where('cil_id',$cil->id)->orderBy('created_at','desc')->update([
            'personal_email' => $cilData['personal_email'],
            'corporate_email' => $cilData['corporate_email'],
            'profession' => $cilData['profession'],
            'own_property' => $cilData['own_property'],
            'educational_degree' => $cilData['educational_degree'],
            'club_membership' => $cilData['club_membership'],
            'knowledge_source' => $cilData['knowledge_source'],
            'kids_education' => $cilData['kids_education'],
            'remarks' => $cilData['remarks'],
            'mobile' => $cilData['mobile'],
            'occupation' => $cilData['occupation'],
            'property_interest' => $cilData['property_interest'],
            'residence' => $cilData['residence'],
            'city' => $cilData['city'],
            'nationality' => $cilData['nationality'],
            'comments' => $cilData['comments'],
            'user_id' => auth()->user()->id,
            'updated_at' => Carbon::now(),
        ]);
        DB::table('leads')->where('id',$cil->lead->id)->update([
            'first_name' => $cilData['lead_first_name'],
            'last_name' => $cilData['lead_last_name'],
            'address' => $cilData['lead_address'],
            // 'company' => $cilData['lead_company'],
        ]);
        DB::table('cils')->where('id',$cil->id)->update(['created_at' => Carbon::parse($cilData['date'])->format('Y-m-d H:i:s')]);
        if($sheet != null){
            $path = $sheet;
            $extension = explode('.',$path)[1];
            if ($extension == "xls" || $extension == "xlsx" || $extension == "csv") {
                $cil_info_path = $sheet;
                $count = count(explode('/',$cil_info_path));
                $fileName = explode('.',explode('/',$cil_info_path)[$count-1])[0];            
                
                $data = Excel::load($cil_info_path, function($reader) use($cil,$cilData){
                    $sheet = $reader->getActiveSheet();
                    $items = $sheet->getCellByColumnAndRow(0,0);
                    $parent = $items->getParent();
                    $cells = $parent->getCellList();
                    foreach($cells as $key => $cell){
                        $cellValue = $parent->getCacheData($cell);
                        if (strpos($cellValue, '$lead_first_name') !== false && strpos($cellValue, 'lead_last_name') !== false) {
                            if($cil->lead != null){
                                $sheet->setCellValue($cell, $cilData['lead_first_name'] . " " . $cilData['lead_last_name']);
                            }
                        }
                        if($parent->getCacheData($cell) == '$lead_first_name'){
                            $sheet->setCellValue($cell, $cilData['lead_first_name']);
                        }
                        if($parent->getCacheData($cell) == '$lead_last_name'){
                            $sheet->setCellValue($cell, $cilData['lead_last_name']);
                        }
                        if($parent->getCacheData($cell) == '$lead_address'){
                            $sheet->setCellValue($cell, $cilData['lead_address']);
                        }
                        if($parent->getCacheData($cell) == '$broker_company'){
                            $sheet->setCellValue($cell, $broker_company);
                        }
                        if($parent->getCacheData($cell) == '$date'){
                            $sheet->setCellValue($cell, $cilData['date']);
                        }
                        if($parent->getCacheData($cell) == '$project'){
                            $sheet->setCellValue($cell, $cil->project->{app()->getLocale().'_name'});
                        }
                        if($parent->getCacheData($cell) == '$broker_agent'){
                            $sheet->setCellValue($cell, $cil->user->name);
                        }
                        if($parent->getCacheData($cell) == '$broker_mobile'){
                            $sheet->setCellValue($cell, $cil->user->phone);
                        }
                        if($parent->getCacheData($cell) == '$project'){
                            $sheet->setCellValue($cell, $cil->project->{app()->getLocale().'_name'});
                        }
                        if($parent->getCacheData($cell) == '$personal_email'){
                            $sheet->setCellValue($cell, $cilData['personal_email']);
                        }
                        if($parent->getCacheData($cell) == '$corporate_email'){
                            $sheet->setCellValue($cell, $cilData['corporate_email']);
                        }
                        if($parent->getCacheData($cell) == '$profession'){
                            $sheet->setCellValue($cell, $cilData['profession']);
                        }
                        if($parent->getCacheData($cell) == '$own_property'){
                            $sheet->setCellValue($cell, $cilData['own_property']);
                        }
                        if($parent->getCacheData($cell) == '$educational_degree'){
                            $sheet->setCellValue($cell, $cilData['educational_degree']);
                        }
                        if($parent->getCacheData($cell) == '$club_membership'){
                            $sheet->setCellValue($cell, $cilData['club_membership']);
                        }
                        if($parent->getCacheData($cell) == '$knowledge_source'){
                            $sheet->setCellValue($cell, $cilData['knowledge_source']);
                        }
                        if($parent->getCacheData($cell) == '$kids_education'){
                            $sheet->setCellValue($cell, $cilData['kids_education']);
                        }
                        if($parent->getCacheData($cell) == '$remarks'){
                            $sheet->setCellValue($cell, $cilData['remarks']);
                        }
                        if($parent->getCacheData($cell) == '$mobile'){
                            $sheet->setCellValue($cell, $cilData['mobile']);
                        }  
                        if($parent->getCacheData($cell) == '$occupation'){
                            $sheet->setCellValue($cell, $cilData['occupation']);
                        }
                        if($parent->getCacheData($cell) == '$property_interest'){
                            $sheet->setCellValue($cell, $cilData['property_interest']);
                        }
                        if($parent->getCacheData($cell) == '$residence'){
                            $sheet->setCellValue($cell, $cilData['residence']);
                        }  
                        if($parent->getCacheData($cell) == '$city'){
                            $sheet->setCellValue($cell, $cilData['city']);
                        }
                        if($parent->getCacheData($cell) == '$nationality'){
                            $sheet->setCellValue($cell, $cilData['nationality']);
                        } 
                        if($parent->getCacheData($cell) == '$comments'){
                            $sheet->setCellValue($cell, $cilData['comments']);
                        }  
                    }
                })
                ->setFilename($fileName)                
                ->store($extension,'uploads/cils');
            }
            else{
                if ($extension == "doc") {
                    $phpWord = \PhpOffice\PhpWord\IOFactory::load($path, 'MsDoc');
                } else if ($extension == "rtf") {
                    $phpWord = \PhpOffice\PhpWord\IOFactory::load($path, 'RTF');                    
                } else if ($extension == "docx") {
                    $phpWord = \PhpOffice\PhpWord\IOFactory::load($path);                        
                }
                $elements = $phpWord->getSections()[0]->getElements();
                foreach ($elements as $key => $element){
                    $tableClass = '\PhpOffice\PhpWord\Element\Table';
                    if ($element instanceof $tableClass){
                        foreach ($element->getRows() as $row){
                            foreach ($row->getCells() as $ky => $cell){
                                foreach ($cell->getElements() as $k => $cEl){
                                    $textClass = 'PhpOffice\PhpWord\Element\Text';
                                    $textRunClass = 'PhpOffice\PhpWord\Element\TextRun';
                                    if ($cEl instanceof $textClass){
                                        $cellValue = $cEl;  
                                    }
                                    elseif ($cEl instanceof $textRunClass){
                                        if (count($cEl->getElements())>0 and $cEl->getElements()[0] instanceof $textClass){
                                            $cellValue = $cEl->getElements()[0];
                                        }
                                    }
                                    $cellValueText = $cellValue->getText();
                                    if($cellValueText == 'agent_name'){
                                        $agent_name = DB::table('cils as cil')->where('id',$cil->id)
                                                                ->join('users as user','cil.user_id','=','user.id')
                                                                ->value('user.name');
                                        $cellValue->setText($agent_name);
                                    }
                                    if (strpos($cellValueText, '$lead_first_name') !== false && strpos($cellValueText, '$lead_last_name') !== false) {
                                        if($cil->lead != null){
                                            $cellValue->setText($cil->lead->first_name . " " . $cil->lead->last_name);
                                        }
                                    }
                                    if(strpos($cellValueText, '$date') !== false && $cilData['date'] != null){
                                        $cellValue->setText($cilData['date']);
                                    }
                                    if(strpos($cellValueText, '$project') !== false && $cil->project != null){
                                        $cellValue->setText($cil->project->{app()->getLocale().'_name'});
                                    }
                                    if(strpos($cellValueText, '$broker_agent') !== false && $cil->user != null){
                                        $cellValue->setText($cil->user->name);
                                    }
                                    if(strpos($cellValueText, '$broker_mobile') !== false && $cil->user != null){
                                        $cellValue->setText($cil->user->phone);
                                    }
                                    if(strpos($cellValueText, '$lead_address') !== false && $cilData['lead_address'] != null){
                                        $cellValue->setText($cilData['lead_address']);
                                    }
                                    if(strpos($cellValueText, '$broker_company') !== false && $broker_company != null){
                                        $cellValue->setText($broker_company);
                                    }
                                    if(strpos($cellValueText, '$personal_email') !== false && $cilData['personal_email'] != null){
                                        $cellValue->setText($cilData['personal_email']);
                                    }
                                    if(strpos($cellValueText, '$corporate_email') !== false && $cilData['corporate_email'] != null){
                                        $cellValue->setText($cilData['corporate_email']);
                                    }
                                    if(strpos($cellValueText, '$profession') !== false && $cilData['profession'] != null){
                                        $cellValue->setText($cilData['profession']);
                                    }
                                    if(strpos($cellValueText, '$own_property') !== false && $cilData['own_property'] != null){
                                        $cellValue->setText($cilData['own_property']);
                                    }
                                    if(strpos($cellValueText, '$educational_degree') !== false && $cilData['educational_degree'] != null){
                                        $cellValue->setText($cilData['educational_degree']);
                                    }
                                    if(strpos($cellValueText, '$club_membership') !== false && $cilData['club_membership'] != null){
                                        $cellValue->setText($cilData['club_membership']);
                                    }
                                    if(strpos($cellValueText, '$knowledge_source') !== false && $cilData['knowledge_source'] != null){
                                        $cellValue->setText($cilData['knowledge_source']);
                                    }
                                    if(strpos($cellValueText, '$kids_education') !== false && $cilData['kids_education'] != null){
                                        $cellValue->setText($cilData['kids_education']);
                                    }
                                    if(strpos($cellValueText, '$remarks') !== false && $cilData['remarks'] != null){
                                        $cellValue->setText($cilData['remarks']);
                                    }
                                    if(strpos($cellValueText, '$mobile') !== false && $cilData['mobile'] != null){
                                        $cellValue->setText($cilData['mobile']);
                                    }
                                    if(strpos($cellValueText, '$occupation') !== false && $cilData['occupation'] != null){
                                        $cellValue->setText($cilData['occupation']);
                                    }
                                    if(strpos($cellValueText, '$property_interest') !== false && $cilData['property_interest'] != null){
                                        $cellValue->setText($cilData['property_interest']);
                                    }
                                    if(strpos($cellValueText, '$residence') !== false && $cilData['residence'] != null){
                                        $cellValue->setText($cilData['residence']);
                                    }
                                    if(strpos($cellValueText, '$city') !== false && $cilData['city'] != null){
                                        $cellValue->setText($cilData['city']);
                                    }
                                    if(strpos($cellValueText, '$nationality') !== false && $cilData['nationality'] != null){
                                        $cellValue->setText($cilData['nationality']);
                                    }
                                    if(strpos($cellValueText, '$comments') !== false && $cilData['comments'] != null){
                                        $cellValue->setText($cilData['comments']);
                                    }                 
                                }
                            }
                        }
                    }
                }
                unlink($path);
                $phpWord->save($path);
            }
        }
        return response()->json("Updated CIL Data Successfully!!");

    }

    public function mailSettings(){
        $users = DB::table('users')->select('id','name')->get();
        return view('admin.cils.mail_settings', ['title' => trans('admin.cil_mail_settings'),'users'=>$users]);        
    }

    public function getCilSettings(){
        $settings = DB::table('settings')->select('id','cil_email','cil_password')->first();
        $settings_editor_data = DB::table('cils_mail_settings')->select('signature','message')->first();
        return response()->json([
            'settings' => $settings,
            'editors_data' => $settings_editor_data 
        ]);
    }

    public function saveCilSettings(Request $request){
        $emails = $request->emails;
        $accepted_keywords = $request->accepted_keywords;
        $rejected_keywords = $request->rejected_keywords;
        $checkSettings = DB::table('cils_mail_settings')->count();
        if($checkSettings == 0){
            DB::table('cils_mail_settings')->insert([
                'signature' => $request->signature,
                'message' => $request->message,
                'user_id' => auth()->user()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        else{
            DB::table('cils_mail_settings')->update([
                'signature' => $request->signature,
                'message' => $request->message,
                'user_id' => auth()->user()->id,
            ]);
        }
        
        foreach($emails as $email){
            $checkEmail = DB::table('cils_emails')->where('email',$email)->count();
            if($checkEmail == 0){
                DB::table('cils_emails')->insert([
                    'email' => $email,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
        if(!empty($accepted_keywords)){
            foreach($accepted_keywords as $keyword){
                $checkKeyword = DB::table('cil_keywords')->where('keyword',$keyword)->count();
                if($checkKeyword == 0){
                    DB::table('cil_keywords')->insert([
                        'keyword' => $keyword,
                        'type' => 'accepted',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }
        
        if(!empty($rejected_keywords)){
            foreach($rejected_keywords as $keyword){
                $checkKeyword = DB::table('cil_keywords')->where('keyword',$keyword)->count();
                if($checkKeyword == 0){
                    DB::table('cil_keywords')->insert([
                        'keyword' => $keyword,
                        'type' => 'rejected',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }
        
        return response()->json("Successfully Saved New Settings");
    }

    public function getCilEmails(){
        $emails =  DB::table('cils_emails')->select('id','email')->get();
        return response()->json($emails);
    }

    public function getCilAcceptedKeywords(){
        $keywords =  DB::table('cil_keywords')->where('type','accepted')->select('id','keyword')->get();
        return response()->json($keywords);
    }

    public function getCilRejectedKeywords(){
        $keywords =  DB::table('cil_keywords')->where('type','rejected')->select('id','keyword')->get();
        return response()->json($keywords);
    }

    public static function updateCilsStatus() {
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
                // $messages = imap_search($mailbox, 'FROM');
                // $messages = imap_search($mailbox, 'SUBJECT "Re: CIL"',SE_UID);
                $accepted_keywords = DB::table('cil_keywords')->where('type','accepted')->pluck('keyword');
                $rejected_keywords = DB::table('cil_keywords')->where('type','rejected')->pluck('keyword');

                $acceptedMessagesIds = [];
                $rejectedMessagesIds = [];
                $cilIds = [];
                if (imap_search($mailbox, 'SUBJECT "Re: CIL"',SE_UID)) {
                    $allmessagesIds = imap_search($mailbox, 'SUBJECT "Re: CIL"',SE_UID);
                    $arr = array_reverse($allmessagesIds);
                    $allmessages = [];
                    $x = count($arr);
                    for ($i = 0; $i < $x; $i++) {
                        $allmessages[] = imap_fetch_overview($mailbox, $arr[$i], 0)[0];
                    }
                    if(count($accepted_keywords) > 0){
                        foreach($accepted_keywords as $keyword){
                            if(imap_search($mailbox, 'BODY "'.$keyword.'"', SE_UID)) {
                                $acceptedMessagesIds = $acceptedMessagesIds + imap_search($mailbox, 'SUBJECT "Re: CIL" BODY "'.$keyword.'"', SE_UID); 
                            }
                        }
                        $arr = array_reverse($acceptedMessagesIds);
                        $acceptedMessages = [];
                        $x = count($arr);
                        for ($i = 0; $i < $x; $i++) {
                            $acceptedMessages[] = imap_fetch_overview($mailbox, $arr[$i], 0)[0];
                        }
                    }
                    if(count($rejected_keywords) > 0){
                        foreach($rejected_keywords as $keyword){
                            if(imap_search($mailbox, 'BODY "'.$keyword.'"', SE_UID)) {
                                $rejectedMessagesIds = $rejectedMessagesIds + imap_search($mailbox, 'SUBJECT "Re: CIL" BODY "'.$keyword.'"', SE_UID); 
                            }
                        }
                        $arr = array_reverse($rejectedMessagesIds);
                        $rejectedMessages = [];
                        $x = count($arr);
                        for ($i = 0; $i < $x; $i++) {
                            $rejectedMessages[] = imap_fetch_overview($mailbox, $arr[$i], 0)[0];
                        }
                    }
                }
                imap_close($mailbox);
                $messagesWithActions = [];
                
                foreach($acceptedMessages as $message){
                    $str = explode(" ",$message->subject)[1];
                    $cilID = explode("_",$str)[1];

                    $developer_cil_expire_date = DB::table('cils as cil')->join('developers as developer','cil.developer_id','=','developer.id')
                                            ->where('cil.id',$cilID)
                                            ->value('developer.cil_expire_date');
                    if($developer_cil_expire_date == null){
                        $developer_cil_expire_date = 30;
                    }
                    DB::table('cils')->where('id',$cilID)->update([
                        'status' => 'clean_lead',
                        'replies_status' => 1,
                        'expire_on' => $developer_cil_expire_date
                    ]);
                    array_push($messagesWithActions,$message->uid);
                }
                foreach($rejectedMessages as $message){
                    $str = explode(" ",$message->subject)[1];
                    $cilID = explode("_",$str)[1];
                    if(!is_numeric($cilID)){
                        continue;
                    }
                    $developer_cil_expire_date = DB::table('cils as cil')->join('developers as developer','cil.developer_id','=','developer.id')
                                            ->where('cil.id',$cilID)
                                            ->value('developer.cil_expire_date');
                    if($developer_cil_expire_date == null){
                        $developer_cil_expire_date = 30;
                    }
                    DB::table('cils')->where('id',$cilID)->update([
                        'status' => 'WOB',
                        'replies_status' => 2,
                        'expire_on' => $developer_cil_expire_date
                    ]);
                    array_push($messagesWithActions,$message->uid);
                }
                foreach($allmessages as $message){
                    $str = explode(" ",$message->subject)[1];
                    $cilID = explode("_",$str)[1];
                    if(!is_numeric($cilID)){
                        continue;
                    }

                    if(!in_array($message->uid,$messagesWithActions)){
                        DB::table('cils')->where('id',$cilID)->update([
                            'replies_status' => 4,
                        ]);
                    }
                }
            } catch (\ErrorException $e) {
                return redirect(adminPath() . '/');
            }
        } else {
            $data = [];
        }
        return redirect(adminPath() . '/cils');        
    }

    public function getCilFilterData(){
        $developers = DB::table('cils as cil')
            ->join('developers as developer','cil.developer_id','=','developer.id')
            ->select('developer.id','developer.en_name')
            ->distinct()
            ->get();
        $projects = DB::table('cils as cil')
            ->join('projects as project','cil.project_id','=','project.id')
            ->select('project.id','project.en_name')
            ->distinct()
            ->get();
        $teamLeaderGroupID = DB::table('groups')->where('team_leader_id',auth()->user()->id)->value('id');
        $members = [];
        $groups = [];
        if($teamLeaderGroupID != null){
            $memberIds = DB::table('group_members')->where('group_id',$teamLeaderGroupID)->distinct()->pluck('member_id')->toArray();
            array_push($memberIds,auth()->user()->id);
            $members = DB::table('users')->whereIn('id',$memberIds)->select('id','name')->get();
        }
        if(auth()->user()->type == "admin"){
            $groups = DB::table('groups')->select('id','name')->get();
        }

        return response()->json([
            'developers' => $developers,
            'projects' => $projects,
            'teamMembers' => $members,
            'groups' => $groups
        ]);                                  
    }

    public function filterCils(Request $request){
        $cils = DB::table('cils as cil')->join('developers as developer','cil.developer_id','=','developer.id')
                                        ->join('projects as project','cil.project_id','=','project.id')
                                        ->leftjoin('leads as lead', 'cil.lead_id', '=', 'lead.id')
                                        ->join('users as user', 'cil.user_id', '=', 'user.id')
                                        ->leftjoin('users as sender', 'cil.sender_id', '=', 'sender.id');
        if($request->from_sent_date){
            $from_sent_date =  Carbon::parse($request->from_sent_date)->format('Y-m-d');
            $cils = $cils->where('cil.sent_date','>=',$from_sent_date. ' 00:00:00');
        }
        if($request->to_sent_date){
            $to_sent_date =  Carbon::parse($request->to_sent_date)->format('Y-m-d');
            $cils = $cils->where('cil.sent_date','<=',$to_sent_date. ' 24:59:59');
        }

        if($request->from_expire_on){
            $from_expire_on =  Carbon::parse($request->from_expire_on)->format('Y-m-d');
            $cils = $cils->where('cil.expire_on','>=',$from_expire_on. ' 00:00:00');
        }
        if($request->to_expire_on){
            $to_expire_on =  Carbon::parse($request->to_expire_on)->format('Y-m-d');
            $cils = $cils->where('cil.expire_on','<=',$to_expire_on. ' 24:59:59');
        }

        if($request->created_at){
            $from_created_at =  Carbon::parse($request->from_created_at)->format('Y-m-d');
            $cils = $cils->where('cil.created_at','>=',$from_created_at. ' 00:00:00');
        }
        if($request->to_created_at){
            $to_created_at =  Carbon::parse($request->to_created_at)->format('Y-m-d');
            $cils = $cils->where('cil.created_at','<=',$to_created_at. ' 24:59:59');
        }
        if($request->developers && count($request->developers) > 0){
            $cils = $cils->whereIn('cil.developer_id',$request->developers);
        }
        if($request->projects && count($request->projects) > 0){
            $cils = $cils->whereIn('cil.project_id',$request->projects);
        }
        if($request->status){
            $cils = $cils->where('cil.status',$request->status);
        }
        if($request->teamMembers){
            $cils = $cils->whereIn('cil.user_id',$request->teamMembers);
        }
        if($request->groups){
            $teamMembers = DB::table('group_members')->whereIn('group_id',$request->groups)->distinct()->pluck('member_id')->toArray();
            $teamLeaders = DB::table('groups')->whereIn('id',$request->groups)->pluck('team_leader_id')->toArray();
            $allTeam = array_unique(array_merge($teamMembers,$teamLeaders));   
            $cils = $cils->whereIn('cil.user_id',$allTeam);
        }
        
        $cils = $cils->select(
            'cil.id',
            'lead.first_name as lead_first_name',
            'lead.last_name as lead_last_name',
            'project.en_name as project',
            'developer.en_name as developer',
            'user.name as user',
            'cil.status',
            'sender.name as sender_name',
            'cil.created_at',
            'cil.sent_date',
            'cil.expire_on'
        )->orderBy('cil.created_at','desc')->paginate(100);
        foreach($cils as $cil){
            if($cil->status == 'not_sent'){
                $cil->status = "Waiting To Send";
            }
        }
        return $cils;
    }
    
    public function getCilReplies($id){
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

                $data = [];        
                if (imap_search($mailbox, 'SUBJECT "Re: CIL_'.$id.'"',SE_UID)) {
                    $data = imap_search($mailbox, 'SUBJECT "Re: CIL_'.$id.'"',SE_UID);
                    $arr = array_reverse($data);
                    $messages = [];
                    $x = count($arr);
                    for ($i = 0; $i < $x; $i++) {
                        $messages[] = (imap_fetchbody($mailbox,$arr[$i],1));
                    }
                }

                imap_close($mailbox);
                return response()->json($messages);
            } catch (\ErrorException $e) {
                return response()->json("There are no Cils With this id in email messages!!");
            }
        } else {
            return response()->json("This email is not connected with any mail providers");
        }
    }
    public function signalHelperCils($player_id = null,$Omassege=null,$url='',$data=[])
    {
        // dd($Omassege);
        $app_id = config('onesignal.app_id');
        if($app_id != null && $app_id != ""){
            if($player_id != 'No Player id' && $player_id != null && $url != null){
                OneSignal::sendNotificationToUser(
                    $Omassege,
                    $player_id,
                    $url = null,
                    $data = null
                );
            }
        }
        
        // return response()->json([
        //     'status' => "ok",
        //     "massege" => 'sending one OneSignal'
        // ]);
    }
}
