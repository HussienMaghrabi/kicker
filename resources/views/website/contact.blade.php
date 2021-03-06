@extends('website.index')
@section('content')

    <!--Contact-->
    <section id="contact-us">
        <div class="contact">

            <div class="map-holder">
                <div id="map"></div>

            </div>
            <div class="row">
                <div class="container">
                    <div class="row p-1">
                        <div class="col-md-6 col-xs-12">

                            <div class="agetn-contact-2 bottom30">
                                <p><i class="icon-telephone114"></i>
                                    @foreach(@App\HubPhone::all() as $phone)
                                        <a href="tel:{{ $phone->phone }}">{{ $phone->phone }}</a>
                                        @if(!$loop->last) 
                                        - 
                                        @endif 
                                    @endforeach
                                </p>
                             
                                    
                                <p><i class=" icon-icons142"></i> <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>

                                <p><i class="icon-browser2"></i>{{str_replace('http://',' ', url('/')) }}</p>
                                <p><i class="icon-icons74"></i> @if(app()->getLocale() == 'en'){{ $contact->address }} @else{{ $contact->ar_address }} @endif</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="agent-p-form">
                                <div class="our-agent-box bottom30">
                                    <h2>{{ __('admin.Send us a message') }}</h2>
                                </div>

                                <div class="row" id="thank-you">
                                    <form action="{{ url('send_massage') }}" method="get" class="callus">
                                        <div class="col-md-12">
                                            @if(auth('lead')->guest())
                                                <div class="single-query form-group">
                                                    <input type="text" placeholder="{{ __('admin.first_name') }}" name="first_name" class="col-md-6 keyword-input" required>
                                                    <input type="text" placeholder="{{ __('admin.last_name') }}" name="last_name" class="col-md-6 keyword-input" required>
                                                </div>
                                                <div class="single-query form-group">
                                                    <input type="text" placeholder="{{ __('admin.phone') }}" name="phone" class="keyword-input" required>
                                                </div>
                                                <div class="single-query form-group">
                                                    <input type="text" placeholder="{{ __('admin.email') }}" name="email" class="keyword-input" required>
                                                </div>
                                            @endif
                                            <div class="single-query form-group">
                                                <textarea placeholder="{{ __('admin.massage') }}" class="form-control" name="massage" required></textarea>
                                            </div>
                                            @if(!auth('lead')->guest())
                                                <input type="hidden" value="{{ auth('lead')->user()->id }}" name="user">
                                            @endif
                                            <input type="submit" value="{{ __('admin.submit now') }}" class=" hub-btn-website">
                                        </div>
                                    </form>


                                </div>

                            </div>
                            @if(Session::has('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success')}}
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact End -->

@endsection
@section('js')
    <script>
        function initAutocomplete() {

            var lat = parseFloat({{ $contact->lat }});
            var lng = parseFloat({{ $contact->lng }});
            var zoom = parseInt({{ $contact->zoom}});
            icon='{{ url('website_style/images/contact-icon.png') }}';
            var map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: lat , lng:lng },
                zoom: zoom,
                mapTypeId: 'roadmap'
            });

            // Create the search box and link it to the UI element.
            var marker = new google.maps.Marker({
                position: { lat: lat, lng: lng},
                map: map,
                icon:icon,
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJ67H5QBLVTdO2pnmEmC2THDx95rWyC1g&libraries=places&callback=initAutocomplete"
            async defer></script>
@endsection