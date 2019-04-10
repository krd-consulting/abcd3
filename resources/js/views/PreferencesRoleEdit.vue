<template>
    <base-dialog title="Edit Role" :visible="active" @close="close" @open="open">
        <form>
            <div>
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5">
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
                    <label class="tw-w-1/5">
                        Scope
                    </label>
                    <div class="tw-w-2/3">
                        <base-select
                            v-model="newRoleData.scope"
                            name="scope"
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
        <div slot="footer" class="tw-flex tw-justify-between tw-border-t tw-px-4 tw-py-4 tw-bg-grey-lightest tw-rounded-b">
            <div>
                <base-button class="tw-py-2 tw-pl-4 tw-pr-4 tw-bg-red-lightest tw-text-red-dark tw-font-bold tw-border-none hover:tw-bg-red hover:tw-text-white" @click="close(false)">
                    <span class="tw-text-xs tw-align-middle">Delete Role</span>
                </base-button>
            </div>
            <div>
                <base-button class="tw-py-2 tw-pl-4 tw-bg-transparent tw-pr-4 tw-text-grey-darker tw-font-bold tw-border-none hover:tw-bg-transparent hover:tw-text-blue" @click="close(false)">
                    <span class="tw-text-xs tw-align-middle">Nevermind</span>
                </base-button>
                <base-button class="tw-py-2 tw-pl-4 tw-pr-4 tw-bg-blue tw-text-white tw-font-bold tw-border-none" @click="update">
                    <span class="tw-text-xs tw-align-middle">Good to go!</span>
                </base-button>
            </div>
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

        methods: {
            load() {
                let request = new Request({});

                request.edit().then((response) => {
                    this.scopes = response.scopes;
                });
            },

            close() {
                this.$emit('update:active', false);

                this.request.errors.clear();
            },

            open() {
                if(this.scopes.length == 0)
                    this.load();

                this.newRoleData = this.role;
            },

            update() {
                this.request = new Request({
                    id: this.newRoleData.id,
                    name: this.newRoleData.name,
                    scope_id: this.newRoleData.scope.id
                });

                this.request.update(this.newRoleData.id)
                    .then((response) => {
                        this.newRoleData = response.data;
                        this.$emit('update', this.newRoleData);
                        this.close();
                    })
                    .catch(() => {
                        //
                    });
            },
        },

        created() {

        }
    }
</script>
