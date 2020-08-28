<template>
    <base-dialog :visible="active" @close="close" @open="open">
        <div slot="title">
            <base-icon class="tw-align-middle">person_add</base-icon> Create Program
        </div>
        <form>
            <div class="tw-mb-2">
              <label>
                  Program Name
              </label>
              <base-input
                v-model="programData['name']"
                name="name"
                @keydown.native="request.errors.clear($event.target.name)"/>
                <span
                  v-if="request.errors.has('name')"
                  v-text="request.errors.get('name')[0]"
                  class="tw-text-xs tw-text-red-500"></span>
            </div>
            <div>
              <label>
                  Volunteer Type
              </label>
              <base-select
                  v-model="programData.volunteer_type"
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
            </div>
            <div class="tw-mb-2">
              <label>
                  Team
              </label>
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
                <span
                  v-if="request.errors.has('team_id')"
                  v-text="request.errors.get('team_id')[0]"
                  class="tw-text-xs tw-text-red-500"></span>
            </div>
            <div>
              <label>
                  When a client is added to this program
              </label>
              <base-select
                  v-model="programData.default_client_status_id"
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
                v-text="request.errors.get('default_client_status_id')[0]"
                class="tw-text-xs tw-text-red-500"></span>
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
                    default_client_status_id: '',
                    volunteer_type: ''
                },
                teams: [],
                statuses: [],
                volunteerTypes: []
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
                    volunteer_type: '',
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
                    this.volunteerTypes = response.volunteer_types;
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
