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

    <style>
        .item-text {
            color:  #feba1b;
        }
    </style>
</head>
<body>
    <div id="app">
        <base-container class="tw-h-screen" v-if="!loading">
            @section('main-sidebar')
            @show

            <base-container class="tw-flex-col">
                @section('main-nav')
                @show

                <el-main class="main tw-flex-1">
                    @yield('content')
                </el-main>
            </base-container>
        </base-container>
    </div>
    @section('scripts')
    @show
</body>
</html>
