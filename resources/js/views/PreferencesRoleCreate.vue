<template>
    <base-dialog :visible="active" @close="close">
        <div slot="title">
            <base-icon class="tw-align-middle">person_add</base-icon> Create Role
        </div>
        <form>
            <div>
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5 tw-text-right tw-px-4">
                        Name
                    </label>
                    <div class="tw-w-2/3">
                            <base-input
                                v-model="roleData.name"
                                name="name"
                                @keydown.native="request.errors.clear($event.target.name)"/>
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
                            v-model="roleData.scope"
                            name="scope_id"
                            placeholder="Select Scope"
                            @change="request.errors.clear('scope_id')">
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
            <base-button @click="store">Create</base-button>
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
                request: new Request({
                    name: '',
                    scope_id: ''
                }),
                roleData: {
                    name: '',
                    scope: {
                        id: ''
                    }
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
                this.request = new Request({
                    name: this.roleData.name,
                    scope_id: this.roleData.scope.id
                });

                this.request.store()
                    .then((response) => {
                        this.roleData = response.data;
                        this.close(true)
                    })
                    .catch((error) => {
                        //
                    });
            },

            close(saved = false) {
                if(saved)
                    this.$emit('save', this.roleData);

                this.$emit('update:active', false);

                this.request.errors.clear();

                this.roleData = {
                    name: '',
                    scope: {
                        id: ''
                    }
                };
            },
        },

        created() {
            this.prepareScopes();
        }
    }
</script>
