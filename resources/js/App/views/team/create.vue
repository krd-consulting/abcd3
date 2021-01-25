<template>
    <base-dialog :visible="active" @close="close" @open="open">
        <div slot="title">
            <div slot="title">Add a new team</div>
        </div>
        <form>
            <div>
                <label>Team Name</label>
                <base-input
                    v-model="teamData.name"
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
        </form>
        <div slot="footer" class="tw-grid tw-grid-cols-2 tw-py-4 tw-px-4 tw-border-t tw-bg-gray-100 tw-rounded-b">
            <div class="tw-text-left">
                <div class="tw-py-2">
                    <el-switch id="input_team_active" v-model="teamData.active" name="active">
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
import Request from "@/api/TeamRequest";

export default {
    props: {
        active: Boolean,
        programId: Number | String,
        teamId: {
            type: Number | String,
            default: null
        }
    },

    data() {
        return {
            request: new Request(),
            teamData: {
                name: '',
                active: true
            },
        };
    },

    methods: {
        close() {
            this.$emit("update:active", false);

            this.request.errors.clear();

            this.teamData.name = '';
        },

        open() {
            this.load();
        },

        load() {
            let request = new Request({});
        },

        store() {
            this.request = new Request(this.teamData);

            this.request
                .store()
                .then(response => {
                    this.$emit("save");
                    this.$message({
                        type: "success",
                        message: "Team created successfully!"
                    });
                    this.close();
                })
                .catch(error => {
                    //
                });
        }
    },

    created() {}
};
</script>
