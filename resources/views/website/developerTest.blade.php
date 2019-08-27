@extends('website.index')
@section('content')
<style>
    .developerdesc{
        background-image: linear-gradient(#c48200,#9e6900);
        color:white;
        padding:2rem;
    }
    .inputstyle{
        background-image: linear-gradient(#c48200,#9e6900);
        opacity:.4;
        color:white;
    }
    .tabs{
        background-image: linear-gradient(#c48200,#9e6900);
    }
    .listyle{
            padding: 1.5rem;
            background-image: linear-gradient(#c48200,#9e6900);
            margin-top: 3.5rem;
            margin-bottom:2rem;
        }
    .New_property_meta_style{
            padding: 1rem;
            background-image: linear-gradient(#c48200,#9e6900) !important;
        }
    .New_property_meta_style span{
        }
        .tag_l{
            padding:0px 2rem !important;
            top:0 !important;
            left:0 !important;
            background-color: white !important;
            opacity:.5;
            border-radius:0;
            font-size:14px;
            font-weight: bold;
            color:white !important;
        }
    .logaAt{
        position: absolute;
        margin-top: -60px;
        color: white;
        padding:0.5rem;
    }
    .counterFet span{
        background-color: #a86f00;
        padding: 9px;
        height: 3rem;
        border-radius: 0;
    }
    .counterFet ul li{
        background-image: linear-gradient(#c48200,#9e6900) !important;
    }
    .devloperlogoholder{
    position: absolute;
    background: white;
    padding: 1rem;
    height: 6vw;
    width: 6vw;
    border-radius: 50%;
    margin-top: -3.5vw;
    margin-left: 11vw;
    box-shadow: rgb(162, 154, 154) 5px 5px 20px 0px;    
}
.project-content-mainpage{
    background-color: whitesmoke;
    height: 30rem;
    margin-bottom:1rem;
}
.text-det span{
    padding:1vw;
    margin-bottom: .25rem;
    color:#a7a7a7;
    font-weight:400;
}
.text-det span b{
    color:black;
}
.redmorediv{
    border-top: 1px solid #a7a7a7
}
.projectPaydet{
    margin-bottom:10px;
}
.projectPaydet b{
    color:#a7a7a7;
}
.projectPaydet strong{
    font-size:13px;
}
.detproject{
    padding:2.5rem .5rem;
}
.btndeveloperpage{
    margin-top:3rem;
}
.proimagecover{
    width:100%;
    height:15rem;
}
.fomcontact{
    background-image:url('/website_style/images/BG.png');
    background-size:cover;
    color:white
}

/*
    Mobile responseve
*/

@media only screen and (max-width: 600px) {
    .fomcontact{
        width:90%;
        margin:auto;
        margin-top:3rem !important;
    }
    .devloperlogoholder{
        height:20vw;
        width:20vw;
        margin-left:65vw;
        margin-top:-10.5vw;
    }
    .home-project-logo{
        width:16vw;
    }
    .btndeveloperpage{
        margin-top:17rem !important;
    }
    .botread{
        width:30vw !important;
        padding:3.75vw !important;
    }
}
</style>
    @if(isset($developer->website_cover))
    <style>
        .page-banner{
            background: url({{ url("uploads/".$developer->website_cover) }});
            background-size: cover !important;
            background-attachment: fixed;
            background-position: center center;
        }
        </style>
    @endif
    <!-- Page Banner Start-->
    <!-- <section class="page-banner padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <img src="{{ url('uploads/'.$developer->logo) }}" style="width: 70px;height: 70px;border-radius: 70px">
                    <h1 class="text-uppercase">{{ $developer->{app()->getLocale().'_name'} }}</h1>
                </div>
            </div>
        </div>
    </section> -->
    <!-- Page Banner End -->

    <div class="wropper">
        <div class="row">
            <div class="col-md-1"></div>
            <!-- contact page -->
            <div class="col-md-10">
                <!-- start main section -->
                <section id="smartsection" >
                    <!-- start Row main div -->
                    <div class="row padding">
                        <!-- begin header -->
                            <div class="col-md-8">
                                <div class="devlogo col-md-12 text-center">
                                    <img src="{{ url('uploads/'.$developer->logo) }}" style="width: 70px;height: 70px;border-radius: 70px">
                                </div>
                                <div class="col-md-12 text-center">
                                    <div class="developertitle">
                                        <h1 class="text-uppercase">{{ $developer->{app()->getLocale().'_name'} }}</h1>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                <h4>Description</h4>
                                <br>
                                    <div class="developerdesc">
                                        <p class="text-center">{{ $developer->{app()->getLocale().'_description'} }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card fomcontact">
                                    <div class="card-title" style="padding: 30px;">
                                        <h3>Contact us</h3>
                                        <h4> We can help you </h4>
                                    </div>
                                    <div class="card-body" style="padding: 25px;margin-top:-5rem">
                                        <form  method="POST" action="{{ url('/sendsubrequest') }}" class="form-group padding">
                                        {{ csrf_field() }}
                                            <div class="form-group">
                                                <label for=""> Full name </label>
                                                <input type="text" name="fullName" class="form-control inputstyle">
                                            </div>
                                            <div class="form-group">
                                                <label for=""> Phone </label>
                                                <input type="number" name="phone" class="form-control inputstyle">
                                            </div>
                                            <div class="form-group">
                                                <label for=""> Email Address </label>
                                                <input type="text" name="email" class="form-control inputstyle">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Your Massege Address </label>
                                                <textarea name="massage" class="form-control inputstyle" name="" rows="4"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-block inputstyle">send <i class="fa fa-faceboox"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                         <!-- End Header -->
                         <!-- End Row main div -->
                    </div>
                    <!-- End main section -->
                </section>

                <section id="contentdiv">
                    <div class="row padding">
                    <!-- begin taps -->
                        <div class="col-md-3 col-sm-12 col-xs-12" style="background-image: url('/website_style/images/tab-BG.png');height:30rem;background-size:contain">
                            <div class="tabs">
                                <div class="col-md-12">
                                    <ul class="counterFet">
                                        <li style="color:white" class="listyle"> <img src="{{ url('/website_style/images/arrow.png') }}">&nbsp&nbsp&nbsp<a style="color:white" href="#" id="projectsClick">{{ __('admin.projects') }} </a> &nbsp&nbsp <span>{{ count($projects) }}</li>
                                        <li style="color:white" class="listyle"> <img src="{{ url('/website_style/images/arrow.png') }}">&nbsp&nbsp&nbsp<a style="color:white" href="#" id="resaleClick">{{ __('admin.resale') }} </a> &nbsp&nbsp <span>{{ count($resaleprojects) }}</span> </li>
                                        <li style="color:white" class="listyle"> <img src="{{ url('/website_style/images/arrow.png') }}">&nbsp&nbsp&nbsp<a style="color:white" href="#" id="rentaleClick"> {{ __('admin.rental') }} </a> &nbsp&nbsp <span>{{ count($rentals) }}</span>  </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- end taps -->
                        <!-- begin content -->
                        <div class="col-md-9 col-sm-12 col-xs-12">
                        <div class="slider responsive">
                            <div id="projects">
                                @foreach($projects as $project)
                                        <div class="col-sm-4">
                                            <div>
                                                <div class="">
                                                    <div class="" style="margin-left:1rem">
                                                        <a href="{{ url(app()->getLocale().'/project/'.slug($project->{app()->getLocale().'_name'}).'-'.$project->id) }}">
                                                            <img src="{{ url('uploads/'.$project->cover) }}" alt="latest property" class="img-responsive proimagecover">
                                                        </a>
                                                        <div class="devloperlogoholder">
                                                            <img src="{{ url('uploads/'.$project->logo) }}" class="home-project-logo" style="margin-top: 0.5vw;margin-left: 0rem;">
                                                        </div>
                                                        <div class="project-content-mainpage">
                                                            <div class="">
                                                                <div class="projectlogo">
                                                                @if(!empty($project->developer->logo))
                                                                    <span><img class="developer-logo"  src="{{ url('uploads/'.$project->developer->logo) }}"></span>
                                                                @endif
                                                                </div>
                                                                <div class="projectname-main">
                                                                    <div class="detproject">
                                                                <!--  project details -->
                                                                <div class="">
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 projectPaydet">
                                                                            <span> <b>{{ __('admin.down_payment') }}  :</b>   <strong>{{ @$project->down_payment }}%</strong></span>
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 projectPaydet">
                                                                            <span> <b>{{ __('admin.delivery_date') }}  :</b>   <strong>{{ @$project->delivery_date }}</strong></span>
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 projectPaydet">
                                                                            <span> <b>{{ __('admin.installment') }}  :</b>   <strong>{{ @$project->installment_year }} {{ __('admin.years') }}</strong></span>
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 projectPaydet">
                                                                        <span> <b>starting area  :</b>  <strong>{{ @$project->area }}</strong></span>
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 projectPaydet">
                                                                            <span> <b>starting price  :</b>  <strong>{{ @$project->meter_price }} {{ __('admin.egp') }} {{ __('admin.meter_price') }}</strong></span>
                                                                        </div>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="btndeveloperpage">
                                                                        <a href="{{ url(app()->getLocale().'/project/'.slug($project->{app()->getLocale().'_name'}).'-'.$project->id) }}" class="btn btn-block  botread">{{ __('admin.read_more') }}</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                @endforeach
                            </div>
                        </div>
                                <div class="hidden" id="resaleDiv">
                                    @foreach($resaleprojects as $resale)
                                    <div class="col-sm-4">
                                    <div>
                                                <div class="">
                                                    <div class="" style="margin-left:1rem">
                                                        <a href="{{ url(app()->getLocale().'/project/'.slug($resale->{app()->getLocale().'_name'}).'-'.$resale->id) }}">
                                                            <img src="{{ url('uploads/'.$resale->cover) }}" alt="latest property" class="img-responsive proimagecover">
                                                        </a>
                                                        <div class="devloperlogoholder">
                                                            <img src="{{ url('uploads/'.$resale->logo) }}" class="home-project-logo" style="margin-top: 0.5vw;margin-left: 0rem;">
                                                        </div>
                                                        <div class="project-content-mainpage">
                                                            <div class="">
                                                                <div class="projectlogo">
                                                                @if(!empty($resale->developer->logo))
                                                                    <span><img class="developer-logo"  src="{{ url('uploads/'.$resale->developer->logo) }}"></span>
                                                                @endif
                                                                </div>
                                                                <div class="projectname-main">
                                                                    <div class="detproject">
                                                                <!--  project details -->
                                                                <div class="">
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 projectPaydet">
                                                                            <span> <b>{{ __('admin.down_payment') }}  :</b>   <strong>{{ @$resale->down_payment }}%</strong></span>
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 projectPaydet">
                                                                            <span> <b>{{ __('admin.delivery_date') }}  :</b>   <strong>{{ @$resale->delivery_date }}</strong></span>
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 projectPaydet">
                                                                            <span> <b>{{ __('admin.installment') }}  :</b>   <strong>{{ @$resale->installment_year }} {{ __('admin.years') }}</strong></span>
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 projectPaydet">
                                                                        <span> <b>starting area  :</b>  <strong>{{ @$resale->area }}</strong></span>
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 projectPaydet">
                                                                            <span> <b>starting price  :</b>  <strong>{{ @$resale->meter_price }} {{ __('admin.egp') }} {{ __('admin.meter_price') }}</strong></span>
                                                                        </div>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="btndeveloperpage">
                                                                        <a href="{{ url(app()->getLocale().'/project/'.slug($resale->{app()->getLocale().'_name'}).'-'.$resale->id) }}" class="btn btn-block  botread">{{ __('admin.read_more') }}</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                    @endforeach
                                </div>
                            <div class="hidden" id="rentals">
                                @foreach($rentals as $rental)
                                    <div class="col-sm-4">
                                    <div>
                                                <div class="">
                                                    <div class="" style="margin-left:1rem">
                                                        <a href="{{ url(app()->getLocale().'/project/'.slug($rental->{app()->getLocale().'_name'}).'-'.$rental->id) }}">
                                                            <img src="{{ url('uploads/'.$rental->cover) }}" alt="latest property" class="img-responsive proimagecover">
                                                        </a>
                                                        <div class="devloperlogoholder">
                                                            <img src="{{ url('uploads/'.$rental->logo) }}" class="home-project-logo" style="margin-top: 0.5vw;margin-left: 0rem;">
                                                        </div>
                                                        <div class="project-content-mainpage">
                                                            <div class="">
                                                                <div class="projectlogo">
                                                                @if(!empty($rental->developer->logo))
                                                                    <span><img class="developer-logo"  src="{{ url('uploads/'.$rental->developer->logo) }}"></span>
                                                                @endif
                                                                </div>
                                                                <div class="projectname-main">
                                                                    <div class="detproject">
                                                                <!--  project details -->
                                                                <div class="">
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 projectPaydet">
                                                                            <span> <b>{{ __('admin.down_payment') }}  :</b>   <strong>{{ @$rental->down_payment }}%</strong></span>
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 projectPaydet">
                                                                            <span> <b>{{ __('admin.delivery_date') }}  :</b>   <strong>{{ @$rental->delivery_date }}</strong></span>
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 projectPaydet">
                                                                            <span> <b>{{ __('admin.installment') }}  :</b>   <strong>{{ @$rental->installment_year }} {{ __('admin.years') }}</strong></span>
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 projectPaydet">
                                                                        <span> <b>starting area  :</b>  <strong>{{ @$rental->area }}</strong></span>
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 projectPaydet">
                                                                            <span> <b>starting price  :</b>  <strong>{{ @$rental->meter_price }} {{ __('admin.egp') }} {{ __('admin.meter_price') }}</strong></span>
                                                                        </div>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="btndeveloperpage">
                                                                        <a href="{{ url(app()->getLocale().'/project/'.slug($rental->{app()->getLocale().'_name'}).'-'.$rental->id) }}" class="btn btn-block  botread">{{ __('admin.read_more') }}</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                    @endforeach
                            </div>
                        <!-- end content -->
                    </div>
                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>

<!--
--------------------------------------------------------------------------------------------------
-->
    <h2 class="text-center"> Simlar projects </h2>
    <section id="property" class="padding_top listing1">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
            <div class="">
           <div class="row">
           <div class="slider responsive">
                @foreach(@App\Project::where('developer_id',$developer->id)->limit(3)->get() as $project)
                    <div class="col-sm-4">
                        <div class="property_item heading_space">
                            <div class="image" style="height: 225px">
                                <a href="{{ url('project/'.$project->id) }}"><img style="height: 225px" src="{{ url('uploads/'.$project->cover) }}" alt="latest property" class="img-responsive"></a>
                                <div class="price clearfix">
                                </div>
                                <span class="tag_l"><img src="{{ url('uploads/'.$project->logo) }}" style="width: 8rem;height: 7rem;"></span>
                            </div>
                            <div class="proerty_content">
                                <div class="proerty_text">
                                    <h3 style="padding:1rem" class="captlize"><a href="#.">{{ $project->{app()->getLocale().'_name'} }}</a></h3>
                                    <p style="padding:1rem"><span><img src="{{ url('/website_style/images/location.png') }}"></span>&nbsp&nbsp&nbsp{{ @App\Location::find($project->location_id)->{app()->getLocale().'_name'} }}</p>
                                </div>
                                <div class="property_meta transparent New_property_meta_style">
                                    @if(count(@App\Phase::where('project_id',$project->id)->get()) > 0)
                                        @foreach(@App\Phase::where('project_id',$project->id)->get() as $phase)
                                            @foreach(@App\Phase_Facilities::where('phase_id',$phase->id)->get() as $fac)
                                                @foreach(@App\Facility::where('id',$fac->facility_id)->get() as $icon)
                                                    <span><img src="{{ url('uploads/'.@App\Icon::where('id',$icon->icon)->first()->icon) }}" width="20px"></span>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @else
                                        <h3 style="color:black;padding:.5rem">{{ $project->{app()->getLocale().'_name'} }}</h3>
                                    @endif
                                </div>

                                <div class="toggle_share collapse" id="proj{{ $project->id }}">
                                    <ul>
                                        <li><a href="#." class="facebook"><i class="icon-facebook-1"></i> Facebook</a></li>
                                        <li><a href="#." class="twitter"><i class="icon-twitter-1"></i> Twitter</a></li>
                                        <li><a href="#." class="vimo"><i class="icon-vimeo3"></i> Vimeo</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            </div>

        </div>

            </div>
            <div class="col-md-1"></div>
        </div>
    </section>


    <!-- Favorite Properties  -->
    <!-- Favorite Properties End -->
@endsection
@section('js')
    <script>
        $("#resaleClick").on("click",function(){
            $("#projects").addClass("hidden");
            $("#rentals").addClass("hidden");
            $("#resaleDiv").removeClass("hidden");
        });
    </script>
    <script>
        $("#rentaleClick").on("click",function(){
            $("#projects").addClass("hidden");
            $("#resaleDiv").addClass("hidden");
            $("#rentals").removeClass("hidden");
        })
    </script>
    <script>
    $("#projectsClick").on("click",function(){
            $("#rentals").addClass("hidden");
            $("#resaleDiv").addClass("hidden");
            $("#projects").removeClass("hidden");
        })
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
            })
        </script>
        <script>
$('.responsive').slick({
// autoplay:true,
  dots: true,
	prevArrow: $('.prev'),
	nextArrow: $('.next'),
  infinite: false,
  speed: 300,
  slidesToShow: 3,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});
</script>

    @endif
@endsection