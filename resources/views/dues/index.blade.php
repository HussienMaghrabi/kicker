@extends('admin.index')

@section('content')
        <div class="box-body">
            <hr>
            <a href="{{ action('DuesController@create') }}" class="btn btn-primary btn-flat" style="color:#fff;">Create</a>
            <br><br>
            <table class="table datatable table-striped table-bordered  dt-responsive nowrap"style="width:100%">
                <thead>
                <tr>
                    <th>{{ trans('ID') }}</th>
                    <th>{{ trans('Value') }}</th>
                    <th>{{ trans('Date') }}</th>
                    <th>{{ trans('Collected') }}</th>
                    <th>{{ trans('Show') }}</th>
                    <th>{{ trans('Edit') }}</th>
                    <th>{{ trans('Delete') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($dues as $due)
                    <tr>
                        <td>{{ $due->id }}</td>
                        <td>{{ $due->value }}</td>
                        <td>{{ $due->date }}</td>
                        <td>{{ $due->collected }}</td>
                        <td><a href="{{ url(adminPath().'/dues/'.$due->id) }}" class="btn btn-primary btn-flat">Show</a></td>
                        <td><a href="{{ url(adminPath().'/dues/'.$due->id.'/edit') }}" class="btn btn-warning btn-flat">Edit</a></td>
                        <td>
                            <form method="POST" action={{url('/admin/dues/'.$due->id)}} >
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            <button type="submit"  class="btn btn-danger btn-flat">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
