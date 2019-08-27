@extends('website.index')
@section('content')
    <!-- Page Banner Start-->
    <style>
        .page-banner{
            background: url("{{ asset('website_style/images/7.jpg') }}")  no-repeat fixed !important;
        }
    </style>
    <section class="page-banner padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="text-uppercase">{{ __('admin.rental') }}</h1>

                </div>
            </div>
        </div>
    </section>
    <!-- Page Banner End -->



    <!-- Listing Start -->
    <section id="listing1" class="listing1 padding_top">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-9">
                            <h2 class="uppercase">{{ __('admin.property_listings') }}</h2>
                        </div>

                    </div>
                    <div class="row">
                        @foreach($rental as $property)
                            <div class="col-sm-6 not-filter">
                                <div class="property_item heading_space">
                                    <div class="image">
                                        @if(Session::get('Newlang') == 'ar')
                                            <a href="{{ url('ar/rental/'.slug($property->{app()->getLocale().'_title'}).'-'.$property->id) }}">
                                        @elseif(Session::get('Newlang') == 'en')
                                            <a href="{{ url('en/rental/'.slug($property->{app()->getLocale().'_title'}).'-'.$property->id) }}">
                                        @endif
                                            <img src="{{ url('uploads/'.$property->image) }}" alt="{{ $property->{app()->getLocale().'_name'} }}" class="img-responsive">
                                        </a>
                                        <div class="price clearfix">
                                            <span class="tag pull-right">{{ $property->price }} {{ __('admin.egp') }}</span>
                                        </div>
                                        <span class="tag_t">{{ __('admin.resale') }}</span>
                                    </div>
                                    <div class="proerty_content">
                                        <div class="proerty_text">
                                            <h3 class="captlize">
                                        @if(Session::get('Newlang') == 'ar')
                                            <a href="{{ url('ar/rental/'.slug($property->{app()->getLocale().'_title'}).'-'.$property->id) }}">{{ $property->{app()->getLocale().'_title'} }}
                                        @elseif(Session::get('Newlang') == 'en')
                                            <a href="{{ url('en/rental/'.slug($property->{app()->getLocale().'_title'}).'-'.$property->id) }}">{{ $property->{app()->getLocale().'_title'} }}
                                        @endif
                                                </a>
                                            </h3>
                                            <p>{{ @App\Location::find($property->location_id)->{app()->getLocale().'_title'} }}</p>
                                        </div>
                                        @if(!auth()->guard('lead')->guest())

                                            <div class="fav like-btn-box" type="rental"  unit_id="{{ $property->id }}" style="cursor: pointer"><span>
                                                    <i class="icon-like" id="fav{{ $property->id }}" style="@if(@App\Favorite::where('lead_id',@auth()->guard('lead')->user()->id)->where('unit_id',$property->id)->first()) color: #caa42d; @endif"></i></span></div>

                                        @endif
                                        <div class="property_meta transparent" >
                                            @foreach(@App\UnitFacility::where('unit_id',$property->id)->where('type','rental')->limit(3)->get() as $facility)
                                                @php($f = @\App\Facility::find($facility->facility_id))
                                                @php($icon = @\App\Icon::find($f->icon))
                                                <span class="col-xs-4" style="line-height: 3.5">
                                                <span class="col-sm-2" style="margin: 7px;">
                                                <img src="{{ url('uploads/'.$icon->icon) }}" style="width: 25px">
                                                    </span>
                                                <span class="text-left" style="padding-top: 10px;padding-left:1px;font-size: 11px">
                                                {{ $f->{app()->getLocale().'_name'} }}
                                                    </span>
                                            </span>
                                            @endforeach
                                        </div>


                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                    </div>

                    <div class="padding_bottom text-center">
                        <ul class="pager">
                            {{ $rental->links() }}
                        </ul>
                    </div>
                </div>
                @include("website.slidefilter")
            </div>
        </div>
    </section>
    <!-- Listing end -->
@endsection
@section('js')
    <script>
        $('.select2').select2();
        $(document).on('click change keyup', '#price_range , #area_range ,#location ,#keyword ,#rooms ,#bathrooms', function () {
            $('.not-filter').addClass('hidden');
            $('.pager').addClass('hidden');
            $('#min_price').val($('#mi_price').text());
            $('#max_price').val($('#ma_price').text());
            $('.to-filter').each(function () {
                if(parseInt($(this).attr('price')) >= parseInt($('#mi_price').text()) &&
                    parseInt($(this).attr('price')) <= parseInt($('#ma_price').text()) &&
                    parseInt($(this).attr('area')) >= parseInt($('#mi_area').text())  &&
                    parseInt($(this).attr('area')) <= parseInt($('#ma_area').text())
                ){
                    if (!isNaN(parseInt($('#location').val()))) {
                        if( parseInt($(this).attr('location')) == parseInt($('#location').val())) {
                            if($('#keyword').val()) {
                                if($(this).attr('en_name').toLowerCase().includes($('#keyword').val().toLowerCase())) {
                                    $(this).removeClass('hidden');
                                }else{
                                    $(this).addClass('hidden');
                                }
                            }else{
                                $(this).removeClass('hidden');
                            }

                        }
                        else{

                            $(this).addClass('hidden');
                        }
                    }
                    else{
                        if($('#keyword').val()) {
                            if($(this).attr('en_name').toLowerCase().includes($('#keyword').val().toLowerCase())) {
                                $(this).removeClass('hidden');
                            }else{
                                $(this).addClass('hidden');
                            }
                        }else {
                            $(this).removeClass('hidden');
                        }
                    }
                }
                else{
                    $(this).addClass('hidden');
                }
            });
        });
        $(document).on('click', '#area_range', function () {
            $('#min_area').val($('#mi_area').text());
            $('#max_area').val($('#mi_area').text());
        });
        $('#non_project').hide();
        $('#facility1').show();
        $(document).ready(function () {
            $('#price_range').nstSlider('set_range', parseInt("{{ $search['data']['rental_personal_min_price'] }}"), parseInt("{{ $search['data']['rental_personal_max_price'] }}"));
            $('#area_range').nstSlider('set_range', parseInt("{{ $search['data']['rental_personal_min_area'] }}"), parseInt("{{ $search['data']['rental_personal_max_area'] }}"));
            $('#price_range').nstSlider('set_position', parseInt("{{ $search['data']['rental_personal_min_price'] }}"), parseInt("{{ $search['data']['rental_personal_max_price'] }}"));
            $('#area_range').nstSlider('set_position', parseInt("{{ $search['data']['rental_personal_min_area'] }}"), parseInt("{{ $search['data']['rental_personal_max_area'] }}"));
            $('#price_lable').text("{{ trans('admin.price') }}");
            $('#min_price').val($('#mi_price').text());
            $('#max_price').val($('#ma_price').text());
            $('#min_area').val($('#mi_area').text());
            $('#max_area').val($('#ma_area').text());
        });
    </script>

    @if(!auth()->guard("lead")->guest())
        <script>
            $(document).on('click', '.fav', function () {
                var unit_id = $(this).attr('unit_id');
                var type = $(this).attr('type');
                var lead = '{{ auth()->guard("lead")->user()->id }}';
                var _token = '{{ csrf_token() }}';
                $.ajax({
                    url: "{{ url('favorite')}}",
                    method: 'get',
                    dataType: 'json',
                    data: {unit_id: unit_id,type : type,lead:lead, _token: _token},
                    success: function (data) {
                        if (data.response == 'add') {
                            $('#fav'+unit_id).css('color','#caa42d');
                        }else{
                            $('#fav'+unit_id).css('color','#161616');
                        }
                    },
                    error: function() {
                        alert('{{ __('admin.error') }}')
                    }
                })
            });
        </script>
    @endif
@endsection
