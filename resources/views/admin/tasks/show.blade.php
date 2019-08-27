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
            <strong>{{ trans('admin.id') }} : </strong>{{ $source->id }}
            <br><hr>
            <strong>{{ trans('admin.assignment_by') }} : </strong>{{ \App\User::find($source->user_id)->name }}
            <br><hr>
            <strong>{{ trans('admin.assignment_to') }} : </strong>{{ $source->name }}
            <br><hr>
            @php
            //dd($source->leads);
                $leads = json_decode($source->leads);
            @endphp
            <strong>{{ trans('admin.leads') }} : </strong>
            @foreach($leads as $lead)
                @if( !$loop->last )
                    {{ App\Lead::find($lead)->first_name.' '.App\Lead::find($lead)->last_name }} -
                @else
                    {{ App\Lead::find($lead)->first_name.' '.App\Lead::find($lead)->last_name }}
                @endif
            @endforeach
            {{--
            <br><hr>
             <strong>{{ trans('admin.due_date') }} : </strong>{{ date('Y-m-d H:i:s',strtotime($date),$source->due_date) }} 
            --}}
            <br><hr> 
            <strong>{{ trans('admin.due_date') }} : </strong>{{ date('d/m/y --- h:i:s a', strtotime($source->created_at)) }}
            <br><hr>
            <strong>{{ trans('admin.task_type') }} : </strong>{{ trans('admin.'.$source->task_type) }}
            <br><hr>
            <strong>{{ trans('admin.status') }}: </strong>{{ trans('admin.'.$source->status) }}
            <br><hr>
            <strong>{{ trans('admin.description') }} : </strong>{{ $source->description }}
            <br><hr>

        </div>
    </div>
@endsection