<template>
    <div>
        <edit-role
            :active.sync="edit.active"
            :role="edit.role"
            @update="updateRole"/>

        <create-role
            :active.sync="create.active"
            @save="storeRole"/>

        <div class="tw-flex tw-items-center tw-justify-between">
            <h2 class="tw-mb-4">
                <base-icon class="tw-text-xl tw-px-2">people</base-icon> Roles
            </h2>
            <base-button @click="createRole">Create Role</base-button>
        </div>
        <div class="tw-w-full tw-flex tw-items-start tw-flex-wrap tw-justify-between">
            <div v-for="(role, roleIndex) in roles" class="lg:tw-w-1/2 tw-w-full tw-pr-4 tw-py-2 tw-flex-no-shrink">
                <div class="tw-rounded tw-shadow">
                    <div class="tw-flex tw-items-center tw-pt-4 tw-pb-2 tw-bg-grey-lighter tw-rounded">
                        <div class="tw-w-3/4 tw-pl-2">
                            <span class="tw-inline-block tw-font-semibold tw-mb-2">
                                {{ role.name }}
                            </span>

                            <scope-tag
                                class="tw-align-middle tw-py-1 tw-font-semibold tw-text-xs tw-text-blue"
                                :scope="role.scope_id"/>
                        </div>
                        <div class="tw-w-1/4 tw-text-center">
                            <button @click="editRole(role, roleIndex)">
                                <base-icon class="tw-text-base">edit</base-icon>
                            </button>
                            <button @click="deleteRole(role, roleIndex)">
                                <base-icon class="tw-text-base">delete</base-icon>
                            </button>
                        </div>
                    </div>
                    <table class="tw-w-full">
                        <tbody>
                            <tr v-for="(permission, permissionIndex) in role.all_permissions" class="hover:tw-bg-grey-lightest">
                                <td width="75%" class="tw-py-4 tw-pl-2 tw-text-sm">{{ permission.name }}</td>
                                <td class="tw-py-4 tw-text-center">
                                    <base-switch
                                        :on="permission.permitted"
                                        @change="updateRolePermission(role, permission, $event, roleIndex, permissionIndex)"/>
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
    import Request from '../api/RoleRequest';
    import CreateRole from './PreferencesRoleCreate';
    import EditRole from './PreferencesRoleEdit';

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
                let request = new Request({...this.params});

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

            editRole(role, index) {
                this.edit.role = role;
                this.edit.active = true;
                this.edit.roleIndex = index;
            },

            updateRole(role) {
                this.roles[this.edit.roleIndex]['name'] = role.name;
                this.roles[this.edit.roleIndex]['scope_id'] = role.scope.id;
            },

            updateRolePermission(role, permission, permitted, roleIndex, permissionIndex) {
                let request = new Request({
                    'role': {
                        'id': role.id
                    },
                    'permission': {
                        'id': permission.id
                    },
                    permitted
                });

                request.updateRolePermission().then(response => {
                        this.roles[roleIndex]['all_permissions'][permissionIndex].permitted = response.permitted;
                    })
                    .catch(error => {
                        //
                    });
            },

            deleteRole(role, roleIndex) {
                let request = new Request({
                    'role': {
                        'id': role.id
                    }
                });

                request.destroy(role.id).then((response) => {
                    this.roles.splice(roleIndex, 1);
                });
            }
        },

        created() {
            this.retrieve();
        }
    }
</script>
