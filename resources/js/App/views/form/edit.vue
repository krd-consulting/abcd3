<template>
    <base-dialog :visible="active" @close="close" @open="open">
        <div slot="title">
            <base-icon class="tw-align-middle">person_add</base-icon> Edit Form Information
        </div>
        <form>
            <div class="tw-mb-2">
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/4 tw-capitalize">
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
                    <label class="tw-w-1/4 tw-capitalize">
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
                    <label class="tw-w-1/4">
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
                    <label class="tw-w-1/4">
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
                    <label class="tw-w-1/4">
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
            <base-button  
                @click="close"
                class="tw-py-2 tw-pl-4 tw-bg-transparent tw-pr-4 tw-text-gray-700 tw-font-bold tw-border-none hover:tw-bg-transparent hover:tw-text-blue tw-text-xs">
                Nevermind
            </base-button>
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
        props: {
            active: Boolean,
            formId: Number | String
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
                    scope_id: ''
                };
            },

            open() {
                this.retrieve();
                this.retrieveTeams();
            },

            initializeWithData(data) {
                this.formData.id = data.form.id;
                this.formData.name = data.form.name;
                this.formData.description = data.form.description;
                this.formData.type = data.form.type;
                
                if(data.form.target == null) {
                    this.formData.target = data.form.target_type_id;
                }else {
                    this.formData.target = `${data.form.target_type_id}_${data.form.target_id}`;
                }

                this.formData.team_id = data.form.team_id;
                this.formData.scope_id = data.form.scope_id;

                this.targetTypes = data.target_types;
                this.types = data.types;
                this.scopes = data.scopes;
            },

            retrieve() {
                let request = new Request({});

                request.edit(this.formId).then((response) => {
                    this.initializeWithData(response.data);
                });
            },

            submit() {
                this.request = new Request(this.formData);

                this.request.update(this.formData.id)
                    .then((response) => {
                        this.$emit('update', response.data);
                        this.close();
                    })
                    .catch((error) => {
                        //
                    });
            }
        },
        created() {
        }
    }
</script>