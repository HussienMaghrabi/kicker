<!DOCTYPE html>
<table>
    <thead>
        <th>date</th>
        <th>f name</th>
        <th>m name</th>
        <th>l name</th>
    </thead>
        <tbody>
            <tr>
                <td>154584</td>
                <td>154584</td>
                <td>154584</td>
                <td>154584</td>
            </tr>
        </tbody>
</table>
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
    @foreach($AllData as $key => $data)
    <tr>
        <td>{{ $key }}</td>
        @for($i=0;$i<$data;$i++)
            <td>{{ $data[$i]['id'] }}</td>
            <td>{{ $data[$i]['en_first_name'] }}</td>
            <td>{{ $data[$i]['en_middle_name'] }}</td>
            <td>{{ $data[$i]['en_last_name'] }}</td>
        @endfor
    </tr>
    @endforeach
    </tbody>
</table>


</body>
</html>
