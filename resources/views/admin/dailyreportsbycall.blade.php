@extends('admin.index')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Agent Status Report By Call</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="form-group col-md-6">
                <label>Agent Name</label>
                <select multiple id="agent-id" style="width: 100%" class="form-control select2"
                        data-placeholder="Agent Name">
                    <option></option>
                    @foreach($agents as $agent)
                        <option value="{{$agent->id}}">{{ $agent->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6">
                <label>Lead Source</label>
                <select multiple id="source-id" style="width: 100%" class="form-control select2"
                        data-placeholder="Lead Source">
                    <option></option>
                    @foreach($lead_sources as $source)
                        <option value="{{$source->id}}">{{ $source->name }}</option>
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

            <div class="form-group col-md-12">
                <button type="button" id="submit" class="btn btn-primary btn-flat">
                    Get <i class="fa fa-spinner fa-spin hidden" id="leadData"></i>
                </button>
            </div>
            <div class="form-group col-md-12" id="error-placeholder"></div>
            <div class="box-body" id="getReportForm"></div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).on('click', '#submit', function () {
            $('#error-placeholder').html("");

            var agents = [];
            var sources = [];
            var fromDate = $('#fromDate').val();
            var toDate = $('#toDate').val();
            var _token = '{{ csrf_token() }}';
            fromDate = $.datepicker.formatDate("yy-mm-dd", new Date(fromDate));
            toDate = $.datepicker.formatDate("yy-mm-dd", new Date(toDate));
            console.log(fromDate);
            console.log(toDate);
            // var fDate = new Date(fromDate.split("/").join("-"));
            // var tDate = new Date(toDate.split("/").join("-"));
            if (!(toDate >= fromDate)) {
                $('#error-placeholder').html("<h1 style='text-align: center'>Not valid date range</h1>");
                return false;
            }

            $('#agent-id option:selected').each(function(i, item){
                agents.push($(item).val());
            });

            $('#source-id option:selected').each(function(i, item){
                sources.push($(item).val());
            });

            $.ajax({
                url: "{{ url(adminPath().'/getdailyreportsbycall') }}",
                method: 'post',
                dataType: 'html',
                data: {agents: agents, sources: sources, fromDate: fromDate, toDate: toDate, _token: _token},
                success: function (data) {
                  //console.log(data);
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
