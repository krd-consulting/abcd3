<base-sidebar class="main-sidebar">
    <sidebar-list>
        <li class="tw-py-4">
            <span class="tw-pl-8 tw-text-3xl tw-font-bold">ABCD</span>
        </li>
        <sidebar-list-item index="1" :route="{ path: '/dashboard' }">
            <base-icon class="tw-text-xl tw-px-2">dashboard</base-icon>
            <span slot="title">Dashboard</span>
        </sidebar-list-item>
        <base-submenu index="2">
            <template slot="title">
                <base-icon class="tw-text-xl tw-px-2">folder</base-icon>
                <span slot="title">Files</span>
            </template>
            @foreach($fileTypes as $type)
                <sidebar-list-item
                    key="{{ $type->id }}"
                    index="2-{{ $type->id }}"
                    :route="{ path: '/files/{{ $type->id }}' }"
                    >
                    <base-icon class="tw-text-xl tw-px-2">insert_drive_file</base-icon>
                    {{ $type->name }}
                </sidebar-list-item>
            @endforeach

        </base-submenu>
    </sidebar-list>
</base-sidebar>
