@extends('admin.index')

@section('content')
<div id="emailsTable">
    <table  class="table datatable table-striped table-bordered  dt-responsive nowrap"style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Lead Name</th>
                <th>Devoleper</th>
                <th>Status</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody >
            @if($cils->count() > 0)
                @foreach($cils as $cil)
                    <tr>
                        <td>{{$cil->id}}</td>
                        <td>{{$cil->lead->first_name ." ".$cil->lead->last_name}}</td>
                        <td>{{$cil->developer}}</td>
                        <td>{{$cil->status}}</td>
                        <td>
                        <select class="form-control"  onchange="' . "if(this.value=='del'){\$('#delete$lead->id').modal('show');} else{location = this.value;}" . '">
                            <option value="#" disabled selected >Options</option>
                            <option value="{{ url(adminPath() . '/cils/' . $lead->id.'/show/') }}">' . trans('admin.show') . '</option>
                            <option value="{{ url(adminPath() . '/leads/' . $cil->lead->id .'/edit/') }}">' . trans('admin.edit') . '</option>
                            <option value="del" class="btn btn-danger btn-flat">' . trans('admin.delete') . '</option>
                        </select>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">No Requests found</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
<script>
        $('.datatable').dataTable({
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            "order": [[ 0, "desc" ]],
            'autoWidth': true
        });
</script>
@endsection