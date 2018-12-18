<template>
    <div>
        <div class="tw-flex tw-items-center tw-justify-between">
            <h2 class="tw-mb-4">
                <base-icon class="tw-text-xl tw-px-2">people</base-icon> Roles
            </h2>
            <base-button>Create Role</base-button>
        </div>
        <table v-for="role in roles" class="tw-w-full tw-mt-8">
            <thead>
                <tr class="tw-border-b-2">
                    <td colspan="2" class="tw-py-2">
                        <span class="tw-inline-block tw-font-semibold">{{ role.name }}</span>
                        <span class="tw-align-middle tw-px-2 tw-py-1 tw-rounded tw-bg-blue-lightest tw-font-semibold tw-text-xs tw-text-blue">
                            <base-icon class="tw-text-xs tw-align-middle">star</base-icon> {{ role.scope.name }}
                        </span>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="permission in role.all_permissions">
                    <td width="90%" class="tw-py-4 tw-border-b">{{ permission.name }}</td>
                    <td class="tw-py-4 tw-border-b">
                        <el-switch v-model="permission.permitted"/>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    import RoleRequest from '../api/RoleRequest';

    export default {
        data() {
            return {
                fields: [],
                roles: [],
                permissions: [],
                request: new RoleRequest({}),
                params: {
                    ascending: true,
                    /*columnFilters: {
                    },*/
                    sortBy: 'field_1_value',
                    page: 1,
                    perPage: 5
                },
                total: 0
            }
        },

        methods: {
            retrieve() {
                this.request.setFields({
                    params: {...this.params}
                });

                this.request.retrieve().then((response) => {
                    this.roles = response.data.roles;
                });
            }
        },

        created() {
            this.retrieve();
        }
    }
</script>
