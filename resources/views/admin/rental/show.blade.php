@extends('admin.index')

@section('content')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $title }}</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="col-md-6">
                <strong>{{ trans('admin.ar_title') }} : </strong>{{ $unit->ar_title }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.ar_description') }} : </strong>{{ $unit->ar_description }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.en_title') }} : </strong>{{ $unit->en_title }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.en_description') }} : </strong>{{ $unit->en_description }}
                <br>
                <hr>
            </div>
            <div class="col-md-2">
                <strong>{{ trans('admin.type') }} : </strong>{{ __('admin.'.$unit->type) }}
                <br>
                <hr>
            </div>
            <div class="col-md-2">
                <strong>{{ trans('admin.unit_type') }}
                    : </strong>{{ @App\UnitType::find($unit->unit_type_id)->{App::getLocale().'_name'} }}
                <br>
                <hr>
            </div>
            @php($agent = @\App\User::find(@\App\Lead::find($unit->lead_id)->agent_id)) 
            @if( $agent != null)
                <div class="col-md-6">
                    <strong>{{ trans('admin.agent') }}
                        : </strong><a href="{{ url(adminPath().'/agent/'.@$agent->id) }}">{{ @$agent->name }}</a>
                    <br>
                    <hr>
                </div>
                @if($agent->id == auth()->user()->id || auth()->user()->type == 'admin')
                <div class="col-md-2">
                    <strong>{{ trans('admin.lead') }}
                        : </strong>{{ @App\Lead::find($unit->Lead_id)->first_name }} {{ @App\Lead::find($unit->lead_id)->last_name }}
                    <br>
                    <hr>
                </div>
                <div class="col-md-6">
                    <strong>Land Area
                        : </strong>{{ $unit->area }}
                    <br>
                    <hr>
                </div>
                <div class="col-md-6">
                    <strong>{{ trans('admin.other_phones') }}
                        : </strong>
                    @if($unit->other_phones != '')
                        @php($phones = json_decode($unit->other_phones))
                        @foreach($phones as $phone)
                            @if(!$loop->last)
                                {{ $phone }} -
                            @else
                                {{ $phone }}
                            @endif
                        @endforeach
                    @endif
                    <br>
                    <hr>
                </div>
                @endif
            @endif
            <div class="col-md-2">
                <strong>{{ trans('admin.phone') }} : </strong>{{ $unit->phone}}
                <br>
                <hr>
            </div>
            
            <div class="col-md-6">
                <strong>Unit Number
                    : </strong>{{ $unit->location_number }}
                <br>
                <hr>
            </div>

            <div class="col-md-6">
                <strong>Buldin area
                    : </strong>{{ $unit->bua }}
                <br>
                <hr>
            </div>
            <div class="col-md-2">
                <strong>{{ trans('admin.area') }} : </strong>{{ $unit->area}}
                <br>
                <hr>
            </div>
            <div class="col-md-2">
                <strong>{{ trans('admin.rooms') }} : </strong>{{ $unit->rooms}}
                <br>
                <hr>
            </div>
            <div class="col-md-2">
                <strong>{{ trans('admin.floor') }} : </strong>{{ $unit->floor}}
                <br>
                <hr>
            </div>
            <div class="col-md-2">
                <strong>{{ trans('admin.bathrooms') }} : </strong>{{ $unit->bathrooms}}
                <br>
                <hr>
            </div>
            <div class="col-md-2">
                <strong>{{ trans('admin.delivery_date') }} : </strong>{{ $unit->bathrooms}}
                <br>
                <hr>
            </div>
            <div class="col-md-2">
                <strong>{{ trans('admin.view') }} : </strong>{{ __('admin.'.$unit->view) }}
                <br>
                <hr>
            </div>
            <div class="col-md-2">
                <strong>{{ trans('admin.finishing') }} : </strong>{{ __('admin.'.$unit->finishing) }}
                <br>
                <hr>
            </div>
            <div class="col-md-2">
                <strong>{{ trans('admin.rent') }} : </strong>{{ $unit->rent}}
                <br>
                <hr>
            </div>
            <div class="col-md-2">
                <strong>{{ trans('admin.image') }} : </strong>

                <img src="{{ url('/'.$unit->image)}}" width="100px" data-toggle="modal" data-target="#exampleModal">
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Show Image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <img class="img-responsive" src="{{ url('/'.$unit->image) }}">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                      </div>
                    </div>
                  </div>
                </div>
                <br>
                <hr>
            </div>
            <div class="col-md-2">
                <strong style="display: block">{{ trans('admin.images') }} : </strong>
                @php($images = \App\RentalImage::where('unit_id',$unit->id)->get())
                @foreach($images as $image)
                <a href="{{ url('/'.$image->image) }}" data-toggle="lightbox" data-gallery="example-gallery">
                    <img height="25px" src="{{ url('/'.$image->image) }}" data-toggle="lightbox" data-gallery="example-gallery"> {{-- $image->id) --}}
                </a>
                @endforeach
                <br>
                <hr>
            </div>
            <div class="col-md-2">
                <strong>{{ trans('admin.project') }}
                    : </strong>{{@App\Project::find($unit->project_id)->{App::getLocale().'_name'} }}
                <br>
                <hr>
            </div>
            <div class="col-md-2">
                <strong>{{ trans('admin.location') }}
                    : </strong>{{ @App\Location::find($unit->location)->{App::getLocale().'_name'} }}
                <br>
                <hr>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <strong>{{ trans('admin.address_ar') }} : </strong>{{ $unit->ar_address }}
                    <br>
                    <hr>
                </div>
                <div class="col-md-6">
                    <strong>{{ trans('admin.address_en') }} : </strong>{{ $unit->en_address }}
                    <br>
                    <hr>
                </div>
                <div class="col-md-12">
                    <div class="facebook"><span>push to facebook</span></div>
                    <div class="olx"><span>push to OLX</span></div>
                    <div class="aqarmap"><span>push to Aqar Map</span></div>
                    <div class="propertyfinder"><span>push to Property Finder</span></div>


                    <br>
                    <hr>
                </div>
                <div class="col-md-12">
                    <div id="map" style="height: 450px; z-index: 999"></div>
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
    <script>
        $('#datepicker').datepicker({
            autoclose: true,
            format: " yyyy",
            viewMode: "years",
            minViewMode: "years",
        });
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
    <script>
        function initAutocomplete() {
            var lat = parseFloat({{ $unit->lat }});
            var lng = parseFloat({{ $unit->lng }});
            var zoom = parseInt({{ $unit->zoom }});
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: lat, lng: lng},
                zoom: zoom,
                mapTypeId: 'roadmap'
            });

            var marker = new google.maps.Marker({
                position: {lat: lat, lng: lng},
                map: map,
                animation: google.maps.Animation.DROP
            });

        }

        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJ67H5QBLVTdO2pnmEmC2THDx95rWyC1g&libraries=places&callback=initAutocomplete"
            async defer></script>
@endsection