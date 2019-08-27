
<table class="table datatable table-striped table-bordered  dt-responsive nowrap" id="printTable" style="width:100%">
    <thead>
    <tr>
        <th>{{ __('admin.id') }}</th>
        <th>{{ __('admin.agent') }}</th>
        <th>{{ __('admin.name') }}</th>
        <th>{{ __('admin.phone') }}</th>
        <th>Calls Status</th>
        <th>{{ __('admin.description') }}</th>
        <th>Lead Source</th>
        <th>{{ __('admin.date') }}</th>
    </tr>
    </thead>
    <tbody id="leads">

        @foreach($calls as $key => $call)

                <tr>
                    <td>{{ $key + 1  }}</td>
                    <td>{{ $call->user->name }}</td>
                    <td>{{ $call->lead->first_name .''. $call->lead->last_name }}</td>
                    <td>{{ $call->lead->phone }}</td>
                    <td>{{ $call->call_status->name }}</td>
                    <td>{{ $call->description }}</td>
                    <td>"{{$call->lead->source->name}}"</td>
                    <td>{{ $call->created_at }}</td>
                </tr>

        @endforeach
    </tbody>
</table>

<button id="print">Print me</button>

<script>
    function printData()
    {
       var divToPrint=document.getElementById("printTable");
       newWin= window.open("");
       newWin.document.write(divToPrint.outerHTML);
       newWin.print();
       newWin.close();
    }

    $('#print').on('click',function(){
        printData();
    })
    $('.datatable').dataTable({
        'paging': true,
        'lengthChange': false,
        "pageLength": 100,
        'searching': true,
        'ordering': true,
        'info': true,
        "order": [[0, "desc"]],
        'autoWidth': true
    })
     /* $(document).on('click', '#getLeadsData', function () {
        var lead_from = $('#lead_from').val();
        var lead_to = $('#lead_to').val();
        var source = $('#lead_source').val();
        var _token = '{{ csrf_token() }}';
        $.ajax({
            url: "{{ url(adminPath().'/get_leads_data') }}",
            method: 'post',
            dataType: 'html',
            data: {from: lead_from, to: lead_to, source: source, _token: _token},
            beforeSend: function () {
                $('#leadData').removeClass('hidden');
            },
            success: function (data) {
                $('#leadData').addClass('hidden');
                $('#leads').html(data);
            },
            error: function (data) {
                $('#leadData').addClass('hidden');
            }
        })
    }) */
</script>
