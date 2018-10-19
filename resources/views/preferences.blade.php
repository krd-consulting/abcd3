@extends('layouts.app')

@section('head-scripts')
    <script src="{{ asset('js/preferences.js') }}" defer></script>
@endsection

@section('main-nav')
    <header class="tw-flex tw-items-center tw-justify-between tw-py-2 tw-border-b">
        <a class="tw-inline-block" href="/">
            <base-icon class="tw-text-2xl">arrow_back</base-icon> Back
        </a>
        <h1 class="tw-inline-block tw-mx-auto tw-text-center">Preferences</h1>
        <span>&nbsp;</span>
    </header>
@endsection

@section('content')
    <div class="tw-container tw-mx-auto tw-w-2/3 tw-flex tw-mt-8">
        <nav>
            <sidebar-list>
                <router-link
                    tag="sidebar-list-item"
                    class="tw-pl-2 tw-pr-4 tw-rounded-lg"
                    to="/preferences/"
                    active-class="active"
                    exact>
                    <a>General</a>
                </router-link>
                <router-link
                    tag="sidebar-list-item"
                    class="tw-pl-2 tw-pr-4 tw-rounded-lg"
                    to="/preferences/files"
                    active-class="active"
                    exact>
                    <a>Files</a>
                </router-link>
                <router-link
                    tag="sidebar-list-item"
                    class="tw-pl-2 tw-pr-4 tw-rounded-lg"
                    to="/preferences/roles"
                    active-class="active"
                    exact>
                    <a>Roles and Permissions</a>
                </router-link>
            </sidebar-list>
        </nav>
        <section class="tw-ml-8 tw-w-3/4">
            <router-view></router-view>
        </section>
    </div>

@endsection
