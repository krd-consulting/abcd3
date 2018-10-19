<base-sidebar>
    <sidebar-list>
        <li class="tw-py-4">
            <a class="tw-pl-8 tw-text-3xl tw-font-bold">ABCD</a>
        </li>
        <sidebar-list-item index="1" :route="{ path: '/dashboard' }">
            <a class="tw-pl-8">Dashboard</a>
        </sidebar-list-item>
        <base-submenu index="2">
            <template slot="title">
                <a href="#" class="tw-pl-8">Files</a>
            </template>
            @foreach($fileTypes as $type)
                <sidebar-list-item
                    key="{{ $type->id }}"
                    index="2-{{ $type->id }}"
                    :route="{ path: '/files/{{ $type->id }}' }">
                    <a class="tw-pl-8">{{ $type->name }}</a>
                </sidebar-list-item>
            @endforeach

        </base-submenu>
    </sidebar-list>
</base-sidebar>
