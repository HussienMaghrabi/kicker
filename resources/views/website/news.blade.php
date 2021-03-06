@extends('website.index')
@section('content')
<!-- Page Banner Start-->
<style>
    .page-banner-bg{
        background: url("{{ url('website_style/images/blog.jpg') }}");
        background-size: contain !important;
        background-attachment: fixed;
        min-height: 130px;
    }
</style>
<section class="page-banner page-banner-bg padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="p-white text-uppercase">{{ __('admin.news')}}</h1>
            </div>
        </div>
    </div>
</section>
<!-- Page Banner End -->


<!-- News Start -->
<section id="news-section-1" class="property-details padding_top">
    <div class="container property-details">
        <div class="row">
            <div class="col-md-8">
                <div class="row">

                    @foreach($events as $event)
                        <div class="news-1-box clearfix">
                            <div class="col-xs-12">
                                <div class="image bottom30">
                                    <a style="color:#414561" href="{{ url('news/'.$event->id) }}"><img src="{{ url('uploads/'.$event->image) }}" alt="{{ $event->{app()->getLocale().'_title'} }}" class="img-responsive"/></a>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="news-details bottom15">
                                    <span><i class="icon-icons228"></i>{{ date('M d Y',strtotime($event->date)) }} </span>
                                </div>
                                <h3 class="bottom10"><a href="{{ url('news/'.$event->id) }}">{{ $event->{app()->getLocale().'_title'} }}</a></h3>
                                <p class="bottom20">{{ Illuminate\Support\Str::words($event->{app()->getLocale().'_description'}, 50, '...') }}</p>
                                <div class="pro-3-link padding-t-20">
                                    <a class="btn-dark border_radius" href="{{ url('news/'.$event->id) }}">Read More</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row margin_bottom">
                    <div class="col-md-12">
                        <ul class="pager">
                            {{ $events->links() }}
                        </ul>
                    </div>
                </div>
            </div>
            <aside class="col-md-4 col-xs-12 ">
                <div class="property-query-area clearfix">
                    @include('website/search')
                </div>
                @include('website.featured_projects',['featured',$featured])
            </aside>
        </div>
    </div>
</section>
<!-- News End -->
@endsection