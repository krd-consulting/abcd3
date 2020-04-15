@extends('layouts.app')

@section('main-nav')
    @include('layouts.nav')
@endsection

@section('main-sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
    <router-view></router-view>
@endsection

@section('scripts')
    <script src="{{ asset('js/app.js') }}" defer></script>
@endsection
