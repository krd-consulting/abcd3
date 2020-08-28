<header class="tw-h-20 tw-bg-white tw-px-10 tw-flex tw-items-center">
    <breadcrumb :items="['Home', 'People', 'Volunteer Type 1']"></breadcrumb>
    <el-input placeholder="Search..." v-model="search" suffix-icon="fas fa-search" class="tw-ml-auto"
        :style="{width: '400px'}">
        <el-dropdown slot="prepend" trigger="click">
            <span class="el-dropdown-link tw-flex tw-items-center">
                <span class="tw-text-xs tw-text-gray-dark tw-font-medium">Category</span>
                <i class="el-icon-arrow-down tw-text-indigo-base tw-font-bold tw-text-sm tw-ml-10"></i>
            </span>
            <el-dropdown-menu slot="dropdown">
                <el-dropdown-item>Client</el-dropdown-item>
                <el-dropdown-item>Volunteer</el-dropdown-item>
                <el-dropdown-item>Staff</el-dropdown-item>
            </el-dropdown-menu>
        </el-dropdown>
    </el-input>
    <notification class="tw-ml-5"></notification>
</header>
