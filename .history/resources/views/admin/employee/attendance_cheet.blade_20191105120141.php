<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Export</title>
    <style>
        #head{
            background-color: #000;color: #fff;
            font-size: 17px;
            font-weight: bold;
            padding: 15px;
        }
    </style>
</head>
<body>
<table>
    <tr id="head">
        <th>Date</th>
        <th>Employee id</th>
        <th>Employee Name</th>
        <th>Time in</th>
        <th>Time out</th>
        <th>comment</th>
    </tr>
    <tbody>
    @for($i=0;$i<$countEmployee;$i++)
        <tr>
            <td>{{ $employees[$i]['id'] }}</td>
            <td>{{ $employees[$i]['en_first_name'] }} {{ $employees[$i]['en_last_name'] }}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    @endfor
    </tbody>
</table>


</body>
</html>
