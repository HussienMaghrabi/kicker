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
               href="{{ url(adminPath().'/agent/create') }}">{{ trans('admin.add') }}</a>
            {{--<table class="table table-hover table-striped datatable">--}}
            <table class="table datatable table-striped table-bordered  dt-responsive nowrap" style="width:100%">
                <thead>
                <tr>
                    <th>{{ trans('admin.id') }}</th>
                    <th>{{ trans('admin.name') }}</th>
                    <th>{{ trans('admin.email') }}</th>
                    <th>{{ trans('admin.phone') }}</th>
                    <th>{{ trans('admin.agent_type') }}</th>
                    <th>{{ trans('admin.show') }}</th>
                    <th>{{ trans('admin.edit') }}</th>
                    <th>{{ trans('admin.delete') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($index as $src)
                    <tr>
                        <td>{{ $src->id }}</td>
                        <td>{{ $src->name }}</td>
                        <td>{{ $src->email }}</td>
                        <td>{{ $src->phone }}</td>
                        <td>{{ $src->source_name }}</td>
                        <td><a href="{{ url(adminPath().'/agent/'.$src->id) }}"
                               class="btn btn-primary btn-flat">{{ trans('admin.show') }}</a></td>
                        <td><a href="{{ url(adminPath().'/agent/'.$src->id.'/edit') }}"
                               class="btn btn-warning btn-flat">{{ trans('admin.edit') }}</a></td>
                        <td>
                          <form action="{{ url(adminPath().'/agent/'.$src->id) }}" method="post">
                            {!! method_field('delete') !!}
                            {!! csrf_field() !!}
                            <button class="btn btn-danger btn-flat">{{ trans('admin.delete') }}</button>
                          </form>
                        </td>
                    </tr>
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
            'autoWidth': true
        })
    </script>
@stop
