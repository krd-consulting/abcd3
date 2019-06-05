@extends('layouts.app')

@section('main-nav')
    <el-header class="tw-flex tw-items-center tw-justify-between tw-py-2 tw-border-b">
        <a class="tw-inline-block" href="/">
            <base-icon class="tw-text-base tw-align-middle">arrow_back</base-icon>
            <span class="tw-align-middle tw-text-sm">Back</span>
        </a>
        <h2 class="tw-inline-block tw-mx-auto tw-text-center">Preferences</h2>
        <span>&nbsp;</span>
    </el-header>
@endsection

@section('content')
    <div class="tw-w-full tw-bg-gray-100">
        <div class="tw-container tw-mx-auto tw-flex tw-mt-8">
            <nav>
                <sidebar-list :collapse="false" class="preferences-sidebar-menu tw-bg-gray-100">
                    <sidebar-list-item index="1" :route="{ path: '/preferences/' }">
                        <base-icon class="tw-text-xl tw-mr-2">dashboard</base-icon>
                        <span slot="title">General</span>
                    </sidebar-list-item>
                    <sidebar-list-item index="2" :route="{ path: '/preferences/records' }">
                        <base-icon class="tw-text-xl tw-mr-2">insert_drive_file</base-icon>
                        <span slot="title">Records</span>
                    </sidebar-list-item>
                    <sidebar-list-item index="3" :route="{ path: '/preferences/programs' }">
                        <base-icon class="tw-text-xl tw-mr-2">assignment</base-icon>
                        <span slot="title">Programs</span>
                    </sidebar-list-item>
                    @can('write roles')
                        <sidebar-list-item index="4" :route="{ path: '/preferences/roles' }">
                            <base-icon class="tw-text-xl tw-mr-2">people</base-icon>
                            <span slot="title">Roles</span>
                        </sidebar-list-item>
                    @endcan
                </sidebar-list>
            </nav>
            <section class="tw-flex-1">
                <router-view></router-view>
            </section>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/preferences.js') }}" defer></script>
@endsection
