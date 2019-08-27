@extends('website.index')
@section('content')
<style>
    .carrerspage{
        padding:7rem;
    }
    .job_content{
        background-color:whitesmoke;
        padding:.9em;
        height:18em;
    }
    .card{
        background-color:whitesmoke;
        height:27em;
        margin-bottom:2em;
    }
    .card-title{
        background-color:#d6bc8a;
    }
    .applay .btn{
        width:50%;
        margin:auto;
    }
    @media screen and (max-width: 768px) {
        .carrerspage{
            padding:1rem;
        }
        .job_content{
            height:18em
        }
    }
</style>
    <div class="carrerspage">
        <div class="row">
            @foreach($data as $d)
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title text-center padding">
                                <strong> {{ $d->en_name }} </strong>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="padding text-center">
                                <div class="job_content">
                                    <p> {{ Illuminate\Support\Str::words($d->en_description, 70, '...') }} </p>
                                </div>
                                <div class="applay">
                                <a href="{{ url(app()->getlocale().'/intrested_jobs/'.$d->id) }}" class="btn btn-info btn-block" > <i class="fa fa-send"> </i>{{ @trans('admin.interested') }} </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center">
            {{ $data->links() }}
        </div>
    </div>
@endsection