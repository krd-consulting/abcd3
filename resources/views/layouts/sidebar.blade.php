<nav class="tw-border-r">
    <sidebar-list :collapse="collapseSidebar" class="main-sidebar-menu">
        <sidebar-list-item index="dashboard" :route="{ path: '/dashboard' }">
            <base-icon class="tw-text-xl tw-mr-2">dashboard</base-icon>
            <span slot="title">Dashboard</span>
        </sidebar-list-item>
        <base-submenu index="/records/">
            <template slot="title">
                <base-icon class="tw-text-xl tw-mr-2">folder</base-icon>
                <span slot="title">Records</span>
            </template>
            @foreach($recordTypes as $type)
                <sidebar-list-item
                    index="/records/{{ $type->slug }}"
                    :route="{ path: '/records/{{ $type->slug }}' }"
                    >
                    <base-icon class="tw-text-xl tw-mr-2">insert_drive_file</base-icon>
                    {{ $type->name }}
                </sidebar-list-item>
            @endforeach
        </base-submenu>
        <base-submenu index="/programs/">
            <template slot="title">
                <base-icon class="tw-text-xl tw-mr-2">assignment</base-icon>
                <span slot="title">Programs</span>
            </template>
            @foreach($programs as $program)
                <sidebar-list-item
                    index="/programs/{{ $program->id }}"
                    key="3-{{ $program->id }}"
                    :route="{ path: '{{ $program->path }}' }"
                    >
                    <base-icon class="tw-text-xl tw-mr-2">assignment</base-icon>
                    {{ $program->name }}
                </sidebar-list-item>
            @endforeach
            @if(count($programs) > 0)
                <sidebar-list-item
                    index="/programs/"
                    :route="{ path: '/programs' }"
                    >
                    All Programs...
                </sidebar-list-item>
            @else
                <li class="tw-py-4 tw-pl-8 tw-text-xs">You have no programs</li>
            @endif
        </base-submenu>
        <sidebar-list-item index="/groups/" :route="{ path: '/groups' }">
            <base-icon class="tw-text-xl tw-mr-2">people</base-icon>
            <span slot="title">Groups</span>
        </sidebar-list-item>
        @if(count($teams) > 1)
            <base-submenu index="/teams/">
                <template slot="title">
                    <base-icon class="tw-text-xl tw-mr-2">people</base-icon>
                    <span slot="title">Teams</span>
                </template>
                @foreach($teams as $team)
                    <sidebar-list-item
                        index="/teams/{{ $team->id }}"
                        :route="{ path: '/teams/{{ $team->id }}' }"
                        >
                        <base-icon class="tw-text-xl tw-mr-2">people</base-icon>
                        {{ $team->name }}
                    </sidebar-list-item>
                @endforeach
            </base-submenu>
        @endif
        <sidebar-list-item index="/forms/" :route="{ path: '/forms' }">
            <base-icon class="tw-text-xl tw-mr-2">assignment</base-icon>
            <span slot="title">Forms</span>
        </sidebar-list-item>
    </sidebar-list>
</nav>
