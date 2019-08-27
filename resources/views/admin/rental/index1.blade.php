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
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link" id="me-tab" data-toggle="tab" href="#me" role="tab" aria-controls="me" aria-selected="true">Me</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="others-tab" data-toggle="tab" href="#others" role="tab" aria-controls="others" aria-selected="false">Others</a>
                </li>
            </ul>
                <div class="tab-content" id="myTabContent">
                    <!--Me data !-->
                    <div class="tab-pane active" id="me" role="tabpanel" aria-labelledby="me-tab">        <div class="box-body">
                    <a class="btn btn-success btn-flat @if(app()->getLocale() == 'en') pull-right @else pull-left @endif"
                    href="{{ url(adminPath().'/rental_units/create') }}">{{ trans('admin.add') }}</a>
                    <table class="table table-hover table-striped datatableMe">
                        <thead>
                        <tr>
                            <th>{{ trans('admin.id') }}</th>
                            <th>{{ trans('admin.property') }}</th>
                            <th>{{ trans('admin.title') }}</th>
                            <th>{{ trans('admin.status') }}</th>
                            <th>{{ trans('admin.location') }}</th>
                            <th>{{ trans('admin.rent') }}</th>
                            <th>{{ trans('admin.rooms') }}</th>
                            <th>{{ trans('admin.bathrooms') }}</th>
                            <th>{{ trans('admin.area') }}</th>
                            <th>{{ trans('admin.delivery_date') }}</th>
                            <th>{{ trans('admin.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($meUnits as $unit)
                            <tr>
                                <td>{{$unit->id}}</td>
                                <td><img src="{{ url('/uploads/'.$unit->image) }}" width="50px"></td>
                                <td>{{ $unit->{app()->getLocale().'_title'} }}</td>
                                <td>{{ $unit->availability }}</td>
                                <td>{{ @App\Location::find($unit->location)->{app()->getLocale().'_name'} }}</td>
                                <td>{{ $unit->rent }}</td>
                                <td>{{ $unit->rooms }}</td>
                                <td>{{ $unit->bathrooms }}</td>
                                <td>{{ $unit->area }}</td>
                                <td>{{ $unit->delivery_date }}</td>
                                <td><a href="{{ url(adminPath().'/rental_units/'.$unit->id) }}"
                                    class="btn btn-primary btn-flat">{{ trans('admin.show') }}</a>
                                    <a href="{{ url(adminPath().'/rental_units/'.$unit->id.'/edit') }}"
                                    class="btn btn-warning btn-flat">{{ trans('admin.edit') }}</a>
                                    <a data-toggle="modal" data-target="#delete{{ $unit->id }}"
                                    class="btn btn-danger btn-flat">{{ trans('admin.delete') }}</a></td>
                            </tr>
                            <div id="delete{{ $unit->id }}" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">{{ trans('admin.delete') . ' ' . trans('admin.lead_source') }}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{ trans('admin.delete') . ' ' . $unit->name }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            {!! Form::open(['method'=>'DELETE','route'=>['rental_units.destroy',$unit->id]]) !!}
                                            <button type="button" class="btn btn-default btn-flat"
                                                    data-dismiss="modal">{{ trans('admin.close') }}</button>
                                            <button type="submit"
                                                    class="btn btn-danger btn-flat">{{ trans('admin.delete') }}</button>
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
                <!--Others data !-->
                <div class="tab-pane fade" id="others" role="tabpanel" aria-labelledby="others-tab">
                 <div class="box-body">
                <a class="btn btn-success btn-flat @if(app()->getLocale() == 'en') pull-right @else pull-left @endif"
                    href="{{ url(adminPath().'/rental_units/create') }}">{{ trans('admin.add') }}</a>
                    <table class="table table-hover table-striped datatableOthers">
                        <thead>
                        <tr>
                            <th>{{ trans('admin.id') }}</th>
                            <th>{{ trans('admin.property') }}</th>
                            <th>{{ trans('admin.title') }}</th>
                            <th>{{ trans('admin.status') }}</th>
                            <th>{{ trans('admin.location') }}</th>
                            <th>{{ trans('admin.rent') }}</th>
                            <th>{{ trans('admin.rooms') }}</th>
                            <th>{{ trans('admin.bathrooms') }}</th>
                            <th>{{ trans('admin.area') }}</th>
                            <th>{{ trans('admin.delivery_date') }}</th>
                            <th>{{ trans('admin.agent') }}</th>
                            <th>{{ trans('admin.privacy') }}</th>
                            <th>{{ trans('admin.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($othersUnits as $unit)
                            <tr>
                                <td>{{$unit->id}}</td>
                                <td><img src="{{ url('/uploads/'.$unit->image) }}" width="50px"></td>
                                <td>{{ $unit->{app()->getLocale().'_title'} }}</td>
                                <td>{{ $unit->availability }}</td>
                                <td>{{ @App\Location::find($unit->location)->{app()->getLocale().'_name'} }}</td>
                                <td>{{ $unit->rent }}</td>
                                <td>{{ $unit->rooms }}</td>
                                <td>{{ $unit->bathrooms }}</td>
                                <td>{{ $unit->area }}</td>
                                <td>{{ $unit->delivery_date }}</td>
                                <td>{{ $unit->lead->agent->name }}</td>
                                <td>{{ $unit->privacy }}</td>
                                <td><a href="{{ url(adminPath().'/rental_units/'.$unit->id) }}"
                                    class="btn btn-primary btn-flat">{{ trans('admin.show') }}</a>
                                    <a href="{{ url(adminPath().'/rental_units/'.$unit->id.'/edit') }}"
                                    class="btn btn-warning btn-flat">{{ trans('admin.edit') }}</a>
                                    <a data-toggle="modal" data-target="#delete{{ $unit->id }}"
                                    class="btn btn-danger btn-flat">{{ trans('admin.delete') }}</a></td>
                            </tr>
                            <div id="delete{{ $unit->id }}" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">{{ trans('admin.delete') . ' ' . trans('admin.lead_source') }}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{ trans('admin.delete') . ' ' . $unit->name }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            {!! Form::open(['method'=>'DELETE','route'=>['rental_units.destroy',$unit->id]]) !!}
                                            <button type="button" class="btn btn-default btn-flat"
                                                    data-dismiss="modal">{{ trans('admin.close') }}</button>
                                            <button type="submit"
                                                    class="btn btn-danger btn-flat">{{ trans('admin.delete') }}</button>
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
    </div>
@endsection

@section('js')
<script>
        $('.datatableMe').dataTable({
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            "order": [[ 0, "desc" ]],
            'autoWidth': true
        });
        $('.datatableOthers').dataTable({
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            "order": [[ 0, "desc" ]],
            'autoWidth': true
        });
        var filter_show = 0;
        $('.filter-icon').on('click',function () {

            if (!filter_show){
                $('.filter').css('right',0);
                $('.filter-icon').css('right','500px');
                filter_show = 1;
            }else{
                $('.filter').css('right','-500px');
                $('.filter-icon').css('right','0');
                filter_show = 0;
            }

        });
    </script>
@stop
