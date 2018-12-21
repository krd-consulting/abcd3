<template>
    <div>
        <edit-role
            :active.sync="edit.active"
            :role="edit.role"
            @update="updateRole"/>

        <base-dialog title="Create Role" :visible.sync="create.active">
            <form>
                <div class="tw-flex tw-items-center tw-w-2/3 tw-mb-4">
                    <label class="tw-w-1/3 tw-text-right tw-px-4">
                        Name
                    </label>
                    <div class="tw-w-2/3">
                        <el-input v-model="create.role.name">
                        </el-input>
                    </div>
                </div>
                <div class="tw-flex tw-items-center tw-w-2/3 tw-mb-4">
                    <label class="tw-w-1/3 tw-text-right tw-px-4">
                        Scope
                    </label>
                    <div class="tw-w-2/3">
                        <el-select v-model="create.role.scope" placeholder="Select Scope">
                            <el-option
                                v-for="scope in create.scopes"
                                :key="scope.id"
                                :label="scope.name"
                                :value="scope">
                                <scope-tag :scope="scope.id">{{ scope.name }}</scope-tag>
                            </el-option>
                        </el-select>
                    </div>
                </div>
            </form>
            <div slot="footer">
                <base-button @click="closeCreateRole">Cancel</base-button>
                <base-button @click="storeRole(create.role.name, create.role.scope.id)">Confirm</base-button>
            </div>
        </base-dialog>
        <div class="tw-flex tw-items-center tw-justify-between">
            <h2 class="tw-mb-4">
                <base-icon class="tw-text-xl tw-px-2">people</base-icon> Roles
            </h2>
            <base-button @click="createRole">Create Role</base-button>
        </div>
        <table v-for="(role, roleIndex) in roles" class="tw-w-full tw-mt-8">
            <thead>
                <tr class="tw-border-b-2">
                    <td class="tw-py-2">
                        <span class="tw-inline-block tw-font-semibold tw-mr-2">
                            {{ role.name }}
                        </span>
                        <scope-tag
                        class="tw-align-middle tw-px-2 tw-py-1 tw-rounded tw-bg-blue-lightest tw-font-semibold tw-text-xs tw-text-blue"
                        :scope="role.scope_id"/>
                    </td>
                    <td class="tw-text-center">
                        <button @click="editRole(role, roleIndex)">
                            <base-icon class="tw-text-base">edit</base-icon>
                        </button>
                        <button @click="deleteRole(role)">
                            <base-icon class="tw-text-base">delete</base-icon>
                        </button>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(permission, permissionIndex) in role.all_permissions">
                    <td width="90%" class="tw-py-4 tw-border-b">{{ permission.name }}</td>
                    <td class="tw-py-4 tw-border-b tw-text-center">
                        <base-switch
                            :on="permission.permitted"
                            @change="updateRolePermission(role, permission, $event, roleIndex, permissionIndex)"/>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    import Request from '../api/RoleRequest';
    import EditRole from './PreferencesRoleEdit';

    export default {
        components: {
            EditRole
        },
        data() {
            return {
                create: {
                    active: false,
                    role: {
                        name: '',
                        scope: {
                        }
                    }
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
            createRole() {
                let request = new Request({});

                request.edit().then((response) => {
                    this.create.active = true;
                    this.create.scopes = response.scopes;
                });
            },

            storeRole(
                name = this.create.role.name,
                scopeId = this.create.role.scope_id
            ) {
                let request = new Request({
                    'role': {
                        'name': name,
                        'scope_id': scopeId
                    }
                });

                request.store().then((response) => {
                    //
                });
            },

            closeCreateRole() {
                this.create = {
                    active: false,
                    role: {
                        scope: {
                        }
                    },
                };
            },

            retrieve() {
                let request = new Request({...this.params});

                request.retrieve().then((response) => {
                    this.roles = response.data.roles;
                });
            },

            editRole(role, index) {
                this.edit.active = true;
                this.edit.role = role;
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

            deleteRole(role) {
                let request = new Request({
                    'role': {
                        'id': role.id
                    }
                });

                request.destroy(role.id).then((response) => {
                    //
                });
            }
        },

        created() {
            this.retrieve();
        }
    }
</script>
