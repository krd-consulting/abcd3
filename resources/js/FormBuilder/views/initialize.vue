<template>
    <base-dialog
        v-bind="$attrs"
        :close-on-click-modal="false"
        :show-close="false"
        :close-on-press-escape="false"
        :visible="active"
        @close="close"
        @open="open">
        <div slot="title">
            <base-icon class="tw-align-text-top">person_add</base-icon> Create New Form
        </div>
        <form>
            <div class="tw-mb-2">
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/3 tw-capitalize">
                        Form Name
                    </label>
                    <div class="tw-w-2/4">
                        <base-input
                            v-model="formData['name']"
                            name="name"
                            @keydown.native="request.errors.clear($event.target.name)"/>
                    </div>
                </div>
                <div v-if="request.errors.has('name')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('name')[0]" class="tw-text-xs tw-text-red-500"></span>
                    </div>
                </div>
            </div>

            <div class="tw-mb-2">
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/3">
                        Form Type
                    </label>
                    <div class="tw-w-2/3">
                        <base-select
                            v-model="formData.type"
                            name="type"
                            placeholder=" "
                            @change="request.errors.clear('type')">
                            <el-option
                                v-for="(type, index) in types"
                                :key="index"
                                :label="type"
                                :value="type">
                                {{ type }}
                            </el-option>
                        </base-select>
                    </div>
                </div>
                <div v-if="request.errors.has('type')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('type')[0]" class="tw-text-xs tw-text-red-500"></span>
                    </div>
                </div>
            </div>
            <div class="tw-mb-2">
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/3">
                        Collect data about
                    </label>
                    <div class="tw-w-2/3">
                        <base-select
                            v-model="formData.target"
                            name="target"
                            placeholder=""
                            @change="request.errors.clear('target.type');
                                request.errors.clear('target.type_id')">
                            <el-option
                                v-for="(type, index) in targetTypes"
                                :key="index"
                                :label="type.name"
                                :value="type.target">
                                <span v-if="type.name === 'Program' || type.name === 'Group'">
                                    {{ type.name }}s
                                </span>
                                <span v-else>{{ type.name }}</span>
                            </el-option>
                        </base-select>
                    </div>
                </div>
                <div v-if="request.errors.has('target.type')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('target.type')[0]" class="tw-text-xs tw-text-red-500"></span>
                    </div>
                </div>
                <div v-if="request.errors.has('target.type_id')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('target.type_id')[0]" class="tw-text-xs tw-text-red-500"></span>
                    </div>
                </div>
            </div>
            <div class="tw-mb-2">
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/3">
                        Limit form access to
                    </label>
                    <div class="tw-w-2/3">
                        <base-select
                            v-model="formData.scope_id"
                            name="target"
                            placeholder=""
                            @change="request.errors.clear('scope_id');">
                            <el-option
                                v-for="(scope, index) in formattedScopes"
                                :key="index"
                                :label="scope.label"
                                :value="scope.id">
                                {{ scope.label }}
                            </el-option>
                        </base-select>
                    </div>
                </div>
                <div v-if="request.errors.has('scope_id')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('scope_id')[0]" class="tw-text-xs tw-text-red-500"></span>
                    </div>
                </div>
                <div v-if="request.errors.has('target.type_id')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('target.type_id')[0]" class="tw-text-xs tw-text-red-500"></span>
                    </div>
                </div>
            </div>

            <!----------------------------   TODO: FIX THIS   ------------------------------->
            <div class="tw-mb-2">
                <div class="tw-flex tw-items-center tw-w-full" v-if="this.formData.scope_id !== 1 && this.formData.scope_id !== 6">
                    <label class="tw-w-1/3 tw-capitalize">
                        {{ scope.name }}
                    </label>
                    <div class="tw-w-2/3">
                        <base-select
                            v-model="formData.owner_id"
                            filterable
                            remote
                            :remote-method="retrieveOwners"
                            name="type"
                            placeholder=" "
                            @change="request.errors.clear('owner_id')">
                            <el-option
                                v-for="(owner, index) in owners"
                                :key="index"
                                :label="owner.name"
                                :value="owner.id">
                                {{ owner.name }}
                            </el-option>
                        </base-select>
                    </div>
                </div>
                <div v-if="request.errors.has('owner_id')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('owner_id')[0]" class="tw-text-xs tw-text-red-500"></span>
                    </div>
                </div>
            </div>
        </form>
        <div slot="footer" class="tw-border-t tw-px-4 tw-py-4 tw-bg-gray-100 tw-rounded-b">
            <a href="javascript:history.back()" class="tw-py-2 tw-pl-4 tw-bg-transparent tw-pr-4 tw-text-gray-700 tw-font-bold tw-border-none hover:tw-bg-transparent hover:tw-text-blue tw-text-xs">
                Nevermind
            </a>
            <base-button
                class="tw-py-2 tw-pl-4 tw-pr-4 tw-bg-blue-500 tw-text-white tw-font-bold tw-border-none"
                @click="submit">
                <span class="tw-text-xs tw-align-middle">OK</span>
            </base-button>
        </div>
    </base-dialog>
</template>
<script>
    import Request from '@/api/FormRequest';
    import TeamRequest from '@/api/TeamRequest';
    import ProgramRequest from '@/api/ProgramRequest';
    import GroupRequest from '@/api/GroupRequest';

    export default {
        inheritAttrs: false,

        props: {
            active: Boolean,
        },

        data() {
            return {
                request: new Request(),
                ownerRequestParams: {
                    ascending: true,
                    sortBy: 'name',
                    page: 1,
                    perPage: 10,
                    search: ''
                },
                formData: {
                    name: '',
                    description: '',
                    target: '',
                    type: '',
                    team_id: '',
                    scope_id: ''
                },
                targetTypes: [],
                types: [],
                scopes: [],
                owners: [],
                selectedType: null
            }
        },
        computed: {
            formattedScopes() {
                const labels  = {
                    universal : 'Everyone',
                    team: 'Users in this form\'s teams',
                    program: 'Users in this form\'s programs',
                    group: 'Users in this form\'s groups',
                    self: 'Just me'
                };

                const scopes = _.clone(this.scopes);


                return scopes.map((scope) => {
                    scope.label = labels[scope.name];
                    return scope;
                });
            },

            scope() {
                const scope = this.scopes.filter((scope) => scope.id == this.formData.scope_id)[0];

                if(scope == null) {
                    return {
                        name: ''
                    };
                }

                return scope;
            }
        },

        methods: {
            ownerClass(scope) {
                const classes = {
                    'team': TeamRequest,
                    'program': ProgramRequest,
                    'group': GroupRequest
                };

                return classes[scope];
            },

            retrieveOwners(keywords) {
                this.ownerRequestParams.search = keywords;

                const ownerClass = this.ownerClass(this.scope.name);

                let ownerRequest = new ownerClass({});

                ownerRequest.setFields({
                    params: {...this.ownerRequestParams }
                });

                let getOwners = ownerRequest.retrieve();

                getOwners.then(response => {
                    this.owners = response.data;
                });

                return getOwners;
            },

            close() {
                this.$emit('update:active', false);

                this.request.errors.clear();

                this.formData = {
                    name: '',
                    description: '',
                    target: '',
                    type: '',
                    team_id: '',
                    scope_id: '',
                };
            },

            open() {
                this.load();
            },

            load() {
                let request = new Request({});

                // this.retrieveTeams();

                request.create().then((response) => {
                    this.targetTypes = response.data.target_types;
                    this.types = response.data.types;
                    this.scopes = response.data.scopes;

                    this.formData.type = this.types['static'];
                    this.formData.target = this.targetTypes[0].target;
                    this.formData.scope_id = this.scopes[0].id;
                });

            },

            submit() {
                this.request = new Request(this.formData);

                this.request.validate()
                    .then((response) => {
                        this.$emit('save', response.data);
                        this.close();
                    })
                    .catch((error) => {
                        //
                    });
            }
        },

        created() {
            this.load();
        }
    }
</script>
