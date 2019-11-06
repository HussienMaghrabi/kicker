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
    @foreach($dateArray as $date)
        <tr>
            <td>{{ $date }}</td>
            @foreach($employees as $employee)
                <td>{{ $employee->id }}</td>
                <td>{{ $employee->en_first_name }} {{ $employee->en_last_name }}</td>
            @endforeach
            <td></td>
            <td></td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>


</body>
</html>
