<template>
    <base-dialog :visible="active" @close="close" @open="open">
        <div slot="title">
            <base-icon class="tw-align-middle">person_add</base-icon> Edit Form
        </div>
        <form>
            <div class="tw-mb-2">
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5 tw-capitalize">
                        Program Name
                    </label>
                    <div class="tw-w-2/3">
                        <base-input
                            v-model="newProgramData['name']"
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
            <div class="tw-mb-2">
                <div  class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5 tw-capitalize">
                        Description
                    </label>
                    <div class="tw-w-2/3">
                        <base-input
                            v-model="newProgramData['description']"
                            name="description"
                            @keydown.native="request.errors.clear($event.target.name)"/>
                    </div>
                </div>
                <div v-if="request.errors.has('description')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('description')[0]" class="tw-text-xs tw-text-red"></span>
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
                            v-model="newProgramData.team.id"
                            :value="newProgramData.team.id"
                            name="team"
                            placeholder="Select Team"
                            @change="request.errors.clear('team')"
                            disabled>
                            <el-option
                                :key="newProgramData.team.id"
                                :label="newProgramData.team.name"
                                :value="newProgramData.team.id">
                                {{ newProgramData.team.name }}
                            </el-option>
                        </base-select>
                    </div>
                </div>
                <div v-if="request.errors.has('team_id')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('team_id')[0]" class="tw-text-xs tw-text-red"></span>
                    </div>
                </div>
            </div>
            <div class="tw-mb-2">
                <div class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5">
                        Default Status for Clients
                    </label>
                    <div class="tw-w-2/3">
                        <base-select
                            v-model="newProgramData.default_client_status_id"
                            name="team"
                            placeholder="Select Default Status"
                            @change="request.errors.clear('default_client_status_id')">
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
                <div v-if="request.errors.has('default_client_status_id')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('default_client_status_id')[0]" class="tw-text-xs tw-text-red"></span>
                    </div>
                </div>
            </div>
            <div>
                <div class="tw-flex tw-items-center tw-w-full">
                    <label>
                        Set client's status as 

                        <base-select
                            v-model="newProgramData.case_client_status_id"
                            name="team"
                            placeholder="Select Default Status"
                            @change="request.errors.clear('case_client_status_id')">
                            <el-option
                                v-for="status in statuses"
                                :key="status.id"
                                :label="status.name"
                                :value="status.id">
                                {{ status.name }}
                            </el-option>
                        </base-select>

                        when added as case.
                    </label>
                </div>
                <div v-if="request.errors.has('case_client_status_id')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('case_client_status_id')[0]" class="tw-text-xs tw-text-red"></span>
                    </div>
                </div>
            </div>
            <div>
                <div class="tw-flex tw-items-center tw-w-full">
                    <label>
                        Set client's status as 

                        <base-select
                            v-model="newProgramData.group_client_status_id"
                            name="team"
                            placeholder="Select Default Status"
                            @change="request.errors.clear('group_client_status_id')">
                            <el-option
                                v-for="status in statuses"
                                :key="status.id"
                                :label="status.name"
                                :value="status.id">
                                {{ status.name }}
                            </el-option>
                        </base-select>

                        when added to group.
                    </label>
                </div>
                <div v-if="request.errors.has('group_client_status_id')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('group_client_status_id')[0]" class="tw-text-xs tw-text-red"></span>
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
    import StatusRequest from '@/api/ClientStatusRequest';

    export default {
        props: {
            active: Boolean,
            programId: Number | String
        },
        data() {
            return {
                request: new Request(),
                program: {},
                newProgramData: {
                    name: '',
                    description: '',
                    team: {},
                    team_id: '',
                    default_client_status_id: '',
                    group_client_status_id: ''
                },
                statuses: []
            }
        },
        methods: {
            close() {
                this.$emit('update:active', false);
                this.request.errors.clear();
                this.newProgramData = {
                    id: '',
                    name: '',
                    description: '',
                    team: {},
                    team_id: '',
                    default_client_status_id: '',
                    group_client_status_id: ''
                };
            },
            open() {
                this.retrieve();
                this.retrieveStatus();

                this.newProgramData.default_client_status_id = 
                    Number(
                        this.newProgramData.default_client_status_id
                    );

                this.newProgramData.group_client_status_id = 
                    Number(
                        this.newProgramData.group_client_status_id
                    );
            },
            initializeWithData(data) {
                this.newProgramData.id = data.id;
                this.newProgramData.name = data.name;
                this.newProgramData.description = data.description;
                this.newProgramData.team_id = data.team_id;
                this.newProgramData.team = data.team;
                this.newProgramData.default_client_status_id = data.default_client_status_id;
                this.newProgramData.group_client_status_id = data.group_client_status_id;
            },
            retrieve() {
                let request = new Request({});
                request.edit(this.programId).then((response) => {
                    this.initializeWithData(response.data);
                });
            },
            retrieveStatus() {
                let request = new StatusRequest({});
                request.retrieve().then((response) => {
                    this.statuses = response.data;
                });
            },
            store() {
                this.request = new Request(this.newProgramData);
                this.request.update(this.newProgramData.id)
                    .then((response) => {
                        this.$emit('update');
                        this.$message({
                            type: 'success',
                            message: 'Program updated successfully!'
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