@extends('layouts.app')

@section('head-scripts')
    <script src="{{ asset('js/app.js') }}" defer></script>
@endsection

@section('main-nav')
    @include('layouts.nav')
@endsection

@section('main-sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
    <el-main>
         <router-view></router-view>
    </el-main>
@endsection
