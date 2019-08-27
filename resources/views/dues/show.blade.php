@extends('admin.index')

@section('content')
        <div class="container">
            ID:<h3>{{$Selected_id->id}}</h3>
            Value:<h3>{{$Selected_id->value}}</h3>
            Date:<h3>{{$Selected_id->date}}</h3>
            Collected:<h3>{{$Selected_id->collected}}</h3>
        </div>
@endsection
