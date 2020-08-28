<nav class="tw-border-r tw-bg-indigo-lightest tw-flex tw-flex-col tw-overflow-y-auto">
    <sidebar-list class="main-sidebar-menu tw-bg-indigo-lightest tw-flex-1">
        <div class="tw-h-20 tw-py-3 tw-px-8 tw-bg-white tw-border-b tw-border-gray-lighter">
            <img v-if="!collapseSidebar" src="{{ url('/images/meals-on-wheels.png') }}"
                alt="Meals on Wheels" class="tw-max-h-full">
            <base-icon v-else>menu</base-icon>
        </div>
        <div class="tw-px-5 tw-py-4 tw-border-b tw-border-gray-light">
            <div class="tw-flex tw-justify-end">
                <base-button size="small" outline>View Profile</base-button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="tw-hidden">
                    @csrf
                </form>
                <base-button size="small" outline class="tw-ml-2"
                    onclick="document.getElementById('logout-form').submit()">Logout</base-button>
            </div>
            <div class="tw-mt-2">
                <div class="tw-text-lg tw-text-black tw-font-extrabold">{{ Auth::user()->name }}</div>
                <div class="tw-text-sm tw-text-gray-dark tw-mt-2">Co-Founder</div>
            </div>
        </div>
        <base-submenu index="/records/people/">
            <template slot="title">
                <i class="fas fa-users tw-text-lg tw-mr-2"></i>
                <span slot="title" class="tw-text-sm tw-font-semibold tw-text-indigo-darkest">People</span>
            </template>
            @foreach($people as $type)
                <sidebar-list-item index="/records/{{ $type->slug }}"
                    class="tw-text-sm tw-font-semibold tw-text-gray-dark">
                    {{ $type->name }}
                </sidebar-list-item>
            @endforeach
        </base-submenu>

        <base-submenu index="/records/other/">
            <template slot="title">
                <i class="fas fa-folder tw-text-lg tw-mr-2"></i>
                <span slot="title" class="tw-text-sm tw-font-semibold tw-text-indigo-darkest">Other Files</span>
            </template>
            @foreach($other as $type)
                <sidebar-list-item index="/records/{{ $type->slug }}"
                    class="tw-text-sm tw-font-semibold tw-text-gray-dark">
                    {{ $type->name }}
                </sidebar-list-item>
            @endforeach
        </base-submenu>

        <base-submenu index="/collections/">
            <template slot="title">
                <i class="fas fa-layer-group tw-text-lg tw-mr-2"></i>
                <span slot="title" class="tw-text-sm tw-font-semibold tw-text-indigo-darkest">Collections</span>
            </template>
            <sidebar-list-item index="/groups/" class="tw-text-sm tw-font-semibold tw-text-gray-dark">
                Groups
            </sidebar-list-item>
            <sidebar-list-item index="/programs/" class="tw-text-sm tw-font-semibold tw-text-gray-dark">
                Programs
            </sidebar-list-item>
            <sidebar-list-item index="/teams/" class="tw-text-sm tw-font-semibold tw-text-gray-dark">
                Teams
            </sidebar-list-item>
        </base-submenu>

        <base-submenu index="/data-management/">
            <template slot="title">
                <i class="fas fa-server tw-text-lg tw-mr-2"></i>
                <span slot="title" class="tw-text-sm tw-font-semibold tw-text-indigo-darkest">Data Management</span>
            </template>
            <sidebar-list-item index="/forms/" class="tw-text-sm tw-font-semibold tw-text-gray-dark">
                Forms
            </sidebar-list-item>
        </base-submenu>

        <base-submenu index="/preferences/">
            <template slot="title">
                <i class="fas fa-cog tw-text-lg tw-mr-2"></i>
                <span slot="title" class="tw-text-sm tw-font-semibold tw-text-indigo-darkest">System
                    Administration</span>
            </template>
            <sidebar-list-item index="/preferences/" class="tw-text-sm tw-font-semibold tw-text-gray-dark">
                General
            </sidebar-list-item>
            <sidebar-list-item index="/preferences/records" class="tw-text-sm tw-font-semibold tw-text-gray-dark">
                Record Types
            </sidebar-list-item>
            <sidebar-list-item index="/preferences/roles" class="tw-text-sm tw-font-semibold tw-text-gray-dark">
                Roles
            </sidebar-list-item>
        </base-submenu>

    </sidebar-list>
    <div class="tw-p-5">
        <img src="{{ asset('/images/meals-on-wheels.png') }}" alt="Meals on Wheels"
            class="tw-w-20">
        <div class="tw-text-indigo-base tw-mt-1 tw-flex tw-justify-between tw-items-end">
            <div class="tw-text-xs">
                Powered by <b class="tw-text-xs">Meals on Wheels</b>
            </div>
            <div class="tw-flex tw-items-center">
                <i class="el-icon-question tw-text-indigo-darker tw-text-2xl"></i>
                <div class="tw-text-indigo-darker tw-ml-2">Help</div>
            </div>
        </div>
    </div>
</nav>
