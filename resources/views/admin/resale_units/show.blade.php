@extends('admin.index')

@section('content')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $title }}</h3>

            <div class="box-tools pull-right">
                <a href="{{ url(adminPath().'/proposals/create?unit='.$unit->id.'&type=resale') }}" class="btn btn-primary btn-flat">{{ trans('admin.add_proposal') }}</a>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="box-body">
            <div class="col-md-6">
                <strong>{{ trans('admin.type') }} : </strong>{{ trans('admin.'.$unit->type) }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.unit_type') }}
                    : </strong>{{ @\App\UnitType::find($unit->unit_type_id)->{app()->getLocale().'_name'} }}
                <br>
                <hr>
            </div>
            @if($unit->project_id)
                <div class="col-md-6">
                    <strong>{{ trans('admin.project') }}
                        : </strong>{{ @\App\Project::find($unit->project_id)->{app()->getLocale().'_name'} }}
                    <br>
                    <hr>
                </div>
            @endif
            {{-- {{dd(@\App\User::find(@\App\Lead::find($unit->lead_id)->commercial_agent_id))}} --}}
            @if(@\App\Lead::find($unit->lead_id)->agent_id==0)
                @php($agent = @\App\User::find(@\App\Lead::find($unit->lead_id)->commercial_agent_id))
            @else
                @php($agent = @\App\User::find(@\App\Lead::find($unit->lead_id)->agent_id))
            @endif
            {{-- @php($agent = @\App\User::find(@\App\Lead::find($unit->lead_id)->agent_id)) --}}

            @if(@$agent->id == auth()->user()->id || auth()->user()->type == 'admin')
            <div class="col-md-6">
                <strong>{{ trans('admin.lead') }}
                    : </strong><a href="{{ url(adminPath().'/leads/'.@$unit->lead_id) }}">{{ @\App\Lead::find($unit->lead_id)->first_name . ' ' . @\App\Lead::find($unit->lead_id)->last_name }}</a>
                <br>
                <hr>
            </div>
            @endif
            <div class="col-md-6">
                <strong>{{ trans('admin.agent') }}
                    {{-- {{dd($agent)}} --}}
                    : </strong><a href="{{ url(adminPath().'/agent/'.@$agent->id) }}">{{ @$agent->name }}</a>
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.original_price') }} : </strong>{{ @$unit->original_price }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.payed') }} : </strong>{{ @$unit->payed }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.rest') }} : </strong>{{ $unit->rest }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.over') }} : </strong>{{ $unit->total }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.delivery_date') }} : </strong>{{ $unit->delivery_date }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.due_now') }} : </strong>{{ $unit->due_now }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.finishing') }} : </strong>{{ trans('admin.'.$unit->finishing) }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.location') }}
                    : </strong>{{ @\App\Location::find($unit->location)->{app()->getLocale().'_name'} }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.ar_notes') }}
                    : </strong>{{ $unit->ar_notes }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.en_notes') }}
                    : </strong>{{ $unit->en_notes }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.ar_description') }}
                    : </strong>{{ $unit->ar_description }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.en_description') }}
                    : </strong>{{ $unit->en_description }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.ar_title') }}
                    : </strong>{{ $unit->ar_title }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.en_title') }}
                    : </strong>{{ $unit->en_title }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.ar_address') }}
                    : </strong>{{ $unit->ar_address }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.en_address') }}
                    : </strong>{{ $unit->en_address }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.youtube_link') }}
                    : </strong><a href="{{ $unit->youtube_link }}" class="fa fa-youtube" target="_blank"></a>
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.phone') }}
                    : </strong>{{ $unit->phone }}
                <br>
                <hr>
            </div>

            <div class="col-md-6">
                <strong>Buldin Area
                    : </strong>{{ $unit->bua }}
                <br>
                <hr>
            </div>

            @if(@$agent->id == auth()->user()->id || auth()->user()->type == 'admin')
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

            <div class="col-md-6">
                <strong>Land Area
                    : </strong>{{ $unit->area }}
                <br>
                <hr>
            </div>

            @if( @$agent->id == auth()->user()->id || auth()->user()->type == 'admin')
            <div class="col-md-6">
                <strong>Unit Number
                    : </strong>{{ $unit->location_number }}
                <br>
                <hr>
            </div>
            @endif
            <div class="col-md-6">
                <strong>{{ trans('admin.price') }}
                    : </strong>{{ $unit->price }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.rooms') }}
                    : </strong>{{ $unit->rooms }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.bathrooms') }}
                    : </strong>{{ $unit->bathrooms }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.floors') }}
                    : </strong>{{ $unit->floors }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.image') }}
                    : </strong>
                    <img height="50px" src="{{ url('/'.$unit->image) }}" data-toggle="modal" data-target="#exampleModal">
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
                            <img class="img-responsive" src="{{ url('/' . $unit->image) }}">
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
            <div class="col-md-6">
                <strong>{{ trans('admin.image') }}
                    : </strong>
                @php($images = \App\ResalImage::where('unit_id',$unit->id)->get())
                @foreach($images as $image)
                <a href="{{ url('/'.$image->image) }}" data-toggle="lightbox" data-gallery="example-gallery">
                    <img height="25px" src="{{ url('/'.$image->image) }}" data-toggle="lightbox" data-gallery="example-gallery"> {{-- $image->id) --}}
                </a>
                @endforeach
                <br>
                <hr>
            </div>

            <div class="col-md-6">
                <strong>{{ trans('admin.payment_method') }} : </strong>{{ trans('admin.'.$unit->payment_method) }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.view') }} : </strong>{{ trans('admin.'.$unit->view) }}
                <br>
                <hr>
            </div>
            <div class="col-md-6">
                <strong>{{ trans('admin.availability') }} : </strong>{{ trans('admin.'.$unit->availability) }}
                <br>
                <hr>
            </div>
            <div class="col-md-12">
                <div class="facebook" ><span>push to facebook</span></div>
                <div class="olx" ><span>push to OLX</span></div>
                <div class="aqarmap" ><span>push to Aqar Mao</span></div>
                <div class="propertyfinder" ><span>push to Property Finder</span></div>
                <br>
                <hr>
            </div>
            <div class="col-md-12">
                <div id="map" style="height: 450px; z-index: 999"></div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
    <script>
        function initAutocomplete() {
            var lat = parseFloat({{ $unit->lat }});
            var lng = parseFloat({{ $unit->lng }});
            var zoom = parseInt({{ $unit->zoom }});
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: lat, lng: lng },
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
