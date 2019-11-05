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
    @for($i = 0;$i < $countDate;$i++)
        <tr>
            <td>{{ $date[$i] }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    @endfor
    </tbody>
</table>


</body>
</html>
