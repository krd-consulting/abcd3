<nav class="tw-border-r">
    <sidebar-list :collapse="collapseSidebar" class="main-sidebar-menu">
        @if(Route::current()->getName() !== "formBuilder")
            <el-menu-item @click="collapseSidebar = !collapseSidebar">
                <img v-if="!collapseSidebar" src="{{ url('/images/abcd-logo.png') }}" alt="ABCD" class="tw-h-12 tw-py-2">
                <base-icon v-else>menu</base-icon>
            </el-menu-item>
        @endif
        <sidebar-list-item index="dashboard">
            <template slot="title">
                <base-icon class="tw-text-xl tw-mr-2">dashboard</base-icon>
                <span slot="title" class="tw-text-gray-900">Dashboard</span>
            </template>
        </sidebar-list-item>
        <base-submenu index="/records/">
            <template slot="title">
                <base-icon class="tw-text-xl tw-mr-2">face</base-icon>
                <span slot="title" class="tw-text-gray-900">Records</span>
            </template>
            @foreach($recordTypes as $type)
                <sidebar-list-item
                    index="/records/{{ $type->slug }}"
                    >
                    <!-- <base-icon class="tw-text-xl tw-mr-2">insert_drive_file</base-icon> -->
                    {{ $type->name }}
                </sidebar-list-item>
            @endforeach
        </base-submenu>

	   <sidebar-list-item index="/groups/">
            <base-icon class="tw-text-xl tw-mr-2">assignment</base-icon>
            <span slot="title" class="tw-text-gray-900">Groups</span>
        </sidebar-list-item>

        <base-submenu index="/programs/">
            <template slot="title">
                <base-icon class="tw-text-xl tw-mr-2">supervised_user_circle</base-icon>
                <span slot="title" class="tw-text-gray-900">Programs</span>
            </template>
            @foreach($programs as $program)
                <sidebar-list-item
                    index="/programs/{{ $program->id }}"
                    key="3-{{ $program->id }}"
                    >
                    <!-- <base-icon class="tw-text-xl tw-mr-2">assignment</base-icon> -->
                    {{ $program->name }}
                </sidebar-list-item>
            @endforeach
            @if(count($programs) > 0)
                <sidebar-list-item
                    index="/programs/"
                    >
                    All Programs...
                </sidebar-list-item>
            @else
                <li class="tw-py-4 tw-pl-8 tw-text-xs">You have no programs</li>
            @endif
        </base-submenu>
        @if(count($teams) > 1)
            <base-submenu index="/teams/">
                <template slot="title">
                    <base-icon class="tw-text-xl tw-mr-2">group_work</base-icon>
                    <span slot="title" class="tw-text-gray-900">Teams</span>
                </template>
                @foreach($teams as $team)
                    <sidebar-list-item
                        index="/teams/{{ $team->id }}"
                        :route="{ path: '/teams/{{ $team->id }}' }"
                        >
                        <!-- <base-icon class="tw-text-xl tw-mr-2">people</base-icon> -->
                        {{ $team->name }}
                    </sidebar-list-item>
                @endforeach
            </base-submenu>
        @endif
        <sidebar-list-item index="/forms/" :route="{ path: '/forms' }">
            <base-icon class="tw-text-xl tw-mr-2">library_books</base-icon>
            <span slot="title" class="tw-text-gray-900">Forms</span>
        </sidebar-list-item>

        <base-submenu index="/preferences/">
            <template slot="title">
                <base-icon class="tw-text-xl tw-mr-2">face</base-icon>
                <span slot="title" class="tw-text-gray-900">System Administration</span>
            </template>
            <sidebar-list-item index="/preferences/">
                General
            </sidebar-list-item>
            <sidebar-list-item index="/preferences/records">
                Record Types
            </sidebar-list-item>
            <sidebar-list-item index="/preferences/roles">
                Roles
            </sidebar-list-item>
        </base-submenu>

    </sidebar-list>
</nav>
