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
        <th>Name</th>
        <th>Time in</th>
        <th>Time out</th>
        <th>comment</th>
        <th>Employee id</th>
    </tr>
    <tbody>
    @foreach($dateArray as $date)
        <tr>
            <td>{{ $date }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>


</body>
</html>
