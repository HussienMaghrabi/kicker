@extends('website.index')
@section('content')
    <style>
    .min-developer{
        padding:7vw;
    }
    .min-developer hr{
        padding:.4rem black solid;
    }
    .deve-card {
        display: flex;
        flex-direction: column;
        width: 280px;
        height: 320px;
        justify-content: center;
        background: white;
        border: 1px solid #ddd;
        padding: 20px 20px;
        margin: 3px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        z-index: 2;
        margin-left:3vw;
        margin-bottom:1vw;
    }
    .deve-card:hover {
        box-shadow: 0 8px 16px 0 rgba(5, 41, 158, 0.2);
        transform: scale(1.1);
        opacity: 0.5;
    }
    .dev-image img{
        width:100%;
    }
    </style>
    <div class="min-developer">
        <div class="row">
            @foreach($developers as $developer)
                <div class="deve-card col-md-3">
                    <div class="dev-image col-md-12">
                        <a href="{{ url(app()->getLocale().'/developer/'.slug($developer->{app()->getLocale().'_name'}).'-'.$developer->id) }}">
                            <img src="{{ url('uploads/'.$developer->logo) }}" alt="">
                        </a>
                    </div>
                    <hr style="color:black">
                    <div class="dev-button col-md-12">
                        <a href="{{ url(app()->getLocale().'/developer/'.slug($developer->{app()->getLocale().'_name'}).'-'.$developer->id) }}" class="btn btn-default btn-block"> {{ @trans('admin.read_more') }} </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="paginate text-center">
            {{ $developers->links() }}
        </div>
    </div>
@endsection