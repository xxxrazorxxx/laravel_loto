<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Laravel</title>
    </head>
    <body>
        <p>
            The {{$game_tour}}
            @if ($is_game_ended)
                was ended
            @else
                in progress.
            @endif
        </p>
        <p>Bank: {{$bank}}</p>
        <p>
            @if ($is_game_ended)
                Last number
            @else
                New number
            @endif
            is: {{$number}}
            @if (!$is_game_ended)
                <a href="{{url('/server')}}">Next number</a>
            @endif
        </p>
        <p>Numbers, which already in the game:</p>
        <p>
            @foreach ($numbers_in_game as $number)
                {{$number}},
            @endforeach
        </p>
    </body>
</html>
