<form action="{{ url(adminPath().'/rental_units') }}" method="post" enctype="multipart/form-data">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ $title }}</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                {{ csrf_field() }}
                <div class="form-group col-md-6 {{ $errors->has('ar_title') ? 'has-error' : '' }}">
                    {!! Form::label(trans('admin.ar_title')) !!}
                    <input class="form-control" name="ar_title" value="{{ old('ar_title') }}">
                </div>
                <div class="form-group col-md-6 {{ $errors->has('en_title') ? 'has-error' : '' }}">
                    {!! Form::label(trans('admin.en_title')) !!}
                    <input class="form-control" name="en_title" value="{{ old('en_title') }}">
                </div>
                <div class="form-group col-md-6 {{ $errors->has('ar_description') ? 'has-error' : '' }}">
                    {!! Form::label(trans('admin.ar_description')) !!}
                    <textarea class="form-control" name="ar_description">{{ old('ar_description') }}</textarea>
                </div>
                <div class="form-group col-md-6 {{ $errors->has('en_description') ? 'has-error' : '' }}">
                    {!! Form::label(trans('admin.en_description')) !!}
                    <textarea class="form-control" name="en_description">{{ old('en_description') }}</textarea>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ $title }}</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group col-md-4">
                    {!! Form::label(trans('admin.lead')) !!}
                    <select class="form-control select2" data-placeholder="{{ trans('admin.lead') }}" name="lead_id">
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
                <div class="form-group col-md-4">
                    {!! Form::label(trans('admin.phone')) !!}
                    <div class="input-group">

                        <input type="phone" class="form-control" name="phone" value="{{ old('phone') }}">
                        <span style="cursor: pointer" class="input-group-addon" id="addPhone"><i class="fa fa-plus"></i></span>
                    </div>
                </div>
                <div class="col-,d-12"><span id="otherPhones"></span></div>
            </div>
        </div>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('admin.unit_data') }}</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">

                <div class="form-group col-md-2">
                    {!! Form::label(trans('admin.usage')) !!}
                    <select class="form-control select2" data-placeholder="{{ trans('admin.type') }}" id="type"
                            name="usage">
                        <option></option>
                        <option value="personal"
                                @if("personal" == old('')) selected @endif>{{ trans('admin.personal') }}</option>
                        <option value="commercial"
                                @if("commercial" == old('')) selected @endif>{{ trans('admin.commercial') }}</option>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    {!! Form::label(trans('admin.type')) !!}
                    <select class="form-control select2" id="unit_type" name="type_id">
                        @foreach(@\App\UnitType::all() as $type)
                            <option value="{{ $type->id }}"
                                    @if($type->id == old('type_id') ) selected @endif> {{ $type->{app()->getLocale().'_name'} }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2 {{ $errors->has('area') ? 'has-error' : '' }}">
                    {!! Form::label(trans('admin.area')) !!}
                    <input class="form-control" name="area" type="number" min="0" value="{{ old('area') }}">
                </div>
                <div class="form-group col-md-2 {{ $errors->has('rooms') ? 'has-error' : '' }}">
                    {!! Form::label(trans('admin.rooms')) !!}
                    <input class="form-control" name="rooms" type="number" min="0" value="{{ old('rooms') }}">
                </div>
                <div class="form-group col-md-2 {{ $errors->has('floor') ? 'has-error' : '' }}">
                    {!! Form::label(trans('admin.floor')) !!}
                    <input class="form-control" name="floor" type="number" min="0" value="{{ old('floor') }}">
                </div>
                <div class="form-group col-md-2 {{ $errors->has('bathrooms') ? 'has-error' : '' }}">
                    {!! Form::label(trans('admin.bathrooms')) !!}
                    <input class="form-control" name="bathrooms" type="number" min="0" value="{{ old('bathrooms') }}">
                </div>
                <div class="form-group col-md-2 {{ $errors->has('delivery_date') ? 'has-error' : '' }}">
                    {!! Form::label(trans('admin.delivery_date')) !!}
                    <input class="form-control " id="datepicker" name="delivery_date" type="text" readonly value="{{ old('delivery_date') }}">
                </div>
                <div class="form-group col-md-2 {{ $errors->has('view') ? 'has-error' : '' }}">
                    {!! Form::label(trans('admin.view')) !!}
                    <select class="form-control select2" data-placeholder="{{ trans('admin.view') }}" name="view">
                        <option></option>
                        <option value="main_street" @if(old('view')=='main_street') selected @endif>{{ trans('admin.main_street') }}</option>
                        <option value="bystreet" @if(old('view')=='bystreet') selected @endif>{{ trans('admin.bystreet') }}</option>
                        <option value="garden" @if(old('view')=='garden') selected @endif>{{ trans('admin.garden') }}</option>
                        <option value="corner" @if(old('view')=='corner') selected @endif>{{ trans('admin.corner') }}</option>
                        <option value="sea_or_river" @if(old('view')=='sea_or_river') selected @endif>{{ trans('admin.sea_or_river') }}</option>
                    </select>
                </div>
                <div class="form-group col-md-2 {{ $errors->has('finishing') ? 'has-error' : '' }}">
                    {!! Form::label(trans('admin.finishing')) !!}
                    <select class="form-control select2" data-placeholder="{{ trans('finishing') }}" name="finishing">
                        <option></option>
                        <option value="finished" @if(old('finishing')=='finished') selected @endif>{{ trans('admin.finished') }}</option>
                        <option value="semi_finished" @if(old('finishing')=='semi_finished') selected @endif>{{ trans('admin.semi_finished') }}</option>
                        <option value="not_finished" @if(old('finishing')=='not_finished') selected @endif>{{ trans('admin.not_finished') }}</option>
                    </select>
                </div>

                <div class="form-group col-md-2 {{ $errors->has('rent') ? 'has-error' : '' }}">
                    {!! Form::label(trans('admin.rent')) !!}
                    <input class="form-control" name="rent" type="number" min="0" value="{{ old('rent') }}">
                </div>
                <div class="form-group col-md-4">
                    {!! Form::label(trans('admin.image')) !!}
                    <input type="file" class="form-control" name="image" accept="image/jpeg, image/png, image/jpg">
                </div>
                <div class="form-group col-md-3">
                    {!! Form::label(trans('admin.other_images')) !!}
                    <input type="file" multiple class="form-control" name="images[]">
                </div>
                <div class="form-group col-md-3  {{ $errors->has('project_id') ? 'has-error' : '' }}">
                    {!! Form::label(trans('admin.project')) !!}
                    <select class="select2 form-control" name="project_id" data-placeholder="{{ __('admin.project') }}">
                        <option></option>
                        @foreach(\App\Project::all() as $project)
                            <option value="{{ $project->id }}"
                                    @if($project->id == old('project_id')) selected @endif> {{ $project->{app()->getLocale().'_name'} }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-3 {{ $errors->has('meta_keywords') ? 'has-error' : '' }}">
                    {!! Form::label(trans('admin.meta_keywords')) !!}
                    <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords') }}" data-role="tagsinput" style="width: 100%">
                </div>
                <div class="form-group col-md-3 {{ $errors->has('meta_description') ? 'has-error' : '' }}">
                    {!! Form::label(trans('admin.meta_description')) !!}
                    <textarea class="form-control" name="meta_description" value="{{ old('meta_description') }}" rows="1"></textarea>
                </div>
                @php($arr=[])
                @if(@count(old('facility'))>0)
                    @php($arr=old('facility'));
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
                                    <option value="{{ $location->id }}"
                                            @if($location->id == old('location')) selected @endif
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

                        <div class="form-group {{ $errors->has('en_address') ? 'has-error' : '' }}">
                            {!! Form::label(trans('admin.address_en')) !!}
                            <input id="address_en" class="form-control" type="text" name="en_address" value="{{ old('en_address') }}">
                        </div>
                        <div class="form-group {{ $errors->has('en_address') ? 'has-error' : '' }}">
                            {!! Form::label(trans('admin.address_ar')) !!}
                            <input id="address" class="form-control" type="text" name="ar_address" value="{{ old('ar_address') }}">
                        </div>

                    </div>
                    <div class="col-md-8">

                        <div id="map"></div>

                    </div>
                </div>


                <input id="lat" name="lat" type="hidden"
                       value="@if(old('lat')){{ old('lat') }} @else 30.0595581 @endif">
                <input id="lng" name="lng" type="hidden"
                       value="@if(old('lng')){{ old('lng') }} @else 31.2233591 @endif">
                <input id="zoom" name="zoom" type="hidden"
                       value="@if(old('zoom')){{ old('zoom') }} @else 7 @endif">

                <button type="submit"
                        class="btn btn-primary btn-flat col-md-1 pull-right">{{ trans('admin.submit') }}</button>

            </div>
        </div>
    </form>