<nav class="tw-border-r">
    <sidebar-list :collapse="collapseSidebar" class="main-sidebar-menu">
        <sidebar-list-item index="1" :route="{ path: '/dashboard' }">
            <base-icon class="tw-text-xl tw-mr-2">dashboard</base-icon>
            <span slot="title">Dashboard</span>
        </sidebar-list-item>
        <base-submenu index="2">
            <template slot="title">
                <base-icon class="tw-text-xl tw-mr-2">folder</base-icon>
                <span slot="title">Records</span>
            </template>
            @foreach($recordTypes as $type)
                <sidebar-list-item
                    key="{{ $type->id }}"
                    index="2-{{ $type->id }}"
                    :route="{ path: '/records/{{ $type->slug }}' }"
                    >
                    <base-icon class="tw-text-xl tw-mr-2">insert_drive_file</base-icon>
                    {{ $type->name }}
                </sidebar-list-item>
            @endforeach
        </base-submenu>
        <base-submenu index="3">
            <template slot="title">
                <base-icon class="tw-text-xl tw-mr-2">assignment</base-icon>
                <span slot="title">Programs</span>
            </template>
            @foreach($programs as $program)
                <sidebar-list-item
                    key="{{ $program->id }}"
                    index="3-{{ $program->id }}"
                    :route="{ path: '/programs/{{ $program->id }}' }"
                    >
                    <base-icon class="tw-text-xl tw-mr-2">assignment</base-icon>
                    {{ $program->name }}
                </sidebar-list-item>
            @endforeach
            @if(count($programs) > 0)
                <sidebar-list-item
                    index="3-5"
                    :route="{ path: '/programs' }"
                    >
                    More programs...
                </sidebar-list-item>
            @else
                <li class="tw-py-4 tw-pl-8 tw-text-xs">You have no programs</li>
            @endif
        </base-submenu>
        @if(count($teams) > 0)
            <base-submenu index="4">
                <template slot="title">
                    <base-icon class="tw-text-xl tw-mr-2">people</base-icon>
                    <span slot="title">Teams</span>
                </template>
                @foreach($teams as $team)
                    <sidebar-list-item
                        key="{{ $team->id }}"
                        index="4-{{ $team->id }}"
                        :route="{ path: '/teams/{{ $team->id }}' }"
                        >
                        <base-icon class="tw-text-xl tw-mr-2">people</base-icon>
                        {{ $team->name }}
                    </sidebar-list-item>
                @endforeach
            </base-submenu>
        @endif
    </sidebar-list>
</nav>
