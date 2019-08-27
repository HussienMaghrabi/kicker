@extends('website.index')
@section('content')
<style>
    .intrest-job{
        padding:7rem;
    }
    .contentjob{
        padding: 7rem 1rem;
    }
    .intrestbtn .btn{
        margin:auto;
        padding:2rem;
    }
    .modal-body{
        background-color:whitesmoke;
    }
    .form-control{
        height:4em !important;
    }
    .modal-header{
        background-color:whitesmoke;
        padding: 2em 1em;
    }
    @media screen and (max-width: 768px) {
        .intrest-job{
            padding:0rem;
            margin-top:6em;
        }
    }
</style>
    <div class="intrest-job">
        <div class="container">
        @include('website.error')
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-8 col-sm-8 col-xs-8">
                    <div class="job-i-title">
                        <h4>Job title</h4>
                        <br>
                        <span> Date : {{ $data->created_at }} &nbsp | &nbsp category : {{ $data->cat_name_en }} &nbsp | &nbsp type : {{ $data->type }}<span>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="applay-header">
                        <!-- <button class="btn bt-block btn-info"> Applay Now <i class="fa fa-send"></i> </button> -->
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="contentjob">
                    {{ $data->en_description }}
                </div>
            </div>
            <div class="col-md-12">
                <div class="intrestbtn pull-left">
                    <button class="btn btn-info btn-block" data-toggle="modal" data-target="#exampleModalLong"> <i class="fa fa-send"></i> {{ trans('admin.apply') }} </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header text-center">
            <h4 class="modal-title" id="exampleModalLongTitle">Apply to {{ $data->en_name }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ url('/applay_job') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="text" name="vacancy_id" value="{{ $data->id }}" hidden>
                <input type="text" name="job_title_id" value="{{ $data->title_id }}" hidden>
                <input type="text" name="job_category_id" value="{{ $data->category_id }}" hidden>
                <input type="text" name="applied_date" value="{{ date('d-m-y') }}" hidden>
                <div class="row">
                    <div class="form-group col-md-12 col-sm-12 col-xs-12 @if($errors->has('f_name')) has-error @endif">
                        <label for="f_name"> First Name </label>
                        <input type="text" id="f_name" name="f_name" class="form-control" placeholder=" First Name ">
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-xs-12 @if($errors->has('l_name')) has-error @endif">
                        <label for="l_name"> Last Name </label>
                        <input type="text" id="l_name" name="l_name" class="form-control" placeholder=" Last Name ">
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-xs-12 @if($errors->has('email')) has-error @endif">
                        <label for="email"> email </label>
                        <input type="email" id="email" name="email" class="form-control" placeholder=" exsampl@mail.com ">
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-xs-12 @if($errors->has('phone')) has-error @endif">
                        <label for="phone"> Phone </label>
                        <input type="number" id="phone" name="phone" class="form-control" placeholder=" Phone ">
                    </div>
                    <div class="file_uploader bottom20 col-sm-12 text-center padding">
                        <div class="box col-sm-12 col-md-12 col-xs-12 @if($errors->has('image')) has-error @endif">
                            <label class="col-sm-12" style="margin: 0 30px">{{ __('admin.main_image') }}</label>
                            <input type="file" name="cv" style="display: none;" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple />
                            <label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose a file&hellip;</span></label>
                        </div>
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-xs-12 @if($errors->has('location')) has-error @endif">
                        <label for="location"> Location </label>
                        <input type="text" id="location" name="location" class="form-control">
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-xs-12 @if($errors->has('linkprofile')) has-error @endif">
                        <label for="linkprofile"> LinkedInProfile  </label>
                        <input type="text" id="linkprofile" name="linkprofile" class="form-control">
                    </div>
                    <div class="form-group col-md-12 col-sm-12 col-xs-12 @if($errors->has('website')) has-error @endif">
                        <label for="Website"> Website  </label>
                        <input type="text" id="Website" name="website" class="form-control">
                    </div>
                </div>
        </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-secondary" data-dismiss="modal">Close</a>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- end bootstrap modal -->

@endsection