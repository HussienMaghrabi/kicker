@extends('admin.index')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $title }}</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <strong>{{ trans('admin.leads') }} : </strong>
            @php($lead=@App\Lead::find($todo->leads))
                     {{@$lead->first_name ." " .@$lead->last_name }}
            <br><hr>
            {{-- <strong>{{ trans('admin.due_date') }} : </strong>{{ date('Y-m-d.',$todo->due_date) }} --}}
            <strong>{{ trans('admin.due_date') }} : </strong>{{ date('d/m/y --- h:i:s a', strtotime($todo->created_at)) }}
            <br><hr>
            <strong>{{ trans('admin.to_do_type') }} : </strong>{{ trans('admin.'.$todo->to_do_type) }}
            <br><hr>
            <strong>{{ trans('admin.status') }} : </strong>{{ trans('admin.'.$todo->status) }}
            <br><hr>
            <strong>phone : </strong>{{ $lead->phone  }}
            <br><hr>
            <strong>{{ trans('admin.description') }} : </strong>{{ $todo->description }}
            <br><hr>
            <a href="/admin/confirm_to_do/{{$todo->id}}" class="btn btn-primary" style="color: white;" >Done</a>
        </div>
    </div>
@endsection