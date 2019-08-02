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
            <base-icon class="tw-align-middle">person_add</base-icon> Create Form
        </div>
        <form>
            <div class="tw-mb-2">
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5 tw-capitalize">
                        Form Name
                    </label>
                    <div class="tw-w-2/3">
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
                <div  class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5 tw-capitalize">
                        Description
                    </label>
                    <div class="tw-w-2/3">
                        <base-input
                            v-model="formData['description']"
                            name="description"
                            @keydown.native="request.errors.clear($event.target.name)"/>
                    </div>
                </div>
                <div v-if="request.errors.has('description')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('description')[0]" class="tw-text-xs tw-text-red-500"></span>
                    </div>
                </div>
            </div>
            <div class="tw-mb-2">
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5">
                        Team
                    </label>
                    <div class="tw-w-2/3">
                        <base-select
                            v-model="formData.team_id"
                            filterable
                            remote
                            :remote-method="retrieveTeams"
                            name="type"
                            placeholder="Select Team"
                            @change="request.errors.clear('team_id')">
                            <el-option
                                v-for="(team, index) in teams"
                                :key="index"
                                :label="team.name"
                                :value="team.id">
                                {{ team.name }}
                            </el-option>
                        </base-select>
                    </div>
                </div>
                <div v-if="request.errors.has('team_id')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('team_id')[0]" class="tw-text-xs tw-text-red-500"></span>
                    </div>
                </div>
            </div>
            <div class="tw-mb-2">
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5">
                        Form Type
                    </label>
                    <div class="tw-w-2/3">
                        <base-select
                            v-model="formData.type"
                            name="type"
                            placeholder="Select Form Type"
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
                    <label class="tw-w-1/5">
                        This form is about
                    </label>
                    <div class="tw-w-2/3">
                        <base-select
                            v-model="formData.target"
                            name="target"
                            placeholder="Select Resource"
                            @change="request.errors.clear('target.type');
                                request.errors.clear('target.type_id')">
                            <el-option
                                v-for="(type, index) in targetTypes"
                                :key="index"
                                :label="type.name"
                                :value="type.target">
                                {{ type.name }}
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
                    <label class="tw-w-1/5">
                        Who can see this form?
                    </label>
                    <div class="tw-w-2/3">
                        <base-select
                            v-model="formData.scope_id"
                            name="target"
                            placeholder="Choose who can see this form."
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
        </form>
        <div slot="footer" class="tw-border-t tw-px-4 tw-py-4 tw-bg-gray-100 tw-rounded-b">
            <a href="javascript:history.back()" class="tw-py-2 tw-pl-4 tw-bg-transparent tw-pr-4 tw-text-gray-700 tw-font-bold tw-border-none hover:tw-bg-transparent hover:tw-text-blue tw-text-xs">
                Nevermind
            </a>
            <base-button 
                class="tw-py-2 tw-pl-4 tw-pr-4 tw-bg-blue-500 tw-text-white tw-font-bold tw-border-none"
                @click="submit">
                <span class="tw-text-xs tw-align-middle">Good to go!</span>
            </base-button>
        </div>
    </base-dialog>
</template>
<script>
    import Request from '@/api/FormRequest';
    import TeamRequest from '@/api/TeamRequest';

    export default {
        inheritAttrs: false,

        props: {
            active: Boolean,
        },

        data() {
            return {
                request: new Request(),
                teamRequest: new TeamRequest(),
                teamRequestParams: {
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
                teams: []
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
            }
        },

        methods: {
            retrieveTeams(keywords) {
                this.teamRequestParams.search = keywords;

                this.teamRequest.setFields({
                    params: {...this.teamRequestParams }
                });

                this.teamRequest.retrieve().then(response => {
                    this.teams = response.data;
                });
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

                request.create().then((response) => {
                    this.targetTypes = response.data.target_types;
                    this.types = response.data.types;
                    this.scopes = response.data.scopes;
                });

                this.retrieveTeams();
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
