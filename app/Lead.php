<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Result {
    public $count = 0;
    public $leads = [];
}

class Lead extends Authenticatable
{
    use HasApiTokens, Notifiable;

    private static $allLeads = [];

    public function toArray(){
        $lead = Parent::toArray();
        $lead['requests'] = $this->requests;
        return $lead;
    }

    public static function getLeads($id)
    {
        $groups = Group::where('parent_id', $id)->get();
        foreach ($groups as $group) {
            foreach (GroupMember::where('group_id', $group->id)->get() as $member) {

                array_push(self::$allLeads, $member->member_id);
                self::getLeads($group->id);
            }
        }
    }

    public static function getAgentLeads($user = null, $pageNate = null, $page = 1)
    {
        if ($user == null)
            $userData = auth()->user();
        else
            $userData = $user;

        // $total = 0;
        // $result = new Result();
        if ($userData->type == 'admin' or checkRole('show_all_leads', $userData)) {

            if ($pageNate == null) {
                return Lead::orderBy('created_at', 'desc')->get(['id','first_name', 'last_name', 'agent_id']);
                // $result->count = $result->leads->count();
            } else {
                $lds = Lead::orderBy('created_at', 'desc');
                // $result->count = round($lds->count() / $pageNate);
                return $lds->offset(($page-1)*$pageNate)->limit($pageNate)->get(['id','first_name', 'last_name', 'agent_id']);
            }
        } else {
                /* if (count(Group::where('team_leader_id', $userData->id)->get()) > 0) {
                $users = [];
                foreach (Group::where('team_leader_id', $userData->id)->get() as $group) {
                    if ($group->parent_id != 0) {
                        foreach (GroupMember::where('group_id', $group->id)->get() as $member) {
                            $users[] = $member->member_id;
                        }
                    } else {
                        self::getLeads($group->id);
                        $users = self::$allLeads;
                    }
                }
                $users[] = auth()->id();
                if ($pageNate == null) {
                    return Lead::whereIn('agent_id', $users)->orWhereIn('commercial_agent_id', $users)->orderBy('updated_at', 'desc')->get();
                } else {
                    return Lead::whereIn('agent_id', $users)->orWhereIn('commercial_agent_id', $users)->orderBy('updated_at', 'desc')->offset(($page-1)*$pageNate)->limit($pageNate)->get();
                }
            } else {*/
                if ($pageNate == null) {
                    return Lead::where('agent_id', $userData->id)->orWhere('commercial_agent_id', $userData->id)->orderBy('created_at', 'desc')->get(['id','first_name', 'last_name', 'agent_id']);
                    // $result->count = $result->leads->count();
                } else {
                    if($page == 1){
                        $lds = Lead::where('agent_id', $userData->id)->orWhere('commercial_agent_id', $userData->id)->orderBy('created_at', 'desc');
                        // $result->count = round($lds->count() / $pageNate);
                        return $lds->offset(($page-1)*$pageNate)->limit($pageNate)->get(['id','first_name', 'last_name', 'agent_id']);
                    } else {
                        // $result->count = 0;
                        return Lead::where('agent_id', $userData->id)->orWhere('commercial_agent_id', $userData->id)->orderBy('created_at', 'desc')->offset(($page-1)*$pageNate)->limit($pageNate)->get(['id','first_name', 'last_name', 'agent_id']);
                    }
                }
        }

        return null;
    }

    public static function getAgentLeadsResult($user = null, $pageNate = null, $page = 1)
    {
        if ($user == null)
            $userData = auth()->user();
        else
            $userData = $user;

        $total = 0;
        $result = new Result();
        if ($userData->type == 'admin' or checkRole('show_all_leads', $userData)) {

            if ($pageNate == null) {
                $result->leads = Lead::orderBy('created_at', 'desc')->get();
                $result->count = $result->leads->count();
            } else {
                $lds = Lead::orderBy('created_at', 'desc');
                $result->count = round($lds->count() / $pageNate);
                $result->leads = $lds->offset(($page-1)*$pageNate)->limit($pageNate)->get();
            }
        } else {
                /* if (count(Group::where('team_leader_id', $userData->id)->get()) > 0) {
                $users = [];
                foreach (Group::where('team_leader_id', $userData->id)->get() as $group) {
                    if ($group->parent_id != 0) {
                        foreach (GroupMember::where('group_id', $group->id)->get() as $member) {
                            $users[] = $member->member_id;
                        }
                    } else {
                        self::getLeads($group->id);
                        $users = self::$allLeads;
                    }
                }
                $users[] = auth()->id();
                if ($pageNate == null) {
                    return Lead::whereIn('agent_id', $users)->orWhereIn('commercial_agent_id', $users)->orderBy('updated_at', 'desc')->get();
                } else {
                    return Lead::whereIn('agent_id', $users)->orWhereIn('commercial_agent_id', $users)->orderBy('updated_at', 'desc')->offset(($page-1)*$pageNate)->limit($pageNate)->get();
                }
            } else {*/
                if ($pageNate == null) {
                    $result->leads = Lead::where('agent_id', $userData->id)->orWhere('commercial_agent_id', $userData->id)->orderBy('created_at', 'desc')->get();
                    $result->count = $result->leads->count();
                } else {
                    if($page == 1){
                        $lds = Lead::where('agent_id', $userData->id)->orWhere('commercial_agent_id', $userData->id)->orderBy('created_at', 'desc');
                        $result->count = round($lds->count() / $pageNate);
                        $result->leads = $lds->offset(($page-1)*$pageNate)->limit($pageNate)->get();
                    } else {
                        // $result->count = 0;
                        $result->leads = Lead::where('agent_id', $userData->id)->orWhere('commercial_agent_id', $userData->id)->orderBy('created_at', 'desc')->offset(($page-1)*$pageNate)->limit($pageNate)->get();
                    }
                }
        }

        return $result;
    }

    public static function getAgentLeadsByAgent($user = null, $pageNate = null, $page = 1, $agent_id)
    {
        if ($user == null)
            $userData = auth()->user();
        else
            $userData = $user;
        if ($userData->type == 'admin' or checkRole('show_all_leads', $userData)) {

            if ($pageNate == null) {
                return Lead::where('agent_id', $agent_id)->orderBy('created_at', 'desc')->get();
            } else {
                return Lead::where('agent_id', $agent_id)->orderBy('created_at', 'desc')->offset(($page-1)*$pageNate)->limit($pageNate)->get();
            }
        } else {
/*            if (count(Group::where('team_leader_id', $userData->id)->get()) > 0) {
                $users = [];
                foreach (Group::where('team_leader_id', $userData->id)->get() as $group) {
                    if ($group->parent_id != 0) {
                        foreach (GroupMember::where('group_id', $group->id)->get() as $member) {
                            $users[] = $member->member_id;
                        }
                    }
                    $users[] = $userData->id;
                    if ($pageNate == null) {
                        return Lead::whereIn('agent_id', $users)->orWhereIn('commercial_agent_id', $users)->get();
                    } else {
                        self::getLeads($group->id);
                        $users = self::$allLeads;
                    }
                }
                $users[] = auth()->id();
                if ($pageNate == null) {
                    return Lead::whereIn('agent_id', $users)->orWhereIn('commercial_agent_id', $users)->get();
                } else {
                    return Lead::whereIn('agent_id', $users)->orWhereIn('commercial_agent_id', $users)->offset(($page-1)*$pageNate)->limit($pageNate)->get();
                }
            } else {*/
                if ($pageNate == null) {
                    return Lead::where('agent_id', $userData->id)->orWhere('commercial_agent_id', $userData->id)->orderBy('created_at', 'desc')->get();
                } else {
                    return Lead::where('agent_id', $userData->id)->orWhere('commercial_agent_id', $userData->id)->orderBy('created_at', 'desc')->offset(($page-1)*$pageNate)->limit($pageNate)->get();
                }
/*            }*/
        }
    }

    public static function getAgentLeadsSync($user = null, $pageNate = null, $page = 1, $last_sync, $ids)
    {
        if ($user == null)
            $userData = auth()->user();
        else
            $userData = $user;

        if ($userData->type == 'admin' or checkRole('show_all_leads', $userData)) {
            if ($pageNate == null) {
                return Lead::where('created_at', '>=', $last_sync)->orWhereIn('id', $ids)->orderBy('created_at', 'desc')->get();
            } else {
                return Lead::where('created_at', '>=', $last_sync)->orWhereIn('id', $ids)->orderBy('created_at', 'desc')->offset(($page-1)*$pageNate)->limit($pageNate)->get();
            }
        } else {
            if (count(Group::where('team_leader_id', $userData->id)->get()) > 0) {
                $users = [];
                foreach (Group::where('team_leader_id', $userData->id)->get() as $group) {
                    if ($group->parent_id != 0) {
                        foreach (GroupMember::where('group_id', $group->id)->get() as $member) {
                            $users[] = $member->member_id;
                        }
                    } else {
                        self::getLeads($group->id);
                        $users = self::$allLeads;
                    }
                }
                $users[] = $userData->id;
                if ($pageNate == null) {
                    return Lead::where('created_at', '>=', $last_sync)->WhereIn('agent_id', $users)->orWhereIn('id', $ids)->orWhereIn('commercial_agent_id', $users)->orderBy('created_at', 'desc')->get();
                } else {
                    return Lead::where('created_at', '>=', $last_sync)->WhereIn('agent_id', $users)->orWhereIn('id', $ids)->orWhereIn('commercial_agent_id', $users)->orderBy('created_at', 'desc')->offset(($page-1)*$pageNate)->limit($pageNate)->get();
                }
            } else {
                if ($pageNate == null) {
                    return Lead::where('agent_id', $userData->id)->where('created_at', '>=', $last_sync)->orWhereIn('id', $ids)->orWhere('commercial_agent_id', $userData->id)->orderBy('created_at', 'desc')->get();
                } else {
                    return Lead::where('agent_id', $userData->id)->where('created_at', '>=', $last_sync)->orWhereIn('id', $ids)->orWhere('commercial_agent_id', $userData->id)->offset(($page-1)*$pageNate)->orderBy('created_at', 'desc')->limit($pageNate)->get();
                }
            }
        }
    }


    public static function getTeamLeads($user = null, $number = null, $count = 100)
    {

        if ($user == null)
            $userData = auth()->user();
        else
            $userData = $user;

        self::$allLeads = [];
        $leads = new Lead;
        if ($userData->type == 'admin' or checkRole('show_all_leads')) {
            if ($number == null) {
                $leads = Lead::where('agent_id', '!=', $userData->id)->where('agent_id', '!=', 0)->
                orWhere('commercial_agent_id', '!=', $userData->id)->where('commercial_agent_id', '!=', 0);
            } else {
                $leads = Lead::where('agent_id', '!=', $userData->id)->where('agent_id', '!=', 0)->
                orWhere('commercial_agent_id', '!=', $userData->id)->where('commercial_agent_id', '!=', 0);
            }
        } else {
            if (Group::where('team_leader_id', $userData->id)->count() > 0) {
                $users = [];
                foreach (Group::where('team_leader_id', $userData->id)->get() as $group) {
                    foreach (GroupMember::where('group_id', $group->id)->get() as $member) {
                        array_push(self::$allLeads, $member->member_id);
                    }
                    self::getLeads($group->id);
                    $users = self::$allLeads;
                }
                if ($number == null) {
                    $leads = Lead::whereIn('agent_id', $users)->orWhereIn('commercial_agent_id', $users);
                } else {
                    $leads = Lead::whereIn('agent_id', $users)->orWhereIn('commercial_agent_id', $users);
                }
            }
            /*elseif (count(GroupMember::where('member_id', $userData->id)->get()) > 0) {
                $allUsers = [];
                $groupMember = GroupMember::where('member_id', $userData->id)->get();
                foreach ($groupMember as $key => $value) {
                    $teamLeaderId = Group::where('parent_id', $value->group_id)->get()->pluck('team_leader_id')->toArray();
                    array_push($allUsers, $teamLeaderId);
                }
                    dd($teamLeaderId);
                return Lead::whereIn('agent_id', $teamLeaderId)->orWhereIn('commercial_agent_id', $teamLeaderId)->orderBy('created_at', 'desc')->paginate($count);
            }*/
        }
        $leads = $leads->select('id','agent_id','commercial_agent_id','lead_source_id','first_name','last_name','phone','status','created_at','phone_iso')->orderBy('created_at', 'desc')->paginate($count);
        return $leads;
    }

    public static function getTeamLeadsTwo($user = null, $number = null, $count = 25)
        {

            if ($user == null)
                $userData = auth()->user();
            else
                $userData = $user;

            self::$allLeads = [];

            if ($userData->type == 'admin' or checkRole('show_all_leads')) {

                if ($number == null) {
                    return Lead::where('agent_id', '!=', $userData->id)->where('agent_id', '!=', 0)->
                    orWhere('commercial_agent_id', '!=', $userData->id)->where('commercial_agent_id', '!=', 0)->
                    orderBy('created_at', 'desc');
                } else {
                    return Lead::where('agent_id', '!=', $userData->id)->where('agent_id', '!=', 0)->
                    orWhere('commercial_agent_id', '!=', $userData->id)->where('commercial_agent_id', '!=', 0)->
                    orderBy('created_at', 'desc');
                }
            } else {
                if (count(Group::where('team_leader_id', $userData->id)->get()) > 0) {
                    $users = [];

                    foreach (Group::where('team_leader_id', $userData->id)->get() as $group) {
                        foreach (GroupMember::where('group_id', $group->id)->get() as $member) {
                            array_push(self::$allLeads, $member->member_id);
                        }
                        self::getLeads($group->id);
                        $users = self::$allLeads;
                    }
                    if ($number == null) {
                        return Lead::whereIn('agent_id', $users)->orWhereIn('commercial_agent_id', $users)->orderBy('created_at', 'desc');
                    } else {
                        return Lead::whereIn('agent_id', $users)->orWhereIn('commercial_agent_id', $users)->orderBy('created_at', 'desc');
                    }
                }
            }
        }


    public static function getTeamLeads2($user = null, $number = null)
    {
        if ($user == null)
            $userData = auth()->user();
        else
            $userData = $user;
        if ($userData->type == 'admin' or checkRole('show_all_leads')) {
            if ($number == null) {

                return Lead::where('agent_id', '!=', $userData->id)->where('agent_id', '!=', 0)->
                orWhere('commercial_agent_id', '!=', $userData->id)->where('commercial_agent_id', '!=', 0)->
                orderBy('created_at', 'desc')->get();
            } else {
                return Lead::where('agent_id', '!=', $userData->id)->where('agent_id', '!=', 0)->
                orWhere('commercial_agent_id', '!=', $userData->id)->where('commercial_agent_id', '!=', 0)->
                orderBy('created_at', 'desc')->offset(($number-1)*20)->limit(20)->get();
            }
        } else {
            if (count(Group::where('team_leader_id', $userData->id)->get()) > 0) {
                $users = [];

                foreach (Group::where('team_leader_id', $userData->id)->get() as $group) {
                    foreach (GroupMember::where('group_id', $group->id)->get() as $member) {
                        array_push(self::$allLeads, $member->member_id);
                    }
                    self::getLeads($group->id);
                    $users = self::$allLeads;
                }
                if ($number == null) {
                    return Lead::whereIn('agent_id', $users)->orWhereIn('commercial_agent_id', $users)->orderBy('created_at', 'desc')->get();
                } else {
                    return Lead::whereIn('agent_id', $users)->orWhereIn('commercial_agent_id', $users)->orderBy('created_at', 'desc')->paginate(25, ['*'], 'team',$number);
                }
            }
        }
    }

     public static function getAgentLea($user = null)
    {
        if ($user == null)
            $userData = auth()->user();
        else
            $userData = $user;

        if ($userData->type == 'admin' or checkRole('show_all_leads', $userData)) {
            return Lead::get();

        } else {
            if (count(Group::where('team_leader_id', $userData->id)->get()) > 0) {
                $users = [];
                foreach (Group::where('team_leader_id', $userData->id)->get() as $group) {
                    if ($group->parent_id != 0) {
                        foreach (GroupMember::where('group_id', $group->id)->get() as $member) {
                            $users[] = $member->member_id;
                        }
                    } else {
                        self::getLeads($group->id);
                        $users = self::$allLeads;
                    }
                }
                $users[] = auth()->id();
                return Lead::whereIn('agent_id', $users)->orWhereIn('commercial_agent_id', $users)->get();
            } else {
                return Lead::where('agent_id', $userData->id)->orWhere('commercial_agent_id', $userData->id)->get()->paginate(25, ['*'], 'team',$number);
            }
        }
    }

    public function getLeadTags($leadID)
    {
        $tags = DB::table('lead_tag as lt')->where('lt.lead_id',$leadID)
							->join('tags as tag','lt.tag_id','=','tag.id')
							->select('tag.id','tag.en_name')
                            ->get();
        return $tags;                            
    }

    public function getLeadFirstTag($leadID)
    {
        $tag = DB::table('lead_tag as lt')->where('lt.lead_id',$leadID)
							->join('tags as tag','lt.tag_id','=','tag.id')
							->limit(1)
                            ->value('tag.en_name');
        return $tag;
    }

    public function reformPhone($phone){
        $countries = DB::table('countries')->select('iso','code')->get();
        $contact = phoneNumbersHandler($phone,$countries);
		$random_id = rand(0, 99999999999);
        $contact = $contact->getData();
        $prefix = '';
        if (str_split($contact->phone)[0] == '1') {
            $prefix = '0';
        } else if (str_split($contact->phone)[0] != '0' and str_split($contact->phone)[0] != '1') {
            $prefix = '00';
        }
        if($contact->phone == "WN"){
            $contact->phone = $prefix . $contact->phone . '_' . $random_id;

        }else if($contact->iso != "EG"){
            $country_code = DB::table('countries')->where('iso',$contact->iso)->value('code');
            $contact->phone = $prefix . $country_code . $contact->phone;
        }
        else{
            $contact->phone = $prefix . $contact->phone;
        }
        return $contact;
    }

    public function reformOtherPhones($other_phones){
        $lead_other_phones = '';
        $countries = DB::table('countries')->select('iso','code')->get();
        if($other_phones != null){
            $other_phones = explode(',',$other_phones);
            foreach($other_phones as $key => $other_phone){
		        $random_id = rand(0, 99999999999);
                $othercontact = phoneNumbersHandler($other_phone,$countries);
                $othercontact = $othercontact->getData();
                $prefix = '';
                if (str_split($othercontact->phone)[0] == '1') {
                    $prefix = '0';
                } else if (str_split($othercontact->phone)[0] != '0' and str_split($othercontact->phone)[0] != '1') {
                    $prefix = '00';
                }
                if($othercontact->iso != "EG"){
                    $country_code = DB::table('countries')->where('iso',$othercontact->iso)->value('code');
                    $other_phone = $prefix . $country_code . $othercontact->phone;
                }else{
                    $other_phone = $prefix . $othercontact->phone;
                }
                if($key == count($other_phones)-1){
                    $lead_other_phones .= $other_phone; 
                }else{
                    $lead_other_phones .= $other_phone . "," ;
                }
            }
        }else{
            return null;
        }
        return $lead_other_phones;
    }

    public function agent()
    {
        return $this->belongsTo('App\User', 'agent_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function commercialAgent()
    {
        return $this->belongsTo('App\User', 'commercial_agent_id');
    }

    public function source()
    {
        return $this->belongsTo('App\LeadSource', 'lead_source_id')->withDefault(['id' => null, 'name' => null]);
    }

    public function industry()
    {
        return $this->belongsTo('App\Industry');
    }

    public function title()
    {
        return $this->belongsTo('App\Title');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function documents()
    {
        return $this->hasMany('App\LeadDocument');
    }

    public function player(){
        return $this->hasMany('App\Player');
    }

    public function lead_actions()
    {
        return $this->hasMany('App\LeadAction');
    }

    public function requests()
    {
        return $this->hasMany('App\Request','lead_id');
    }

    public function calls()
    {
        return $this->hasMany('App\Call');
    }

    public function meetings()
    {
        return $this->hasMany('App\Meeting');
    }

    public function form(){
        return $this->belongsTo('App\Form', 'form_source_id');
    }

    public function tags(){
        return $this->belongsToMany('App\Tag', 'lead_tag', 'lead_id', 'tag_id');
    }
}
