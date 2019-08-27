@extends("website.index")
@section("content")
<style>
    .req-page{
        margin-top:5vw;
        margin-bottom:5vw;
    }
</style>
<div class="req-page">
    <div class="container">
    @include('website.error')
        <form action="{{ url('requiest_resale') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <!-- begin personal info -->
            <div class="personal-info">
                <h3> {{ @trans('admin.p_info') }} </h3>
                <hr>
                <div class="form-group @if($errors->has('gender')) has-error @endif">
                    <label for="gender"> {{ @trans('admin.gender') }} :</label>
                    <select name="gender" id="gender" class="form-control">
                        <option value="mr">Mr.</option>
                        <option value="mr">Mrs.</option>
                        <option value="ms">Ms.</option>
                    </select>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-12 @if($errors->has('f_name')) has-error @endif">
                    <label for="f_name"> {{ @trans('admin.first_name') }} :</label>
                    <input id="f_name" type="text" name="f_name" class="form-control" value="{{ old('f_name') }}" placeholder="First name" >
                    @if ($errors->has('f_name'))
                        <small class="helperror">{{ $errors->first('f_name') }} </small>
                    @endif                                    
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-12 @if($errors->has('l_name')) has-error @endif">
                    <label for="l_name"> {{ @trans('admin.last_name') }} :</label>
                    <input id="l_name" type="text" name="l_name" class="form-control" value="{{ old('l_name') }}" placeholder="Last name" >
                    @if ($errors->has('l_name'))
                        <small class="helperror">{{ $errors->first('l_name') }} </small>
                    @endif                                    
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-12 @if($errors->has('email')) has-error @endif">
                    <label for="email"> {{ @trans('admin.email') }} :</label>
                    <input id="email" type="text" name="email" placeholder="Example@example.com" value="{{ old('email') }}" class="form-control" >
                    @if ($errors->has('email'))
                        <small class="helperror">{{ $errors->first('email') }} </small>
                    @endif                                    
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-12 @if($errors->has('phone')) has-error @endif">
                    <label for="phone"> {{ @trans('admin.phone') }} :</label>
                    <input id="phone" type="number" name="phone" placeholder="Phone number" value="{{ old('phone') }}" class="form-control" >
                    @if ($errors->has('phone'))
                        <small class="helperror">{{ $errors->first('phone') }} </small>
                    @endif                                    
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-12 @if($errors->has('password')) has-error @endif">
                    <label for="password"> {{ @trans('admin.password') }} :</label>
                    <input id="password" type="password" name="password" class="form-control" >
                    @if ($errors->has('password'))
                        <small class="helperror">{{ $errors->first('password') }} </small>
                    @endif                                    
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-12 @if($errors->has('password')) has-error @endif">
                    <label for="confirmPassword"> {{ @trans('admin.confirmPassword') }} :</label>
                    <input id="confirmPassword" type="password" name="password_confirmation" class="form-control" >
                    @if ($errors->has('password'))
                        <small class="helperror">{{ $errors->first('password') }} </small>
                    @endif                                    
                </div>
            </div>
            <!-- end info of personal -->
            <br><br>
            <!-- begin resale information -->
                <div class="resale-info">
                    <h3> {{ @trans('admin.resale_info') }} </h3>
                    <hr>
                    <!-- names and comments -->
                    <div class="form-group col-md-6 col-sm-6 col-xs-12 @if($errors->has('unitName_ar')) has-error @endif">
                        <label for="AR-unit"> {{ @trans('admin.ar_name') }} :</label>
                        <input id="AR-unit" type="text" name="unitName_ar" class="form-control" value="{{ old('unitName_ar') }}" placeholder="unit arabic name" >
                        @if ($errors->has('unitName_ar'))
                            <small class="helperror">{{ $errors->first('unitName_ar') }} </small>
                        @endif
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12 @if($errors->has('unitName_en')) has-error @endif">
                        <label for="en-unit"> {{ @trans('admin.unitName_en') }} :</label>
                        <input id="en-unit" type="text" name="unitName_en" class="form-control" value="{{ old('unitName_en') }}" placeholder="unit english name" >
                        @if ($errors->has('unitName_en'))
                            <small class="helperror">{{ $errors->first('unitName_en') }} </small>
                        @endif
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12 @if($errors->has('unit_ar_description')) has-error @endif">
                        <label for="Description">{{ @trans('admin.description') }}</label>
                        <textarea name="unit_ar_description" class="form-control" id="Description" value="{{ old('unit_ar_description') }}" placeholder="Arabic description of unit " rows="6"></textarea>
                        @if ($errors->has('description'))
                            <small class="helperror">{{ $errors->first('description') }} </small>
                        @endif
                    </div>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12 @if($errors->has('unit_en_description')) has-error @endif">
                        <label for="Description">{{ @trans('admin.description') }}</label>
                        <textarea name="unit_en_description" class="form-control" id="Description" placeholder="English description of unit " rows="6">{{ old('unit_en_description') }}</textarea>
                        @if ($errors->has('unit_en_description'))
                            <small class="helperror">{{ $errors->first('unit_en_description') }} </small>
                        @endif
                    </div>
                    <!-- end propertis detalis -->
                </div>
            <!-- end resale information -->
            <!-- begin resale images -->
                <div class="res_img">
                    <h3 class="margin40 bottom15">{{ @trans('admin.unti_photos') }}</h3>
                    <div class="file_uploader bottom20 col-sm-12 text-center padding">
                        <div class="box col-sm-6 col-md-6 col-xs-12 @if($errors->has('image')) has-error @endif">
                            <label class="col-sm-12" style="margin: 0 30px">{{ __('admin.main_image') }}</label>
                            <input type="file" name="image" style="display: none;" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple />
                            <label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose a file&hellip;</span></label>
                        </div>
                        <div class="box col-sm-6 col-md-6 col-xs-12">
                            <label class="col-sm-12" style="margin: 0 30px">{{ __('admin.other_images') }}</label>
                            <input type="file" name="other_images" style="display: none;" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple />
                            <label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose a file&hellip;</span></label>
                        </div>

                    </div>
                </div>
            <!-- end resale images -->
            <!-- end names and comments -->
                <h3> {{ @trans('admin.resale_details') }} </h3>
                <hr>
            <!-- begin propertis detalis -->
                <div class="form-group col-md-12 col-sm12 col-xs-12 @if($errors->has('price')) has-error @endif">
                    <label for="price"> {{ @trans('admin.price') }} </label>
                    <input type="number" id="price" class="form-control" placeholder="Price" name="price">
                    @if ($errors->has('price'))
                        <small class="helperror">{{ $errors->first('price') }} </small>
                    @endif
                </div>
                <div class="form-group col-md-4 col-sm-4 col-xs-12 @if($errors->has('unit_type')) has-error @endif">
                    <label for="type"> {{ @trans('admin.type') }} </label>
                    <select name="unit_type" id="" class="select2 form-control">
                        <option value=""></option>
                        <option value="resale"> For sale </option>
                        <option value="rental"> For rent </option>
                    </select>
                    @if ($errors->has('unit_type'))
                        <small class="helperror">{{ $errors->first('unit_type') }} </small>
                    @endif
                </div>

                <div class="form-group col-md-4 col-sm-4 col-xs-12 @if($errors->has('type_id')) has-error @endif">
                    <label for="type"> {{ @trans('admin.type') }} </label>
                    <select name="type_id" id="" class="select2 form-control">
                        <option value=""></option>
                        <option value="personal"> Residential </option>
                        <option value="commercial"> Commercial </option>
                    </select>
                    @if ($errors->has('type_id'))
                        <small class="helperror">{{ $errors->first('type_id') }} </small>
                    @endif
                </div>

                <div class="form-group col-md-4 col-sm-4 col-xs-12 @if($errors->has('unit_type_id')) has-error @endif">
                    <label for="type"> {{ @trans('admin.unit_type') }} </label>
                    <select name="unit_type_id" id="" class="select2 form-control">
                        <option value=""></option>
                        @foreach($units_type as $type)
                            @if(Session::get('Newlang') == 'ar')
                                <option value="{{ $type->id }}"> {{ ($type->ar_name) }} </option>
                            @else
                                <option value="{{ $type->id }}"> {{ ($type->en_name) }} </option>
                            @endif
                        @endforeach
                    </select>
                    @if ($errors->has('unit_type_id'))
                        <small class="helperror">{{ $errors->first('unit_type_id') }} </small>
                    @endif
                </div>
                <div class="form-group col-md-4 col-sm-4 col-xs-4 @if($errors->has('size')) has-error @endif">
                    <label for="size"> {{ @trans('admin.size') }} </label>
                    <input type="number" value="{{ old('size') }}" name="size" placeholder="{{ @trans('admin.size') }}" class='form-control'>
                    @if ($errors->has('size'))
                        <small class="helperror">{{ $errors->first('size') }} </small>
                    @endif
                </div>
                <div class="form-group col-md-4 col-sm-4 col-xs-4 @if($errors->has('room')) has-error @endif">
                    <label for="Rooms"> {{ @trans('admin.rooms') }} </label>
                    <input type="number" value="{{ old('room') }}" name="room" placeholder="{{ @trans('admin.rooms') }}" class='form-control'>
                    @if ($errors->has('room'))
                        <small class="helperror">{{ $errors->first('room') }} </small>
                    @endif
                </div>
                <div class="form-group col-md-4 col-sm-4 col-xs-4 @if($errors->has('bathroom')) has-error @endif">
                    <label for="Rooms"> {{ @trans('admin.bathroom') }} </label>
                    <input type="number" value="{{ old('bathroom') }}"  name="bathroom" placeholder="{{ @trans('admin.bathroom') }}" class='form-control'>
                    @if ($errors->has('bathroom'))
                        <small class="helperror">{{ $errors->first('bathroom') }} </small>
                    @endif
                </div>

                <div class="form-group col-md-4 col-sm-4 col-xs-4 @if($errors->has('finish')) has-error @endif">
                    <label for="Finishing"> {{ @trans('admin.finishing') }} </label>
                    <select name="finish" id="Finishing"  data-placeholder="{{ trans('admin.finish') }}" class="select2 form-control">
                        <option></option>
                        <option value="finished" @if(old('finishing') == 'finished')selected @endif>{{ trans('admin.finished') }}</option>
                        <option value="semi_finished" @if(old('finishing') == 'semi_finished')selected @endif>{{ trans('admin.semi_finished') }}</option>
                        <option value="not_finished" @if(old('finishing') == 'not_finished')selected @endif>{{ trans('admin.not_finished') }}</option>
                    </select>
                    @if ($errors->has('finish'))
                        <small class="helperror">{{ $errors->first('finish') }} </small>
                    @endif
                </div>
                <div class="form-group col-md-4 col-sm-4 col-xs-4 @if($errors->has('view')) has-error @endif">
                    <label for=""> {{ @trans('admin.view') }} </label>
                    <select class="select2 form-control" name="view" data-placeholder="{{ trans('admin.view') }}">
                        <option></option>
                        <option value="main_street" @if(old('view') == 'main_street')selected @endif>{{ trans('admin.main_street') }}</option>
                        <option value="bystreet" @if(old('view') == 'bystreet')selected @endif>{{ trans('admin.bystreet') }}</option>
                        <option value="garden" @if(old('view') == 'garden')selected @endif>{{ trans('admin.garden') }}</option>
                        <option value="corner" @if(old('view') == 'corner')selected @endif>{{ trans('admin.corner') }}</option>
                        <option value="sea_or_river" @if(old('view') == 'sea_or_river')selected @endif>{{ trans('admin.sea_or_river') }}</option>
                    </select>
                    @if ($errors->has('view'))
                        <small class="helperror">{{ $errors->first('view') }} </small>
                    @endif
                </div>
                <div class="form-group col-md-4 col-sm-4 col-xs-4 @if($errors->has('project_id')) has-error @endif">
                    <label for="Rooms"> {{ @trans('admin.projects') }} </label>
                    <select class="select2 form-control" name="project_id" data-placeholder="{{ trans('admin.project') }}">
                        <option></option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" @if($project->id == request()->project) selected @endif>{{ $project->{app()->getLocale().'_name'} }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('project_id'))
                        <small class="helperror">{{ $errors->first('project_id') }} </small>
                    @endif
                </div>
            <!-- end propertis detalis -->
            <!-- video pro -->
            <h3> {{ @trans('admin.video') }} </h3>
            <hr>
            <div class="form-group col-md-12">
                <label for="video"> {{ @trans('admin.video') }} </label>
                <input type="text" name="video" class="form-control" value="{{ old('video') }}" placeholder="https://vimeo.com">
            </div>
            <!-- end video pro -->
            <!-- map -->
            <div class="col-sm-12">
                                <h3 class="bottom15 margin40">Place on Map</h3>
                                <div class="single-query form-group bottom15">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
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
                                                @if ($errors->has('location'))
                                                    <small class="helperror">{{ $errors->first('location') }} </small>
                                                @endif
                                            </div>

                                            <div class="form-group @if($errors->has('en_address')) has-error @endif">
                                                <label>{{ trans('admin.en_address') }}</label>
                                                {!! Form::text('en_address',request()->en_address,['class' => 'form-control', 'placeholder' => trans('admin.en_address'),'id'=>'address']) !!}
                                            </div>
                                            @if ($errors->has('en_address'))
                                                <small class="helperror">{{ $errors->first('en_address') }} </small>
                                            @endif
                                            <div class="form-group @if($errors->has('ar_address')) has-error @endif">
                                                <label>{{ trans('admin.ar_address') }}</label>
                                                {!! Form::text('ar_address',request()->ar_address,['class' => 'form-control', 'placeholder' => trans('admin.ar_address')]) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div id="map" style="height: 300px !important; x-index: 999"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="map" style="height: 300px !important;z-index:20"></div>
                            <div class="col-md-12 pull-right">
                                <button type="submit" class="btn-blue hub-btn border_radius margin40">submit property</button>
                            </div>
                        </div>
                        <input id="lat" name="lat" type="hidden"
                               value="@if(request()->has('lat')){{ request()->lat }} @else 30.0595581 @endif">
                        <input id="lng" name="lng" type="hidden"
                               value="@if(request()->has('lng')){{ request()->lng }} @else 31.2233591 @endif">
                        <input id="zoom" name="zoom" type="hidden"
                               value="@if(request()->has('zoom')){{ request()->lng }} @else 7 @endif">
                        <input value="0" name="total" type="hidden">
                        <input value="cash" name="payment_method" type="hidden">
                        <input value="0" name="due_now" type="hidden">
                        <input value="0" name="featured" type="hidden">

            <!-- end map -->
        </form>
    </div>
</div>

@endsection
@section('js')
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJ67H5QBLVTdO2pnmEmC2THDx95rWyC1g&libraries=places&callback=initAutocomplete"
            async defer></script>
    <script>
        $(document).on('change','#prop_type',function () {
            if($(this).val() == 'sale'){
                $('#sale').removeClass('hidden');
                $('#rent').addClass('hidden');
            } else if($(this).val() == 'rent'){
                $('#rent').removeClass('hidden');
                $('#sale').addClass('hidden');
            }
        });
        $(document).on('change', '#type', function () {
            var usage = $(this).val();
            var _token = '{{ csrf_token() }}';
            $.ajax({
                url: "{{ url('get_unit_types')}}",
                method: 'post',

                data: {usage: usage, _token: _token},
                success: function (data) {
                    $('#unit_type').html(data);
                }
            });
        });
    </script>
@endsection