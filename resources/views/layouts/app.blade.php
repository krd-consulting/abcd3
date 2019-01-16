<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ABCD') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="https://rsms.me/inter/inter-ui.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <base-container id="app" class="tw-h-screen">
        @section('main-sidebar')
        @show

        <base-container>
            @section('main-nav')
            @show

            @yield('content')
        </base-container>
    </base-container>

    <!-- Scripts -->
    @section('scripts')
    @show
</body>
</html>
