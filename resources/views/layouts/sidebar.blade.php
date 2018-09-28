<nav class="tw-fixed tw-w-1/6 tw-h-screen tw-pt-20 tw-border-r">
    <sidebar-list>
        <sidebar-list-item >
            <a href="#" class="tw-pl-8">Dashboard</a>
        </sidebar-list-item>
        <li class="tw-py-2">
            <a href="#" class="tw-pl-8">Records</a>
            <sidebar-list-item
                v-for="(record, index) in records"
                :key="record.id"
                :active="record.active"
                :title="record.title"
                :options="record.options"
            >
                <a href="#" class="tw-pl-12">@{{ record.title }}</a>
                <records-list-item-options slot="options" slot-scope="props" :options="props.options" :show-options="props.showOptions"></records-list-item-options>
            </sidebar-list-item>
        </li>
    </sidebar-list>
</nav>
