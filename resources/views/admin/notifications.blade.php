@extends('admin.index')

@section('content')
<style type="text/css">
    img{
        width: 30px;
    }
</style>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Notification</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
         
            <div class="container">
                <ul >
                 
                    <hr style="margin: 0 !important;"/>
                    @if(@\App\ProjectRequest::where('created_at', '<=', date('Y-m-d') . ' 23:59:59')->count() > 0)
                        <h6 style="padding: 0 20px; text-transform: uppercase; color: darkgrey;">{{ __('admin.project') }}</h6>
                        <li class="user-body" style="padding: 0 15px">
                            <div class="row">
                                <div class="col-md-12" style="padding: 0;position: relative;">
                                    <ul id="notifications" style="list-style: none">
                                        @if(auth()->user()->type == 'admin')
                                            @foreach(@\App\ProjectRequest::get() as $row)
                                                <li style="border-bottom: solid 1px silver;">
                                                    <a href="{{ url(adminPath().'/get_project') }}">
                                                        new project pushed to you "{{ $row->name }}"
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </li>
                    @endif
                    @if(@\App\AdminNotification::count() > 0)
                        <h6 style="padding: 0 20px; text-transform: uppercase; color: darkgrey;">{{ __('admin.today') }}</h6>
                        <li class="user-body" style="padding: 0 15px">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul id="notifications">
                                        @foreach(@\App\AdminNotification::where('user_id', auth()->user()->id)->orWhere(assigned_to, auth()->user()->id)->get() as $notify)
                                            @if($notify->type == 'switch')
                                                <li @if($notify->status == 1) style="background-color: #86caff" @endif>
                                                    <a href="{{ url(adminPath().'/leads/'.$notify->type_id) }}">
                                                        <img src="{{ url('images/notify/switch.png') }}">
                                                        {{ \App\User::find($notify->user_id)->name . ' ' . __('admin.has_switched') }}
                                                        @if($notify->type_id != 'bulk')
                                                            {{ @\App\Lead::find($notify->type_id)->prefix_name . ' ' . @\App\Lead::find($notify->type_id)->first_name }}
                                                        @else
                                                            {{ __('admin.bulk') }}
                                                        @endif
                                                        {{__('admin.to') . ' ' . @\App\User::find($notify->assigned_to)->name }}
                                                    </a>
                                                </li>
                                            @elseif($notify->type == 'task')

                                                        <li style="@if($notify->status==0)background:#0000001a;@endif border-bottom: solid 1px silver;">

                                                            <a type='leads' class="notificationElement"
                                                               url="{{ url(adminPath().'/tasks/'.$notify->type_id) }}"
                                                               nid="{{ $notify->id }}"
                                                               href="#">
                                                            <div class="v-bar"><i class="fa fa-circle"
                                                                                  id="noti-{{ $notify->id }}"
                                                                                  @if($notify->status == 0) style="color:{{ @$color }};" @endif></i>
                                                            </div>
                                                            <div class="noti-icon"><img
                                                                        src="{{ url('images/notify/task.png') }}">
                                                            </div>
                                                                <span>
                                                                    New Task has Added to You
                                                                </span>
                                                            <div class='timeAgo'>{{time_ago($notify->created_at)}}</div>
                                                            </a>


                                                        </li>

                                                    @elseif($notify->type == 'finish_task')

                                                        <li style="@if($notify->status==0)background:#0000001a;@endif border-bottom: solid 1px silver;">
                                                            <div class="v-bar"><i class="fa fa-circle"
                                                                                  id="noti-{{ $notify->id }}"
                                                                                  @if($notify->status == 0) style="color:{{ @$color }};" @endif></i>
                                                            </div>
                                                            <div class="noti-icon"><img
                                                                        src="{{ url('images/notify/task.png') }}">
                                                            </div>
                                                            <a type='leads' class="notificationElement"
                                                               url="{{ url(adminPath().'/tasks/'.$notify->type_id) }}"
                                                               nid="{{ $notify->id }}"
                                                               href="#">
                                                                <span>
                                                                    {{ @App\User::find($notify->user_id)->name }}
                                                                    finished his task

                                                                 </span>
                                                            </a>

                                                            <div class='timeAgo'>{{time_ago($notify->created_at)}}</div>
                                                        </li>

                                                    @elseif($notify->type == 'to_do')

                                                        <li style="@if($notify->status==0)background:#0000001a;@endif border-bottom: solid 1px silver;">
                                                            <div class="v-bar"><i class="fa fa-circle"
                                                                                  id="noti-{{ $notify->id }}"
                                                                                  @if($notify->status == 0) style="color:{{ @$color }};" @endif></i>
                                                            </div>
                                                            <div class="noti-icon"><img
                                                                        src="{{ url('images/notify/to-do.png') }}">
                                                            </div>
                                                            <a type='leads' class="notificationElement"
                                                               url="{{ url(adminPath().'/todos/'.$notify->type_id) }}"
                                                               nid="{{ $notify->id }}"
                                                               href="#">
                                                                <span>
                                                                    You have a to-do to finish

                                                                 </span>
                                                            </a>

                                                            <div class='timeAgo'>{{time_ago($notify->created_at)}}</div>
                                                        </li>

                                                    @elseif($notify->type == 'close_deal')

                                                        <li style="@if($notify->status==0)background:#0000001a;@endif border-bottom: solid 1px silver;">
                                                            <div class="v-bar"><i class="fa fa-circle"
                                                                                  id="noti-{{ $notify->id }}"
                                                                                  @if($notify->status == 0) style="color:{{ @$color }};" @endif></i>
                                                            </div>
                                                            <div class="noti-icon"><img
                                                                        src="{{ url('images/notify/close-deal.png') }}">
                                                            </div>
                                                            <a type='leads' class="notificationElement"
                                                               url="{{ url(adminPath().'/deals/'.$notify->type_id) }}"
                                                               nid="{{ $notify->id }}"
                                                               href="#">
                                                                <span>
                                                            {{ \App\User::find($notify->user_id)->name . ' ' . __('admin.has_switched') }}
                                                                    {{ @App\User::find($notify->user_id)->name }} closed a deal
                                                                 </span>
                                                            </a>

                                                            <div class='timeAgo'>{{time_ago($notify->created_at)}}</div>
                                                        </li>

                                                    @elseif($notify->type == 'favorite')

                                                        <li style="@if($notify->status==0)background:#0000001a;@endif border-bottom: solid 1px silver;">
                                                            <div class="v-bar"><i class="fa fa-circle"
                                                                                  id="noti-{{ $notify->id }}"
                                                                                  @if($notify->status == 0) style="color: {{ @$color }};" @endif></i>
                                                            </div>
                                                            <div class="noti-icon"><img
                                                                        src="{{ url('uploads/noti/fav.png') }}">
                                                            </div>
                                                            <a type='leads' class="notificationElement"
                                                               url="{{ url(adminPath().'/lead/'.$notify->type_id) }}"
                                                               nid="{{ $notify->id }}"
                                                               href="#">
                                                                <span>
                                                                    {{ App\Lead::find($notify->type_id)->first_name }}
                                                                    add a {{ App\Favorite::find($notify->type_id)->type }}
                                                                    to his favorite
                                                                 </span>
                                                            </a>

                                                            <div class='timeAgo'>{{time_ago($notify->created_at)}}</div>
                                                        </li>

                                                    @elseif($notify->type == 'new_website_lead')

                                                        <li style="@if($notify->status==0)background:#0000001a;@endif border-bottom: solid 1px silver;">
                                                            <div class="v-bar"><i class="fa fa-circle"
                                                                                  id="noti-{{ $notify->id }}"
                                                                                  @if($notify->status == 0) style="color:{{ @$color }};" @endif></i>
                                                            </div>
                                                            <div class="noti-icon"><img
                                                                        src="{{ url('images/notify/website-leads-01.png') }}">
                                                            </div>
                                                            <a type='leads' class="notificationElement"
                                                               url="{{ url(adminPath().'/leads/'.$notify->type_id) }}"
                                                               nid="{{ $notify->id }}"
                                                               href="#">
                                                                <span>
                                                                    {{ App\Lead::find($notify->type_id)->first_name }}
                                                                    add from website
                                                                </span>
                                                            </a>

                                                            <div class='timeAgo'>{{time_ago($notify->created_at)}}</div>
                                                        </li>

                                                        @elseif($notify->type == 'note_lead')

                                                        <li style="@if($notify->status==0)background:#0000001a;@endif border-bottom: solid 1px silver;">
                                                            <div class="v-bar"><i class="fa fa-circle"
                                                                                  id="noti-{{ $notify->id }}"
                                                                                  @if($notify->status == 0) style="color:{{ @$color }};" @endif></i>
                                                            </div>
                                                            <div class="noti-icon"><img
                                                                        src="{{ url('images/notify/website-leads-01.png') }}">
                                                            </div>
                                                            <a type='leads' class="notificationElement"
                                                               url="{{ url(adminPath().'/leads/'.$notify->type_id) }}"
                                                               nid="{{ $notify->id }}"
                                                               href="#">
                                                                <span>

                                                                    {{ App\User::find($notify->user_id)->name }}
                                                                    add a note in lead 
                                                                    {{ App\Lead::find($notify->type_id)->first_name }}
                                                                </span>
                                                            </a>

                                                            <div class='timeAgo'>{{time_ago($notify->created_at)}}</div>
                                                        </li>

                                                     @elseif($notify->type == 'added_lead' )
                                                        <li style="@if($notify->status==0)background:#0000001a;@endif border-bottom: solid 1px silver;">
                                                            <div class="v-bar"><i class="fa fa-circle"
                                                            id="noti-{{ $notify->id }}"
                                                            @if($notify->status == 0) style="color:{{ @$color }};" @endif></i>
                                                            </div>
                                                            <div class="noti-icon"><img
                                                                        src="{{ url('images/notify/add-leads.png') }}">
                                                            </div>
                                                            <a type='leads' class="notificationElement"
                                                               url="{{ url(adminPath().'/leads/'.$notify->type_id) }}"
                                                               nid="{{ $notify->id }}"
                                                               href="#">
                                                                <span>
                                                                    New lead has Added to You
                                                                </span>
                                                            </a>

                                                            <div class='timeAgo'>{{time_ago($notify->created_at)}}</div>
                                                        </li>
                                                        @elseif(auth()->user()->type == 'admin' && $notify->type == 'broadcast_event' )
                                                        <li style="@if($notify->status==0)background:#0000001a;@endif border-bottom: solid 1px silver;">
                                                            <div class="v-bar"><i class="fa fa-circle"
                                                            id="noti-{{ $notify->id }}"
                                                            @if($notify->status == 0) style="color:{{ @$color }};" @endif></i>
                                                            </div>
                                                            <div class="noti-icon"><img
                                                                        src="{{ url('images/notify/website-leads-01.png') }}">
                                                            </div>
                                                            <a type='leads' class="notificationElement"
                                                               url="{{ url(adminPath().'/events_request/'.$notify->type_id) }}"
                                                               nid="{{ $notify->id }}"
                                                               href="#">
                                                                <span>
                                                                    New BroadCast Event "{{\App\ProdcastEvent::where('id',$notify->type_id)->first()->title_event_en}}" IS Added
                                                                </span>
                                                            </a>

                                                            <div class='timeAgo'>{{time_ago($notify->created_at)}}</div>
                                                        </li>
                                                  @elseif(auth()->user()->type == 'admin' && $notify->type =='project_added')
                                                      <li style="@if($notify->status==0)background:#0000001a;@endif border-bottom: solid 1px silver;">
                                                                <a class="notificationElement"
                                                               nid="{{ $notify->id }}"
                                                               href="#"
                                                               url="{{ url(adminPath().'/get_project') }}" type="project">
                                                                    <div>
                                                                        <div class="v-bar"><i class="fa fa-circle"
                                                                                  id="noti-{{ $notify->id }}"
                                                                                  @if($notify->status == 0) style="color:{{ @$color }};" @endif></i></div>
                                                                        <div class="noti-icon"><img
                                                                                    src="{{ url('images/notify/websiteleads.png') }}">
                                                                        </div>
                                                                        <span>new project pushed to you "{{ $notify->name }}
                                                                            "</span>
                                                                    </div>
                                                                    <div class='timeAgo'>{{time_ago($notify->created_at)}}</div>
                                                                </a>
                                                      </li>
                                                      
                                                    @endif
                                            
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </li>
                    @endif
                    @if(@\App\AdminNotification::count() > 0)
                        <h6 style="padding: 0 20px; text-transform: uppercase; color: darkgrey;">{{ __('admin.earlier') }}</h6>
                        <li class="user-body" style="padding: 0 15px">
                            <div class="row">
                                <div class="col-md-12" style="padding: 0;position: relative;">
                                    <ul id="notifications" style="list-style: none">
                                        @foreach(@\App\AdminNotification::where('user_id', auth()->user()->id)->orWhere(assigned_to, 'auth()->user()->id')->get() as $notify)
                                            @if($notify->type == 'switch')
                                                <li style="border-bottom: solid 1px silver;@if($notify->status==1) background-color: #86caff @endif">
                                                    <a href="{{ url(adminPath().'/leads/'.$notify->type_id) }}">
                                                        {{ \App\User::find($notify->user_id)->name . ' ' . __('admin.has_switched') }}
                                                        @if($notify->type_id != 'bulk')
                                                            {{ @\App\Lead::find($notify->type_id)->prefix_name . ' ' . @\App\Lead::find($notify->type_id)->first_name }}
                                                        @else
                                                            {{ __('admin.bulk') }}
                                                        @endif
                                                        {{__('admin.to') . ' ' . @\App\User::find($notify->assigned_to)->name }}

                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection
