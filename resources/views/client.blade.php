<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Laravel</title>
</head>
<body>
    <p>Hello, {{ $name }} {{ $surname }}</p>
    <p>Your ticket number is {{$client_number}}, and you take part in the {{ $game_number }} game tour.</p>
    <p>You can check the result on the following page: <a href="{{url('/client/' . $client_number)}}">{{url('/client/' . $client_number)}}</a></p>
    <p>This is your ticket:</p>
    @foreach ($ticket_data['fields'] as $field)
        <table border="1" width="300">
            @foreach ($field as $row)
                <tr align="center">
                    @for ($i = 0; $i < 9; $i++)
                        <td width="30">@if (!empty($row[$i])){{$row[$i]}}@endif</td>
                    @endfor
                </tr>
            @endforeach
        </table>
        <br>
    @endforeach
</body>
</html>
