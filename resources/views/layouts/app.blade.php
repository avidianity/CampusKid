<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link rel="stylesheet" href="{{ elixir('webfonts/Lato.css') }}">
        <link rel="stylesheet" href="{{ elixir('css/assets.css') }}">
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta http-equiv="X-UA-Compatible" content="IE=7">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('APP_NAME', 'CampusKid') }}</title>
        @yield('head')
    </head>
    <body>
        @yield('content')
        <script type="text/javascript" src="{{ mix('js/app.js') }}" defer></script>
    </body>
</html>
