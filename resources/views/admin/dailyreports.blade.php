@extends('admin.index')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Agent Status Report</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="form-group col-md-6">
                <label>Agent Name</label>
                <select id="agent-id" multiple style="width: 100%" class="form-control select2"
                        data-placeholder="Agent Name">
                    <option></option>
                    @foreach($agents as $agent)
                        <option value="{{$agent->id}}">{{ $agent->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>From</label>
                <input type="text" readonly="" class="form-control datepicker" id="fromDate">
            </div>
            <div class="form-group col-md-3">
                <label>To</label>
                <input type="text" readonly="" class="form-control datepicker" id="toDate">
            </div>
            <div class="form-group col-md-12" id="error-placeholder">
            </div>
            <div class="form-group col-md-6">
                <button type="button" id="submit" class="btn btn-primary btn-flat">
                    Get <i class="fa fa-spinner fa-spin hidden" id="leadData"></i>
                </button>
            </div>
            <div class="box-body" id="getReportForm"></div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).on('click', '#submit', function () {
            $('#error-placeholder').html("");
            var fromDate = $('#fromDate').val();
            var toDate = $('#toDate').val();

            fromDate = $.datepicker.formatDate("yy-mm-dd", new Date(fromDate));
            toDate = $.datepicker.formatDate("yy-mm-dd", new Date(toDate));
            console.log(fromDate);
            console.log(toDate);
            if (!(toDate >= fromDate)) {
                $('#error-placeholder').html("<h1 style='text-align: center'>Not valid date range</h1>");
                return false;
            }

            var agents = [];
            $('#agent-id option:selected').each(function(i, item){
                agents.push($(item).val());
            });
            var _token = '{{ csrf_token() }}';
            $.ajax({
                url: "{{ url(adminPath().'/getdailyreports') }}",
                method: 'post',
                dataType: 'html',
                data: {agents: agents, fromDate: fromDate, toDate: toDate, _token: _token},
                success: function (data) {
                    $('#getReportForm').html(data);
                    // $('.select2').select2();
                    // $('.datepicker').datepicker({
                    //     format: 'yyyy-mm-dd',
                    //     autoclose: true,
                    // });

                }
            })
        })
    </script>
@endsection
