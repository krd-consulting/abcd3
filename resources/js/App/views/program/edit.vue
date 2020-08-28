<template>
    <base-dialog :visible="active" @close="close" @open="open">
        <div slot="title">
            <base-icon class="tw-align-middle">person_add</base-icon> Edit Form
        </div>
        <form>
            <div class="tw-mb-2">
              <label>
                  Program Name
              </label>
              <base-input
                  v-model="newProgramData['name']"
                  name="name"
                  @keydown.native="request.errors.clear($event.target.name)"/>
              <span
                v-if="request.errors.has('name')"
                v-text="request.errors.get('name')[0]"
                class="tw-text-xs tw-text-red"></span>
            </div>
            <!--<div>
              <label>
                  Volunteer Type
              </label>
              <base-select
                  v-model="newProgramData.volunteer_type"
                  name="team"
                  placeholder="Select Volunteer Type"
                  @change="request.errors.clear('volunteer_type')">
                  <el-option
                      key="none"
                      label="None"
                      value="">
                      None
                  </el-option>
                  <el-option
                      v-for="type in volunteerTypes"
                      :key="type.slug"
                      :label="type.name"
                      :value="type.slug">
                      {{ type.name }}
                  </el-option>
              </base-select>
              <span
                v-if="request.errors.has('volunteer_type')"
                v-text="request.errors.get('volunteer_type')[0]"
                class="tw-text-xs tw-text-red-500"></span>
            </div>-->
            <div class="tw-mb-2">
              <label>
                  Team
              </label>
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
              <span
                v-if="request.errors.has('team_id')"
                v-text="request.errors.get('team_id')[0]"
                class="tw-text-xs tw-text-red"></span>
            </div>
            <div class="tw-mb-2">
              <label>
                  When a client is added to this program
              </label>
              <base-select
                  v-model="newProgramData.default_client_status_id"
                  name="team"
                  placeholder="Set the client's status to..."
                  @change="request.errors.clear('default_client_status_id')">
                  <el-option
                      v-for="status in statuses"
                      :key="status.id"
                      :label="`Set the client's status to ${status.name}`"
                      :value="status.id">
                      {{ status.name }}
                  </el-option>
              </base-select>
              <span
                v-if="request.errors.has('default_client_status_id')"
                v-text="request.errors.get('default_client_status_id')[0]" class="tw-text-xs tw-text-red"></span>
            </div>
            <div class="tw-mb-2">
              <label>
                  When a client is assigned as a case
              </label>

              <base-select
                  v-model="newProgramData.case_client_status_id"
                  name="team"
                  placeholder="Set the client's status to..."
                  @change="request.errors.clear('case_client_status_id')">
                  <el-option
                      v-for="status in statuses"
                      :key="status.id"
                      :label="`Set the client's status to ${status.name}`"
                      :value="status.id">
                      {{ status.name }}
                  </el-option>
              </base-select>
              <span
                v-if="request.errors.has('case_client_status_id')"
                v-text="request.errors.get('case_client_status_id')[0]"
                class="tw-text-xs tw-text-red"></span>
            </div>
            <div class="tw-mb-2">
              <label>
                  When a client is added to a group
              </label>
              <base-select
                  v-model="newProgramData.group_client_status_id"
                  name="team"
                  placeholder="Set the client's status to..."
                  @change="request.errors.clear('group_client_status_id')">
                  <el-option
                      v-for="status in statuses"
                      :key="status.id"
                      :label="`Set the client's status to ${status.name}`"
                      :value="status.id">
                      {{ status.name }}
                  </el-option>
              </base-select>
              <span
                v-if="request.errors.has('group_client_status_id')"
                v-text="request.errors.get('group_client_status_id')[0]"
                class="tw-text-xs tw-text-red"></span>
            </div>

        </form>
        <div slot="footer" class="tw-px-4 tw-py-4 tw-rounded-b">
            <base-button class="tw-py-2 tw-pl-4 tw-bg-transparent tw-pr-4 tw-text-gray-700 tw-font-bold tw-border-none hover:tw-bg-transparent hover:tw-text-blue" @click="close(false)">
                <span class="tw-text-xs tw-align-middle">Nevermind</span>
            </base-button>
            <base-button class="tw-py-2 tw-pl-4 tw-pr-4 tw-bg-indigo-base tw-text-white tw-font-bold tw-border-none" @click="store">
                <span class="tw-text-xs tw-align-middle">OK</span>
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
                    case_client_status_id: '',
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
                    case_client_status_id: '',
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

                this.newProgramData.case_client_status_id =
                    Number(
                        this.newProgramData.case_client_status_id
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
                this.newProgramData.case_client_status_id = data.case_client_status_id;
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
