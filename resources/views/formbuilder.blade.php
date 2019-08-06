@extends('layouts.app')

@section('main-nav')
    @include('layouts.nav')
@endsection

@section('content')
    <el-main class="main">
         <router-view></router-view>
    </el-main>
    <!-- <initialize :active.sync="initialize.active" @save="initializeForm"/> -->
@endsection

@section('scripts')
    <script src="{{ asset('js/formbuilder.js') }}" defer></script>
@endsection
