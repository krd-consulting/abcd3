<template>
    <base-dialog title="Manage Programs" :visible="active" @close="close" @open="open">
        <div class="tw-flex tw-text-grey-darkest">
            <div class="tw-flex-1 tw-pr-2">
                <div class="tw-border tw-border-blue-lighter tw-rounded tw-overflow-y-auto" style="max-height: 300px;">
                    <div class="tw-bg-blue-lightest tw-text-blue-dark tw-py-2 tw-px-2 tw-rounded-t">
                        Current Programs
                    </div>
                    <div class="tw-h-64 tw-overflow-y-auto">
                        <div v-if="selected.length == 0" class="tw-py-24 tw-text-center">
                            <span>Nothing here, yet.</span>
                        </div>
                        <div v-for="program in selected" class="tw-py-2 tw-px-2 tw-border-b tw-border-blue-lighter">
                            <label class="tw-flex">
                                <div class="tw-flex-initial">
                                    <base-checkbox :value="true" @change="remove(program.id)"/>
                                </div>
                                <div class="tw-flex-1 tw-pl-2">
                                    <div>
                                        <span class="tw-text-base">{{ program.name }}</span>
                                    </div>
                                    <div>
                                        <span class="tw-text-xs tw-text-grey">{{ program.team.name }}</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tw-flex-1 tw-pl-2">
                <div class="tw-rounded tw-border tw-overflow-y-auto" style="max-height: 300px;">
                    <div class="tw-bg-grey-lightest tw-py-2 tw-px-2 tw-rounded-t">
                        Available Programs
                    </div>
                    <div class="tw-h-64 tw-overflow-y-auto">
                        <div v-if="notSelected.length == 0" class="tw-py-24 tw-text-center">
                            <span>There are no more available programs.</span>
                        </div>
                        <div v-for="program in notSelected" class="tw-py-2 tw-px-2 tw-border-b">
                            <label class="tw-flex">
                                <div class="tw-flex-initial">
                                    <base-checkbox :value="false" @change="add(program.id)"/>
                                </div>
                                <div class="tw-flex-1 tw-pl-2">
                                    <div>
                                        <span class="tw-text-base">{{ program.name }}</span>
                                    </div>
                                    <div>
                                        <span class="tw-text-xs tw-text-grey">{{ program.team.name }}</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div slot="footer" class="tw-border-t tw-px-4 tw-py-4 tw-bg-grey-lightest tw-rounded-b">
            <base-button class="tw-py-2 tw-pl-4 tw-pr-4 tw-bg-blue tw-text-white tw-font-bold tw-border-none" @click="close">
                <span class="tw-text-xs tw-align-middle">Good to go!</span>
            </base-button>
        </div>
    </base-dialog>
</template>
<script>
    import ProgramRequest from '../api/ProgramRequest';
    import RecordProgramsRequest from '../api/RecordProgramsRequest';

    export default {
        props: {
            active: Boolean,
            assignedPrograms: Array
        },

        data() {
            return {
                programs: [],
                programsRequest: new ProgramRequest({}),
                recordProgramsRequest: new RecordProgramsRequest({}),
                selected: [],
            }
        },

        computed: {
            notSelected() {
                return _.differenceBy(this.programs, this.selected, 'id');
            }
        },

        methods: {
            close() {
                this.$emit('update:active', false);
                this.$emit('close');
            },

            open() {
                this.selected = _.cloneDeep(this.assignedPrograms);

                this.programsRequest.retrieve().then(response => {
                    this.programs = response;
                });
            },

            add(id) {
                this.recordProgramsRequest.store(
                    this.$route.params.recordType,
                    this.$route.params.record,
                    id
                ).then((response) => {
                    this.selected.push(_.find(this.programs, {id}));
                });
            },

            remove(id) {
                this.recordProgramsRequest.destroy(
                    this.$route.params.recordType,
                    this.$route.params.record,
                    id
                ).then((response) => {
                    this.selected = _.reject(this.selected, { id });
                });
            }
        },

        created() {

        }
    }
</script>
