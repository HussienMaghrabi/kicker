@extends('admin.index')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $title }}</h3>
            <div class="box-tools pull-right">
            </div>
        </div>
        <div class="box-body">
        {!! Form::open(['url' => adminPath().'/popup/1','method' => 'post', 'files' => true]) !!}
            {{ csrf_field() }}
                <div class="form-group">
                    <label for="">Background Image</label>
                    <input type="file" name="backgroundRequest" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">logo Image</label>
                    <input type="file" name="logoRequest" class="form-control">
                </div>
                <div class="form-group padding">
                    <button class="btn btn-info btn-sm"><i class="fa fa-send"></i>  Go</button>
                </div>
                {!! Form::close() !!}
        </div>
        <div class="box-body">
        <table class="table datatable table-striped table-bordered  dt-responsive nowrap"style="width:100%">
                <thead>
                <tr>
                    <th>{{ trans('admin.id') }}</th>
                    <th>Page name</th>
                    <th>active</th>
                </tr>
                </thead>
                <tbody>
                @foreach($popups as $pop)
                    <?php
                        $GetNameArray = explode("_",$pop->page_name)[1]
                    ?>
                    <tr>
                        <td>{{ $pop->id }}</td>
                        <td>{{ $GetNameArray }}</td>
                        <td>
                        <div class="form-group"
                         id="">
                        <input type="hidden" name="activepop" value="0">
                        <input type="checkbox" name="activepop" id="activepop" class="switch-box"
                                data-on-text="{{ __('admin.yes') }}"
                                data-off-text="{{ __('admin.no') }}"
                                @if($pop->active) checked @endif value="1">
                        </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @section('js')
        <script>
            
        </script>
    @endsection
@endsection