<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title></title>
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  
        <link rel="stylesheet" href="{{ asset('scss/style.css') }}">

  
</head>
    <style>
        .box_1 {
        background-image: url("/uploads/{{ $setting->backgroundRequest }}");
        }

        .box_2 {
            background-image: url("/uploads/{{ $setting->backgroundRequest }}");
        }

        .box_3 {
            background-image: url("/uploads/{{ $setting->backgroundRequest }}");
        }

        .box_4 {
            background-image: url("/uploads/{{ $setting->backgroundRequest }}");
        }

        .box_5 {
            background-image: url("/uploads/{{ $setting->backgroundRequest }}");
        }
    </style>
<body>
<div class="container">
    <form method="POST" action="{{ url('/sendsubrequest') }}">
        {{ csrf_field() }}
        <div class="box box_1">
            <div class="text-center padding">
                <img class="logo" src="{{ url('/uploads/'.$setting->logoRequest) }}" height="200px" alt="">
            </div>
            <div class="form-group">
                <h2 for="intrested"> Location you are intrested in *</h2>
                <div class="center-align">
                <ul>
                @foreach($locations as $location)
                    <li class="locations">
                        <input type="radio" value="{{ $location->id }}" id="{{ $location->id }}-option" name="location_id">
                        <label for="{{ $location->id }}-option">{{ $location->en_name }}</label>
                        <div class="check">
                            <div class="inside"></div>
                        </div>
                    </li>
                @endforeach
                </ul>
                </div>
            </div>
        </div>

        <div class="box box_2 under">
            <div class="text-center padding">
                    <img class="logo" src="{{ url('/uploads/'.$setting->logoRequest) }}" height="200px" alt="">
            </div>
            <div class="form-group">
                <h2 for="Unit_type"> Unit type you are intrested in * </h2>
                <div class="center-align">
                <ul>
                @foreach($unitTypes as $type)
                    <li>
                        <input type="radio" id="f-option-{{ $type->id }}" value="{{ $type->id }}" name="unit_type_id">
                        <label for="f-option-{{ $type->id }}">{{ $type->en_name }}</label>
                        <div class="check"></div>
                    </li>
                @endforeach
                </ul>
                </div>
            </div>

        </div>


        <div class="box box_3 under">
            <div class="text-center padding">
                <img class="logo" src="{{ url('/uploads/'.$setting->logoRequest) }}" height="200px" alt="">
            </div>
            <div class="col-md-6 form-group" style="margin-top: 10rem;">
                <div class="form-group @if($errors->has('en_name')) has-error @endif">
                <h2 for="Name"> Your name * </h2>
                <input type="text" name="fullName" value="{{ old('fullName') }}" class=" inputField form-control" >
                </div>
                <h2 for="Name"> Email * </h2>
                <input type="email" name="email" class="inputField form-control" value="{{ old('email') }}" >
                <h2 for="Name"> Your phone number * </h2>
                <input type="number" name="phone" value="{{ old('phone') }}" class="inputField form-control" >

                <div class="checkTime">
                <h2 for="">Your best time to be contacted</h2>
                    <ul>
                        <li>
                            <input type="radio" id="f-time-one" value="1" name="ContactTime">
                            <label for="f-time-one">11:00 AM : 5:00 PM</label>
                            <div class="check"></div>
                        </li>
                        <li>
                            <input type="radio" id="f-time-two" value="2" name="ContactTime">
                            <label for="f-time-two">5:00 PM : 11:00 PM</label>
                            <div class="check"></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="box box_4 under">
            <div class="text-center padding">
                <img class="logo" src="{{ url('/uploads/'.$setting->logoRequest) }}" height="200px" alt="">
            </div>

            <div class="col-md-6 form-group" style="margin-top: 10rem;">
            <h2 for="Massage">Massage</h2>
            <textarea required name="massage" id="" rows="10" class="inputField form-control" ></textarea>
            <br>
            <button class="btn btn-block bb" type="submit"> Send <i class="fa fa-send"></i> </button>
            </div>
        </div>
    </form>
</div>
<script  src="{{ asset('scss/js/index.js') }}"></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

</body>

</html>
