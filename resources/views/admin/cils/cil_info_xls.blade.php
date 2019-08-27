<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cil Info</title>
    <style>
        #head{
            background-color: #000;
            color: #fff;
            font-size: 17px;
            font-weight: bold;
            padding: 15px;
        }
    </style>
</head>
<body>
<table>
    <tr id="head">
        <th>Company Name</th>
        <th>Developer Name</th>
        <th>Lead First Name</th>
        <th>Lead Last Name</th>
        <th>Lead Creation Date</th>
        <th>Lead Address</th>
        <th>Lead Phone</th>
        <th>Lead Agent</th>
        <th>Project Name</th>
        <th>Project Address</th>
        <th>Sender Name</th>
        <th>Sender Title</th>
        <th>Sender Mobile number</th>
    </tr>
    <tr id="content">
        @if(isset($broker_name))
            <td>{{ $broker_name }}</td>
        @endif
        @if(isset($cil->developer))
            <td>{{ $cil->developer->{app()->getLocale().'_name'} }}</td>
        @endif
        @if(isset($cil->lead))
            <td>{{ $cil->lead->first_name }}</td>
            <td>{{ $cil->lead->last_name }}</td>
            <td>{{ $cil->lead->created_at }}</td>
            <td>{{ $cil->lead->address }}</td>
            <td>{{ $cil->lead->phone }}</td>
            <td>{{ $cil->lead->agent->name }}</td>
        @endif
        @if(isset($cil->project))
            <td>{{ $cil->project->{app()->getLocale().'_name'} }}</td>
            @if(isset($cil->project->location))
            <td>{{ $cil->project->location->{app()->getLocale().'_name'} }}</td>
            @endif
        @endif
        @if(isset($user))
            <td>{{ $user->name }}</td>
            <td>{{ $user->agentType->name }}</td>
            <td>{{ $user->phone }}</td>
        @endif
    </tr>
</table>
</body>
</html>
