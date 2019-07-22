<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ABCD') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body onload="load()">
    <div id="app">
        @section('main-nav')
        @show

        <base-container class="tw-min-h-screen" v-if="!loading">
            @section('main-sidebar')
            @show

            @yield('content')
        </base-container>
    </div>

    <!-- Scripts -->
    <script type="text/javascript">
        document.getElementById('app').style.opacity = 0;

        function load() {
            document.getElementById('app').style.opacity = 100;
        }
    </script>
    @section('scripts')
    @show
</body>
</html>
