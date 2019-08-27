@include('website.nav')
<style>
.feature-home{
    background:rgba(51, 51, 51, 0.3);
    margin-left:5px;
    padding:10px;
}
.project-btn {
    background:black;
    margin-right:0px;
    height:40px;
    width:120px;
    
}
.project-bb,.property_item{
    background:rgba(202, 202, 202, 0.3);
}
.project-bb span{
    float:left;
    margin-left:4px;
}
.project-bb h4{
    /*padding-left:30px;*/
}
.project-content-mainpage{
    background-color: white;
    height: 27rem;
}
.projectPaydet{
    margin-bottom:10px;
}
.projectPaydet b{
    color:#a7a7a7;
    font-size:11px;
}
.projectPaydet strong{
    font-size:11px;
}
.home-project-logo{
    border-radius: 50%;
    /*background: #7b7272b0;*/
}

body > div > section.padding.col-md-10.col-md-offset-1 > section > div > div{
    transform: unset !important;
}
.feature-home{
    background:rgba(51, 51, 51, 0.3);
    margin-left:5px;
    padding:10px;
}
.project-btn {
    background:black;
    margin-right:0px;
    height:40px;
    width:120px;
    
}
.project-bb,.property_item{
    background:rgba(202, 202, 202, 0.3);
}
.project-bb span{
    float:left;
    margin-left:4px;
}
.project-bb h4{
    padding-left:30px;
}
.modal-body{
    padding:40px !important;
}
.modal-footer{
    padding:0 !important;
}
.modal{
        overflow:hidden
    }
.closebton{
    border-radius:50%;
    margin-top:-2.5%;
    margin-right:-1rem !important;
}
.title,
.form {
    margin: 0 auto;
    border-radius: 2px;
}

.title {
    margin-bottom: 0.5em;
    display: block;
    background: orange;
    font-family: 'Nunito', sans-serif;
    font-size: 12px;
    padding: 1em;
    text-transform: uppercase;
    box-sizing: border-box;
    text-align: center;
    cursor: pointer;
}

.flag {
    position: absolute;
    top: 7px;
    border-radius: 2px;
    border: 35px solid;
    border-top-color: orange;
    border-bottom-color: orange;
}
.carouselContent .owl-wrapper-outer{
    /*margin-left:-10vw;*/
}
.show ~ .title {
    transform:rotate(-90deg);
    z-index: 2;
    width: 14vw;
    position: fixed;
    top: 20vw;
    transition:
        width 200ms ease-out,
        top 200ms ease-out;
    left:-6vw !important;
}

.show ~ .title .flag {
    opacity: 0; 
}

.show ~ .title .left {
    left: 0;
    border-right-color: orange;
    border-left-color: transparent;
}

.show ~ .title .right {
    right: 0;
    border-right-color: transparent;
    border-left-color: orange;
}
.show ~ .form {
    opacity: 0;
    transition:
        opacity 200ms linear;
}

.show:checked ~ .title {
    position: fixed;
     top: 9vw; 
    transform:unset;
    width: 500px;
}

.show:checked ~ .title .left {
    opacity: 0.7;
    left: -55px;
    transition: 
        opacity 50ms linear 200ms,
        left 50ms linear 200ms;
}

.show:checked ~ .title .right {
    opacity: 0.7;
    right: -55px;
    transition: 
        opacity 50ms linear 200ms,
        right 50ms linear 200ms;
}

.show:checked ~ .form {
    opacity: 1;
    display:block !important;
}

.form {
    position:fixed;
    z-index:999999;
    top:11.6vw;
    width: 24vw;
    background: #ddd;
    padding: 2em 0 2em 0;
    display:none;
}

.group,
.group-2 {
    margin: 0 auto;
    width: 80%;
}

.group {
    margin-bottom: 2em;
}

.group:after {
    content: '';
    display: block;
    clear: both;
}

.col-1,
.col-2 {
    float: left;
}

.col-1 {
    width: 40%;
}

.col-1 label {
    height: 40px;
    line-height: 40px;
    font-size: 18px;
    text-shadow: 0.5px 0.5px 0 #fff;
    font-family: 'Nunito', sans-serif;
    text-transform: capitalize;
}

.col-2 {
    width: 60%;
}

.col-2 input {
    width: 100%;
    height: 40px;
    font-family: 'Nunito', sans-serif;
    outline: none;
    border: none;
    border-radius: 20px;
    box-sizing: border-box;
    box-shadow: 
        inset 0 0 3px 0 rgba(0,0,0,0.3),
        0.5px 0.5px 0 0 #fff;
    padding: 1em;
    background: rgba(80,80,80,0.1);
}
.col-2 textarea {
    width: 100%;
    height: 80px;
    font-family: 'Nunito', sans-serif;
    outline: none;
    border: none;
    border-radius: 20px;
    box-sizing: border-box;
    box-shadow: 
        inset 0 0 3px 0 rgba(0,0,0,0.3),
        0.5px 0.5px 0 0 #fff;
    padding: 1em;
    background: rgba(80,80,80,0.1);
}

input[type="submit"] {
    display: block;
    margin: 0 auto;
    width: 30%;
}

.group-2 {
    margin-bottom: 1em;
}

.group-2:after {
    content: '';
    display: block;
    clear: both;
}

.group-2 *:not(a) {
    float: left;
}

.group-2 .checkbox {
    display: none;
}

.group-2 label {
    font-family: 'Nunito', sans-serif;
    font-size: 12px;
    height: 100%;
    cursor: pointer;
    line-height: 22px;
}

.group-2 label a {
    position: relative;
    text-decoration: none;
    color: blue;
}

.group-2 label a:after {
    position: absolute;
    top: 15px;
    left: 50%;
    right: 50%;
    content: '';
    height: 1px;
    background: blue;
    transition:
        left 70ms linear,
        right 70ms linear;
}

.group-2 label a:hover:after {
    left: 0;
    right: 0;
}



.toogle {
    position: relative;
    width: 41px;
    height: 21px;
    border-radius: 10px;
    margin-right: 1em;
    background: #ccc;
    box-shadow:
        inset 0 0 2px 0 rgba(0,0,0,0.5),
        0.5px 0.5px 0 0 #fff;
    
}

.toogle:before {
    content: '';
    width: 15px;
    height: 15px;
    border-radius: 50%;
    background: #fff;
    box-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}

.checkbox ~ label .toogle:before {
    position: absolute;
    top: 3px;
    left: 3px;
    transition: left 150ms linear;
}

.checkbox ~ label .toogle {
    background: rgba(200,0,0,0.5);
}

.checkbox ~ label {
    color: rgba(0,0,0,0.4);
    transition: color 100ms linear;
}

.checkbox:checked ~ label .toogle:before {
    position: absolute;
    top: 3px;
    left: 22px;
}

.checkbox:checked ~ label .toogle {
    background: rgba(0,200,0,0.5);
}
.dwrber{
    height:27vw;
    width:25vw;
    background-color:white;
    margin-left:.5rem;
}
.devloperlogoholder{
    position: absolute;
    background: white;
    padding: 1rem;
    height: 100px;
    width: 100px;
    border-radius: 50%;
    margin-top: -2.5vw;
    margin-left: 15vw;
    box-shadow: rgb(162, 154, 154) 5px 5px 20px 0px;
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
.carouselContent .owl-carousel .owl-wrapper-outer{
    width:105%;
}

.checkbox:checked ~ label {
    color: rgba(0,0,0,1);
}

.submit {
    border: none;
    outline: none;
    position: relative;
    height: 40px;
    color: #fff;
    font-family: 'Nunito', sans-serif;
    text-transform: uppercase;
    border-radius: 2px;
    background: rgba(0,0,0,0.6);
    box-shadow: 0 0 1px 0 #000;
    letter-spacing: 1.5px;
    font-size: 18px;
    transition: background 70ms linear;
}

.submit:hover {
    color: orange;
    background: rgba(0,0,0,1);
}
.carouselContent .owl-item{
    width:unset !important;
}
.owl-item.active > div:after {
  content: 'active';
}
.owl-item.center > div:after {
  content: 'center';
}
.owl-item.active.center > div:after {
  content: 'active center';
}
.owl-item > div:after {
  font-family: sans-serif;
  font-size: 24px;
  font-weight: bold;
}

.slick-dots {
	text-align: center;
  margin: 0 0 10px 0;
  padding: 0;
  li {
    display:inline-block;
    margin-left: 4px;
    margin-right: 4px;
    &.slick-active {
      button {
        background-color:black;
      }
    }
    button {
      font: 0/0 a;
      text-shadow: none;
      color: transparent;
      background-color:#999;
      border:none;
      width: 15px;
      height: 15px;
      border-radius:50%;
    }
		:hover{
			background-color: black;
		}
  }
}

/* Custom Arrow */
.prev{
	color: #999;
	position: absolute;
	top: 38%;
	left: -2em;
	font-size: 1.5em;
		:hover{
			cursor: pointer;
			color: black;
		}
}
.next{
	color: #999;
	position: absolute;
	top: 38%;
	right: -2em;
	font-size: 1.5em;
	:hover{
			cursor: pointer;
			color: black;
		}
}

@media screen and (max-width: 800px) {
    .next {
        display: none !important;
    }
}
@media only screen and (max-width: 600px) {
    .modal{
        overflow:unset !important
    }
    .gifimage{
        text-align:center;
    }
    .gifimage img{
        width:40vw !important;
        height:40vw !important;
    }
    .title{
        display:none
    }
        .devloperlogoholder{
        margin-left:50vw !important;
        margin-top:-11vw;
    }
    .devloperlogoholder img{
        width:20vw !important;
    }
    .projectlogo span img{
        width:23vw;
        position:unset;
    }
    .detproject{
        margin-top:-4rem;
    }
    .project-content-mainpage{
    height: 27rem;
    }
        .projectName{
        font-size:1.5rem;
        margin-top:0rem;
    }
    .slick-dotted.slick-slider{
        margin-top:-7rem;
    }
    .botread{
        margin-top:28vw !important;
        width:35vw;
        padding:10px;
    }
    .onmobiletext{
        margin-top:4vw;
    }
    .mobrespodata span{
        margin-left:3rem;
    }
    .projectName{
        font-size:15px !important;
    }
}
@media screen and (min-width: 1600px) {
    .devloperlogoholder{
        margin-left:11vw;
    }
}
</style>

<!-- open model -->
<div class="modal fade" id="admodal" role="dialog" tabindex="-1" style="margin-top:17vw;height: 34rem;overflow:hidden">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
        <div class="closediv">
            <div class="btnclose">
                <button class="closebton btn btn-danger pull-right" data-dismiss="modal" type="button">X</button><br class="visible-xs">
            </div>
        </div>
			<div class="modal-body">
				<div>
					<!-- Wrapper for slides -->
					<div class="carousel-inner">
						<div class="item active">
                            <div class="row">
                                <div class="col-md-8 col-sm-8 col-sx-8">
                                    <h1>Need help ?</h1>
                                    <h1>Request a callback</h1>
                                    <p>We can help you to find a new home today</p>
                                    <p>just fill in your request,and we will call you back</p>
                                </div>
                                <div class="col-md-4 col-sm-4 col-sx-4 gifimage">
                                    <a href="{{ url('/Submitpage') }}">
                                        <img class="gifimage" src="{{ url('website_style/images/gif/6-map.gif') }}" style="height: 9vw;" alt="">
                                    </a>
                                </div>
                            </div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<br class="visible-xs">
				<a href="{{ url('/Submitpage') }}" style="background-color:black;font-weight:bold;font-size:x-large;letter-spacing:.4rem;color:white" class="btn btn-block">Submit your request</a>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- close model -->

<!--Slider-->
<section class="banner_six hidden-xs hidden-sm">
    <h3 class="hidden">hidden</h3>
    <div id="property-d-1" class="owl-carousel">
        @foreach(@App\Project::where('on_slider',1)->orderBy('id', 'desc')->get() as $slider)
        <div class="item">
            <img src="{{ url('uploads/'.$slider->website_slider) }}" alt="" data-bgposition="center center" data-bgfit="cover">
            <div class="container">
            <div class="slider-property text-left">
                <div class="bg_white text-left">
                    <h2 >{{ $slider->{app()->getLocale().'_name'} }}</h2>
                    <div class="row">
                    <p class="col-xs-8">{{ \Illuminate\Support\Str::words($slider->{app()->getLocale().'_description'} , 65,'..') }}</p>
                        <h4 class="col-xs-4" > <img src="{{ url('uploads/'.$slider->logo) }}" width="150px"> </h4>

                    </div>
                        @if(Session::get('Newlang') == 'ar')
                            <a href="{{ url('ar/project/'.slug($slider->en_name).'-'.$slider->id) }}" class="btn-more empty-button" style="font-size:14px;color: #fff;">
                                <span>{{ __('admin.more_details') }}</span>
                            </a>
                        @elseif(Session::get('Newlang') == 'en')
                            <a href="{{ url('en/project/'.slug($slider->en_name).'-'.$slider->id) }}" class="btn-more empty-button" style="font-size:14px;color: #fff;">
                                <span>{{ __('admin.more_details') }}</span>
                            </a>
                        @endif
                        
                </div>
                <div class="property_meta">
                    <span style="font-size: 22px">{{ $slider->down_payment }} % {{ __('admin.down_payment') }}</span>
                    <span style="font-size: 22px">{{ $slider->installment_year }} {{ __('admin.installment_year') }}</span>
                </div>
            </div>
            </div>
        </div>

       @endforeach
    </div>
</section>
<!--Slider eands-->
<!--Slider-->
<div class="rev_slider_wrapper hidden-lg hidden-md">
    <div id="rev_slider" class="rev_slider"  data-version="5.0">
        <ul>
            <!-- SLIDE  -->
            @foreach(@App\Project::where('on_slider',1)->orderBy('id', 'desc')->get() as $slider)
                <li data-transition="fade">
                    <!-- MAIN IMAGE -->
                    <img src="{{ url('uploads/' . $slider->website_slider) }}" alt="" data-bgposition="center center" data-bgfit="cover">
                    <h1 class="tp-caption tp-resizeme uppercase"
                        data-x="center" data-hoffset="0"
                        data-y="275"
                        data-transform_idle="o:1;"
                        data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;"
                        data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;"
                        data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
                        data-mask_out="x:0;y:0;s:inherit;e:inherit;"
                        data-start="500"
                        data-splitin="none"
                        data-splitout="none"
                        style="z-index: 6; color: #fff;font-size: 56px">{{ $slider->{app()->getLocale().'_name'} }}
                    </h1>
                    <p class="tp-caption  tp-resizeme"
                       data-x="center" data-hoffset="0"
                       data-y="320"
                       data-transform_idle="o:1;"
                       data-transform_in="opacity:0;s:2000;e:Power3.easeInOut;"
                       data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;"
                       data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
                       data-mask_out="x:0;y:0;s:inherit;e:inherit;"
                       data-start="800" style="color: #e6e6e6; font-size: 20px;margin-top: 10px;">{{ @App\Location::find($slider->location_id)->{app()->getLocale().'_name'} }}
                    </p>
                    <img src="{{ url('uploads/' . $slider->image) }}" alt="" data-bgposition="center center" data-bgfit="cover">
                    <div class="slider-caption tp-caption tp-resizeme"
                         data-x="['right','right','center','center']" data-hoffset="['0','0','0','0']"
                         data-y="['center','center','center','center']" data-voffset="['0','0','0','0']"
                         data-responsive_offset="on"
                         data-visibility="['on','on','off','off']"
                         data-start="1500"
                         data-transition="fade"
                         data-transform_idle="o:1;"
                         data-transform_in="x:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:2000;e:Power3.easeInOut;"
                         data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;"
                         data-mask_in="x:0px;y:0px;s:inherit;e:inherit;">
                    </div>
                    <div class="tp-caption  tp-resizeme"
                         data-x="center" data-hoffset="0"
                         data-y="400"
                         data-width="full"
                         data-transform_idle="o:1;"
                         data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;"
                         data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;"
                         data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
                         data-mask_out="x:0;y:0;s:inherit;e:inherit;"
                         data-start="800" style="color: #fff;font-size: 36px;">
                        {{ $slider->down_payment }}% {{ __('admin.down_payment')}} & {{ $slider->installment_year }}
                        {{ __('admin.installment') }}
                        @if($slider->installment_year > 1 && app()->getLocale() == 'en'){{ __('admin.years')}}
                        @elseif($slider->installment_year <= 1 && app()->getLocale() == 'en'){{ __('admin.year')}}
                        @elseif($slider->installment_year <= 10 && app()->getLocale() == 'ar'){{ __('admin.years')}}
                        @elseif($slider->installment_year > 10 && app()->getLocale() == 'ar'){{ __('admin.year')}}
                        @endif
                    </div>
                    <div class="tp-caption tp-static-layer"
                         id="slide-37-layer-2"
                         data-x="left" data-hoffset="550"
                         data-y="500" data-voffset="560"
                         data-whitespace="nowrap"
                         data-visibility="['on','on','on','on']"
                         data-start="500"
                         data-basealign="slide"
                         data-startslide="0"
                         data-endslide="5"
                         style="z-index: 5;">
                        @if(Session::get('Newlang') == 'ar')
                            <a href="{{ url('ar/project/'.slug($slider->en_name).'-'.$slider->id) }}" class="btn-white border_radius uppercase">{{ __('admin.read_more') }}</a>
                        @elseif(Session::get('Newlang') == 'en')
                            <a href="{{ url('en/project/'.slug($slider->en_name).'-'.$slider->id) }}" class="btn-white border_radius uppercase">{{ __('admin.read_more') }}</a>
                        @endif
                        
                    </div>
                </li>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<!--Slider ends-->
<!-- Property Search area Start -->
<div class="col-xs-12" style="background: #eee">
    <form class="callus container" action="{{ url('search') }}" method="get" style="padding: 20px;margin-top: 50px;">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-sm-4">
            <div class="single-query bottom15">
                <input type="text" name="keyword" class="keyword-input" style="margin: 0;" placeholder="{{ __('admin.Keyword (e.g. "office")') }}">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="single-query bottom15">
                <select name="location" class="select2" data-placeholder="{{ trans('admin.select_location') }}">
                    <option></option>
                    @foreach($search['region'] as $location)
                        <option value="{{ $location['id'] }}">{{  $location['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="single-query bottom15">
                <select class="select2" id="unit_type" multiple name="unit_type[]" data-placeholder="{{ __('admin.select unit type') }}" style="height: 48px;">
                    <option></option>
                    @foreach($search['unit_type'] as $unit_type)
                        <option value="{{ $unit_type['id'] }}">{{ $unit_type['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-2" style="margin-top: 30px">
            <div class="single-query bottom15">
                <select name="type" class="select2" id="property_type"
                        data-placeholder="{{ trans('admin.select_type') }}">
                    <option></option>
                    <option value="project" selected>{{ trans('admin.project') }}</option>
                    <option value="resale"  >{{ trans('admin.resale') }}</option>
                    <option value="rental">{{ trans('admin.rental') }}</option>
                </select>
            </div>
        </div>
        <div class="col-sm-10">
            <div class="col-sm-6">
                <input type="hidden" name="min_price" id="min_price" value="{{ $search['data']['project_min_price'] }}">
                <input type="hidden" name="max_price" id="max_price" value="{{ $search['data']['project_max_price'] }}">
                <input type="hidden" name="min_area" id="min_area" value="{{ $search['data']['project_min_area'] }}">
                <input type="hidden" name="max_area" id="max_area" value="{{ $search['data']['project_max_area'] }}">
                <div class="col-md-12 col-sm-12 col-xs-12 bottom15" >
                    <div class="single-query-slider">
                        <div class="clearfix top20">
                            <label class="@if(app()->getLocale()=='en') pull-right @else pull-left @endif" id="price_lable">{{ trans('admin.price') }}</label>
                            <div class="price text-right @if(app()->getLocale()=='en') pull-left @else pull-right @endif">
                                (
                                <div class="leftLabel" id="mi_price"></div>
                                <span>EG</span> )
                                <span>to ( <div class="rightLabel" id="ma_price"></div> EG )</span>

                            </div>
                        </div>
                        <div id="price_range" data-range_min="{{ $search['data']['project_min_price'] }}"
                             data-range_max="{{ $search['data']['project_max_price'] }}"
                             data-cur_min="{{ $search['data']['project_min_price'] }}"
                             data-cur_max="{{ $search['data']['project_max_price'] }}"
                             class="nstSlider animating_css_class">
                            <div class="bar"></div>
                            <div class="leftGrip"></div>
                            <div class="rightGrip"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="col-md-12 col-sm-12 col-xs-12 bottom15">
                    <div class="single-query-slider">
                        <div class="clearfix top20">
                            <label class="pull-left">area Range:</label>
                            <div class="price text-right"> (
                                <div class="leftLabel" id="mi_area"></div>
                                <span>m<sup>2</sup> ) </span>

                                <span>to ( <div class="rightLabel" id="ma_area"></div> m<sup>2</sup> )</span>
                            </div>
                        </div>
                        <div id="area_range" data-range_min="{{ $search['data']['project_min_area'] }}"
                             data-range_max="{{ $search['data']['project_max_area'] }}"
                             data-cur_min="{{ $search['data']['project_min_area'] }}"
                             data-cur_max="{{ $search['data']['project_max_area'] }}"
                             class="nstSlider">
                            <div class="bar"></div>
                            <div class="leftGrip"></div>
                            <div class="rightGrip"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <div id="non_project">
        <div class="search-2">
            <div class="col-md-4 col-sm-4 col-xs-4">
                <div class="single-query bottom15">
                    <select class="select2" name="rooms"
                            data-placeholder="{{ trans('admin.select_number_of_rooms') }}">
                        <option></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <div class="single-query bottom15">
                    <select class="select2" name="bathrooms"
                            data-placeholder="{{ trans('admin.select_number_of_bathrooms') }}">
                        <option></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="facility1">
        <div class="col-sm-12">
            <div class="group-button-search">
                <a data-toggle="collapse" href=".search-propertie-filters" class="more-filter">
                    <i class="fa fa-plus text-1" aria-hidden="true"></i><i class="fa fa-minus text-2 hide"
                                                                           aria-hidden="true"></i>
                    <div class="text-1">{{ __('admin.Show more search options') }}</div>
                    <div class="text-2 hide">{{ __('admin.less more search options') }}</div>
                </a>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12 text-right facility1 form-group top30 pull-right">
                <button type="submit" class="border_radius btn-yellow text-uppercase">{{ __('admin.search') }}</button>
            </div>
            <br>
            <div class="search-propertie-filters collapse">
                <div class="container-2">
                    <div class="row">
                        @foreach($search['facilities'] as $facility)
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="search-form-group white bottom10">
                                    <input type="checkbox" class="checkbox" value="{{ $facility['id'] }}"
                                           name="check-box"/>
                                    <span>{{ $facility['name'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</form>
</div>
<!-- Property Search area End -->


<!-- Latest Property -->
        <section style="background:url('images/bg.jpg') no-repeat 100%" id="property" class="padding index2 ">
        <div class="row">
            <div class="col-xs-12 text-center p-1" style="margin-top:20px;">
                <h2 class="uppercase blu-color" style="color:white !important;">{{ __('admin.featured_projects') }}</h2>
            </div>
        </div>
        <div class="container"style="margin-top: 4.85em;">
            <div class="row">
            <div class="col-md-12 heroSlider-fixed">
                <div class="overlay">
            </div>
                <!-- Slider -->
                <div class="slider responsive">
                @foreach(@App\Project::where('show_website',1)->orderby('featured_priority')->limit('9')->get() as $project)
                    <div>
                        <div class="">
                            <div class="" style="margin-left:1rem">
                                <a href="{{ url(app()->getLocale().'/project/'.slug($project->{app()->getLocale().'_name'}).'-'.$project->id) }}">
                                    <img src="{{ url('uploads/'.$project->cover) }}" alt="latest property" class="img-responsive">
                                </a>
                                <div class="devloperlogoholder">
                                    <img src="{{ url('uploads/'.$project->logo) }}" class="home-project-logo" style="margin-top: 0.75vw;margin-left: 1rem;">
                                </div>
                                <div class="project-content-mainpage">
                                    <div class="">
                                        <div class="projectlogo">
                                            <span><img class="developer-logo"  src="{{ url('uploads/'.$project->developer->logo) }}"></span>
                                        </div>
                                        <div class="projectname-main">
                                            <div class="detproject">
                                        <!--  project details -->
                                        <div class="onmobiletext">
                                                <div class="col-md-6 col-sm-6 col-xs-6 projectPaydet">
                                                    <span> <b>{{ __('admin.down_payment') }}  :</b>   <strong>{{ @$project->down_payment }}%</strong></span>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6 projectPaydet">
                                                    <span> <b>{{ __('admin.delivery_date') }}  :</b>   <strong>{{ @$project->delivery_date }}</strong></span>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6 projectPaydet">
                                                    <span> <b>{{ __('admin.installment') }}  :</b>   <strong>{{ @$project->installment_year }} {{ __('admin.years') }}</strong></span>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6 projectPaydet">
                                                <span> <b>starting area  :</b>  <strong>{{ @$project->area }}</strong></span>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12 projectPaydet">
                                                    <span> <b>starting price  :</b>  <strong>{{ @$project->meter_price }} {{ __('admin.egp') }} {{ __('admin.meter_price') }}</strong></span>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="">
                                                <a href="{{ url(app()->getLocale().'/project/'.slug($project->{app()->getLocale().'_name'}).'-'.$project->id) }}" class="btn btn-block  botread">{{ __('admin.read_more') }}</a>
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
            </div>
        </div>
 </section>
<!-- Latest Property Ends -->
<section id="" class="padding col-md-10 col-md-offset-1">
    <div style="width: 100%;display: inline-block;">
    @php $count = @App\ResaleUnit::where('featured',1)->orderby('priority')->count(); @endphp
    @if($count)
        <h3 class="uppercase text-center blu-color" style="padding:0 0 30px 0">{{ __('admin.over') }} {{ $count }} {{ __('admin.properties_egypt') }}</h3>
    @endif
    </div>
    <section class="center slider col-xs-12">
        @foreach(@App\ResaleUnit::where('featured',1)->orderby('priority')->get() as $unit)
            <a href="{{ url(app()->getLocale().'/resale/'.slug($unit->{app()->getLocale().'_title'}).'-'.$unit->id) }}">
                <div class="resale-unit" >
                    <div class="col-sm-6" style="background: url({{ url('' . $unit->image) }});background-position: 50%;background-size:cover;height: 450px;padding: 0;margin-bottom: 20px; ">
                        <div class="resale-data" class="col-sm-12 bottom-20">
                            <h3 class="margin" style="padding: 4px 8px;font-size: 18px">{{ $unit->{app()->getLocale().'_title'} }}</h3>
                            <h5 class="col-xs-6" style="padding: 0 8px;">{{ @App\Location::find($unit->location)->{app()->getLocale().'_name'} }} </h5>
                            <h4 class="col-xs-6 text-right" style="">{{ $unit->price}} {{ __('admin.egp') }}</h4>
                            <span class="col-xs-12" style="color:#8a6d3b;text-align: center;width: 100%">
                                @if(isset($unit->rooms))
                                    <span class="pull-left resale-home"><i class="fas fa-bed"></i> {{ $unit->rooms }} {{ __('admin.bedrooms') }}</span>
                                @endif
                                @if(isset($unit->bathrooms))
                                    <span class="pull-right resale-home"><i class="fas fa-bath"></i> {{ $unit->bathrooms }} {{ __('admin.bathrooms') }}</span>
                                @endif
                            </span>

                        </div>
                    </div>

                </div>
            </a>
        @endforeach
    </section>

</section>

<input type="checkbox" id="show" class="show" style="display:none !important" />
<!-- Title+Button -->
<label for="show" class="title">Send message<i class="flag left"></i><i class="flag right"></i></label>
<!-- Form -->
<form action="{{ url('/sendsubrequest') }}" method="post" class="form">
{{ csrf_field() }}
    <!-- First Name -->
    <div class="group">
        <div class="col-1">
            <label for="f-name">Full name</label>
        </div>
        <div class="col-2">
            <input type="text" id="full-name" name="fullName" placeholder="Full Name" required />
        </div>
    </div>
    <!-- Last Name -->
    <div class="group">
        <div class="col-1">
            <label for="phone">Phone</label>
        </div>
        <div class="col-2">
            <input type="number" name="phone" id="phone" placeholder="Phone number" required/>
        </div>
    </div>
    <!-- Password -->
    <!-- Email -->
    <div class="group">
        <div class="col-1">
            <label for="email">your email</label>
        </div>
        <div class="col-2">
            <input type="email" name="email" id="email" placeholder="example@email.com" required/>
        </div>
    </div>
    <div class="group">
    <div class="col-1">
            <label for="email"> best time to contacted</label>
        </div>
        <div class="">

        <input type="radio" id="f-time-one" value="1" name="ContactTime">
        <label for="f-time-one">11:00 AM : 5:00 PM</label>
<br>
        <input type="radio" id="f-time-two" value="2" name="ContactTime">
        <label for="f-time-two">5:00 PM : 11:00 PM</label>
        </div>
    </div>
    <div class="group">
        <div class="col-1">Your massege</div>
        <div class="col-2"><textarea name="massage" id="" cols="30" rows="10" required></textarea></div>
    </div>
    <
    <!-- Terms & Conditions -->
    <!-- <div class="group-2">
        <input type="checkbox" class="checkbox" id="terms" />
        <label for="terms"><span class="toogle"></span>I declare to have read and accepted the <a href="#">terms of service</a></label>
    </div> -->
    <!-- Notifications -->
    <!-- <div class="group-2">
        <input type="checkbox" class="checkbox" id="notifications" />
        <label for="notifications"><span class="toogle"></span>Show me popular news via email</label>
    </div> -->
    <!-- Submit button -->
    <input type="submit" class="submit" value="submit" />
</form>

<div class="col-md-12 distrecs">
<h2 class="uppercase blu-color text-center" style="margin-top: 1vw;margin-left: 40vw;color:white !important;position: absolute;"> {{ @trans('admin.odistric') }}</h2>
<div class="container"style="margin-top: 4.85em;">
    <div class="row">
      <div class="col-md-12 heroSlider-fixed">
        <div class="overlay">
      </div>
         <!-- Slider -->
        <div class="slider responsive-distrecs">
          <div>
            <a href="{{ url(app()->getLocale().'/districts/east') }}"><img  src="{{ url('/website_style/images/Artboard 13.png') }}" alt="" /></a>
            </div>
            <div>
                <a href="{{ url(app()->getLocale().'/districts/west') }}"><img src="{{ url('/website_style/images/Artboard 14.png') }}" alt="" /></a>
            </div>
            <div>
                <a href="{{ url(app()->getLocale().'/districts/north') }}"><img src="{{ url('/website_style/images/Artboard 16.png') }}" alt="" /></a>
            </div>
            <div>
                <a href="{{ url(app()->getLocale().'/districts/redsea') }}"> <img src="{{ url('/website_style/images/Artboard 15.png') }}" alt="" /> </a>
            </div>
            <div>
                <a href="{{ url(app()->getLocale().'/districts/mostkblCity') }}"><img src="{{ url('/website_style/images/Artboard 17.png') }}" alt="" /></a>
            </div>
            <div>
                <a href="{{ url(app()->getLocale().'/districts/Newcapital') }}"> <img src="{{ url('/website_style/images/Artboard 18.png') }}" alt="" /> </a>
            </div>
        </div>				
      </div>
    </div>
  </div>
</div>

<!--Partners-->

<section id="logos">
    <div class="container partner2 padding">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h3 class="uppercase blu-color">{{ __('admin.our_partners') }}</h3>
                <p class="heading_space"></p>
            </div>
        </div>
        <div class="row">
            <div id="partners" class="owl-carousel" style="overflow: visible;">
                @foreach(@App\Developer::where('featured',1)->get() as $developer)
                    <div class="item">
                        <a href="{{ url(app()->getLocale().'/developer/'.slug($developer->{app()->getLocale().'_name'}).'-'.$developer->id) }}">
                            <img src="{{ url('uploads/'.$developer->logo)}}" alt="Featured Partner" style="width: 100px;height: 100px;border-radius: 50%" data-toggle="tooltip" data-placement="right" title="{{ $developer->{app()->getLocale().'_name'} }}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!--Partners Ends-->


<!-- News (Blogs) -->
<div class="col-md-12 news-section" >
    <div class="container">
        <h2 class="section-title" style="text-align: center;">{{ __('admin.home_latest') }}<a href="{{ url('news') }}" class="link-arrow-2 pull-right">{{ __('admin.all_news') }} <i class="icon ion-ios-arrow-right"></i></a></h2>
    </div>
            <div class="container"style="margin-top: 4.85em;">
    <div class="row">
      <div class="col-md-12 heroSlider-fixed">
         <!-- Slider -->
        <div class="slider responsive-blogs">
        @foreach($events as $event)

            <div class="card">
                <div class="card-inner-container">
                    <div class="card-overlay">
                        <div class="overlay-content">
                            <p class="date"></p>
                            <h3 class="overlay-title">Our Mission is to serve you </h3>
                            <p class="desc">Our Mission is to serve you with the best way possible , always find your needs through the market by filtering it for you and giving you the best results .</p>
                            <a class="read-more"href="#">Read More</a>
                        </div>
                    </div>
                    <div class="card-body" >
                        <!-- blog image -->
                       <div class="image">
                            @if(Session::get('Newlang') == 'ar')
                                <a href="{{  url('ar/news/'.$event->id) }}">
                            @elseif(Session::get('Newlang') == 'en')
                            <a href="{{  url('en/news/'.$event->id) }}">
                            @endif
                             <img src="{{ url('uploads/'.$event->image) }}" alt="{{ $event->{app()->getLocale().'_title'} }}" class="img-responsive" />
                            </a>
                        </div>
                    </div>
                    <!-- end blog image -->
                    <!-- blog content -->
                    <div class="proerty_content">
                            <div class="proerty_text">
                                <h3 class="news-title"><a href="{{ url(app()->getLocale().'/news/'.$event->id) }}">{{ $event->{app()->getLocale().'_title'} }}</a></h3>
                                <hr>
                                <p class="news-description">{{ Illuminate\Support\Str::words($event->{app()->getLocale().'_description'}, 50, '...') }}</p>
                            </div>
                    </div>
                    <!-- end blog content -->
                </div>
            </div>

            @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

<!-- End blogs -->





@php
    $header =  $_SERVER['HTTP_USER_AGENT'];
@endphp
@if(stripos($header,'Android') !== false)
    <div class="android-dev" style="position: fixed;bottom: 0;background: #fff;width: 100%;float:right;padding: 20px;z-index: 1000">
        <a href="{{ app()->getLocale().'/'.\App\Setting::first()->play_store }}" style="width: 80%;float: left" >For better experience download our app<img src="{{ url('website_style/images/play-store-icon.png') }}" width="30px"></a>
        <div style="width: 20%;border-left:1px solid #000;float: left" class="dapp-close-btn"><i class="fas fa-times pull-right " style="text-align: center;font-size: 22px"></i></div>
    </div>


@elseif(stripos($header,'iPhone') !== false)
<div class="android-dev" style="position: fixed;bottom: 0;background: #fff;width: 100%;float:right;padding: 20px;z-index: 1000">
    <a href="{{ app()->getLocale().'/'.\App\Setting::first()->apple_store }}" style="width: 80%;float: left" >For better experience download our app<img src="{{ url('website_style/images/apple.png') }}" width="30px"></a>
    <div style="width: 20%;border-left:1px solid #000;float: left" class="dapp-close-btn"><i class="fas fa-times pull-right " style="text-align: center;font-size: 22px"></i></div>
</div>
@endif

<!--Footer-->
@php($contact = @App\Setting::first())
<footer class="col-md-12 col-sm-12 col-xs-12 footer_third" >
    <div class="container padding_top">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="footer_panel bottom30">
                    <a href="{{ url(app()->getLocale().'/') }}" class="logo bottom30"><img src="{{ url('website_style/images/wlogo.png')}}" width="150px" alt="logo"></a>

                        <p class="bottom15">{{ __('admin.footer_text') }}
                        </p>


                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="footer_panel bottom30">
                    <h4 class="bottom30">{{ __('admin.latest_news') }}</h4>
                    @foreach(@App\Event::limit(3)->get() as $news)
                        <div class="media bottom30">
                            <div class="media-body">
                                <a href="{{ url(app()->getLocale().'/events/'.$news->id) }}"><i class="icon-clock5"></i> {{ $news->{app()->getLocale().'_title'} }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="footer_panel bottom30">
                    <h4 class="bottom30"> {{ __('admin.get_in_touch') }}</h4>
                    <div class="agetn-contact-2 bottom30">
                        <p><i class="icon-telephone114"></i>@foreach(@App\HubPhone::all() as $phone) {{ $phone->phone }} @if(!$loop->last) - @endif @endforeach</p>
                        <p><i class=" icon-icons142"></i> <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>

                        <p><i class="icon-browser2"></i>{{str_replace('http://',' ', url('/')) }}</p>
                        <p><i class="icon-icons74"></i> @if(app()->getLocale() == 'en'){{ $contact->address }} @else{{ $contact->ar_address }} @endif</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="footer_panel bottom30">
                    <h4 class="bottom30">{{ __('admin.Subscribe') }}</h4>
                    <p>{{ __('admin.subscribe') }}</p>
                    <form class="top30" method="post" action="{{ url('newsletter') }}">
                        {{ csrf_field() }}
                        <input class="search" name="email" placeholder="{{ __('admin.email_enter') }}" type="text">
                        <button class="button_s" href="#">
                            <i class="icon-mail-envelope-open"></i>
                        </button>
                    </form>
                    <div class="row" style="margin-top: 20px">
                        <div class="col-xs-6">
                            <a href="{{ $contact->play_store }}">
                                <img src="{{ url('website_style/images/googleplay.png') }}" class="col-xs-12" style="padding: 0">
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a href="{{ $contact->apple_store }}">
                                <img src="{{ url('website_style/images/applestore.png') }}" class="col-xs-12" style="padding: 0">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--CopyRight-->
        <div class="copyright_simple">
            <div class="row">
                <div class="col-md-6 col-sm-5 top20 bottom20">
                    <p class="text-left">{!! __('admin.copyright') !!}</p>
                </div>
                <div class="col-md-6 col-sm-7 text-right top15 bottom10">
                    <ul class="social_share">
                        @foreach(@App\HubSocial::all() as $social)
                            <li><a href="{{ $social->link }}" ><img src="{{ url('uploads/'.$social->web_icon) }}" style="height: 30px"></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>




<script src="{{  asset('website_style/js/jquery-2.1.4.js')}}"></script>
<script src="{{  asset('website_style/js/bootstrap.min.js')}}"></script>
<script src="{{  asset('website_style/js/jquery.appear.js')}}"></script>
<script src="{{  asset('website_style/js/jquery-countTo.js') }}"></script>
<script src="{{  asset('website_style/js/bootsnav.js') }}"></script>
<script src="{{  asset('website_style/js/masonry.pkgd.min.js') }}"></script>
<script src="{{  asset('website_style/js/jquery.parallax-1.1.3.js') }}"></script>
<script src="{{  asset('website_style/js/jquery.cubeportfolio.min.js') }}"></script>
<script src="{{  asset('website_style/js/range-Slider.min.js') }}"></script>
<script src="{{  asset('website_style/js/owl.carousel.min.js') }}"></script>
<script src="{{  asset('website_style/js/selectbox-0.2.min.js') }}"></script>
<script src="{{  asset('website_style/js/zelect.js') }}"></script>
<script src="{{  asset('website_style/js/jquery.fancybox.js') }}"></script>
<script src="{{  asset('website_style/js/jquery.themepunch.tools.min.js') }}"></script>
<script src="{{  asset('website_style/js/jquery.themepunch.revolution.min.js') }}"></script>
<script src="{{  asset('website_style/js/revolution.extension.actions.min.js') }}"></script>
<script src="{{  asset('website_style/js/revolution.extension.layeranimation.min.js') }}"></script>
<script src="{{  asset('website_style/js/revolution.extension.navigation.min.js') }}"></script>
<script src="{{  asset('style/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{  asset('website_style/js/revolution.extension.parallax.min.js') }}"></script>
<script src="{{  asset('website_style/js/revolution.extension.slideanims.min.js') }}"></script>
<script src="{{  asset('website_style/js/revolution.extension.video.min.js') }}"></script>
<script src="{{  asset('website_style/js/custom.js') }}"></script>
<script src="{{  asset('website_style/js/functions.js') }}"></script>
<script src="{{  asset('website_style/css/slick/slick.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/solid.js" integrity="sha384-+Ga2s7YBbhOD6nie0DzrZpJes+b2K1xkpKxTFFcx59QmVPaSA8c7pycsNaFwUK6l" crossorigin="anonymous"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/fontawesome.js" integrity="sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c" crossorigin="anonymous"></script>
@yield('js')
<script>
$('.responsive').slick({
autoplay:true,
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
<script>
$('.responsive-distrecs').slick({
autoplay:true,
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
<script>
$('.responsive-blogs').slick({
autoplay:true,
  dots: true,
	prevArrow: $('.prev'),
	nextArrow: $('.next'),
  infinite: false,
  speed: 300,
  slidesToShow: 4,
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

<script>
    $(document).ready(function () {
		setTimeout(function() {
			$('#admodal').find('.item').first().addClass('active');
		    $('#admodal').modal({
		    	backdrop: 'static',
	    		keyboard: false
		    });
		}, 3000);
	    $('#adCarousel').carousel({
		  interval: 4000,
		  cycle: true
		});
	    
	    $("#buttonSuccess").click(function(e){
	    	e.preventDefault();
	    	var url = $(this).attr("href");
	    	var win = window.open(url, '_blank');
	    	$('#admodal').modal('hide');
	    })
        $('.checkbox').attr('name', 'facilities[]');
    });
</script>
<script>
    $('.dapp-close-btn').on('click',function () {
        $('.android-dev').addClass('hidden');
    });
    $('.dapp-close-btn').on('click',function () {
        $('.ios-dev').addClass('hidden');
    });
</script>
<script>
    $('.select2').select2();
    $(document).on('click', '#price_range', function () {
        $('#min_price').val($('#mi_price').text());
        $('#max_price').val($('#ma_price').text());
    })
    $(document).on('click', '#area_range', function () {
        $('#min_area').val($('#mi_area').text());
        $('#max_area').val($('#ma_area').text());
    })
    $('#non_project').hide();
    $(document).on('change', '#property_type', function () {
        if ($(this).val() == "project") {
            $('#non_project').hide();
            $('#facility1').show();
            $('#price_range').nstSlider('set_range', parseInt("{{ $search['data']['project_min_price'] }}"), parseInt("{{ $search['data']['project_max_price'] }}"));
            $('#area_range').nstSlider('set_range', parseInt("{{ $search['data']['project_min_area'] }}"), parseInt("{{ $search['data']['project_max_area'] }}"));
            $('#price_range').nstSlider('set_position', parseInt("{{ $search['data']['project_min_price'] }}"), parseInt("{{ $search['data']['project_max_price'] }}"));
            $('#area_range').nstSlider('set_position', parseInt("{{ $search['data']['project_min_area'] }}"), parseInt("{{ $search['data']['project_max_area'] }}"));
            $('#price_lable').text("{{ trans('admin.price') }}");
            $('#min_price').val($('#mi_price').text());
            $('#max_price').val($('#ma_price').text());
            $('#min_area').val($('#mi_area').text());
            $('#max_area').val($('#ma_area').text());
        }
        else if ($(this).val() == "resale") {
            $('#non_project').show();
            $('#facility1').hide();
            $('#price_range').nstSlider('set_range', parseInt("{{ $search['data']['resale_min_price'] }}"), parseInt("{{ $search['data']['resale_max_price'] }}"));
            $('#area_range').nstSlider('set_range', parseInt("{{ $search['data']['resale_min_area'] }}"), parseInt("{{ $search['data']['resale_max_area'] }}"));
            $('#price_range').nstSlider('set_position', parseInt("{{ $search['data']['resale_min_price'] }}"), parseInt("{{ $search['data']['resale_max_price'] }}"));
            $('#area_range').nstSlider('set_position', parseInt("{{ $search['data']['resale_min_area'] }}"), parseInt("{{ $search['data']['resale_max_area'] }}"));
            $('#price_lable').text("{{ trans('admin.price') }}");
            $('#min_price').val($('#mi_price').text());
            $('#max_price').val($('#ma_price').text());
            $('#min_area').val($('#mi_area').text());
            $('#max_area').val($('#ma_area').text());
        }
        else if ($(this).val() == "rental") {
            $('#non_project').show();
            $('#facility1').hide();
            $('#price_range').nstSlider('set_range', parseInt("{{ $search['data']['rental_min_price'] }}"), parseInt("{{ $search['data']['rental_max_price'] }}"));
            $('#area_range').nstSlider('set_range', parseInt("{{ $search['data']['rental_min_area'] }}"), parseInt("{{ $search['data']['rental_max_area'] }}"));
            $('#price_range').nstSlider('set_position', parseInt("{{ $search['data']['rental_min_price'] }}"), parseInt("{{ $search['data']['rental_max_price'] }}"));
            $('#area_range').nstSlider('set_position', parseInt("{{ $search['data']['rental_min_area'] }}"), parseInt("{{ $search['data']['rental_max_area'] }}"));
            $('#price_lable').text("{{ trans('admin.rent') }}");
            $('#min_price').val($('#mi_price').text());
            $('#max_price').val($('#ma_price').text());
            $('#min_area').val($('#mi_area').text());
            $('#max_area').val($('#ma_area').text());
        }
    })
</script>
<script>
    $(document).ready(function () {
        $('.checkbox').attr('name', 'facilities[]');
    });
</script>
<script>
    $(".center").slick({
        dots: false,
        infinite: true,
        centerMode: true,
        autoplay:true,
        slidesToShow: 3,
        centerPadding: '-120px',
        arrows:true,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1000,
                settings: {
                    arrows: true,
                    centerMode: true,
                    centerPadding: '0px',
                    slidesToShow: 1,
                }
            }
            ,
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '0px',
                    slidesToShow: 1,
                    autoplay:true,
                }
            }

        ]
    });
    $(".center2").slick({
        dots: false,
        infinite: true,
        autoplay:true,
        slidesToShow: 1,
        centerMode: true,
        centerPadding: '20px',
        variableWidth: true,
        slidesToScroll: -1,
        arrows:true,
        rtl: true,
        responsive: [

            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '200px',
                    slidesToShow: 1,
                    variableWidth: true,
                    variableHeight: true,
                    autoplay:true,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '50px',
                    slidesToShow: 1,
                    variableWidth: true,
                    variableHeight: true,
                    autoplay:true,
                }
            }
        ]
    });
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

</script>
<script>
    var show = true;
    $('.more-filter').on('click',function () {

        if(show==true)
        {
            $('.social').addClass('hidden');
            show=false;
        }

        else
        {
            show=true;
            $('.social').removeClass('hidden');
        }


    });


    $(document).ready(function () {
        $('.checkbox').attr('name','facility[]')
    })
</script>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '2251185615170512'); 
fbq('track', 'PageView');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=2251185615170512&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->



@yield('js')
</body>
</html>

