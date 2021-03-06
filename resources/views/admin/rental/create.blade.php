@extends('admin.index')

@section('content')
    <link rel="stylesheet" type="text/css" href="https://rawgit.com/lykmapipo/themify-icons/master/css/themify-icons.css">
        <link rel="stylesheet" type="text/css" href="https://rawgit.com/cristijora/vue-form-wizard/master/dist/vue-form-wizard.min.css">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">



        <div class="box">
        <div class="box-body">
            <div id="app">
                <div>
                    <form action="{{ url(adminPath().'/rental_units') }}" method="post" enctype="multipart/form-data" id="rental-form">
                        {{ csrf_field() }}
                    <form-wizard @on-complete="onComplete(model)"
                                 color="gray"
                                 error-color="#a94442"
                                 >
                        <tab-content title="Description & Privacy"
                                      icon="" >
                           <div class="form-group  {{ $errors->has("privacy") ? 'has-error' : '' }} col-md-12">
                                {!! Form::label(trans("admin.privacy")) !!}
                                @{{ privacy }}
                                <br>
                                <select class="select2 form-control" style="width: 100%" name="privacy"
                                        data-placeholder="{{ trans("admin.privacy") }}" id="Privacy" v-model="privacy">
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
                                        data-placeholder="{{ trans("admin.agent") }}" v-model="agent_id">
                                    <option></option>
                                </select>
                            </div> -->
                            <div class="form-group col-md-6 {{ $errors->has('ar_title') ? 'has-error' : '' }}">
                                {!! Form::label(trans('admin.ar_title')) !!}
                                @{{ ar_title }}
                                <input class="form-control" name="ar_title" value="{{ old('ar_title') }}" v-model="ar_title">
                            </div>
                            <div class="form-group col-md-6 {{ $errors->has('en_title') ? 'has-error' : '' }}">
                                {!! Form::label(trans('admin.en_title')) !!}
                                <input class="form-control" name="en_title" value="{{ old('en_title') }}" v-model="en_title">
                            </div>
                            <div class="form-group col-md-6 {{ $errors->has('ar_description') ? 'has-error' : '' }}">
                                {!! Form::label(trans('admin.ar_description')) !!}
                                <textarea class="form-control" name="ar_description" v-model="ar_description">{{ old('ar_description') }}</textarea>
                            </div>
                            <div class="form-group col-md-6 {{ $errors->has('en_description') ? 'has-error' : '' }}">
                                {!! Form::label(trans('admin.en_description')) !!}
                                <textarea class="form-control" name="en_description" v-model="en_description">{{ old('en_description') }}</textarea>
                            </div>
                            <div class="form-group @if($errors->has('ar_notes')) has-error @endif col-md-6">
                                <label>{{ trans('admin.ar_notes') }}</label>
                                {!! Form::textarea('ar_notes','',['class' => 'form-control', 'placeholder' => trans('admin.ar_notes'),'rows'=>5]) !!}
                            </div>

                            <div class="form-group @if($errors->has('en_notes')) has-error @endif col-md-6">
                                <label>{{ trans('admin.en_notes') }}</label>
                                {!! Form::textarea('en_notes','',['class' => 'form-control', 'placeholder' => trans('admin.en_notes'),'rows'=>5]) !!}
                            </div>

                            <div class="box-body">
                                {{-- <div class="form-group col-md-6">
                                    {!! Form::label(trans('admin.lead')) !!}
                                    <select class="form-control select2" data-placeholder="{{ trans('admin.lead') }}" name="lead_id" >
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
                                
                                <div class="form-group col-md-6">
                                    {!! Form::label(trans('admin.phone')) !!}
                                    <div class="input-group">

                                        <input type="phone" class="form-control" name="phone" value="{{ old('phone') }}" >
                                        <span style="cursor: pointer" class="input-group-addon" id="addPhone"><i class="fa fa-plus"></i></span>
                                    </div>
                                </div>
                                <div class="col-,d-12"><span id="otherPhones"></span></div>
                            </div>
                        </tab-content>
                        <tab-content title="Unit"
                                     icon="" >
                        <div class="body-box">
                            <div class="form-group col-md-2">
                                {!! Form::label(trans('admin.usage')) !!}<br>
                                <select class="form-control select2" style="width:100%" data-placeholder="{{ trans('admin.type') }}" id="type"
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
                                <select class="form-control select2" style="width:100%" id="unit_type" name="type_id">
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
                                <select class="form-control select2" style="width:100%" data-placeholder="{{ trans('admin.view') }}" name="view">
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
                                <select class="form-control select2" style="width:100%" data-placeholder="{{ trans('finishing') }}" name="finishing">
                                    <option></option>
                                    <option value="finished" @if(old('finishing')=='finished') selected @endif>{{ trans('admin.finished') }}</option>
                                    <option value="semi_finished" @if(old('finishing')=='semi_finished') selected @endif>{{ trans('admin.semi_finished') }}</option>
                                    <option value="not_finished" @if(old('finishing')=='not_finished') selected @endif>{{ trans('admin.not_finished') }}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                {!! Form::label(trans('admin.image')) !!}
                                <input type="file" class="form-control" name="image" accept="image/jpeg, image/png, image/jpg" v-model="image">
                            </div>
                            <div class="form-group col-md-3">
                                {!! Form::label(trans('admin.other_images')) !!}
                                <input type="file" multiple class="form-control" name="images[]">
                            </div>
                            <div class="form-group col-md-3  {{ $errors->has('project_id') ? 'has-error' : '' }}">
                                {!! Form::label(trans('admin.project')) !!}
                                <select class="select2 form-control" style="width:100%" name="project_id" data-placeholder="{{ __('admin.project') }}">
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
                            <div class="form-group  {{ $errors->has("facility") ? 'has-error' : '' }} col-md-12">
                                {!! Form::label(trans("admin.facility")) !!}
                                @{{ facility }}
                                <br>
                                <select class="select2 form-control" style="width: 100%" multiple name="facility[]"
                                        data-placeholder="{{ trans("admin.facilities") }}" v-model="facility">
                                    <option></option>
                                    @foreach(App\Facility::get() as $facilty)
                                        <option value="{{ $facilty->id }}" @if(in_array($facilty->id,$arr)) selected @endif>{{ $facilty->en_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        </tab-content>
                        <tab-content title="Location"
                                     icon="" >
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group @if($errors->has('location')) has-error @endif">
                                        <label>{{ trans('admin.location') }}</label>
                                        <select class="select2 form-control" name="location" id="location" style="width:100%"
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
                                        <select class="select2 form-control" name="country_id" id="country_id" style="width:100%"
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
                        </tab-content>

                        <tab-content title="Payment"
                                     icon="" >
                         <div class="form-group col-md-12 {{ $errors->has('rent') ? 'has-error' : '' }}">
                                {!! Form::label(trans('admin.rent')) !!}
                                <input class="form-control" name="rent" type="number" min="0" value="{{ old('rent') }}">
                            </div>
                        </tab-content>
                    </form-wizard>
                </form>
                </div>
            </div>
        </div>
    </div>

    
    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 300px;
        }

        /* Optional: Makes the sample page fill the window. */

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
@endsection
@section('js')

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
    <script src="https://unpkg.com/vue-multiselect@2.0.0-beta.13/lib/vue-multiselect.min.js"></script>
    <script src="https://rawgit.com/cristijora/vue-form-wizard/master/dist/vue-form-wizard.js"></script>
    <script src="https://rawgit.com/icebob/vue-form-generator/master/dist/vfg.js"></script>


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
       privacy: '',
       agent_id:'',
       ar_title:'',
       en_title:'',
       ar_description:'',
       en_description:'',
       en_description:'',
       facility:[],
       image:'',
  }
},
 methods: {
  onComplete: function(json){
      // alert('Yay. Done!');
      // adminPath().'/resale_units'
        $( "#rental-form" ).submit();

      /*console.log(json);
      console.log(window.location.origin + ' / {{adminPath()."/resale_units"}}');

      axios({
        method: 'post',
        url: window.location.origin + '{{ "/" . adminPath()."/resale_units"}}',
        data: json,
        config: { headers: {'Content-Type': 'multipart/form-data' }}
        })
        .then(function (response) {
            //handle success
            // adminPath() . '/resale_units/' . $unit->id
            console.log(window.location.origin + '{{ "/" . adminPath()."/resale_units"}}' + response.data.unitId);
            window.location.href = '{{url(adminPath()."/resale_units")."/"}}' + response.data.unitId;
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
        var i = 1;
        $(document).on('click', '#addPhone', function () {
            $('#otherPhones').append('<div class="form-group col-md-4" id="otherPhone' + i + '">' +
                '<label>{{ trans("admin.other_phones") }}</label>' +
                '<div class="input-group">' +
                '{!! Form::text("other_phones[]","",["class" => "form-control", "placeholder" => trans("admin.other_phones")]) !!}' +
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

            // Create the search box and link it to the UI element.

            var input2 = document.getElementById('address_en');
            var searchBox = new google.maps.places.SearchBox(input2);
//            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            // Bias the SearchBox results towards current map's viewport.
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
                    $('#lang').val(place.geometry.location.lng());

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
        }

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
