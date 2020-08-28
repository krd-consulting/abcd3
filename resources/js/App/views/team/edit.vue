<template>
    <base-dialog :visible="active" @close="close" @open="retrieve">
        <div slot="title">
            <base-icon class="tw-align-middle">person_add</base-icon> Edit Team
        </div>
        <form>
            <div>
                <label>Team Name</label>
                <base-input
                    v-model="newTeamData.name"
                    name="name"
                    background
                    @keydown.native="request.errors.clear($event.target.name)"
                />
                <div
                    v-if="request.errors.has('name')"
                    v-text="request.errors.get('name')[0]"
                    class="field-error"
                ></div>
            </div>
            <!-- <div class="tw-mb-2">
                <div  class="tw-flex tw-items-center tw-w-full">
                    <label class="tw-w-1/5 tw-capitalize">
                        Description
                    </label>
                    <div class="tw-w-2/3">
                        <base-input
                            v-model="newTeamData['description']"
                            name="description"
                            @keydown.native="request.errors.clear($event.target.name)"/>
                    </div>
                </div>
                <div v-if="request.errors.has('description')" class="tw-flex tw-justify-end">
                    <div class="tw-w-4/5 tw-py-2">
                        <span v-text="request.errors.get('description')[0]" class="tw-text-xs tw-text-red"></span>
                    </div>
                </div>
            </div> -->
        </form>
        <div slot="footer" class="tw-grid tw-grid-cols-2 tw-py-4 tw-px-4 tw-border-t tw-bg-gray-100 tw-rounded-b">
            <div class="tw-text-left">
                <div class="tw-py-2">
                    <el-switch id="input_team_active" v-model="newTeamData.active" name="active">
                    </el-switch>
                    <label for="input_team_active">Enabled</label>
                </div>
            </div>
            <div>
                <base-button gray @click="close(false)">
                    <span class="tw-text-xs tw-align-middle">Cancel</span>
                </base-button>
                <base-button @click="store">
                        <span class="tw-text-xs tw-align-middle">Save</span>
                </base-button>
            </div>
        </div>
    </base-dialog>
</template>
<script>
    import Request from '@/api/TeamRequest';

    export default {
        props: {
            active: Boolean,
            teamId: Number | String
        },

        data() {
            return {
                request: new Request(),
                newTeamData: {
                    name: '',
                    description: '',
                    active: false
                },
            }
        },

        methods: {
            close() {
                this.$emit('update:active', false);

                this.request.errors.clear();

                this.newTeamData.id = null;
                this.newTeamData.name = null;
                this.newTeamData.description = null;
            },

            initializeWithData(data) {
                this.newTeamData.id = data.id;
                this.newTeamData.name = data.name;
                this.newTeamData.description = data.description;
                this.newTeamData.active = data.active;
            },

            retrieve() {
                let request = new Request({});

                request.edit(this.teamId).then((response) => {
                    this.initializeWithData(response.data);
                });
            },

            store() {
                this.request = new Request(this.newTeamData);

                this.request.update(this.newTeamData.id)
                    .then((response) => {
                        this.$emit('update');
                        this.$message({
                            type: 'success',
                            message: 'Team updated successfully!'
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
