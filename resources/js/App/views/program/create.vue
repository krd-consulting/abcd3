<template>
    <base-dialog :visible="active" @close="close" @open="open">
        <div slot="title">
            <base-icon class="tw-align-middle">person_add</base-icon> Create Program
        </div>
        <form>
            <div class="tw-mb-2">
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5 tw-capitalize">
                        Program Name
                    </label>
                    <div class="tw-w-2/3">
                        <base-input
                            v-model="programData['name']"
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
                            v-model="programData['description']"
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
                            v-model="programData.team_id"
                            name="team"
                            placeholder="Select Team"
                            @change="request.errors.clear('team_id')"
                            :disabled="disableTeam">
                            <el-option
                                v-for="team in teams"
                                :key="team.id"
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
            <div>
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5">
                        Default Status for Clients
                    </label>
                    <div class="tw-w-2/3">
                        <base-select
                            v-model="programData.settings.default_client_status_id"
                            name="team"
                            placeholder="Select Default Status"
                            @change="request.errors.clear('settings.default_client_status_id')">
                            <el-option
                                v-for="status in statuses"
                                :key="status.id"
                                :label="status.name"
                                :value="status.id">
                                {{ status.name }}
                            </el-option>
                        </base-select>
                    </div>
                </div>
                <div v-if="request.errors.has('settings.default_client_status_id')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('settings.default_client_status_id')[0]" class="tw-text-xs tw-text-red-500"></span>
                    </div>
                </div>
            </div>
        </form>
        <div slot="footer" class="tw-border-t tw-px-4 tw-py-4 tw-bg-gray-100 tw-rounded-b">
            <base-button class="tw-py-2 tw-pl-4 tw-bg-transparent tw-pr-4 tw-text-gray-700 tw-font-bold tw-border-none hover:tw-bg-transparent hover:tw-text-blue" @click="close(false)">
                <span class="tw-text-xs tw-align-middle">Nevermind</span>
            </base-button>
            <base-button class="tw-py-2 tw-pl-4 tw-pr-4 tw-bg-blue-500 tw-text-white tw-font-bold tw-border-none" @click="store">
                <span class="tw-text-xs tw-align-middle">Good to go!</span>
            </base-button>
        </div>
    </base-dialog>
</template>
<script>
    import Request from '@/api/ProgramRequest';

    export default {
        props: {
            active: Boolean,
            teamId: {
                type: String | Number,
                default: ''
            },
            disableTeam: {
                type: Boolean,
                default: false
            }
        },

        data() {
            return {
                request: new Request(),
                programData: {
                    name: '',
                    description: '',
                    team_id: '',
                    settings: { 
                        default_client_status_id: ''
                    }
                },
                teams: [],
                statuses: []
            }
        },

        methods: {
            close() {
                this.$emit('update:active', false);

                this.request.errors.clear();

                this.programData = {
                    name: '',
                    description: '',
                    team_id: '',
                    settings: { 
                        default_client_status_id: ''
                    }
                };
            },

            open() {
                this.programData.team_id = this.teamId == '' ? '' : Number(this.teamId);

                this.load();
            },

            load() {
                let request = new Request({});

                request.create().then((response) => {
                    this.teams = response.teams;
                    this.statuses = response.statuses;
                });
            },

            store() {
                this.request = new Request(this.programData);

                this.request.store()
                    .then((response) => {
                        this.$emit('save');
                        this.$message({
                            type: 'success',
                            message: 'Program created successfully!'
                        });
                        this.close()
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
