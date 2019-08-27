<div>
    <h2>Application Form</h2>
    <hr/>
</div>
<h4 style="color: #caa42d">Client Information:</h4>
<table class="table datatable table-striped table-bordered  dt-responsive nowrap" style="width:100%">

{{--<table style="width: 100%">--}}
    <tr style="height: 50px">
        <th style="width: 30%; text-align: left">Date</th>
        <td style="width: 70%; text-align: left; border-bottom: 1px solid black">{{ explode(' ',$cils->lead->created_at)[0] }}</td>
    </tr>
    <tr style="height: 50px">
        <th style="width: 30%; text-align: left">Name</th>
        <td style="width: 70%; text-align: left; border-bottom: 1px solid black">{{ $cils->lead->first_name . ' ' . $cils->lead->last_name }}</td>
    </tr>
    <tr style="height: 50px">
        <th style="width: 30%; text-align: left">Address</th>
        <td style="width: 70%; text-align: left; border-bottom: 1px solid black">{{ $cils->lead->address }}</td>
    </tr>
    <tr style="height: 50px">
        <th style="width: 30%; text-align: left">Phone</th>
        <td style="width: 70%; text-align: left; border-bottom: 1px solid black">{{ $cils->lead->phone }}</td>
    </tr>
    <tr style="height: 50px">
        <th style="width: 30%; text-align: left">Email</th>
        <td style="width: 70%; text-align: left; border-bottom: 1px solid black"><a href="mailto:{{ $cils->lead->email }}">{{ $cils->lead->email }}</a></td>
    </tr>
    <tr style="height: 50px">
        <th style="width: 30%; text-align: left">Industry</th>
        <td style="width: 70%; text-align: left; border-bottom: 1px solid black">{{ @App\Industry::find($cils->lead->industry_id)->name }}</td>
    </tr>
    <tr style="height: 50px">
        <th style="width: 30%; text-align: left">Company</th>
        <td style="width: 70%; text-align: left; border-bottom: 1px solid black">{{ $cils->lead->company }}</td>
    </tr>
    <tr style="height: 50px">
        <th style="width: 30%; text-align: left">Club Membership</th>
        <td style="width: 70%; text-align: left; border-bottom: 1px solid black">{{ $cils->lead->club }}</td>
    </tr>
    @if(!empty($file))
    <tr style="height: 50px">
        <th style="width: 30%; text-align: left">Attatchment</th>
        <td style="width: 70%; text-align: left; border-bottom: 1px solid black"><a href="{{ url('uploads/'.@\App\LeadDocument::find($file)->file) }}">File</a></td>
    </tr>
    @endif
    @if(isset($cils->project->en_name))
    <tr style="height: 50px">
        <th style="width: 30%; text-align: left">Project</th>
        <td style="width: 70%; text-align: left; border-bottom: 1px solid black">{{ $cils->project->en_name }}</td>
    </tr>
    @endif
</table>
<br/>
<h4 style="color: #caa42d">Kids Information:</h4>
<br/>
<table style="width: 100%">
    <tr style="height: 50px">
        <th style="width: 30%; text-align: left">Kids Schools</th>
        <td style="width: 70%; text-align: left; border-bottom: 1px solid black">{{ $cils->lead->school }}</td>
    </tr>
</table>