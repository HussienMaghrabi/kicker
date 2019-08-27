@extends('admin.index')

@section('content')

    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
    <link rel="stylesheet" type="text/css" href="https://rawgit.com/lykmapipo/themify-icons/master/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="https://rawgit.com/cristijora/vue-form-wizard/master/dist/vue-form-wizard.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

    <style>
        pre {
        overflow: auto;
        }
        pre .string { color: #885800; }
        pre .number { color: blue; }
        pre .boolean { color: magenta; }
        pre .null { color: red; }
        pre .key { color: green; }
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 100%;
        }

        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #description {
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
        }

        #infowindow-content .title {
            font-weight: bold;
        }

        #infowindow-content {
            display: none;
        }

        #map #infowindow-content {
            display: inline;
        }

        .pac-card {
            margin: 10px 10px 0 0;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            background-color: #fff;
            font-family: Roboto;
        }

        #pac-container {
            padding-bottom: 12px;
            margin-right: 12px;
        }

        .pac-controls {
            display: inline-block;
            padding: 5px 11px;
        }

        .pac-controls label {
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
        }

        #pac-input {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 400px;
        }

        #pac-input:focus {
            border-color: #4d90fe;
        }

        #title {
            color: #fff;
            background-color: #4d90fe;
            font-size: 25px;
            font-weight: 500;
            padding: 6px 12px;
        }

        #target {
            width: 345px;
        }
    </style>
    <div class="box">
        <div class="box-body">
            <div id="app">
                <div>
                    {!! Form::open(['url' => adminPath().'/resale_units','method'=>'post','enctype'=> 'multipart/form-data', 'id'=>'resale-form']) !!}
                    <form-wizard @on-complete="onComplete(model)"
                                 color="gray"
                                 error-color="#a94442"
                                 >
                        <tab-content title="Description & Privacy"
                                     icon="" >
                           <div class="form-group  {{ $errors->has("privacy") ? 'has-error' : '' }} col-md-12">
                                {!! Form::label(trans("admin.privacy")) !!}
                                <br>
                                <select class="select2 form-control" style="width: 100%" name="privacy"
                                        data-placeholder="{{ trans("admin.privacy") }}" id="Privacy">
                                    <option></option>
                                    <option selected value="only_me">{{ __('admin.only_me') }}</option>
                                    <option value="team_only">{{ __('admin.team_only') }}</option>
                                    <option value="public">{{ __('admin.public') }}</option>
                                    <option value="custom">{{ __('admin.custom') }}</option>
                                </select>
                            </div>
                            <!-- <div class="form-group  {{ $errors->has("agent_id") ? 'has-error' : '' }} col-md-6">
                                {!! Form::label(trans("admin.agent")) !!}
                                <br>
                                <select class="select2 form-control ResCom" style="width: 100%" name="agent_id"
                                        data-placeholder="{{ trans("admin.agent") }}">
                                    <option></option>
                                    @if(($user = @App\User::find(Auth()->user()->id)) !== null)
                                        <option selected value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endif
                                </select>
                            </div> -->

                            <div class="form-group @if($errors->has('ar_title')) has-error @endif col-md-6">
                                <label>{{ trans('admin.ar_title') }}</label>
                                {!! Form::text('ar_title',request()->ar_name,['class' => 'form-control', 'placeholder' => trans('admin.ar_title')]) !!}
                            </div>

                            <div class="form-group @if($errors->has('en_title')) has-error @endif col-md-6">
                                <label>{{ trans('admin.en_title') }}</label>
                                {!! Form::text('en_title',request()->en_name,['class' => 'form-control', 'placeholder' => trans('admin.en_title')]) !!}
                            </div>

                            <div class="form-group @if($errors->has('ar_description')) has-error @endif col-md-6">
                                <label>{{ trans('admin.ar_description') }}</label>
                                {!! Form::textarea('ar_description',request()->ar_description,['class' => 'form-control', 'placeholder' => trans('admin.ar_description'),'rows'=>5]) !!}
                            </div>

                            <div class="form-group @if($errors->has('en_description')) has-error @endif col-md-6">
                                <label>{{ trans('admin.en_description') }}</label>
                                {!! Form::textarea('en_description',request()->en_description,['class' => 'form-control', 'placeholder' => trans('admin.en_description'),'rows'=>5]) !!}
                            </div>
                            <div class="form-group @if($errors->has('ar_notes')) has-error @endif col-md-6">
                                <label>{{ trans('admin.ar_notes') }}</label>
                                {!! Form::textarea('ar_notes','',['class' => 'form-control', 'placeholder' => trans('admin.ar_notes'),'rows'=>5]) !!}
                            </div>

                            <div class="form-group @if($errors->has('en_notes')) has-error @endif col-md-6">
                                <label>{{ trans('admin.en_notes') }}</label>
                                {!! Form::textarea('en_notes','',['class' => 'form-control', 'placeholder' => trans('admin.en_notes'),'rows'=>5]) !!}
                            </div>

                            {{-- <div class="form-group @if($errors->has('lead_id')) has-error @endif col-md-6">
                                <label>{{ trans('admin.lead') }}</label>
                                <select class="form-control select2"   name="lead_id" data-placeholder="{{ trans('admin.lead') }}">
                                    <option></option>
                                    @foreach(@App\Lead::getAgentLeads() as $lead)
                                        <option  value="{{ $lead->id }}"
                                                @if(old('lead_id') == $lead->id) selected
                                                @elseif(request()->lead == $lead->id) selected @endif>
                                                {{ $lead->first_name . ' ' . $lead->last_name }}
                                                -
                                                @if($lead->agent_id == auth()->id())
                                                    {{ __('admin.my_lead') }}
                                                @else
                                                    {{ __('admin.team_lead', ['agent' => @$lead->name]) }}
                                                @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <div class="form-group @if($errors->has('agent_id')) has-error @endif col-md-6">
                                <label>
                                    {{ trans('admin.agent') }}
                                </label>
                                <select class="form-control select2" data-placeholder="{{ trans('admin.agent') }}" name="agent_id" style="width: 100%">
                                    @foreach(App\User::get() as $lead)
                                    <option @if($lead->id==auth()->user()->id) selected @endif value="{{ $lead->id }}">
                                        {{ $lead->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group @if($errors->has('leads')) has-error @endif col-md-6">
                                <label>
                                    {{ trans('admin.leads') }}
                                </label>
                                <select class="form-control select2" data-placeholder="{{ trans('admin.leads') }}" name="lead_id" style="width: 100%">
                                    <option>
                                    </option>
                                    @foreach(@App\Lead::get() as $lead)
                                    <option value="{{ $lead->id }}">
                                        {{ $lead->first_name.' '.$lead->last_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group @if($errors->has('phone')) has-error @endif col-md-6">
                                <label>{{ trans('admin.phone') }}</label>
                                <div class="input-group">
                                    {!! Form::number('phone','',['class' => 'form-control', 'placeholder' => trans('admin.phone')]) !!}
                                    <span style="cursor: pointer" class="input-group-addon" id="addPhone"><i
                                                class="fa fa-plus"></i></span>
                                </div>
                            </div>
                            <span id="otherPhones"></span>
                        </tab-content>
                        <tab-content title="Unit"
                                     icon="" >
                        <div class="box-body">
                         <div class="form-group @if($errors->has('type')) has-error @endif col-xs-2">
                            <label>{{ trans('admin.type') }}</label> <br>
                            <select class="select2 form-control" style="width: 100%" name="type" id="type" data-placeholder="{{ trans('admin.type') }}">
                                <option></option>
                                <option value="personal"
                                        @if("personal" == request()->type) selected @endif>{{ trans('admin.personal') }}</option>
                                <option value="commercial"
                                        @if("commercial" == request()->type) selected @endif>{{ trans('admin.commercial') }}</option>
                            </select>
                        </div>

                        <div class="form-group @if($errors->has('unit_type_id')) has-error @endif col-md-2">
                            <label>{{ trans('admin.unit_type') }}</label>
                            <select class="select2 form-control" name="unit_type_id" style="width: 100%"
                                    data-placeholder="{{ trans('admin.unit_type') }}" id="unit_type">
                                <option></option>
                                @foreach(@\App\UnitType::all() as $type)
                                    <option value="{{ $type->id }}"
                                            @if($type->id == request()->type_id) selected @endif>{{ $type->{app()->getLocale().'_name'} }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group @if($errors->has('project_id')) has-error @endif col-md-2">
                            <label>{{ trans('admin.project') }}</label>
                            <select class="select2 form-control" style="width: 100%" name="project_id" data-placeholder="{{ trans('admin.project') }}">
                                <option></option>
                                @foreach(@\App\Project::all() as $project)
                                    <option value="{{ $project->id }}"
                                            @if($project->id == request()->project) selected @endif>{{ $project->{app()->getLocale().'_name'} }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- <div class="form-group @if($errors->has('broker_id')) has-error @endif col-md-2">
                            <label>{{ trans('admin.broker') }}</label>
                            <select class="select2 form-control" style="width: 100%" name="broker_id" data-placeholder="{{ trans('admin.broker') }}">
                                <option></option>
                            </select>
                        </div> -->
                        <div class="form-group @if($errors->has('delivery_date')) has-error @endif col-md-2">
                            <label>{{ trans('admin.delivery_date') }}</label>
                            <div class="input-group">
                                {!! Form::text('delivery_date','',['class' => 'form-control', 'placeholder' => trans('admin.delivery_date'),'readonly'=>'','id'=>'datepicker']) !!}
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="form-group @if($errors->has('area')) has-error @endif col-md-2">
                            <label>{{ trans('admin.area') }}</label>
                            {!! Form::number('area',request()->area,['class' => 'form-control', 'placeholder' => trans('admin.area')]) !!}
                        </div>

                        <div class="form-group @if($errors->has('rooms')) has-error @endif col-md-2">
                            <label>{{ trans('admin.rooms') }}</label>
                            {!! Form::number('rooms','',['class' => 'form-control', 'placeholder' => trans('admin.rooms')]) !!}
                        </div>

                        <div class="form-group @if($errors->has('bathrooms')) has-error @endif col-md-2">
                            <label>{{ trans('admin.bathrooms') }}</label>
                            {!! Form::number('bathrooms','',['class' => 'form-control', 'placeholder' => trans('admin.bathrooms')]) !!}
                        </div>

                        <div class="form-group @if($errors->has('floors')) has-error @endif col-md-2">
                            <label>{{ trans('admin.floors') }}</label>
                            {!! Form::number('floors','',['class' => 'form-control', 'placeholder' => trans('admin.floors')]) !!}
                        </div>


                        <div class="form-group @if($errors->has('finishing')) has-error @endif col-md-2">
                            <label>{{ trans('admin.finishing') }}</label>
                            <select class="select2 form-control" style="width: 100%" name="finishing" data-placeholder="{{ trans('admin.finishing') }}">
                                <option></option>
                                <option value="finished">{{ trans('admin.finished') }}</option>
                                <option value="semi_finished">{{ trans('admin.semi_finished') }}</option>
                                <option value="not_finished">{{ trans('admin.not_finished') }}</option>
                            </select>
                        </div>
                        <div class="form-group @if($errors->has('image')) has-error @endif col-md-2">
                            <label>{{ trans('admin.image') }}</label>
                            {!! Form::file('image',['class' => 'form-control', 'placeholder' => trans('admin.image'), 'accept' => 'image/*']) !!}
                        </div>

                        <div class="form-group @if($errors->has('other_images')) has-error @endif col-md-2">
                            <label>{{ trans('admin.other_images') }}</label>
                            {!! Form::file('other_images[]',['class' => 'form-control', 'placeholder' => trans('admin.other_images'), 'multiple'=>'']) !!}
                        </div>
                        <div class="form-group @if($errors->has('view')) has-error @endif col-md-3">
                            <label>{{ trans('admin.view') }}</label>
                            <select class="select2 form-control" style="width: 100%" name="view" data-placeholder="{{ trans('admin.view') }}">
                                <option></option>
                                <option value="main_street">{{ trans('admin.main_street') }}</option>
                                <option value="bystreet">{{ trans('admin.bystreet') }}</option>
                                <option value="garden">{{ trans('admin.garden') }}</option>
                                <option value="corner">{{ trans('admin.corner') }}</option>
                                <option value="sea_or_river">{{ trans('admin.sea_or_river') }}</option>
                            </select>
                        </div>


                        <div class="form-group @if($errors->has('youtube_link')) has-error @endif col-md-3">
                            <label>{{ trans('admin.youtube_link') }}</label>
                            {!! Form::text('youtube_link','',['class' => 'form-control', 'placeholder' => trans('admin.youtube_link')]) !!}
                        </div>

                        <div class="form-group @if($errors->has('payment_method')) has-error @endif col-md-3">
                            <br/>
                            <input type="hidden" name="featured" value="0">
                            <input type="checkbox" name="featured" class="switch-box" data-on-text="{{ __('admin.yes') }}"
                                   data-off-text="{{ __('admin.no') }}" data-label-text="{{ __('admin.featured') }}" value="1">
                        </div>
                        @php($arr=[])
                        @if(@count(old('facility')) > 0)
                            @php($arr = old('facility'));
                        @endif
                        <!-- <br> -->
                        <div class="form-group  {{ $errors->has('facility') ? 'has-error' : '' }} col-md-3">
                            {!! Form::label(trans("admin.facility")) !!}
                            <br>
                            <select class="select2 form-control" style="width: 100%" multiple name="facility[]"
                                    data-placeholder="{{ trans("admin.facilities") }}">
                                <option></option>
                                @foreach(App\Facility::get() as $facilty)
                                    <option value="{{ $facilty->id }}" @if(in_array($facilty->id,$arr)) selected @endif>{{ $facilty->en_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group @if($errors->has('bua')) has-error @endif col-md-12">
                            <label>{{ trans('admin.bua') }}</label>
                            <input type="number" name="bua" placeholder="{{ trans('admin.Bua') }}" class="form-control">
                        </div>

                        <div class="form-group @if($errors->has('villa')) has-error @endif col-md-12">
                            <label>{{ trans('admin.villa') }}</label>
                            <input type="number" name="villa" placeholder="{{ trans('admin.villa') }}" class="form-control">
                        </div>

                        </div>

                        </tab-content>
                        <tab-content title="Location"
                                     icon="" >
                         <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="form-group @if($errors->has('location')) has-error @endif">
                                    <label>{{ trans('admin.location') }}</label>
                                    <select class="select2 form-control" style="width: 100%" name="location" id="location"
                                            data-placeholder="{{ trans('admin.location') }}">
                                        <option></option>
                                        @foreach(@\App\Location::all() as $location)
                                            <option value="{{ $location->id }}" @if($location->id == request()->location) selected
                                                    @endif
                                                    lat="{{ $location->lat }}" lng="{{ $location->lng }}"
                                                    zoom="{{ $location->zoom }}">{{ $location->{app()->getLocale().'_name'} }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group @if($errors->has('country_id')) has-error @endif">
                                    <label>{{ trans('admin.country') }}</label>
                                    <select class="select2 form-control" style="width: 100%" name="country_id" id="country_id"
                                            data-placeholder="{{ trans('admin.country') }}">
                                        <option></option>
                                        @foreach(@DB::table('country')->get() as $country)
                                            <option value="{{ $country->id }}">{{ $country->{app()->getLocale().'_name'} }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <span id="cities"></span>

                                <div class="form-group @if($errors->has('en_address')) has-error @endif">
                                    <label>{{ trans('admin.en_address') }}</label>
                                    {!! Form::text('en_address',request()->en_address,['class' => 'form-control', 'placeholder' => trans('admin.en_address'),'id'=>'address']) !!}
                                </div>

                                <div class="form-group @if($errors->has('ar_address')) has-error @endif">
                                    <label>{{ trans('admin.ar_address') }}</label>
                                    {!! Form::text('ar_address',request()->ar_address,['class' => 'form-control', 'placeholder' => trans('admin.ar_address')]) !!}
                                </div>

                            </div>
                            <div class="col-md-8">
                                <div id="map" style="height: 450px; x-index: 999"></div>
                            </div>
                        </div>
                        <input id="lat" name="lat" type="hidden"
                               value="@if(request()->has('lat')){{ request()->lat }} @else 30.0595581 @endif">
                        <input id="lng" name="lng" type="hidden"
                               value="@if(request()->has('lng')){{ request()->lng }} @else 31.2233591 @endif">
                        <input id="zoom" name="zoom" type="hidden"
                               value="@if(request()->has('zoom')){{ request()->lng }} @else 7 @endif">
                        </tab-content>
                        <tab-content title="Payment"
                                     icon="" >
                         <div class="form-group @if($errors->has('original_price')) has-error @endif col-md-2">
                            <label>{{ trans('admin.original_price') }}</label>
                            {!! Form::number('original_price',request()->unit_price,['class' => 'form-control', 'placeholder' => trans('admin.original_price')]) !!}
                        </div>

                        <div class="form-group @if($errors->has('payed')) has-error @endif col-md-2">
                            <label>{{ trans('admin.payed') }}</label>
                            {!! Form::number('payed','',['class' => 'form-control', 'placeholder' => trans('admin.payed')]) !!}
                        </div>

                        <div class="form-group @if($errors->has('rest')) has-error @endif col-md-2">
                            <label>{{ trans('admin.rest') }}</label>
                            {!! Form::number('rest','',['class' => 'form-control', 'placeholder' => trans('admin.rest')]) !!}
                        </div>

                        <div class="form-group @if($errors->has('total')) has-error @endif col-md-2">
                            <label>{{ trans('admin.total') }}</label>
                            {!! Form::number('total','',['class' => 'form-control', 'placeholder' => trans('admin.total')]) !!}
                        </div>
                        <div class="form-group @if($errors->has('price')) has-error @endif col-md-2">
                            <label>{{ trans('admin.price') }}</label>
                            {!! Form::number('price','',['class' => 'form-control', 'placeholder' => trans('admin.price')]) !!}
                        </div>
                        <div class="form-group @if($errors->has('payment_method')) has-error @endif col-md-2">
                            <label>{{ trans('admin.payment_method') }}</label>
                            <br>
                            <select class="select2 form-control" name="payment_method" style="width: 100%" 
                                    data-placeholder="{{ trans('admin.payment_method') }}">
                                <option></option>
                                <option value="cash">{{ trans('admin.cash') }}</option>
                                <option value="installment">{{ trans('admin.installment') }}</option>
                                <option value="cash_or_installment">{{ trans('admin.cash_or_installment') }}</option>
                            </select>
                        </div>
                        <div class="form-group @if($errors->has('due_now')) has-error @endif col-md-4">
                            <label>{{ trans('admin.due_now') }}</label>
                            {!! Form::number('due_now','',['class' => 'form-control', 'placeholder' => trans('admin.due_now')]) !!}
                        </div>
                        <div class="form-group @if($errors->has('transfer')) has-error @endif col-md-4">
                            <label>{{ trans('admin.transfer') }}</label>
                            <input type="number" name="transfer" placeholder="{{ trans('admin.transfer') }}" class="form-control">
                        </div>
                        <div class="form-group @if($errors->has('maintenance')) has-error @endif col-md-4">
                            <label>{{ trans('admin.maintenance') }}</label>
                            <input type="number" name="maintenance" placeholder="{{ trans('admin.maintenance') }}" class="form-control">
                        </div>
                        <br>
                        </tab-content>
                    </form-wizard>
                    {!! Form::close() !!} 
                </div>
            </div>
        </div>
    </div>
     {{-- {!! Form::open(['url' => adminPath().'/resale_units','method'=>'post','enctype'=> 'multipart/form-data']) !!}
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admin.unit_info') }}</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="form-group @if($errors->has('ar_title')) has-error @endif col-md-6">
                <label>{{ trans('admin.ar_title') }}</label>
                {!! Form::text('ar_title',request()->ar_name,['class' => 'form-control', 'placeholder' => trans('admin.ar_title')]) !!}
            </div>

            <div class="form-group @if($errors->has('en_title')) has-error @endif col-md-6">
                <label>{{ trans('admin.en_title') }}</label>
                {!! Form::text('en_title',request()->en_name,['class' => 'form-control', 'placeholder' => trans('admin.en_title')]) !!}
            </div>

            <div class="form-group @if($errors->has('ar_description')) has-error @endif col-md-6">
                <label>{{ trans('admin.ar_description') }}</label>
                {!! Form::textarea('ar_description',request()->ar_description,['class' => 'form-control', 'placeholder' => trans('admin.ar_description'),'rows'=>5]) !!}
            </div>

            <div class="form-group @if($errors->has('en_description')) has-error @endif col-md-6">
                <label>{{ trans('admin.en_description') }}</label>
                {!! Form::textarea('en_description',request()->en_description,['class' => 'form-control', 'placeholder' => trans('admin.en_description'),'rows'=>5]) !!}
            </div>
            <div class="form-group @if($errors->has('ar_notes')) has-error @endif col-md-6">
                <label>{{ trans('admin.ar_notes') }}</label>
                {!! Form::textarea('ar_notes','',['class' => 'form-control', 'placeholder' => trans('admin.ar_notes'),'rows'=>5]) !!}
            </div>

            <div class="form-group @if($errors->has('en_notes')) has-error @endif col-md-6">
                <label>{{ trans('admin.en_notes') }}</label>
                {!! Form::textarea('en_notes','',['class' => 'form-control', 'placeholder' => trans('admin.en_notes'),'rows'=>5]) !!}
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admin.lead_info') }}</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="form-group @if($errors->has('lead_id')) has-error @endif col-md-6">
                <label>{{ trans('admin.lead') }}</label>
                <select class="select2 form-control" name="lead_id" data-placeholder="{{ trans('admin.lead') }}">
                    <option></option>
                    @foreach(@App\Lead::getAgentLeads() as $lead)
                        <option value="{{ $lead->id }}"
                                @if(old('lead_id') == $lead->id) selected
                                @elseif(request()->lead == $lead->id) selected @endif>
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
            <div class="form-group @if($errors->has('phone')) has-error @endif col-md-6">
                <label>{{ trans('admin.phone') }}</label>
                <div class="input-group">
                    {!! Form::number('phone','',['class' => 'form-control', 'placeholder' => trans('admin.phone')]) !!}
                    <span style="cursor: pointer" class="input-group-addon" id="addPhone"><i
                                class="fa fa-plus"></i></span>
                </div>
            </div>
            <span id="otherPhones"></span>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admin.unit_description') }}</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="form-group @if($errors->has('type')) has-error @endif col-md-2">
                <label>{{ trans('admin.type') }}</label>
                <select class="select2 form-control" name="type" id="type" data-placeholder="{{ trans('admin.type') }}">
                    <option></option>
                    <option value="personal"
                            @if("personal" == request()->type) selected @endif>{{ trans('admin.personal') }}</option>
                    <option value="commercial"
                            @if("commercial" == request()->type) selected @endif>{{ trans('admin.commercial') }}</option>
                </select>
            </div>

            <div class="form-group @if($errors->has('unit_type_id')) has-error @endif col-md-2">
                <label>{{ trans('admin.unit_type') }}</label>
                <select class="select2 form-control" name="unit_type_id"
                        data-placeholder="{{ trans('admin.unit_type') }}" id="unit_type">
                    <option></option>
                    @foreach(@\App\UnitType::all() as $type)
                        <option value="{{ $type->id }}"
                                @if($type->id == request()->type_id) selected @endif>{{ $type->{app()->getLocale().'_name'} }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group @if($errors->has('project_id')) has-error @endif col-md-2">
                <label>{{ trans('admin.project') }}</label>
                <select class="select2 form-control" name="project_id" data-placeholder="{{ trans('admin.project') }}">
                    <option></option>
                    @foreach(@\App\Project::all() as $project)
                        <option value="{{ $project->id }}"
                                @if($project->id == request()->project) selected @endif>{{ $project->{app()->getLocale().'_name'} }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group @if($errors->has('broker_id')) has-error @endif col-md-2">
                <label>{{ trans('admin.broker') }}</label>
                <select class="select2 form-control" name="broker_id" data-placeholder="{{ trans('admin.broker') }}">
                    <option></option>
                </select>
            </div>


            <div class="form-group @if($errors->has('original_price')) has-error @endif col-md-2">
                <label>{{ trans('admin.original_price') }}</label>
                {!! Form::number('original_price',request()->unit_price,['class' => 'form-control', 'placeholder' => trans('admin.original_price')]) !!}
            </div>

            <div class="form-group @if($errors->has('payed')) has-error @endif col-md-2">
                <label>{{ trans('admin.payed') }}</label>
                {!! Form::number('payed','',['class' => 'form-control', 'placeholder' => trans('admin.payed')]) !!}
            </div>

            <div class="form-group @if($errors->has('rest')) has-error @endif col-md-2">
                <label>{{ trans('admin.rest') }}</label>
                {!! Form::number('rest','',['class' => 'form-control', 'placeholder' => trans('admin.rest')]) !!}
            </div>

            <div class="form-group @if($errors->has('total')) has-error @endif col-md-2">
                <label>{{ trans('admin.total') }}</label>
                {!! Form::number('total','',['class' => 'form-control', 'placeholder' => trans('admin.total')]) !!}
            </div>
            <div class="form-group @if($errors->has('due_now')) has-error @endif col-md-2">
                <label>{{ trans('admin.due_now') }}</label>
                {!! Form::number('due_now','',['class' => 'form-control', 'placeholder' => trans('admin.due_now')]) !!}
            </div>
            <div class="form-group @if($errors->has('delivery_date')) has-error @endif col-md-2">
                <label>{{ trans('admin.delivery_date') }}</label>
                <div class="input-group">
                    {!! Form::text('delivery_date','',['class' => 'form-control', 'placeholder' => trans('admin.delivery_date'),'readonly'=>'','id'=>'datepicker']) !!}
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
            <div class="form-group @if($errors->has('area')) has-error @endif col-md-2">
                <label>{{ trans('admin.area') }}</label>
                {!! Form::number('area',request()->area,['class' => 'form-control', 'placeholder' => trans('admin.area')]) !!}
            </div>

            <div class="form-group @if($errors->has('price')) has-error @endif col-md-2">
                <label>{{ trans('admin.price') }}</label>
                {!! Form::number('price','',['class' => 'form-control', 'placeholder' => trans('admin.price')]) !!}
            </div>

            <div class="form-group @if($errors->has('rooms')) has-error @endif col-md-2">
                <label>{{ trans('admin.rooms') }}</label>
                {!! Form::number('rooms','',['class' => 'form-control', 'placeholder' => trans('admin.rooms')]) !!}
            </div>

            <div class="form-group @if($errors->has('bathrooms')) has-error @endif col-md-2">
                <label>{{ trans('admin.bathrooms') }}</label>
                {!! Form::number('bathrooms','',['class' => 'form-control', 'placeholder' => trans('admin.bathrooms')]) !!}
            </div>

            <div class="form-group @if($errors->has('floors')) has-error @endif col-md-2">
                <label>{{ trans('admin.floors') }}</label>
                {!! Form::number('floors','',['class' => 'form-control', 'placeholder' => trans('admin.floors')]) !!}
            </div>


            <div class="form-group @if($errors->has('finishing')) has-error @endif col-md-2">
                <label>{{ trans('admin.finishing') }}</label>
                <select class="select2 form-control" name="finishing" data-placeholder="{{ trans('admin.finishing') }}">
                    <option></option>
                    <option value="finished">{{ trans('admin.finished') }}</option>
                    <option value="semi_finished">{{ trans('admin.semi_finished') }}</option>
                    <option value="not_finished">{{ trans('admin.not_finished') }}</option>
                </select>
            </div>
            <div class="form-group @if($errors->has('image')) has-error @endif col-md-2">
                <label>{{ trans('admin.image') }}</label>
                {!! Form::file('image',['class' => 'form-control', 'placeholder' => trans('admin.image'), 'accept' => 'image/*']) !!}
            </div>

            <div class="form-group @if($errors->has('other_images')) has-error @endif col-md-2">
                <label>{{ trans('admin.other_images') }}</label>
                {!! Form::file('other_images[]',['class' => 'form-control', 'placeholder' => trans('admin.other_images'), 'multiple'=>'']) !!}
            </div>
            <div class="form-group @if($errors->has('view')) has-error @endif col-md-3">
                <label>{{ trans('admin.view') }}</label>
                <select class="select2 form-control" name="view" data-placeholder="{{ trans('admin.view') }}">
                    <option></option>
                    <option value="main_street">{{ trans('admin.main_street') }}</option>
                    <option value="bystreet">{{ trans('admin.bystreet') }}</option>
                    <option value="garden">{{ trans('admin.garden') }}</option>
                    <option value="corner">{{ trans('admin.corner') }}</option>
                    <option value="sea_or_river">{{ trans('admin.sea_or_river') }}</option>
                </select>
            </div>


            <div class="form-group @if($errors->has('youtube_link')) has-error @endif col-md-3">
                <label>{{ trans('admin.youtube_link') }}</label>
                {!! Form::text('youtube_link','',['class' => 'form-control', 'placeholder' => trans('admin.youtube_link')]) !!}
            </div>


            <div class="form-group @if($errors->has('payment_method')) has-error @endif col-md-3">
                <label>{{ trans('admin.payment_method') }}</label>
                <select class="select2 form-control" name="payment_method"
                        data-placeholder="{{ trans('admin.payment_method') }}">
                    <option></option>
                    <option value="cash">{{ trans('admin.cash') }}</option>
                    <option value="installment">{{ trans('admin.installment') }}</option>
                    <option value="cash_or_installment">{{ trans('admin.cash_or_installment') }}</option>
                </select>
            </div>

            <div class="form-group @if($errors->has('payment_method')) has-error @endif col-md-3">
                <br/>
                <input type="hidden" name="featured" value="0">
                <input type="checkbox" name="featured" class="switch-box" data-on-text="{{ __('admin.yes') }}"
                       data-off-text="{{ __('admin.no') }}" data-label-text="{{ __('admin.featured') }}" value="1">
            </div>
            @php($arr=[])
            @if(@count(old('facility')) > 0)
                @php($arr = old('facility'));
            @endif
            <div class="form-group  {{ $errors->has("facility") ? 'has-error' : '' }} col-md-4">
                {!! Form::label(trans("admin.facility")) !!}
                <br>
                <select class="select2 form-control" style="width: 100%" multiple name="facility[]"
                        data-placeholder="{{ trans("admin.facilities") }}">
                    <option></option>
                    @foreach(App\Facility::get() as $facilty)
                        <option value="{{ $facilty->id }}" @if(in_array($facilty->id,$arr)) selected @endif>{{ $facilty->en_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group  {{ $errors->has("agent_id") ? 'has-error' : '' }} col-md-4">
                {!! Form::label(trans("admin.agent")) !!}
                <br>
                <select class="select2 form-control ResCom" style="width: 100%" name="agent_id"
                        data-placeholder="{{ trans("admin.agent") }}">
                    <option></option>
                    @if(($user = @App\User::find(Auth()->user()->id)) !== null)
                        <option selected value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                </select>
            </div>

            <div class="form-group  {{ $errors->has("privacy") ? 'has-error' : '' }} col-md-4">
                {!! Form::label(trans("admin.privacy")) !!}
                <br>
                <select class="select2 form-control" style="width: 100%" name="privacy"
                        data-placeholder="{{ trans("admin.privacy") }}" id="Privacy">
                    <option></option>
                    <option selected value="only_me">{{ __('admin.only_me') }}</option>
                    <option value="team_only">{{ __('admin.team_only') }}</option>
                    <option value="public">{{ __('admin.public') }}</option>
                    <option value="custom">{{ __('admin.custom') }}</option>
                </select>
            </div>

            <div class="form-group  {{ $errors->has("agents") ? 'has-error' : '' }} col-md-12 hidden" id="CustomAgents">
                {!! Form::label(trans("admin.agents")) !!}
                <br>
                <select class="select2 form-control ResCom" style="width: 100%" name="agents[]"
                        data-placeholder="{{ trans("admin.agents") }}" multiple>
                    <option></option>
                </select>
            </div>

            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="form-group @if($errors->has('location')) has-error @endif">
                        <label>{{ trans('admin.location') }}</label>
                        <select class="select2 form-control" name="location" id="location"
                                data-placeholder="{{ trans('admin.location') }}">
                            <option></option>
                            @foreach(@\App\Location::all() as $location)
                                <option value="{{ $location->id }}" @if($location->id == request()->location) selected
                                        @endif
                                        lat="{{ $location->lat }}" lng="{{ $location->lng }}"
                                        zoom="{{ $location->zoom }}">{{ $location->{app()->getLocale().'_name'} }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group @if($errors->has('country_id')) has-error @endif">
                        <label>{{ trans('admin.country') }}</label>
                        <select class="select2 form-control" name="country_id" id="country_id"
                                data-placeholder="{{ trans('admin.country') }}">
                            <option></option>
                            @foreach(@DB::table('country')->get() as $country)
                                <option value="{{ $country->id }}">{{ $country->{app()->getLocale().'_name'} }}</option>
                            @endforeach
                        </select>
                    </div>

                    <span id="cities"></span>

                    <div class="form-group @if($errors->has('en_address')) has-error @endif">
                        <label>{{ trans('admin.en_address') }}</label>
                        {!! Form::text('en_address',request()->en_address,['class' => 'form-control', 'placeholder' => trans('admin.en_address'),'id'=>'address']) !!}
                    </div>

                    <div class="form-group @if($errors->has('ar_address')) has-error @endif">
                        <label>{{ trans('admin.ar_address') }}</label>
                        {!! Form::text('ar_address',request()->ar_address,['class' => 'form-control', 'placeholder' => trans('admin.ar_address')]) !!}
                    </div>


                    <div class="form-group @if($errors->has('maintenance')) has-error @endif">
                        <label>{{ trans('admin.maintenance') }}</label>
                        <input type="number" name="maintenance" placeholder="{{ trans('admin.maintenance') }}" class="form-control">
                    </div>

                    <div class="form-group @if($errors->has('transfer')) has-error @endif">
                        <label>{{ trans('admin.transfer') }}</label>
                        <input type="number" name="transfer" placeholder="{{ trans('admin.transfer') }}" class="form-control">
                    </div>

                    <div class="form-group @if($errors->has('bua')) has-error @endif">
                        <label>{{ trans('admin.bua') }}</label>
                        <input type="number" name="bua" placeholder="{{ trans('admin.Bua') }}" class="form-control">
                    </div>

                    <div class="form-group @if($errors->has('villa')) has-error @endif">
                        <label>{{ trans('admin.villa') }}</label>
                        <input type="number" name="villa" placeholder="{{ trans('admin.villa') }}" class="form-control">
                    </div>


                </div>
                <div class="col-md-8">
                    <div id="map" style="height: 450px; x-index: 999"></div>
                </div>
            </div>
            <input id="lat" name="lat" type="hidden"
                   value="@if(request()->has('lat')){{ request()->lat }} @else 30.0595581 @endif">
            <input id="lng" name="lng" type="hidden"
                   value="@if(request()->has('lng')){{ request()->lng }} @else 31.2233591 @endif">
            <input id="zoom" name="zoom" type="hidden"
                   value="@if(request()->has('zoom')){{ request()->lng }} @else 7 @endif">
            <div class="col-md-12">
                <br/>
                <button type="submit" class="btn btn-primary btn-flat">{{ trans('admin.submit') }}</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!} --}}
@endsection
@section('js')

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script> -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
    <script src="https://unpkg.com/vue-multiselect@2.0.0-beta.13/lib/vue-multiselect.min.js"></script>
    <script src="https://rawgit.com/cristijora/vue-form-wizard/master/dist/vue-form-wizard.js"></script>
    <script src="https://rawgit.com/icebob/vue-form-generator/master/dist/vfg.js"></script>

    <!-- <script type="text/javascript">
        $(document).ready(function() {
           $('.selectpicker').selectpicker();
        });        
    </script> -->



    <script type="text/javascript">

Vue.use(VueFormWizard)
Vue.use(VueFormGenerator)

Vue.component("multiselect", VueMultiselect.default);
new Vue({
 el: '#app',
 data:{
   // lead: function(){
   //
   // },
   model:{

        selectedFile: null,
        // first section <<<<<<<<<<
        privacy:'',
        agents:'',
        ar_title:'',
        ar_description:'',
        ar_notes:'',
        en_title:'',
        en_description:'',
        en_notes:'',
        lead_id:'',
        phone:'',
        // second section <<<<<<<<<<
        type:'',
        unit_type_id:'',
        project_id:'',
        broker_id:'',
        due_now:'',
        delivery_date:'',
        area:'',
        rooms:'',
        bathrooms:'',
        floors:'',
        finishing:'',
        image: null,
        other_images:[],
        view:'',
        youtube_link:'',
        featured:'',
        facility:[],

        // third section <<<<<<<<<<

        location:'',
        country_id:'',
        city_id:'',
        district_id:'',
        en_address:'',
        ar_address:'',
        lat: 30.0595581,
        lng: 31.2233591,
        zoom: 7,

        // fourth section <<<<<<<<<<
        original_price:'',
        payed:'',
        rest:'',
        total:'',
        price:'',
        payment_method:''
   },


},
 methods: {
  onComplete: function(json){
      // alert('Yay. Done!');

      $( "#resale-form" ).submit();
      // adminPath().'/resale_units'
      /*const formData = new FormData();
      formData.append('myFile', this.selectedFile, this.selectedFile.name)
      console.log(json);
      console.log(window.location.origin + ' / {{adminPath()."/resale_units"}}');
      console.log(this.model.image)
      this.selectedFile = this.model.image

      axios({
        method: 'post',
        url: window.location.origin + '{{ "/" . adminPath()."/resale_units"}}',
        data: json,
        config: { headers: {'Content-Type': 'multipart/form-data' }}
        })
        .then(function (response) {
            //handle success
            // adminPath() . '/resale_units/' . $unit->id
            // console.log(window.location.origin + '{{ "/" . adminPath()."/resale_units"}}' + response.data.unitId);
            // window.location.href = '{{url(adminPath()."/resale_units")."/"}}' + response.data.unitId;s
            console.log(response.status);
            console.log(response);
        })
        .catch(function (response) {
            //handle error
            console.log(response.status);
            console.log(response);
        });*/

   },
   validateFirstTab: function(){
     return this.$refs.firstTabForm.validate();
   },
   validateSecondTab: function(){
     return this.$refs.secondTabForm.validate();
   },
   validateThirdTab: function(){
     return this.$refs.thirdTabForm.validate();
   },
   validateFourthTab: function(){
     return this.$refs.fourthTabForm.validate();
   },

   prettyJSON: function(json) {
            if (json) {
                json = JSON.stringify(json, undefined, 4);
                json = json.replace(/&/g, '&').replace(/</g, '<').replace(/>/g, '>');
                return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function(match) {
                    var cls = 'number';
                    if (/^"/.test(match)) {
                        if (/:$/.test(match)) {
                            cls = 'key';
                        } else {
                            cls = 'string';
                        }
                    } else if (/true|false/.test(match)) {
                        cls = 'boolean';
                    } else if (/null/.test(match)) {
                        cls = 'null';
                    }
                    return '<span class="' + cls + '">' + match + '</span>';
                });
            }
        }
  }
})

    </script>
    <script>
        $(document).on('change', '#country_id', function () {
            var id = $(this).val();
            var _token = '{{ csrf_token() }}';
            $.ajax({
                url: "{{ url(adminPath().'/get_countries_cities')}}",
                method: 'post',
                data: {id: id, _token: _token},
                success: function (data) {
                    $('#cities').html(data);
                    $('.select2').select2();
                }
            });
        });
    </script>
    <script>
        $('#datepicker').datepicker({
            autoclose: true,
            format: " yyyy",
            viewMode: "years",
            minViewMode: "years",
        });
    </script>
    <script>
        function initAutocomplete() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: @if(request()->has('lat')){{ request()->lat }} @else 30.0595581 @endif,
                    lng: @if(request()->has('lng')){{ request()->lng }} @else 31.2233591 @endif},
                    zoom: @if(request()->has('zoom')){{ request()->lng }} @else 7 @endif,
                    mapTypeId: 'roadmap'
            });

            var input = document.getElementById('address');
            var searchBox = new google.maps.places.SearchBox(input);

            map.addListener('bounds_changed', function () {
                searchBox.setBounds(map.getBounds());
            });


            var marker = new google.maps.Marker({
                position: {
                    lat: @if(request()->has('lat')){{ request()->lat }} @else 30.0595581 @endif,
                    lng: @if(request()->has('lng')){{ request()->lng }} @else 31.2233591 @endif},
                map: map,
                draggable: false,
                animation: google.maps.Animation.DROP
            });


            searchBox.addListener('places_changed', function () {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                var bounds = new google.maps.LatLngBounds();
                places.forEach(function (place) {

                    $('#lat').val(place.geometry.location.lat());
                    $('#lng').val(place.geometry.location.lng());

                    marker.setPosition(place.geometry.location);

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });

            google.maps.event.addListener(map, 'click', function (event) {
                if(marker)
                {
                    marker.setMap(null);
                    var myLatLng = event.latLng;
                }

                marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,

                });
                $('#lat').val(marker.getPosition().lat());
                $('#lng').val(marker.getPosition().lng());
                console.log(marker.getPosition().lat());
            })

            google.maps.event.addListener(map, 'zoom_changed', function () {
                $('#zoom').val(map.getZoom())
            });

            $('#location').on('change', function () {
                var lat = parseFloat($('option:selected', this).attr('lat'));
                var lng = parseFloat($('option:selected', this).attr('lng'));
                var zoom = parseInt($('option:selected', this).attr('zoom'));
                $('#lat').val(lat);
                $('#lng').val(lng);
                $('#zoom').val(zoom);
                marker.setPosition({lat: lat, lng: lng});
                map.setCenter(new google.maps.LatLng(lat, lng));
                map.setZoom(zoom);
            })
        }
    </script>
    <script>
        $(document).on('change', '#type', function () {
            var usage = $(this).val();
            var _token = '{{ csrf_token() }}';
            $.ajax({
                url: "{{ url(adminPath().'/get_unit_types')}}",
                method: 'post',

                data: {usage: usage, _token: _token},
                success: function (data) {
                    $('#unit_type').html(data);
                }
            });
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJ67H5QBLVTdO2pnmEmC2THDx95rWyC1g&libraries=places&callback=initAutocomplete"
            async defer></script>
    <script>
        var i = 1;
        $(document).on('click', '#addPhone', function () {
            $('#otherPhones').append('<div class="form-group col-md-4" id="otherPhone' + i + '">' +
                '<label>{{ trans("admin.other_phones") }}</label>' +
                '<div class="input-group">' +
                '<input name="other_phones[]" class="form-control" placeholder="{{ trans("admin.other_phones") }}" type="number" value="">' +
                '<span style="cursor: pointer" class="removePhone input-group-addon" num="' + i + '"><i' +
                ' class="fa fa-minus"></i></span>' +
                '</div>' +
                '</div>');
            i++;
        });

        $(document).on('click', '.removePhone', function () {
            var num = $(this).attr('num');
            $('#otherPhone' + num).remove();
        })
    </script>
    <script>
        $(document).on('change', '#type', function () {
            if ($(this).val() == 'personal') {
                $('.ResCom').html('@foreach(App\User::where('residential_commercial', 'residential')->get() as $agent)' +
                    '<option></option>' +
                    '<option value="{{ $agent->id }}">{{ $agent->name }}</option>' +
                    '@endforeach');
            } else {
                $('.ResCom').html('@foreach(App\User::where('residential_commercial', 'commercial')->get() as $agent)' +
                    '<option></option>' +
                    '<option value="{{ $agent->id }}">{{ $agent->name }}</option>' +
                    '@endforeach');
            }
        });

        $(document).on('change', '#Privacy', function () {
            if ($(this).val() == 'custom') {
                $('#CustomAgents').removeClass('hidden');
            } else {
                $('#CustomAgents').addClass('hidden');
            }
        })
    </script>
@endsection
