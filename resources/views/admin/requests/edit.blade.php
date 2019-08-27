@extends('admin.index')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Request</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <form action={{url(adminPath().'/requests/'.$data->id)}} method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="put">
                <div class="form-group @if($errors->has('lead')) has-error @endif">
                    <label>{{ trans('admin.lead') }}</label>
                    <select name="lead" class="form-control select2" style="width: 100%"
                            data-placeholder="{{ trans('admin.lead') }}">
                        <option></option>
                        @foreach(@App\Lead::getAgentLeads() as $lead)
                            <option value="{{ $lead->id }}"
                                    @if($data->lead_id == $lead->id) selected @endif>
                                {{ $lead->first_name . ' ' . $lead->last_name }}
                                -
                                @if($lead->agent_id == auth()->id())
                                    {{ __('admin.my_lead') }}
                                @else
                                    {{ __('admin.team_lead', ['agent' => @$lead->agent->name]) }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group {{ $errors->has('buyer_seller') ? 'has-error' : '' }} col-md-3">
                    {!! Form::label(trans('admin.buyer_seller')) !!}
                    <select class="select2 form-control" id="buyer_seller" name="buyer_seller" style="width: 100%"
                            data-placeholder="{{ trans('admin.type') }}">
                        <option></option>
                        <option value="buyer" @if($data->type == 'buyer') selected @endif>{{ trans('admin.buyer') }}</option>
                        <option value="seller" @if($data->type == 'seller') selected @endif>{{ trans('admin.seller') }}</option>

                    </select>
                </div>
                <div class="form-group @if($errors->has('unit_type')) has-error @endif">
                    <label class="col-xs-12">{{ trans('admin.unit_type') }}</label>
                    <select name="unit_type" class="form-control select2" style="width: 100%"
                            data-placeholder="{{ trans('admin.unit_type') }}">
                        <option></option>
                        @foreach(App\UnitType::get() as $lead)
                            <option value="{{ $lead->id }}" @if($lead->id == $data->unit_type_id) selected @endif>
                                {{ $lead->{app()->getLocale().'_name'} }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('admin.price') }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-6 @if($errors->has('price_from')) has-error @endif">
                                <label> {{ trans('admin.from') }}</label>
                                <input type="number" name="price_from" class="form-control"
                                       value="{{ $data->price_from }}" placeholder="{{ trans('admin.from') }}">
                            </div>
                            <div class="col-xs-6 @if($errors->has('price_to')) has-error @endif">
                                <label> {{ trans('admin.to') }}</label>
                                <input type="number" name="price_to" class="form-control" value="{{ $data->price_to }}"
                                       placeholder="{{ trans('admin.to') }}">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->


                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('admin.area') }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-6 @if($errors->has('area_from')) has-error @endif">
                                <label> {{ trans('admin.from') }}</label>
                                <input type="number" name="area_from" class="form-control"
                                       value="{{ $data->area_from }}" placeholder="{{ trans('admin.from') }}">
                            </div>
                            <div class="col-xs-6 @if($errors->has('area_to')) has-error @endif">
                                <label> {{ trans('admin.to') }}</label>
                                <input type="number" name="area_to" class="form-control" value="{{ $data->area_to }}"
                                       placeholder="{{ trans('admin.to') }}">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 @if($errors->has('request_type')) has-error @endif">
                                <label> {{ trans('admin.request_type') }}</label>
                                <select name="request_type" class="form-control select2" style="width: 100%"
                                        data-placeholder="{{ trans('admin.request_type') }}">
                                    <option></option>
                                    <option value="resale" @if('resale' == $data->request_type) selected @endif>{{ trans('admin.resale') }}</option>
                                    <option value="rental" @if('rental' == $data->request_type) selected @endif>{{ trans('admin.rental') }}</option>
                                    <option value="new_home" @if('new_home' == $data->request_type) selected @endif>{{ trans('admin.new_home') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 @if($errors->has('type')) has-error @endif">
                                <label> {{ trans('admin.type') }}</label>
                                <select name="type" class="form-control select2" style="width: 100%"
                                        data-placeholder="{{ trans('admin.type') }}">
                                    <option></option>
                                    <option value="commercial" @if('commercial' == $data->unit_type) selected @endif>{{ trans('admin.commercial') }}</option>
                                    <option value="residential" @if('residential' == $data->unit_type) selected @endif>{{ trans('admin.residential') }}</option>
                                    <option value="land" @if('land' == $data->unit_type) selected @endif>{{ trans('admin.land') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-header ">
                        <h3 class="box-title">{{ trans('admin.rooms') }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-6 @if($errors->has('rooms_from')) has-error @endif">
                                <label> {{ trans('admin.from') }}</label>
                                <input type="number" name="rooms_from" class="form-control"
                                       value="{{ $data->rooms_from }}" placeholder="{{ trans('admin.from') }}">
                            </div>
                            <div class="col-xs-6 @if($errors->has('rooms_to')) has-error @endif">
                                <label> {{ trans('admin.to') }}</label>
                                <input type="number" name="rooms_to" class="form-control" value="{{ $data->rooms_to }}"
                                       placeholder="{{ trans('admin.to') }}">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-header ">
                        <h3 class="box-title">{{ trans('admin.bathrooms') }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-6 @if($errors->has('bathrooms_from')) has-error @endif">
                                <label> {{ trans('admin.from') }}</label>
                                <input type="number" name="bathrooms_from" class="form-control"
                                       value="{{ $data->bathrooms_from }}" placeholder="{{ trans('admin.from') }}">
                            </div>
                            <div class="col-xs-6 @if($errors->has('bathrooms_to')) has-error @endif">
                                <label> {{ trans('admin.to') }}</label>
                                <input type="number" name="bathrooms_to" class="form-control" value="{{ $data->bathrooms_to }}"
                                       placeholder="{{ trans('admin.to') }}">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 @if($errors->has('location')) has-error @endif">
                                <label> {{ trans('admin.location') }}</label>
                                <select name="location" class="form-control select2" style="width: 100%"
                                        data-placeholder="{{ trans('admin.location') }}">
                                    <option></option>
                                    @foreach(@\App\Location::get() as $lead)
                                        <option value="{{ $lead->id }}" @if($lead->id == $data->location) selected @endif>
                                            {{ $lead->{app()->getLocale().'_name'} }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 @if($errors->has('down_payment')) has-error @endif">
                                <label> {{ trans('admin.down_payment') }}</label>
                                <input type="number" name="down_payment" class="form-control"
                                       value="{{ $data->down_payment }}" placeholder="{{ trans('admin.down_payment') }}">
                            </div>

                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 @if($errors->has('project')) has-error @endif">
                                <label> {{ trans('admin.project') }}</label>
                                <select name="project" class="form-control select2" style="width: 100%"
                                        data-placeholder="{{ trans('admin.project') }}">
                                    <option></option>
                                    @foreach(@\App\Project::get() as $lead)
                                        <option value="{{ $lead->id }}" @if($lead->id == $data->project_id) selected @endif>
                                            {{ $lead->{app()->getLocale().'_name'} }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                    <!-- /.box-body -->


                </div>
                <div class="form-group @if($errors->has('date')) has-error @endif col-md-12">
                    <label>{{ trans('admin.delivery_date') }}</label>
                    <div class="input-group">
                        <input class="form-control datepicker1" placeholder="Delivery Date" readonly="" id="date" name="date" type="text" value="{{ $data->date }}">
                        {{-- {!! Form::text('date','',['class' => 'form-control datepicker1', 'placeholder' => trans('admin.delivery_date'),'readonly'=>'','id'=>'date']) !!} --}}
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
                <div class="form-group @if($errors->has('notes')) has-error @endif">
                    <label> {{ trans('admin.notes') }}</label>
                    <textarea name="notes" class="form-control"
                              value={{ $data->notes }} placeholder="{!! trans('admin.notes') !!}"
                              rows="6">{{ $data->notes }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-flat">{{ trans('admin.submit') }}</button>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var start = new Date("{{ Date('Y-m-d',$data->date_from)}}");
        // console.log(start);
        var end = new Date("{{ Date('Y-m-d',$data->date_to)}}");

        start = moment(start);
        end = moment(end);

        function cb(start, end) {
            $('#reportrange1 span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
            $("#start_date").val(start.toString('Y-m-d'));
            $("#end_date").val(end.toString('Y-m-d'));
        }

        $('.reportrange1').daterangepicker({

            startDate: start,
            endDate: end,
            locale: {
                format: 'DD/MM/YYYY'
            },

        }, cb);

        cb(start, end);
    </script>
    <script>
        $('.datepicker1').datepicker({
            autoclose: true,
            format: " yyyy",
            viewMode: "years",
            minViewMode: "years",
        });
    </script>
@endsection
