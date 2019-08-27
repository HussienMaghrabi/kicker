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
               href="{{ url(adminPath().'/proposals/create') }}">{{ trans('admin.add') }}</a>
            <table class="table datatable table-striped table-bordered  dt-responsive nowrap"style="width:100%">
                <thead>
                <tr>
                    <th>{{ trans('admin.id') }}</th>
                    <th>{{ trans('admin.lead') }}</th>
                    <th>{{ trans('admin.confirm') }}</th>
                    <th>{{ trans('admin.show') }}</th>
                    <th>{{ trans('admin.edit') }}</th>
                    <th>{{ trans('admin.delete') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($proposals as $proposal)
                    <tr>
                        <td>{{ $proposal->id }}</td>
                        <td>{{ @\App\Lead::find($proposal->lead_id)->first_name . ' ' . @\App\Lead::find($proposal->lead_id)->last_name }}</td>
                        <td>
                            @if($proposal->status == 'pending')
                            <a data-toggle="modal" data-target="#confirm{{ $proposal->id }}"
                               class="btn btn-success btn-flat">{{ trans('admin.confirm') }}</a>
                            @endif
                        </td>
                        <td><a href="{{ url(adminPath().'/proposals/'.$proposal->id) }}"
                               class="btn btn-primary btn-flat">{{ trans('admin.show') }}</a></td>
                        <td><a href="{{ url(adminPath().'/proposals/'.$proposal->id.'/edit') }}"
                               class="btn btn-warning btn-flat">{{ trans('admin.edit') }}</a></td>
                        <td>
                             <form action="{{ url(adminPath().'/proposals/'.$proposal->id) }}" method="post">
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