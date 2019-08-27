
<table class="table datatable table-striped table-bordered  dt-responsive nowrap" id="printTable" style="width:100%">
    <thead>
        <tr>
            <th>{{ __('admin.id') }}</th>
            <th>{{ __('admin.name') }}</th>
            <th>{{ __('admin.phone') }}</th>
            <th>Calls Status</th>
            <th>{{ __('admin.description') }}</th>
            <th>Lead Source</th>
            <th>{{ __('admin.date') }}</th>
        </tr>
    </thead>
    <tbody id="leads">
    @foreach($leads as $lead)
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
    {{-- /* $(document).on('click', '#getLeadsData', function () {
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
    }) */ --}}
</script>
