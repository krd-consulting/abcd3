@extends('layouts.app')

@section('head-scripts')
    <script src="{{ asset('js/preferences.js') }}" defer></script>
@endsection

@section('main-nav')
    <el-header class="tw-flex tw-items-center tw-justify-between tw-py-2 tw-border-b">
        <a class="tw-inline-block" href="/">
            <base-icon class="tw-text-2xl">arrow_back</base-icon> Back
        </a>
        <h1 class="tw-inline-block tw-mx-auto tw-text-center">Preferences</h1>
        <span>&nbsp;</span>
    </el-header>
@endsection

@section('content')
    <div class="tw-container tw-mx-auto tw-w-2/3 tw-flex tw-mt-8">
        <nav>
            <sidebar-list>
                <sidebar-list-item index="1" :route="{ path: '/preferences/' }">
                    <base-icon class="tw-text-xl tw-pl-2">dashboard</base-icon>
                    <a class="tw-pl-2">General</a>
                </sidebar-list-item>
                <sidebar-list-item index="2" :route="{ path: '/preferences/files' }">
                    <base-icon class="tw-text-xl tw-pl-2">dashboard</base-icon>
                    <a class="tw-pl-2">Files</a>
                </sidebar-list-item>
                <sidebar-list-item index="3" :route="{ path: '/preferences/roles' }">
                    <base-icon class="tw-text-xl tw-pl-2">dashboard</base-icon>
                    <a class="tw-pl-2">Roles and Permissions</a>
                </sidebar-list-item>
            </sidebar-list>
        </nav>
        <section class="tw-ml-8 tw-w-3/4">
            <router-view></router-view>
        </section>
    </div>

@endsection
