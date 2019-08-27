<!DOCTYPE html>
@php($setting=\App\Setting::first())
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$setting->title}}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
    .bodyHome{
        background:url('{{url("images/BGlandingpage.jpg")}}') no-repeat;
        background-size: cover;
        margin:0px;
        padding:0px;
        width:100%;
        min-height:952px;
    }
    .main-body{
    }
    ul.social_share{
    }
    ul.social_share li a {
        /* background: #fff; */
        color: #b07d12;
        border-radius: 50%;
        box-shadow: 1px 1px 2px #6f6f6f;
        display: block;
        font-size: 15px;
        height: 50px;
        line-height: 30px;
        width: 50px;
        margin-right: 5px;
        z-index: 1;
        position: relative;
    }
    ul.social_share li{
        float:left;
    }
    ol, ul {
        padding: 0;
        margin: 0;
        list-style: none;
    }
    .about{
        color:white;
        text-align:center;
        margin-bottom:30px;
    }
    .form-control{
        border-radius:0px !important;
        margin-right: 1px;
        margin-left: 1px;
    }
    .btn-submit{
        background:#5F5B5C;
        color:white;
        border-color:#5F5B5C;
        padding-top:2px;
        padding-bottom:2px;
    }
    .rightSide{
        border-left:2px solid #FFF;
        border-radius:3px;
        color:white;
        padding-left:0px;
        text-align:center;
        
    }
    @media (max-width:768px){
        .rightSide{
        border:none;
        margin-bottom:100px;
        }
        ul.social_share{
        margin-top:0px !important;
        margin-bottom:100px;
        position:absolute;
        top:-320px ;
        }
        .form-control{
            margin-bottom:2px;
        }
    }
    
    </style>
</head>
<body class="bodyHome">
<div class="row">
    <div class="col-2"></div>

    <div class="col-8" >
                        <div class="row" style="margin-top:100px;margin-bottom:50px;">
                            <div class="col-md-8 col-sm-12" style="text-align:center;" ><img  src='{{url('uploads/'.$setting->logo)}}'/></div>

                            <div class="col-md-4 col-sm-12 text-right top15 bottom10">
                                <ul class="social_share">
                                    @foreach(@App\HubSocial::all() as $social)
                                        <li><a href="{{ $social->link }}" ><img src="{{ url('uploads/'.$social->web_icon) }}" style="height: 40px"></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="row about">
                            <p>{{$setting->about_hub}}</p>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <form  action="">
                                    <div class="form-group row">
                                        <input class="form-control col-md-5 col-sm-12" placeholder="FIRST NAME" name="first_name" type="text"/>
                                        <input class="form-control col-md-5 col-sm-12" placeholder="LAST NAME" name="last_name" type="text"/>
                                    </div>
                                    <div class="form-group row">
                                        <select class="form-control col-md-5 col-sm-12" placeholder="REQUEST TYPE" name="request_type" type="text">
                                            <option selected disabled>REQUEST TYPE</option>
                                            <option value="resale">{{ trans('admin.resale') }}</option>
                                            <option value="rental">{{ trans('admin.rental') }}</option>
                                            <option value="prime">{{ trans('admin.prime') }}</option>
                                        </select>
                                        <input class="form-control col-md-5 col-sm-12" placeholder="PHONE" name="phone" type="number"/>
                                    </div>
                                    <div class="form-group row">
                                        <input class="form-control col-md-10 col-sm-12" style="marign-right:0px !important;" placeholder="EMAIL" name="email" type="number"/>
                                    </div>
                                    <div class="form-group row">
                                        <textarea rows="4" class="form-control col-md-10 col-sm-12" style="marign-right:0px !important;" placeholder="DISCRIPTION" name="info" ></textarea>
                                    </div>
                                    <div class="form-group row">
                                        <button class="btn-submit col-md-10 col-sm-12" style="marign-right:0px !important;" type="submit">SUBMIT</button>
                                    </div>
                                </form>
                            </div>
                            <div class="rightSide" class="col-md-6 col-xs-12">
                                    <br/>
                                    <br/>
                                    <bold><h3>Call Us</h3></bold>
                                    <h4>{{\App\HubPhone::first()->phone}}</h4>
                                    <br/>
                                    <br/>
                                    <br/>
                                    <bold><h3>Or Visit US</h3></bold>
                                    <h6>&nbsp;&nbsp;&nbsp;{{$setting->address}}</h6>

                            </div>
                        </div>
    </div>
    <div class="col-2"></div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>