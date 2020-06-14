<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta http-equiv="X-UA-Compatible" content="IE=7">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('APP_NAME', 'CampusKid') }}</title>
        <link rel="stylesheet" href="{{ elixir('webfonts/Lato.css') }}">
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script type="text/javascript" src="{{ mix('js/app.js') }}" defer></script>
        @yield('head')
    </head>
    <body>
        @yield('content')
    </body>
</html>
