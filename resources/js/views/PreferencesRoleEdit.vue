<template>
    <base-dialog title="Edit Role" :visible="active" @close="closeEditRole">
        <form>
            <div class="tw-flex tw-items-center tw-w-2/3 tw-mb-4">
                <label class="tw-w-1/3 tw-text-right tw-px-4">
                    Name
                </label>
                <div class="tw-w-2/3">
                    <el-input v-model="newRoleData.name">
                    </el-input>
                </div>
            </div>
            <div class="tw-flex tw-items-center tw-w-2/3 tw-mb-4">
                <label class="tw-w-1/3 tw-text-right tw-px-4">
                    Scope
                </label>
                <div class="tw-w-2/3">
                    <el-select v-model="newRoleData.scope">
                        <el-option
                            v-for="scope in scopes"
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
            <base-button @click="closeEditRole">Cancel</base-button>
            <base-button @click="updateRole">Confirm</base-button>
        </div>
    </base-dialog>
</template>
<script>
    import Request from '../api/RoleRequest';

    export default {
        props: {
            active: false,
            role: Object
        },

        data() {
            return {
                newRoleData: {
                    name: '',
                    scope_id: '',
                    scope: {}
                },

                scopes: []
            }
        },

        watch: {
            role: function() {
                this.newRoleData = this.role;
            },

            active: function() {
                if(this.active)
                    this.editing = this.active;
            }
        },

        methods: {
            prepareScopes() {
                let request = new Request({});

                request.edit().then((response) => {
                    this.scopes = response.scopes;
                });
            },

            closeEditRole(updated) {

                if(updated)
                    this.$emit('update', this.newRoleData);

                this.$emit('update:active', false);
            },

            updateRole() {
                let request = new Request({
                    'role': {
                        'id': this.newRoleData.id,
                        'name': this.newRoleData.name,
                        'scope_id': this.newRoleData.scope.id
                    }
                });

                request.update(this.newRoleData.id).then((response) => {
                    this.closeEditRole(true);
                });
            },
        },

        created() {
            this.prepareScopes();
        }
    }
</script>
