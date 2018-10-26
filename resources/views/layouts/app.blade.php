<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ABCD') }}</title>

    <!-- Scripts -->
    @section('head-scripts')
    @show

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <base-container id="app" style="height: 100vh;">
        @section('main-sidebar')
        @show

        <base-container>
            @section('main-nav')
            @show

            @yield('content')
        </base-container>
    </base-container>
</body>
</html>
