<base-sidebar>
    <sidebar-list>
        <li class="tw-py-4">
            <a class="tw-pl-8 tw-text-3xl tw-font-bold">ABCD</a>
        </li>
        <sidebar-list-item index="1" :route="{ path: '/dashboard' }">
            <base-icon class="tw-text-xl tw-pl-2">dashboard</base-icon>
            <a class="tw-pl-2">Dashboard</a>
        </sidebar-list-item>
        <base-submenu index="2">
            <template slot="title">
                <base-icon class="tw-text-xl tw-pl-2">folder</base-icon>
                <a href="#" class="tw-pl-2">

                    Files
                </a>
            </template>
            @foreach($fileTypes as $type)
                <sidebar-list-item
                    key="{{ $type->id }}"
                    index="2-{{ $type->id }}"
                    :route="{ path: '/files/{{ $type->id }}' }"
                    >
                    <base-icon class="tw-text-xl tw-pl-2">insert_drive_file</base-icon>
                    <a class="tw-pl-2">{{ $type->name }}</a>
                </sidebar-list-item>
            @endforeach

        </base-submenu>
    </sidebar-list>
</base-sidebar>
