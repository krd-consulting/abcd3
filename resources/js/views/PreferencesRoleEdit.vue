<template>
    <base-dialog title="Edit Role" :visible="active" @close="close">
        <form>
            <div>
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5 tw-text-right tw-px-4">
                        Name
                    </label>
                    <div class="tw-w-2/3">
                        <base-input
                            v-model="newRoleData.name"
                            :value="role.name"
                            name="name"/>
                    </div>
                </div>
                <div v-if="request.errors.has('name')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('name')[0]" class="tw-text-xs tw-text-red"></span>
                    </div>
                </div>
            </div>
            <div class="tw-mt-2">
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5 tw-text-right tw-px-4">
                        Scope
                    </label>
                    <div class="tw-w-2/3">
                        <base-select
                            v-model="newRoleData.scope"
                            name="scope_id"
                            placeholder="Select Scope">
                            <el-option
                                v-for="scope in scopes"
                                :key="scope.id"
                                :label="scope.name"
                                :value="scope">
                                <scope-tag :scope="scope.id">{{ scope.name }}</scope-tag>
                            </el-option>
                        </base-select>
                    </div>
                </div>
                <div v-if="request.errors.has('scope_id')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('scope_id')[0]" class="tw-text-xs tw-text-red"></span>
                    </div>
                </div>
            </div>
        </form>
        <div slot="footer">
            <base-button @click="close(false)">Cancel</base-button>
            <base-button @click="update">Confirm</base-button>
        </div>
    </base-dialog>
</template>
<script>
    import Request from '../api/RoleRequest';

    export default {
        props: {
            active: Boolean,
            role: Object
        },

        data() {
            return {
                newRoleData: {
                    id: '',
                    name: '',
                    scope_id: '',
                    scope: {}
                },

                request: new Request({
                    id: '',
                    name: '',
                    scope_id: '',
                    scope: {}
                }),

                scopes: []
            }
        },

        watch: {
            role: function() {
                this.newRoleData = this.role;
            },

            active: function() {
                if(this.active) {
                    this.editing = this.active;
                }
            }
        },

        methods: {
            prepareScopes() {
                let request = new Request({});

                request.edit().then((response) => {
                    this.scopes = response.scopes;
                });
            },

            close(updated) {
                if(updated)
                    this.$emit('update', this.newRoleData);

                this.$emit('update:active', false);

                this.request.errors.clear();
            },

            update() {
                this.request = new Request({
                    id: this.newRoleData.id,
                    name: this.newRoleData.name,
                    scope_id: this.newRoleData.scope.id
                });

                this.request.update(this.newRoleData.id)
                    .then((response) => {
                        this.close(true);
                    })
                    .catch(() => {
                        //
                    });
            },
        },

        created() {
            this.prepareScopes();
        }
    }
</script>
