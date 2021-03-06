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
        <div class="box-body">
            <a class="btn btn-success btn-flat @if(app()->getLocale() == 'en') pull-right @else pull-left @endif"
               href="{{ url(adminPath().'/calls/create') }}">{{ trans('admin.add') }}</a>
            {{--<table class="table table-hover table-striped datatable">--}}
            <table class="table datatable table-striped table-bordered  dt-responsive nowrap" style="width:100%">
                <thead>
                <tr>
                    <th>{{ trans('admin.id') }}</th>
                    <th>{{ trans('admin.lead') }}</th>
                    <th>{{ trans('admin.agent') }}</th>
                    <th>{{ trans('admin.date') }}</th>
                    <th>{{ trans('admin.show') }}</th>
                    <th>{{ trans('admin.edit') }}</th>
                    <th>{{ trans('admin.delete') }}</th>
                </tr>
                </thead>
                <tbody>
                    {{-- {{$calls}} --}}
                @foreach($calls as $call)
                    <tr>
                        <td>{{ $call->id }}</td>
                        <td>{{ @\App\Lead::find($call->lead_id)->first_name . ' ' . @\App\Lead::find($call->lead_id)->last_name }}</td>
                        <td>{{ @\App\User::find($call->user_id)->name }}</td>
                        <td>{{ date('Y-m-d',$call->date) }}</td>
                        <td><a href="{{ url(adminPath().'/calls/'.$call->id) }}"
                               class="btn btn-primary btn-flat">{{ trans('admin.show') }}</a></td>
                        <td><a href="{{ url(adminPath().'/calls/'.$call->id.'/edit') }}"
                               class="btn btn-warning btn-flat">{{ trans('admin.edit') }}</a></td>
                        <td><a data-toggle="modal" data-target="#delete{{ $call->id }}"
                               class="btn btn-danger btn-flat">{{ trans('admin.delete') }}</a></td>
                    </tr>
                    <div id="delete{{ $call->id }}" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">{{ trans('admin.delete') . ' ' . trans('admin.lead_source') }}</h4>
                                </div>
                                <div class="modal-body">
                                    <p>{{ trans('admin.delete') . ' ' . $call->name }}</p>
                                </div>
                                <div class="modal-footer">
                                    {!! Form::open(['method'=>'DELETE','route'=>['calls.destroy',$call->id]]) !!}
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
    </div>
@endsection

@section('js')
    <script>
        $('.datatable').dataTable({
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            "order": [[ 0, "desc" ]],
            'autoWidth': true,
            "data": "createdTime",
            columns: [
            {"data": "userCreated",
             "type": "date ",
             "render":function (value) {
                 if (value === null) return "";

                  var pattern = /Date\(([^)]+)\)/;
                  var results = pattern.exec(value);
                  var dt = new Date(parseFloat(results[1]));

                  return (dt.getMonth() + 1) + "/" + dt.getDate() + "/" + dt.getFullYear();}
            }
        ],
           // "render": function (data) {
           //     var date = new Date(data);
           //     var month = date.getMonth() + 1;
           //     return (month.length > 1 ? month : "0" + month) + "/" + date.getDate() + "/" + date.getFullYear();
           // }

        })
    </script>
@stop
