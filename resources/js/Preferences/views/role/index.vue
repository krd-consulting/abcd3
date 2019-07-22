<template>
    <div>
        <edit-role
            :active.sync="edit.active"
            :role="edit.role"
            @update="updateRole"/>

        <create-role
            :active.sync="create.active"
            @save="storeRole"/>

        <div class="tw-flex tw-items-center tw-justify-between tw-mx-2 tw-pb-4 tw-border-b">
            <div>
                <h2>
                    <base-icon class="tw-text-xl tw-px-2">people</base-icon>
                    <span>Manage Roles</span>
                </h2>
            </div>
            <base-button class="tw-py-2 tw-pl-2 tw-pr-4 tw-bg-transparent tw-text-blue-500 tw-font-bold tw-border-none" @click="createRole">
                <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
                <span class="tw-text-xs tw-align-middle">Create Role</span>
            </base-button>
        </div>
        <div class="tw-w-full tw-flex tw-py-4 tw-items-start tw-flex-wrap tw-justify-between tw-overflow-y-auto" style="max-height: 78vh;">
            <div v-for="(role, roleIndex) in roles" class="tw-w-1/2 tw-mb-4 tw-px-2">
                <div class="tw-rounded tw-shadow tw-bg-white tw-px-4 tw-py-2">
                    <div class="tw-flex tw-items-center tw-pt-4 tw-pb-2 tw-border-b tw-rounded-t">
                        <div class="tw-w-3/4">
                            <div class="tw-font-semibold">
                                {{ role.name }}
                            </div>

                            <scope-tag
                                class="tw-py-1 tw-text-xs tw-text-blue-500 tw-font-semibold tw-capitalize"
                                :scope="role.scope_id"/>
                        </div>
                        <div class="tw-w-1/4 tw-text-right tw-mr-4">
                            <button @click="editRole(role)">
                                <base-icon class="tw-text-sm tw-text-gray-500 hover:tw-text-blue">edit</base-icon>
                            </button>
                            <button @click="confirm(role)">
                                <base-icon class="tw-text-sm tw-text-gray-500 hover:tw-text-red-400">delete</base-icon>
                            </button>
                        </div>
                    </div>
                    <table class="tw-w-full">
                        <tbody>
                            <tr v-for="(permission, permissionIndex) in role.all_permissions">
                                <td width="75%" class="tw-py-4 tw-text-sm tw-capitalize">{{ permission.name }}</td>
                                <td class="tw-py-4 tw-text-right tw-pr-4">
                                    <base-switch
                                        v-model="permission.permitted"
                                        @change="toggleRolePermission(role, permission, $event, roleIndex, permissionIndex)"/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import RoleRequest from '@/api/RoleRequest';
    import RolePermissionRequest from '@/api/RolePermissionRequest';
    import CreateRole from './create';
    import EditRole from './edit';

    export default {
        components: {
            CreateRole,
            EditRole
        },
        data() {
            return {
                create: {
                    active: false
                },
                edit: {
                    active: false,
                    role: {
                        name: '',
                        scope: {
                        }
                    }
                },
                fields: [],
                roles: [],
                permissions: [],
                params: {
                    ascending: true,
                    sortBy: 'field_1_value',
                    page: 1,
                    perPage: 5
                },
                total: 0
            }
        },

        methods: {
            retrieve() {
                let request = new RoleRequest({...this.params});

                request.retrieve().then((response) => {
                    this.roles = Object.values(response.data.roles);
                });
            },

            createRole() {
                this.create.active = true;
            },

            storeRole(role) {
                this.roles.splice(0, 0, role);
            },

            editRole(role) {
                this.edit.role = _.clone(role);
                this.edit.active = true;
            },

            updateRole(role) {
                this.retrieve();
            },

            toggleRolePermission(role, permission, permitted, roleIndex, permissionIndex) {
                let request = new RolePermissionRequest();

                if(permitted) {
                    request.store(role.id, permission.id)
                        .then(() => {
                            this.enableRolePermission(roleIndex, permissionIndex)
                        });
                } else {
                    request.destroy(role.id, permission.id)
                        .then(() => {
                            this.disableRolePermission(roleIndex, permissionIndex)
                        });
                }
            },

            enableRolePermission(role, permission) {
                this.roles[role]['all_permissions'][permission].permitted = true;
            },

            disableRolePermission(role, permission) {
                this.roles[role]['all_permissions'][permission].permitted = false;
            },

            confirm(role) {
                this.$confirm('Are you sure you want to delete this role?', 'Delete Role', {
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.deleteRole(role)
                        .then(() => {
                            this.$message({
                                type: 'success',
                                message: 'Role was deleted.'
                            });
                        })
                        .catch(() => {
                            this.$message({
                                type: 'error',
                                message: 'Oops! Something went wrong.'
                            });
                        });
                })
            },

            deleteRole(role) {
                let request = new RoleRequest({
                    'role': {
                        'id': role.id
                    }
                });

                return request.destroy(role.id).then((response) => {
                    this.retrieve();
                });
            }
        },

        created() {
            this.retrieve();
        }
    }
</script>
