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
                <a href="#" class="tw-pl-8">Records</a>
            </template>
            <sidebar-list-item
                v-for="(record, index) in records"
                :key="record.id"
                :index="`2-${index}`"
                :active="record.active"
                :title="record.title"
                :options="record.options"
                :route="{ path:`/record/${record.id}` }"
            >
                <a class="tw-pl-8">@{{ record.title }}</a>
            </sidebar-list-item>

        </base-submenu>
    </sidebar-list>
</base-sidebar>
