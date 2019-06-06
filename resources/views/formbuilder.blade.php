@extends('layouts.app')

@section('main-nav')
    @include('layouts.nav')
@endsection

@section('content')
    <el-main class="main">
         <router-view></router-view>
    </el-main>
@endsection

@section('scripts')
    <script src="{{ asset('js/formbuilder.js') }}" defer></script>
@endsection
