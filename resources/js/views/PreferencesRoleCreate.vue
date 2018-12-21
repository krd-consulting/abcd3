<template>
    <base-dialog title="Create Role" :visible="active" @close="close">
        <form>
            <div class="tw-flex tw-items-center tw-w-2/3 tw-mb-4">
                <label class="tw-w-1/3 tw-text-right tw-px-4">
                    Name
                </label>
                <div class="tw-w-2/3">
                    <el-input v-model="roleData.name">
                    </el-input>
                </div>
            </div>
            <div class="tw-flex tw-items-center tw-w-2/3 tw-mb-4">
                <label class="tw-w-1/3 tw-text-right tw-px-4">
                    Scope
                </label>
                <div class="tw-w-2/3">
                    <el-select v-model="roleData.scope" placeholder="Select Scope">
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
            <base-button @click="close">Cancel</base-button>
            <base-button @click="store">Confirm</base-button>
        </div>
    </base-dialog>
</template>
<script>
    import Request from '../api/RoleRequest';

    export default {
        props: {
            active: Boolean,

        },

        data() {
            return {
                roleData: {
                    name: '',
                    scope_id: ''
                },
                scopes: []
            }
        },

        methods: {
            prepareScopes() {
                let request = new Request({});

                request.create().then((response) => {
                    this.scopes = response.scopes;
                });
            },

            store() {
                let request = new Request({
                    'role': {
                        'name': this.roleData.name,
                        'scope_id': this.roleData.scope.id
                    }
                });

                request.store().then((response) => {
                    this.roleData = response.data;
                    this.close(true)
                });
            },

            close(saved) {
                if(saved)
                    this.$emit('save', this.roleData);

                this.$emit('update:active', false);

                this.roleData = {
                    role: {
                        scope: {
                        }
                    },
                };
            },
        },

        created() {
            this.prepareScopes();
        }
    }
</script>
