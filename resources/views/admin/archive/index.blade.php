@extends('admin.index')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Archive</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <form class="" action="/admin/archive" method="post">
                {{ csrf_field() }}
                <div class="form-group col-md-4">
                    {{-- <label>Agent Name</label> --}}
                    {{-- <div class="checkbox"> --}}
                      <label><input type="checkbox" value="5" name="answered_not_interest">answered not interest</label>
                    {{-- </div> --}}
                </div>
                <div class="form-group col-md-4">
                    {{-- <label>Agent Name</label> --}}
                      <label><input type="checkbox" value="8" name="wrong_number"> Wrong Number</label>
                </div>
                <div class="form-group col-md-4">
                    {{-- <label>Agent Name</label> --}}
                    {{-- <div class="checkbox"> --}}
                      <label><input type="checkbox" value="lowest" name="probability">Lowest</label>
                    {{-- </div> --}}
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary btn-flat">
                        proceed<i class="fa fa-spinner fa-spin hidden" id="leadData"></i>
                    </button>
                </div>
            </form>


            <table class="table table-bordered table-hover datatable">
                <thead>
                <tr>
                    <th>{{ __('admin.id') }}</th>
                    <th>{{ __('admin.name') }}</th>
                    <th>{{ __('admin.phone') }}</th>
                    <th>{{ __('admin.description') }}</th>
                    <th>{{ __('admin.date') }}</th>
                </tr>
                </thead>
                <tbody id="leads">
                {{-- @foreach($calls as $call)
                    <tr>
                        <td>{{ $lead->id }}</td>
                        <td>{{ $lead->first_name .''. $lead->last_name }}</td>
                        <td>{{ $lead->phone }}</td>
                        <td>
                            @php( $str = '')
                            @foreach($lead->calls as $call)
                                @php( $str .= $call->call_status->name . ' --- ')
                            @endforeach
                            {{$str}}
                        </td>
                        <td>
                            @php($str = '')
                            @foreach($lead->calls as $call)
                                @php($str .= $call->description . ' --- ')
                            @endforeach
                            {{$str}}
                        </td>
                        <td>
                            {{$lead->source->name}}
                        </td>
                        <td>{{ $lead->created_at }}</td>
                    </tr>
                @endforeach --}}
                </tbody>
            </table>


            {{-- <span id="getReportForm"></span> --}}
        </div>
    </div>
@endsection
@section('js')
    <script>
        // $(document).on('click', '#submit', function () {
        //     var agentId = $('#agent-id').val();
        //     var date = $('#date').val();
        //     var _token = '{{ csrf_token() }}';
        //     $.ajax({
        //         url: "{{ url(adminPath().'/getdailyreports') }}",
        //         method: 'post',
        //         dataType: 'html',
        //         data: {agentId: agentId, date: date, _token: _token},
        //         success: function (data) {
        //             $('#getReportForm').html(data);
        //             // $('.select2').select2();
        //             // $('.datepicker').datepicker({
        //             //     format: 'yyyy-mm-dd',
        //             //     autoclose: true,
        //             // });
        //
        //         }
        //     })
        // })
    </script>
@endsection
