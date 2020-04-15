@extends('layouts.app')

@section('main-nav')
    <el-header class="tw-flex tw-bg-blue-500 tw-text-white tw-items-center tw-justify-between tw-py-2 tw-border-b">
        <a class="tw-inline-block" href="/">
            <base-icon class="tw-text-white tw-align-middle">arrow_back</base-icon>
            <span class="tw-align-middle tw-text-sm tw-text-white">Back</span>
        </a>
        <h2 class="tw-inline-block tw-mx-auto tw-text-center">Preferences</h2>
        <span>&nbsp;</span>
    </el-header>
@endsection

@section('content')
    <div class="tw-absolute tw-w-full tw-h-full tw-bg-gray-100">
        <div class="tw-container tw-mx-auto tw-flex tw-mt-8">
            <nav>
                <sidebar-list :collapse="false" class="preferences-sidebar-menu tw-bg-gray-100">
                    <sidebar-list-item index="/preferences/">
                        <base-icon class="tw-text-xl tw-mr-2">dashboard</base-icon>
                        <span slot="title" class="tw-text-black">General</span>
                    </sidebar-list-item>
                    <sidebar-list-item index="/preferences/records">
                        <base-icon class="tw-text-xl tw-mr-2">insert_drive_file</base-icon>
                        <span slot="title" class="tw-text-black">Records</span>
                    </sidebar-list-item>
                    <sidebar-list-item index="/preferences/programs">
                        <base-icon class="tw-text-xl tw-mr-2">assignment</base-icon>
                        <span slot="title" class="tw-text-black">Programs</span>
                    </sidebar-list-item>
                    @can('write roles')
                        <sidebar-list-item index="/preferences/roles">
                            <base-icon class="tw-text-xl tw-mr-2">people</base-icon>
                            <span slot="title" class="tw-text-black">Roles</span>
                        </sidebar-list-item>
                    @endcan
                </sidebar-list>
            </nav>
            <section class="tw-flex-1 tw-min-h-full tw-w-full">
                <router-view></router-view>
            </section>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/preferences.js') }}" defer></script>
@endsection
