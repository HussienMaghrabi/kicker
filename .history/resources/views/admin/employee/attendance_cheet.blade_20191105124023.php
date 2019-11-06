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
    <thead>
        <th>date</th>
        <th>f name</th>
        <th>m name</th>
        <th>l name</th>
    </thead>
        <tbody>
        @foreach($AllData as $key => $value)
            @for($i = 0; $i < $countEmployee ; $i++)
                <tr>
                    <td> {{ $key[$i] }} </td>
                    <td>154584</td>
                    <td>154584</td>
                    <td>154584</td>
                </tr>
            @endfor
        @endforeach
        </tbody>
</table>
</body>
</html>
