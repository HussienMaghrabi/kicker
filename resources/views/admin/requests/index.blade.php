@extends('admin.index')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $title }}</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link" id="me-tab" data-toggle="tab" href="#me" role="tab" aria-controls="me" aria-selected="true">Me</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="team-tab" data-toggle="tab" href="#team" role="tab" aria-controls="team" aria-selected="false">Team</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="requests-tab" data-toggle="tab" href="#requests" role="tab" aria-controls="requests" aria-selected="false">Requests BroadCast </a>
                </li>
            </ul>
        <div class="box-body tab-content">
        <div class="tab-pane active" id="me" role="tabpanel" aria-labelledby="me-tab">
            <a class="btn btn-success btn-flat @if(app()->getLocale() == 'en') pull-right @else pull-left @endif"
               href="{{ url(adminPath().'/requests/create') }}">{{ trans('admin.add') }}</a>
            <table class="table datatable table-striped table-bordered  dt-responsive nowrap"style="width:100%">
                <thead>
                <tr>
                    <th>{{ trans('admin.id') }}</th>
                    <th>{{ trans('admin.lead') }}</th>
                    <th>{{ trans('admin.type') }}</th>
                    <th>{{ trans('admin.price').' '.trans('admin.from') }}</th>
                    <th>{{ trans('admin.price').' '.trans('admin.to') }}</th>
                    <th>{{ trans('admin.date').' '.trans('admin.start') }}</th>
                    <th>{{ trans('admin.date').' '.trans('admin.end') }}</th>
                    {{-- <th>{{ trans('admin.description') }}</th> --}}
                    <th>{{ trans('admin.show') }}</th>
                    <th>{{ trans('admin.edit') }}</th>
                    <th>{{ trans('admin.delete') }}</th>
                </tr>
                </thead> 
                <tbody>
                @foreach($index as $src)
                    <tr>
                        <td>{{ $src->id }}</td>
                        <td>{{ @$src->first_name . ' ' . @$src->last_name }}</td>
                        <td>{{ $src->unit_type }}</td>
                        <td>{{ $src->price_from }}</td>
                        <td>{{ $src->price_to }}</td>
                        <td>{{ Date('Y-m-d',strtotime($src->created_at)) }}</td>
                        <td>{{ Date('Y-m-d',strtotime($src->date)) }}</td>
                        {{-- <td>{{ $src->project->en_description }}</td> --}}
                        <td><a href="{{ url(adminPath().'/requests/'.$src->id) }}"
                               class="btn btn-primary btn-flat">{{ trans('admin.show') }}</a></td>
                        <td><a href="{{ url(adminPath().'/requests/'.$src->id.'/edit') }}"
                               class="btn btn-warning btn-flat">{{ trans('admin.edit') }}</a></td>
                        <td><a data-toggle="modal" data-target="#delete{{ $src->id }}"
                               class="btn btn-danger btn-flat">{{ trans('admin.delete') }}</a></td>
                    </tr>
                    <div id="delete{{ $src->id }}" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">{{ trans('admin.delete') . ' ' . trans('admin.lead_source') }}</h4>
                                </div>
                                <div class="modal-body">
                                    <p>{{ trans('admin.delete') . ' ' . $src->id }}</p>
                                </div>
                                <div class="modal-footer">
                                    {!! Form::open(['method'=>'DELETE','route'=>['requests.destroy',$src->id]]) !!}
                                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">{{ trans('admin.close') }}</button>
                                    <button type="submit" class="btn btn-danger btn-flat">{{ trans('admin.delete') }}</button>
                                    {!! Form::close() !!}
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="team" role="tabpanel" aria-labelledby="team-tab">
          <a class="btn btn-success btn-flat @if(app()->getLocale() == 'en') pull-right @else pull-left @endif"
             href="{{ url(adminPath().'/requests/create') }}">{{ trans('admin.add') }}</a>
          <table class="table datatable table-striped table-bordered  dt-responsive nowrap"style="width:100%">
              <thead>
              <tr>
                  <th>{{ trans('admin.id') }}</th>
                  <th>{{ trans('admin.lead') }}</th>
                  <th>{{ trans('admin.agent') }}</th>
                  <th>{{ trans('admin.type') }}</th>
                  <th>{{ trans('admin.price').' '.trans('admin.from') }}</th>
                  <th>{{ trans('admin.price').' '.trans('admin.to') }}</th>
                  <th>{{ trans('admin.date').' '.trans('admin.start') }}</th>
                  <th>{{ trans('admin.date').' '.trans('admin.end') }}</th>
                  {{-- <th>{{ trans('admin.description') }}</th> --}}
                  <th>{{ trans('admin.show') }}</th>
                  <th>{{ trans('admin.edit') }}</th>
                  <th>{{ trans('admin.delete') }}</th>
              </tr>
              </thead>
              <tbody>
              @foreach($teamRequests as $teamRequest)
                  <tr>
                      <td>{{ $teamRequest->id }}</td>
                      <td>{{ @$teamRequest->first_name . ' ' . @$teamRequest->last_name }}</td>
                      <td>{{ $teamRequest->agent }}</td>
                      <td>{{ $teamRequest->unit_type }}</td>
                      <td>{{ $teamRequest->price_from }}</td>
                      <td>{{ $teamRequest->price_to }}</td>
                      <td>{{ Date('Y-m-d',strtotime($teamRequest->created_at)) }}</td>
                      <td>{{ Date('Y-m-d',strtotime($teamRequest->date)) }}</td>
                      {{-- <td>{{ $src->project->description }}</td> --}}
                      <td><a href="{{ url(adminPath().'/requests/'.$teamRequest->id) }}"
                             class="btn btn-primary btn-flat">{{ trans('admin.show') }}</a></td>
                      <td><a href="{{ url(adminPath().'/requests/'.$teamRequest->id.'/edit') }}"
                             class="btn btn-warning btn-flat">{{ trans('admin.edit') }}</a></td>
                      <td><a data-toggle="modal" data-target="#delete{{ $teamRequest->id }}"
                             class="btn btn-danger btn-flat">{{ trans('admin.delete') }}</a></td>
                  </tr>
                  <div id="delete{{ $teamRequest->id }}" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                          <!-- Modal content-->
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">{{ trans('admin.delete') . ' ' . trans('admin.lead_source') }}</h4>
                              </div>
                              <div class="modal-body">
                                  <p>{{ trans('admin.delete') . ' ' . $teamRequest->id }}</p>
                              </div>
                              <div class="modal-footer">
                                  {!! Form::open(['method'=>'DELETE','route'=>['requests.destroy',$teamRequest->id]]) !!}
                                  <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">{{ trans('admin.close') }}</button>
                                  <button type="submit" class="btn btn-danger btn-flat">{{ trans('admin.delete') }}</button>
                                  {!! Form::close() !!}
                              </div>
                          </div>

                      </div>
                  </div>
              @endforeach
              </tbody>
          </table>
        </div>
        <div class="tab-pane fade" id="requests" role="tabpanel" aria-labelledby="requests-tab">
          <a class="btn btn-success btn-flat @if(app()->getLocale() == 'en') pull-right @else pull-left @endif"
             href="{{ url(adminPath().'/requests/create') }}">{{ trans('admin.add') }}</a>
          <table class="table datatable table-striped table-bordered  dt-responsive nowrap"style="width:100%">
              <thead>
              <tr>
                  <th>{{ trans('admin.id') }}</th>
                  <th>{{ trans('admin.agent') }}</th>
                  <th>{{ trans('admin.type') }}</th>
                  <th>{{ trans('admin.price').' '.trans('admin.from') }}</th>
                  <th>{{ trans('admin.price').' '.trans('admin.to') }}</th>
                  <th>{{ trans('admin.date').' '.trans('admin.start') }}</th>
                  <th>{{ trans('admin.date').' '.trans('admin.end') }}</th>
                  {{-- <th>{{ trans('admin.description') }}</th> --}}
                  <th>{{ trans('admin.show') }}</th>
                  <th>{{ trans('admin.edit') }}</th>
                  <th>{{ trans('admin.delete') }}</th>
              </tr>
              </thead>
              <tbody>
              @foreach($broadcastRequests as $broadcastRequest)
                  <tr>
                      <td>{{ $broadcastRequest->id }}</td>
                      <td>{{ @$broadcastRequest->user->name }}</td>
                      <td>{{ $broadcastRequest->unit_type }}</td>
                      <td>{{ $broadcastRequest->price_from }}</td>
                      <td>{{ $broadcastRequest->price_to }}</td>
                      <td>{{ Date('Y-m-d',strtotime($broadcastRequest->created_at)) }}</td>
                      <td>{{ Date('Y-m-d',strtotime($broadcastRequest->date)) }}</td>
                      {{-- <td>{{ $src->project->description }}</td> --}}
                      <td><a href="{{ url(adminPath().'/requests/'.$broadcastRequest->id) }}"
                             class="btn btn-primary btn-flat">{{ trans('admin.show') }}</a></td>
                      <td><a href="{{ url(adminPath().'/requests/'.$broadcastRequest->id.'/edit') }}"
                             class="btn btn-warning btn-flat">{{ trans('admin.edit') }}</a></td>
                      <td><a data-toggle="modal" data-target="#delete{{ $broadcastRequest->id }}"
                             class="btn btn-danger btn-flat">{{ trans('admin.delete') }}</a></td>
                  </tr>
                  <div id="delete{{ $broadcastRequest->id }}" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                          <!-- Modal content-->
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">{{ trans('admin.delete') . ' ' . trans('admin.lead_source') }}</h4>
                              </div>
                              <div class="modal-body">
                                  <p>{{ trans('admin.delete') . ' ' . $broadcastRequest->id }}</p>
                              </div>
                              <div class="modal-footer">
                                  {!! Form::open(['method'=>'DELETE','route'=>['requests.destroy',$broadcastRequest->id]]) !!}
                                  <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">{{ trans('admin.close') }}</button>
                                  <button type="submit" class="btn btn-danger btn-flat">{{ trans('admin.delete') }}</button>
                                  {!! Form::close() !!}
                              </div>
                          </div>

                      </div>
                  </div>
              @endforeach
              </tbody>
          </table>
        </div>
            {{ $index->links() }}
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.datatable').dataTable({
             'paging': false,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,

            'autoWidth': true
        })
    </script>
@stop
