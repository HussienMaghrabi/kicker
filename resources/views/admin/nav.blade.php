
<style>
    .dropdown-menu .sub-menu {
        left: 100%;
        position: absolute;
        top: 0;
        visibility: hidden;
        margin-top: -1px;
    }

    .dropdown-menu li:hover .sub-menu {
        visibility: visible;
    }

    .dropdown-menu .dropdown-menu {
        display: none !important;
        margin-left: 165px;
        background: rgba(0, 0, 0, 0.8);
        border: 0;
        margin-top: -32px !important;
    }

    .dropdown-menu:hover .dropdown-menu {
        display: block !important;
    }

    .dropdown:hover .dropdown-menu {
        display: block;
    }

    .nav-tabs .dropdown-menu,
    .nav-pills .dropdown-menu,
    .navbar .dropdown-menu {
        margin-top: 0;
    }

    .navbar .sub-menu:before {
        border-bottom: 7px solid transparent;
        border-left: none;
        border-right: 7px solid rgba(0, 0, 0, 0.2);
        border-top: 7px solid transparent;
        left: -7px;
        top: 10px;
    }

    .navbar .sub-menu:after {
        border-top: 6px solid transparent;
        border-left: none;
        border-right: 6px solid #fff;
        border-bottom: 6px solid transparent;
        left: 10px;
        top: 11px;
        left: -6px;
    }

    .user-menu .dropdown-menu {
        background: rgba(255, 255, 255, 1) !important;
    }
    .admin-noti li span {
        width: auto !important;
        right:auto;
        position: initial !important;
        font-size: 12px;
    }
    .admin-noti li span:hover{
        font-size: 14px;
    }
    .timeAgo{
        color:#ABABAB;
        margin-left: 20px;
    }
    .nav>li>a{
        padding: 10px 9px !important;
    }

    @media screen and (min-width: 767px) {
        .menu-list-mobile{
            visibility: hidden;
        }
    }

    @media screen and (max-width: 767px) {
        .menu-div{
            display: none;
        }

        .header-navbar{
            display: block !important;
        }
        .follow-up-header{
            width: 100% !important;
        }
    }

    .menu-icon{
        font-size: 2.5rem
    }

    .header-menu-icon{
        background: unset !important;
        border: unset !important;
        margin-top: 1.5rem;
    }
    
    .leads-content{
        display: none;
        list-style: none;
        position: absolute;
        left: 15rem;
        width: max-content;
        background: white;
        top: 0rem;
    }

    .inventory-content{
        display: none;
        list-style: none;
        position: absolute;
        left: 15rem;
        width: max-content;
        background: white;
        top: 3rem;
    }

    .marketing-content{
        display: none;
        list-style: none;
        position: absolute;
        left: 15rem;
        width: max-content;
        background: white;
        top: 5rem;
    }

    .marketing-campaigns-content{
        display: none;
        list-style: none;
        position: absolute;
        left: 14rem;
        width: max-content;
        background: white;
        top: 0rem;
    }

    .hr-content{
        display: none;
        list-style: none;
        position: absolute;
        left: 15rem;
        width: max-content;
        background: white;
        top: 8rem;
    }

    .leads-item:hover .leads-content,
    .inventory-item:hover .inventory-content,
    .hr-item:hover .hr-content,
    .marketing-campaigns-item:hover .marketing-campaigns-content,
    .marketing-item:hover .marketing-content{
        display: block;
    }

    .menu-div a{
        font-size: 1.8rem;
    }

    .header-navbar{
        display: flex;
    }

</style>


<header class="main-header">
    <nav class="navbar navbar-default">
        <div class="container-fluid header-navbar">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header col-lg-2">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="{{ url(adminPath()) }}" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>H</b>UB</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg">
            <img src="{{ url('uploads/'.getInfo()->logo) }}" style="max-height: 50px; padding-bottom: 7px">
        </span>
                </a>
            </div>
            <div class="btn-group menu-div">
                <button type="button" class="btn btn-default dropdown-toggle header-menu-icon" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-bars menu-icon" aria-hidden="true"></i>
                </button>
                <ul class="dropdown-menu" role="menu">
                    @if(checkRole('add_leads')
                    or checkRole('switch_leads')
                    or checkRole('edit_leads')
                    or checkRole('show_all_leads')
                    or checkRole('send_cil')
                    or checkRole('calls')
                    or checkRole('meetings')
                    or checkRole('requests')
                    or auth()->user()->type == 'admin')
                  <li class="test-bs leads-item"><a @if(Request::segment(2) == 'leads') class="gold-background" @endif
                    href="{{ url(adminPath().'/vue/leads') }}" target="_self"><img style="margin-right: 1rem" src="{{ url('icon/header-lead.png') }}">{{ trans('admin.lead') }}
                    </a>
                    <ul class="leads-content">
                            @if(checkRole('add_leads')
                            or checkRole('switch_leads')
                            or checkRole('edit_leads')
                            or checkRole('show_all_leads')
                            or checkRole('send_cil')
                            or auth()->user()->type == 'admin')
                                <li>
                                    <a @if(Request::segment(2) == 'leads') class="gold-background" @endif
                                    href="{{ url(adminPath().'/leads') }}">{{ trans('admin.all_leads') }}

                                    </a>
                                </li>
                            @endif
                            @if(checkRole('calls') or auth()->user()->type == 'admin')
                                <li class="treeview @if(Request::segment(2) == 'calls') menu-open active @endif">
                                    <a @if(Request::segment(2) == 'calls')  class="gold-background"
                                       @endif href="{{ url(adminPath().'/calls') }}"><span>{{ trans('admin.calls') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if(checkRole('meetings') or auth()->user()->type == 'admin')
                                <li>
                                    <a @if(Request::segment(2) == 'meetings') class="gold-background" @endif
                                    href="{{ url(adminPath().'/meetings') }}"><span>{{ trans('admin.meetings') }}</span>

                                    </a>
                                </li>
                            @endif
                            @if(checkRole('requests') or auth()->user()->type == 'admin')
                                <li>
                                    <a @if(Request::segment(2) == 'requests') class="gold-background"
                                       @endif href="{{ url(adminPath().'/requests') }}"><span>{{ trans('admin.requests') }}</span>


                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{url(adminPath().'/events_request')}}"></a>
                            </li>
                            <li>
                                <a @if(Request::segment(2) == 'requests') class="gold-background"
                                    @endif href="{{ url(adminPath().'/requests_broadcast') }}"> <span>{{ trans('admin.requests_broadcast') }}</span>
                                </a>
                            </li>
                      </ul>
                  </li>
                  @endif

                  @if(checkRole('add_developers')
                    or checkRole('edit_developers')
                    or checkRole('delete_developers')
                    or checkRole('show_developers')

                    or checkRole('add_projects')
                    or checkRole('edit_projects')
                    or checkRole('delete_projects')
                    or checkRole('show_projects')

                    or checkRole('add_phases')
                    or checkRole('edit_phases')
                    or checkRole('delete_phases')
                    or checkRole('show_phases')

                    or checkRole('add_properties')
                    or checkRole('edit_properties')
                    or checkRole('delete_properties')
                    or checkRole('show_properties')

                    or checkRole('add_resale_units')
                    or checkRole('edit_resale_units')
                    or checkRole('delete_resale_units')
                    or checkRole('show_resale_units')

                    or checkRole('add_rental_units')
                    or checkRole('edit_rental_units')
                    or checkRole('delete_rental_units')
                    or checkRole('show_rental_units')

                    or checkRole('add_lands')
                    or checkRole('edit_lands')
                    or checkRole('delete_lands')
                    or checkRole('show_lands')
                    or auth()->user()->type == 'admin')
                  <li class="test-bs inventory-item">
                    <a @if(Request::segment(2) == 'inventory' or Request::segment(2) == 'developers' or Request::segment(2) == 'projects' or Request::segment(2) == 'resale_units' or Request::segment(2) == 'rental_units' or Request::segment(2) == 'lands') class="gold-background"
                    @endif href="{{ url(adminPath().'/inventory') }}" class="dropdown-toggle"
                    data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span><img style="margin-right: 1rem" src="{{ url('icon/header-inventory.png') }}">{{ trans('admin.inventory') }}</span>
                     </a>
                    <ul class="inventory-content">
                            @if(checkRole('add_developers') or checkRole('edit_developers') or checkRole('delete_developers') or checkRole('show_developers') or auth()->user()->type == 'admin')
                            <li>
                                <a @if(Request::segment(2) == 'developers') class="gold-background"
                                   @endif href="{{ url(adminPath().'/developers') }}"><span>{{ trans('admin.developers') }}</span>
                                </a>
                            </li>
                        @endif
                        @if(checkRole('add_lands') or checkRole('edit_lands') or checkRole('delete_lands') or checkRole('show_lands') or auth()->user()->type == 'admin')
                            <li>
                                <a @if(Request::segment(2) == 'lands') class="gold-background"
                                   @endif href="{{ url(adminPath().'/lands') }}"><span>{{ trans('admin.lands') }}</span>

                                </a>
                            </li>
                        @endif
                        @if(checkRole('add_projects') or checkRole('edit_projects') or checkRole('delete_projects') or checkRole('show_projects') or auth()->user()->type == 'admin')
                            <li class="treeview @if(Request::segment(2) == 'projects') menu-open active @endif">
                                <a @if(Request::segment(2) == 'projects') class="gold-background"
                                   @endif href="{{ url(adminPath().'/projects') }}"><span>{{ trans('admin.projects') }}</span>

                                </a>
                            </li>
                        @endif
                        @if(checkRole('add_resale_units') or checkRole('edit_resale_units') or checkRole('delete_resale_units') or checkRole('show_resale_units') or auth()->user()->type == 'admin')
                            <li class="treeview @if(Request::segment(2) == 'resale_units') menu-open active @endif">
                                <a @if(Request::segment(2) == 'resale_units') class="gold-background"
                                   @endif href="{{ url(adminPath().'/resale_units') }}"><span>{{ trans('admin.resale_units') }}</span>
                                </a>
                            </li>
                        @endif
                        @if(checkRole('add_rental_units') or checkRole('edit_rental_units') or checkRole('delete_rental_units') or checkRole('show_rental_units') or auth()->user()->type == 'admin')
                            <li class="treeview @if(Request::segment(2) == 'rental_units') menu-open active @endif">
                                <a @if(Request::segment(2) == 'rental_units') class="gold-background"
                                   @endif href="{{ url(adminPath().'/rental_units') }}"><span>{{ trans('admin.rental_units') }}</span>
                                </a>
                            </li>
                        @endif
                      </ul>
                  </li>
                  @endif

                  @if(checkRole('marketing') or auth()->user()->type == 'admin')
                  <li class="test-bs marketing-item">
                        <a @if(Request::segment(2) == 'marketing') class="gold-background" @endif href="#"
                        class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                        aria-expanded="false">
                         <span><img style="margin-right: 1rem" src="{{ url('icon/header-marketing.png') }}">{{ trans('admin.marketing') }}</span>
                     </a>
                    <ul class="marketing-content">
                            <li class="marketing-campaigns-item">
                                    <a @if(Request::segment(2) == 'campaigns') class="gold-background sub"
                                       @endif href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">
                                        <span>{{ trans('admin.campaigns') }} &nbsp &nbsp &nbsp </span>

                                    </a>
                                    <ul class="marketing-campaigns-content">
                                        <li>
                                            <a @if(Request::segment(2) == 'campaign_types' and Request::segment(3) == '') class="gold-background"
                                               @endif href="{{ url(adminPath().'/campaign_types') }}">{{ trans('admin.all') }} {{ trans('admin.types') }}
                                            </a></li>
                                        <li>
                                            <a @if(Request::segment(2) == 'campaign_types' and Request::segment(3) == 'create') class="gold-background"
                                               @endif href="{{ url(adminPath().'/campaign_types/create') }}">{{ trans('admin.add') }} {{ trans('admin.type') }}
                                            </a></li>
                                        <li>
                                            <a @if(Request::segment(2) == 'campaigns' and Request::segment(3) == '') class="gold-background"
                                               @endif href="{{ url(adminPath().'/campaigns') }}">{{ trans('admin.all') }} {{ trans('admin.campaigns') }}
                                            </a></li>
                                        <li>
                                            <a @if(Request::segment(2) == 'campaigns' and Request::segment(3) == 'create') class="gold-background"
                                               @endif href="{{ url(adminPath().'/campaigns/create') }}">{{ trans('admin.add') }} {{ trans('admin.campaigns') }}
                                            </a>
                                        </li>
                                        <li>
                                            <form id="ddssa" action="{{ url(adminPath().'/export_xls') }}" method="post"
                                                  enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <a id="ddss" class="gold-background" href="#" type="submit">
                                                    <span> {{ trans('admin.export_excel_file') }}</span>
                                                </a>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a @if(Request::segment(2) == 'developers_facebook') class="gold-background"
                                       @endif href="{{ url(adminPath().'/developers_facebook') }}">
                                        <span> {{ trans('admin.developers') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if(Request::segment(2) == 'projects_facebook') class="gold-background"
                                       @endif href="{{ url(adminPath().'/projects_facebook') }}">
                                        <span> {{ trans('admin.projects') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if(Request::segment(2) == 'competitors_facebook') class="gold-background"
                                       @endif href="{{ url(adminPath().'/competitors_facebook') }}">
                                        <span> {{ trans('admin.competitors') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a @if(Request::segment(2) == 'forms') class="gold-background"
                                       @endif href="{{ url(adminPath().'/forms') }}">{{ trans('admin.forms') }}
                                    </a>
                                </li>
                      </ul>
                  </li>
                  @endif
                  
                  <li><a @if(Request::segment(2) == 'proposals') class="gold-background"
                    @endif href="{{ url(adminPath().'/proposals') }}">
                     <span><img style="margin-right: 1rem" src="{{ url('icon/header-proposals.png') }}">{{ trans('admin.proposals') }}</span>

                 </a></li>
                 
                 @if(checkRole('deals') or auth()->user()->type == 'admin')
                 <li><a @if(Request::segment(2) == 'deals') class="gold-background"
                    @endif href="{{ url(adminPath().'/deals') }}">
                     <span><img style="margin-right: 1rem" src="{{ url('icon/header-closed-deals.png') }}">{{ trans('admin.closed_deals') }}</span>

                 </a></li>
                 @endif

                 @if(checkRole('finance') or auth()->user()->type == 'admin')
                 <li><a @if(Request::segment(2) == 'finances') class="gold-background"
                    @endif href="{{ url(adminPath().'/finances') }}">
                     <span><img style="margin-right: 1rem" src="{{ url('icon/header-finances.png') }}">{{ trans('admin.finances') }}</span>

                 </a></li>
                 @endif

                 @if(auth()->user()->type == 'admin' or auth()->user()->hr == 1)
                  <li class="test-bs hr-item"><a @if(Request::segment(2) == 'Hr') class="gold-background"
                    @endif href="{{ url(adminPath().'/emp-dashboard') }}">
                     <span><img style="margin-right: 1rem" src="{{ url('icon/header-hr.png') }}">{{ trans('admin.hr') }}</span>
                 </a>
                    <ul class="hr-content">
                        <li><a class="gold-background" href="{{ url(adminPath().'/job_categories') }}">{{ trans('admin.job_categories') }}</a></li>
                        <li><a class="gold-background" href="{{ url(adminPath().'/job_titles') }}">{{ trans('admin.job_titles') }}</a></li>
                        <li><a class="gold-background" href="{{ url(adminPath().'/vacancies') }}">{{ trans('admin.vacancies') }}</a></li>
                        <li><a class="gold-background" href="{{ url(adminPath().'/applications') }}">{{ trans('admin.applications') }}</a></li>
                        <li><a class="gold-background" href="{{ url(adminPath().'/employees') }}">{{ trans('admin.employee') }}</a></li>
                        <li><a class="gold-background" href="{{ url(adminPath().'/vacations') }}">{{ trans('admin.vacations') }}</a></li>
                        <li><a class="gold-background" href="{{ url(adminPath().'/salaries') }}">salaries</a></li>
                        <li><a class="gold-background" href="{{ url(adminPath().'/salaries-details') }}">salaries-details</a></li>
                        <li><a class="gold-background" href="{{ url(adminPath().'/rules-procedure') }}">{{ trans('admin.rules_of_procedure') }}</a></li>
                      </ul>
                  </li>
                  @endif

                  @if(checkRole('reports') or auth()->user()->type == 'admin')
                  <li><a @if(Request::segment(2) == 'reports') class="gold-background"
                    @endif href="{{ url(adminPath().'/reports') }}">
                     <span><img style="margin-right: 1rem" src="{{ url('icon/header-reports.png') }}">{{ trans('admin.reports') }}</span>

                 </a></li>
                  @endif
                </ul>
              </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse col-lg-5 menu-list-mobile" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                    @if(checkRole('add_leads')
                    or checkRole('switch_leads')
                    or checkRole('edit_leads')
                    or checkRole('show_all_leads')
                    or checkRole('send_cil')
                    or checkRole('calls')
                    or checkRole('meetings')
                    or checkRole('requests')
                    or auth()->user()->type == 'admin')
                    <li>
                        <a @if(Request::segment(2) == 'leads') class="gold-background" @endif
                        href="{{ url(adminPath().'/leads#/MyLeads/1') }}" target="_self">{{ trans('admin.lead') }}

                        </a>
                    </li>
                        {{-- <li class="dropdown">
                            <a @if(Request::segment(2) == 'leads' OR Request::segment(2) =='requests' OR Request::segment(2) =='calls' OR Request::segment(2) =='meetings' ) class="gold-background"
                               @endif
                               href="{{ url(adminPath().'/leads') }}" target="_self" class="dropdown-toggle" data-toggle="dropdown"
                               role="button" aria-haspopup="true"
                               aria-expanded="false">{{ trans('admin.lead') }} </a>
                            <ul class="dropdown-menu">

                                @if(checkRole('add_leads')
                                or checkRole('switch_leads')
                                or checkRole('edit_leads')
                                or checkRole('show_all_leads')
                                or checkRole('send_cil')
                                or auth()->user()->type == 'admin')
                                    <li>
                                        <a @if(Request::segment(2) == 'leads') class="gold-background" @endif
                                        href="{{ url(adminPath().'/leads') }}"><i
                                                    class="fa fa-users"></i> {{ trans('admin.all_leads') }}

                                        </a>
                                    </li>
                                @endif
                                @if(checkRole('calls') or auth()->user()->type == 'admin')
                                    <li class="treeview @if(Request::segment(2) == 'calls') menu-open active @endif">
                                        <a @if(Request::segment(2) == 'calls')  class="gold-background"
                                           @endif href="{{ url(adminPath().'/calls') }}">
                                            <i class="fa fa-phone"></i> <span>{{ trans('admin.calls') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if(checkRole('meetings') or auth()->user()->type == 'admin')
                                    <li>
                                        <a @if(Request::segment(2) == 'meetings') class="gold-background" @endif
                                        href="{{ url(adminPath().'/meetings') }}">
                                            <i class="fa fa-handshake-o"></i> <span>{{ trans('admin.meetings') }}</span>

                                        </a>
                                    </li>
                                @endif
                                @if(checkRole('requests') or auth()->user()->type == 'admin')
                                    <li>
                                        <a @if(Request::segment(2) == 'requests') class="gold-background"
                                           @endif href="{{ url(adminPath().'/requests') }}">
                                            <i class="fa fa-edit"></i> <span>{{ trans('admin.requests') }}</span>


                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a class="fa fa-users" href="{{url(adminPath().'/events_request')}}"> <i>   {{trans('admin.events')}}</i> </a>
                                </li>
                                <!-- <li>
                                    <a @if(Request::segment(2) == 'requests') class="gold-background"
                                        @endif href="{{ url(adminPath().'/requests_broadcast') }}">
                                        <i class="fa fa-edit"></i> <span>{{ trans('admin.requests_broadcast') }}</span>
                                    </a>
                                </li> -->
                            </ul>

                        </li> --}}
                    @endif
                        @if(checkRole('followUp') or auth()->user()->type == 'admin' or auth()->user()->type == 'agent')
                      <li style="width: 14%;" class="follow-up-header">
                          <a style="margin-top: -2%;" @if(Request::segment(2) == 'followUp') class="gold-background"
                             @endif href="{{ url(adminPath().'/followUp') }}">
                              <span>{{ trans('admin.follow-up') }}</span>
                              @if($followUpCount > 0)
                              <div style="cursor: pointer; display: unset; position: relative">
                                <img src="/icon/followupLoading.gif" style="width: 30%;">
                                <span style="position: absolute; top: 1%; right: 44%; font-size: 1.05rem; color: #8f9194;">{{ $followUpCount }}</span>
                              </div>
                              @endif

                          </a>
                      </li>
                    @endif

                        @if(checkRole('teamFollowUp') or auth()->user()->type == 'admin' or auth()->user()->type == 'agent')
                      <li>
                          <a @if(Request::segment(2) == 'teamFollowUp') class="gold-background"
                             @endif href="{{ url(adminPath().'/teamFollowUp') }}">
                              <span>{{ trans('admin.teamFollowUp') }}</span>

                          </a>
                      </li>
                    @endif
                    @if(checkRole('add_developers')
                    or checkRole('edit_developers')
                    or checkRole('delete_developers')
                    or checkRole('show_developers')

                    or checkRole('add_projects')
                    or checkRole('edit_projects')
                    or checkRole('delete_projects')
                    or checkRole('show_projects')

                    or checkRole('add_phases')
                    or checkRole('edit_phases')
                    or checkRole('delete_phases')
                    or checkRole('show_phases')

                    or checkRole('add_properties')
                    or checkRole('edit_properties')
                    or checkRole('delete_properties')
                    or checkRole('show_properties')

                    or checkRole('add_resale_units')
                    or checkRole('edit_resale_units')
                    or checkRole('delete_resale_units')
                    or checkRole('show_resale_units')

                    or checkRole('add_rental_units')
                    or checkRole('edit_rental_units')
                    or checkRole('delete_rental_units')
                    or checkRole('show_rental_units')

                    or checkRole('add_lands')
                    or checkRole('edit_lands')
                    or checkRole('delete_lands')
                    or checkRole('show_lands')
                    or auth()->user()->type == 'admin')
                        <li class="dropdown">
                            <a @if(Request::segment(2) == 'inventory' or Request::segment(2) == 'developers' or Request::segment(2) == 'projects' or Request::segment(2) == 'resale_units' or Request::segment(2) == 'rental_units' or Request::segment(2) == 'lands') class="gold-background"
                               @endif href="{{ url(adminPath().'/inventory') }}" class="dropdown-toggle"
                               data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span>{{ trans('admin.inventory') }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                @if(checkRole('add_developers') or checkRole('edit_developers') or checkRole('delete_developers') or checkRole('show_developers') or auth()->user()->type == 'admin')
                                    <li>
                                        <a @if(Request::segment(2) == 'developers') class="gold-background"
                                           @endif href="{{ url(adminPath().'/developers') }}">
                                            <i class="fa fa-dashboard"></i> <span>{{ trans('admin.developers') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if(checkRole('add_lands') or checkRole('edit_lands') or checkRole('delete_lands') or checkRole('show_lands') or auth()->user()->type == 'admin')
                                    <li>
                                        <a @if(Request::segment(2) == 'lands') class="gold-background"
                                           @endif href="{{ url(adminPath().'/lands') }}">
                                            <i class="fa fa-crop"></i> <span>{{ trans('admin.lands') }}</span>

                                        </a>
                                    </li>
                                @endif
                                @if(checkRole('add_projects') or checkRole('edit_projects') or checkRole('delete_projects') or checkRole('show_projects') or auth()->user()->type == 'admin')
                                    <li class="treeview @if(Request::segment(2) == 'projects') menu-open active @endif">
                                        <a @if(Request::segment(2) == 'projects') class="gold-background"
                                           @endif href="{{ url(adminPath().'/projects') }}">
                                            <i class="fa fa-dashboard"></i> <span>{{ trans('admin.projects') }}</span>

                                        </a>
                                    </li>
                                @endif
                                @if(checkRole('add_resale_units') or checkRole('edit_resale_units') or checkRole('delete_resale_units') or checkRole('show_resale_units') or auth()->user()->type == 'admin')
                                    <li class="treeview @if(Request::segment(2) == 'resale_units') menu-open active @endif">
                                        <a @if(Request::segment(2) == 'resale_units') class="gold-background"
                                           @endif href="{{ url(adminPath().'/resale_units') }}">
                                            <i class="fa fa-home"></i> <span>{{ trans('admin.resale_units') }}</span>
                                        </a>
                                    </li>
                                @endif
                                {{-- @if(checkRole('add_rental_units') or checkRole('edit_rental_units') or checkRole('delete_rental_units') or checkRole('show_rental_units') or auth()->user()->type == 'admin')
                                    <li class="treeview @if(Request::segment(2) == 'rental_units') menu-open active @endif">
                                        <a @if(Request::segment(2) == 'rental_units') class="gold-background"
                                           @endif href="{{ url(adminPath().'/rental_units') }}">
                                            <i class="fa fa-home"></i> <span>{{ trans('admin.rental_units') }}</span>
                                        </a>
                                    </li>
                                @endif --}}
                            </ul>
                        </li>
                    @endif
                    @if(checkRole('marketing') or auth()->user()->type == 'admin')
                        <li class="dropdown">
                            <a @if(Request::segment(2) == 'marketing') class="gold-background" @endif href="#"
                               class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                               aria-expanded="false">
                                <span>{{ trans('admin.marketing') }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="dropdown">
                                    <a @if(Request::segment(2) == 'campaigns') class="gold-background sub"
                                       @endif href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-dashboard"></i> <span>{{ trans('admin.campaigns') }} &nbsp &nbsp &nbsp ></span>

                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a @if(Request::segment(2) == 'campaign_types' and Request::segment(3) == '') class="gold-background"
                                               @endif href="{{ url(adminPath().'/campaign_types') }}"><i
                                                        class="fa fa-circle-o"></i>{{ trans('admin.all') }} {{ trans('admin.types') }}
                                            </a></li>
                                        <li>
                                            <a @if(Request::segment(2) == 'campaign_types' and Request::segment(3) == 'create') class="gold-background"
                                               @endif href="{{ url(adminPath().'/campaign_types/create') }}"><i
                                                        class="fa fa-circle-o"></i>{{ trans('admin.add') }} {{ trans('admin.type') }}
                                            </a></li>
                                        <li>
                                            <a @if(Request::segment(2) == 'campaigns' and Request::segment(3) == '') class="gold-background"
                                               @endif href="{{ url(adminPath().'/campaigns') }}"><i
                                                        class="fa fa-circle-o"></i>{{ trans('admin.all') }} {{ trans('admin.campaigns') }}
                                            </a></li>
                                        <li>
                                            <a @if(Request::segment(2) == 'campaigns' and Request::segment(3) == 'create') class="gold-background"
                                               @endif href="{{ url(adminPath().'/campaigns/create') }}"><i
                                                        class="fa fa-circle-o"></i>{{ trans('admin.add') }} {{ trans('admin.campaigns') }}
                                            </a>
                                        </li>
                                        <li>
                                            <form id="ddssa" action="{{ url(adminPath().'/export_xls') }}" method="post"
                                                  enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <a id="ddss" class="gold-background" href="#" type="submit">
                                                    <i class="fa fa-file"></i>
                                                    <span> {{ trans('admin.export_excel_file') }}</span>
                                                </a>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                                {{-- <li>
                                    <a @if(Request::segment(2) == 'developers_facebook') class="gold-background"
                                       @endif href="{{ url(adminPath().'/developers_facebook') }}">
                                        <i class="fa fa-facebook"></i> <span> {{ trans('admin.developers') }}</span>
                                    </a>
                                </li> --}}
                                {{-- <li>
                                    <a @if(Request::segment(2) == 'projects_facebook') class="gold-background"
                                       @endif href="{{ url(adminPath().'/projects_facebook') }}">
                                        <i class="fa fa-facebook"></i> <span> {{ trans('admin.projects') }}</span>
                                    </a>
                                </li> --}}
                                {{-- <li>
                                    <a @if(Request::segment(2) == 'competitors_facebook') class="gold-background"
                                       @endif href="{{ url(adminPath().'/competitors_facebook') }}">
                                        <i class="fa fa-facebook"></i> <span> {{ trans('admin.competitors') }}</span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a @if(Request::segment(2) == 'forms') class="gold-background"
                                       @endif href="{{ url(adminPath().'/forms') }}"><i
                                                class="fa fa-edit"></i>{{ trans('admin.forms') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a @if(Request::segment(2) == 'proposals') class="gold-background"
                               @endif href="{{ url(adminPath().'/proposals') }}">
                                <span>{{ trans('admin.proposals') }}</span>

                            </a>
                        </li>
                    @endif
                    @if(checkRole('deals') or auth()->user()->type == 'admin')
                        <li>
                            <a @if(Request::segment(2) == 'deals') class="gold-background"
                               @endif href="{{ url(adminPath().'/deals') }}">
                                <span>{{ trans('admin.closed_deals') }}</span>

                            </a>
                        </li>
                    @endif
                    @if(checkRole('finance') or auth()->user()->type == 'admin')
                        <li>
                            <a @if(Request::segment(2) == 'finances') class="gold-background"
                               @endif href="{{ url(adminPath().'/finances') }}">
                                <span>{{ trans('admin.finances') }}</span>

                            </a>{{--
                <ul class="treeview-menu" @if(Request::segment(2) == 'finances')  @endif>
            <li>
                <a @if(Request::segment(2) == 'finances' and Request::segment(3) == 'bank') class="gold-background"
                @endif href="{{ url(adminPath().'/bank') }}"><i
                    class="fa fa-circle-o"></i>{{ trans('admin.settings') }}</a></li>
            </ul> --}}
                        </li>
                    @endif

                    @if(auth()->user()->type == 'admin' or auth()->user()->hr == 1)
                    <li class="dropdown">
                        <a @if(Request::segment(2) == 'Hr') class="gold-background"
                           @endif href="{{ url(adminPath().'/emp-dashboard') }}">
                            <span>{{ trans('admin.hr') }}</span>

                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="gold-background" href="{{ url(adminPath().'/job_categories') }}">{{ trans('admin.job_categories') }}</a></li>
                            <li><a class="gold-background" href="{{ url(adminPath().'/job_titles') }}">{{ trans('admin.job_titles') }}</a></li>
                            <li><a class="gold-background" href="{{ url(adminPath().'/vacancies') }}">{{ trans('admin.vacancies') }}</a></li>
                            <li><a class="gold-background" href="{{ url(adminPath().'/applications') }}">{{ trans('admin.applications') }}</a></li>
                            <li><a class="gold-background" href="{{ url(adminPath().'/employees') }}">{{ trans('admin.employee') }}</a></li>
                            <li><a class="gold-background" href="{{ url(adminPath().'/vacations') }}">{{ trans('admin.vacations') }}</a></li>
                            <li><a class="gold-background" href="{{ url(adminPath().'/salaries') }}">salaries</a></li>
                            <li><a class="gold-background" href="{{ url(adminPath().'/salaries-details') }}">salaries-details</a></li>
                            <li><a class="gold-background" href="{{ url(adminPath().'/rules-procedure') }}">{{ trans('admin.rules_of_procedure') }}</a></li>

                        </ul>
                    </li>
                    @endif
                    @if(checkRole('reports') or auth()->user()->type == 'admin')
                      <li>
                          <a @if(Request::segment(2) == 'reports') class="gold-background"
                             @endif href="{{ url(adminPath().'/reports') }}">
                              <span>{{ trans('admin.reports') }}</span>

                          </a>
                      </li>
                    @endif

                </ul>

            </div><!-- /.navbar-collapse -->
            <div class="col-md-2 col-lg-4" style="width: fit-content">
               <ul class="nav navbar-nav navbar-right">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu ">


                </li>

                @php $color = '#000'; @endphp
                <style type="text/css">
                    .notifaction .dropdown-menu{
                      padding: 10px;
                      max-height: 400px;
                      width: 400px !important;
                      overflow-y: scroll;

                    }
                    .notifaction .dropdown-menu::-webkit-scrollbar {
                      width: 5px;
                    }

                    .notifaction .dropdown-menu::-webkit-scrollbar-track {
                      background: #ddd;
                    }

                    .notifaction .dropdown-menu::-webkit-scrollbar-thumb {
                      background: #AAA;
                    }
                    .admin-noti li {
                        padding: 5px 20px !important;

                    }
                    .v-bar{
                        border:none !important;
                        height:auto !important;
                    }
                </style>
                @if(auth()->user()->type  == 'admin' || checkRole('cil'))
                <li class="">
                        <a href="{{ url('/admin/cils') }}" class="" >
                            <i class="fa fa-envelope"></i>
                            <span class="label label-danger" id="countNotifications">
                            {{ @\App\Cil::where('status', 'not_sent')->count() }}
                        </span>
                        </a>
                </li>
                @endif
               <li class="dropdown user user-menu notifaction">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell"></i>
                            <span class="label label-danger" id="countNotifications">
                            {{ @\App\AdminNotification::where('assigned_to',auth()->user()->id)->where('status',0)->count() }}
                        </span>
                        </a>
                        <ul class="dropdown-menu">
                            @if(count($notToday) > 0)
                                <h6 style="padding: 0 20px; text-transform: uppercase; color: darkgrey;">{{ __('admin.today') }}</h6>
                                <li class="user-body" style="padding: 0 15px">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul id="notifications" class="admin-noti">
                                                @foreach($notToday as $notify)
                                                @if($notify->type_id)
                                                    @if($notify->type == 'switch')

                                                        <li style="@if($notify->status==0)background:#0000001a;@endif border-bottom: solid 1px silver;">

                                                            <a type='leads' href="#" class="notificationElement"
                                                               url="{{ url(adminPath().'/leads/'.$notify->type_id) }}"
                                                               nid="{{ $notify->id }}">
                                                            <div class="v-bar"><i class="fa fa-circle" id="noti-{{ $notify->id }}"
                                                                @if($notify->status == 0) style="color:{{ @$color }};" @endif></i>
                                                            </div>
                                                            <div class="noti-icon"><img
                                                                    src="{{ url('images/notify/switch.png') }}">
                                                            </div>
                                                                <span>
                                                                    -Yohoo ..New lead
                                                                    @if($notify->type_id != 'bulk')
                                                                    MR. (
                                                                        <b>{{ @\App\Lead::find($notify->type_id)->prefix_name . ' ' . @\App\Lead::find($notify->type_id)->first_name }}</b>
                                                                        )
                                                                    @else
                                                                        {{ __('admin.bulk') }}
                                                                    @endif
                                                                     has been switched to
                                                                    <b>you</b>.
                                                                </span>
                                                               <div class='timeAgo'>{{time_ago($notify->created_at)}}</div>
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
                                                  @endif
                                                @endforeach

                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            @endif

                            @if(count($notEarly) > 0)
                                <h6 style="padding: 0 20px; text-transform: uppercase; color: darkgrey;">{{ __('admin.earlier') }}</h6>
                                <li class="user-body" style="padding: 0 15px">
                                    <div class="row">
                                        <div class="col-md-12" style="padding: 0;position: relative;">
                                            <ul id="notifications" class="admin-noti" style="list-style: none">
                                                @foreach($notEarly as $notify)
                                                @if($notify->type_id)
                                                    @if($notify->type == 'switch')

                                                        <li id='{{$notify->status}}' style="@if($notify->status==0)background:#0000001a;@endif border-bottom: solid 1px silver;">
                                                            <div class="v-bar"><i class="fa fa-circle"
                                                                                  id="noti-{{ $notify->id }}"
                                                                                  @if($notify->status == 0) style="color:{{ @$color }};" @endif></i>
                                                            </div>
                                                            <div class="noti-icon"><img
                                                                        src="{{ url('images/notify/switch.png') }}">
                                                            </div>
                                                            <a href="#" class="notificationElement"
                                                               url="{{ url(adminPath().'/leads/'.$notify->type_id) }}"
                                                               nid="{{ $notify->id }}"
                                                            >
                                                                <span>
                                                                     {{ \App\User::find($notify->user_id)->name . ' ' . __('admin.has_switched') }}
                                                                    @if($notify->type_id != 'bulk')
                                                                        {{ $notify->user_id . ' ' . @\App\Lead::find($notify->type_id)->first_name }}
                                                                    @else
                                                                        {{ __('admin.bulk') }}
                                                                    @endif
                                                                    {{__('admin.to') . ' ' . @\App\User::find($notify->assigned_to)->name }}
                                                                </span>
                                                            </a>

                                                            <div class='timeAgo'>{{time_ago($notify->created_at)}}</div>

                                                        </li>


                                                    @elseif($notify->type == 'task')

                                                        <li style="@if($notify->status==0)background:#0000001a;@endif border-bottom: solid 1px silver;">
                                                            <div class="v-bar"><i class="fa fa-circle"
                                                                                  id="noti-{{ $notify->id }}"
                                                                                  @if($notify->status == 0) style="color:{{ @$color }};" @endif></i>
                                                            </div>
                                                            <div class="noti-icon"><img
                                                                        src="{{ url('uploads/noti/task.png') }}">
                                                            </div>
                                                            <a class="notificationElement"
                                                               url="{{ url(adminPath().'/tasks/'.$notify->type_id) }}"
                                                               nid="{{ $notify->id }}"
                                                               href="#">
                                                                <span>
                                                                    New Task has Added to You
                                                                </span>
                                                            </a>

                                                            <div class='timeAgo'>{{time_ago($notify->created_at)}}</div>

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
                                                            <a class="notificationElement"
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
                                                            <a class="notificationElement"
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
                                                            <a class="notificationElement"
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
                                                                        src="{{ url('images/notify/favorite.png') }}">
                                                            </div>
                                                            <a class="notificationElement"
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
                                                                        src="{{ url('images/notify/add-leads.png') }}">
                                                            </div>
                                                            <a class="notificationElement"
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
                                                    @elseif($notify->type == 'added_lead')

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
                                                                    New BroadCast Event "{{ \App\ProdcastEvent::where('id',$notify->type_id)->first()->name }}" IS Added
                                                                </span>
                                                            </a>

                                                            <div class='timeAgo'>{{time_ago($notify->created_at)}}</div>
                                                        </li>
                                                    @else
                                                     @if(auth()->user()->type == 'admin' && $notify->type == 'project_added')

                                                      <li style=" @if($notify->status==0)background:#0000001a;@endif border-bottom: solid 1px silver;">
                                                                <a href="{{ url(adminPath().'/get_project') }}">
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
                                                     @endif
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            @endif
                            <li style="background-color: black;color: white;text-align: center">
                                <a href="{{ url(adminPath().'/notifications') }}">see more</a>
                            </li>
                        </ul>
                    </li>


                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu" style="font-size: 1.5em">
                    @if(app()->getLocale() == 'ar')
                        <a href="{{ url(adminPath().'/language/en') }}" class="">
                            <i class="fa fa-globe"></i>
                            <span class="label label-danger" style="font-size: 0.5em">en</span>
                        </a>
                    @else
                        <a href="{{ url(adminPath().'/language/ar') }}" class="">
                            <i class="fa fa-globe"></i>
                            <span class="label label-danger" style="font-size: 0.5em">ar</span>
                        </a>
                    @endif
                </li>
                @if(decryptHelper(auth()->user()->email_password) != null)
                    <li class="dropdown tasks-menu" style="font-size: 1.5em">
                        <a href="{{ url(adminPath().'/inbox') }}" class="">
                            <i class="fa fa-envelope"></i>
                            @if(Home::count_mails())
                                <span class="label label-danger"
                                      style="font-size: 0.5em">{{ Home::count_mails() }}</span>
                            @endif
                        </a>
                    </li>
                @endif
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if (auth()->user()->image =='')
                            <img src="../../dist/img/lead.png" class="user-image" alt="User Image">
                            @else
                                <img src="{{ url('uploads/'.auth()->user()->image) }}" class="user-image" alt="User Image">
                        @endif
                        <span class="hidden-xs">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            {{-- {{auth()->user()->image}} --}}
                            @if (auth()->user()->image =='')
                                <img src="../../dist/img/lead.png" class="img-circle" alt="User Image">
                                @else
                                    <img src="{{ url('uploads/'.auth()->user()->image) }}" class="img-circle" alt="User Image">
                            @endif

                            <p>
                                {{ auth()->user()->name }}
                                - {{ @App\AgentType::find(auth()->user()->agent_type_id)->name }}
                                <small>{{ trans('admin.member_since') .' ' }}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body hidden">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ url(adminPath().'/employees/'. \App\Employee::where('id', Auth()->user()->employee_id)->first()->id)}}"
                                   class="btn btn-default btn-flat">{{ trans('admin.profile') }}</a>
                            </div>
                            <div class="pull-right">
                                <a id="logoutUrl" href="{{ url(adminPath().'/logout') }}"
                                   class="btn btn-default btn-flat">{{ trans('admin.logout') }}</a>
                            </div>
                        </li>
                    </ul>
                </li>
                @if(checkRole('settings') or auth()->user()->type == 'admin')
                    <li class="dropdown tasks-menu" style="font-size: 1.5em">
                        <a href="{{ url(adminPath().'/settings_menu') }}" class="">
                            <i class="fa fa-gears"></i>
                        </a>
                    </li>
                @endif
            </ul>
             </div>
        </div><!-- /.container-fluid -->
    </nav>
</header>

<div class="content-wrapper">
    <section class="content-header">
