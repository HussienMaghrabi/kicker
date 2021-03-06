{{--<table class="table table-hover table-striped datatableTeam" style="width: 100%" id="teamDataTable">--}}
<table class="table datatable table-striped table-bordered  dt-responsive nowrap" style="width: 100%" id="teamDataTable">
    <thead>
    <tr>
         <th style="width: 5%">
            <div class="checkbox">
                <label>
                    <input type="checkbox" id="checkAll">
                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                </label>
            </div>
        </th>
        <th>{{ trans('admin.id') }}</th>
        @if(Auth()->user()->residential_commercial == 'residential')
            <th>{{ trans('admin.lpersonal') .' '.trans('admin.status') }}</th>
        @endif
        @if(Auth()->user()->residential_commercial == 'commercial')
            <th>{{ trans('admin.lscommercial') .' '.trans('admin.status') }}</th>
        @endif
        <th>{{ trans('admin.personal') }} {{ trans('admin.agent') }}</th>
        <th>{{ trans('admin.scommercial') }} {{ trans('admin.agent') }}</th>
        <th>{{ trans('admin.name') }}</th>
        <th>{{ trans('admin.email') }}</th>
        <th>{{ trans('admin.phone') }}</th>
        <th>{{ trans('admin.source') }}</th>
        <th>{{ trans('admin.option') }}</th>
        @if(checkRole('switch_leads') or auth()->user()->type == 'admin')
            <th>{{ trans('admin.switch') }}</th>
        @endif
        <th>{{ trans('admin.hint') }}</th>
    </tr>
    </thead>
    <tbody id="teamData">
        @php($commercialAgents = @\App\User::where('residential_commercial', 'commercial')->pluck('id')->toArray())
        @php($residentialAgents = @\App\User::where('residential_commercial', 'residential')->pluck('id')->toArray())
    @foreach($teams as $lead)
        <tr>
            <td class="checkbox" style="width: 5%">
                <label>
                    <input class="switch" name="checked_leads[]" type="checkbox"
                           value={{ $lead->id }}>
                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                </label>
            </td>
            <td>{{ $lead->id }}</td>
            @if(Auth()->user()->residential_commercial == 'residential')
                <td>
                    <i class="fa fa-circle" aria-hidden="true" style="@if(DB::table('lead_actions')->whereIn('user_id', $residentialAgents)->where('lead_id',$lead->id)->count() > 0) color:green;@else color:red @endif"></i>
                </td>
            @endif
            @if(Auth()->user()->residential_commercial == 'commercial')
                <td>
                    <i class="fa fa-circle" aria-hidden="true" style="@if(DB::table('lead_actions')->whereIn('user_id', $commercialAgents)->where('lead_id',$lead->id)->count() > 0) color:green;@else color:red @endif"></i>
                </td>
            @endif
            <td>{{ @App\User::find($lead->agent_id)->name }}</td>
            <td>{{ @App\User::find($lead->commercial_agent_id)->name }}</td>
            <td>{{ $lead->first_name . ' ' . $lead->last_name }}</td>
            <td>
                <a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a>
            </td>
            <td>{{ $lead->phone }}</td>
            <td>{{ @App\LeadSource::find($lead->lead_source_id)->name }}</td>
            <td><select class="form-control" onchange="if(this.value=='del'){$('#delete{{ $lead->id }}').modal();} else{location = this.value;}">
                <option value="#" disabled="" selected="">Options</option>
                <option value="{{url(adminPath() . '/leads/' . $lead->id)}}">Show</option>
                <option value="{{url(adminPath() . '/leads/' . $lead->id)}}/edit">Edit</option>
                <option value="{{ url(adminPath() . '/delete-lead/' . $lead->id) }}" class="delete" data-toggle="modal" data-target="#delete{{ $lead->id }}">Delete</option>
                </select>
                    <div id="delete{{ $lead->id }}" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">??</button>
                                    <h4 class="modal-title">Delete Lead</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Delete gjf dtr</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                                    <a value="del" class="delete" data-toggle="modal" data-target="#delete' . $lead->id . '" class="btn btn-danger btn-flat">Delete</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </td>

                <td>
                    <a data-toggle="modal" data-target="#switch{{ $lead->id }}"
                        class="btn btn-success btn-flat">{{ trans('admin.switch') }}</a>
                </td>
                <td><a onclick="showHintSpan({{ $lead->id }})"><i class="fa fa-eye" aria-hidden="true"></a></i></td>
        </tr>
        <div id="delete{{ $lead->id }}" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{ trans('admin.delete') . ' ' . trans('admin.lead') }}</h4>
                    </div>
                    <div class="modal-body">
                        <p>{{ trans('admin.delete') . ' ' . $lead->name }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat"
                                data-dismiss="modal">{{ trans('admin.close') }}</button>
                        <a class="btn btn-danger btn-flat" href="{{ url(adminPath() . '/delete-lead/' . $lead->id) }}">{{ trans('admin.delete') }}</a>
                    </div>
                </div>

            </div>
        </div>
        <div id="switch{{ $lead->id }}" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{ trans('admin.switch') . ' ' . trans('admin.lead') }}</h4>
                    </div>
                    <form action="{{ url(adminPath() . '/switch_leads') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <select class="select2" name="agent_id"
                                    data-placeholder="{{ __('admin.agent') }}" style="width: 100%">
                                <option></option>
                                @foreach(@App\User::get() as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" value="{{ $lead->id }}" name="leads[]">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-flat"
                                    data-dismiss="modal">{{ trans('admin.close') }}</button>
                            <button type="submit"
                                    class="btn btn-success btn-flat">{{ trans('admin.switch') }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    @endforeach
    </tbody>
</table>
{{-- <div class="row">
    <div class="col-xs-12">
        {{ $paginator->links() }}
    </div>
</div> --}}