<template>
    <base-dialog title="Manage Programs" :visible="active" @close="close" @open="open">
        <div class="tw-flex">
            <div class="tw-flex-1 tw-pr-2">
                <div class="tw-border" style="height: 300px;">
                    <div class="tw-bg-grey-lightest tw-py-2 tw-px-2">
                        Current Programs
                    </div>
                    <div class="tw-px-2">
                        <div v-if="selected.length == 0" class="tw-py-2 tw-text-center">
                            <span>There are no current programs, yet.</span>
                        </div>
                        <div v-for="program in selected" class="tw-py-2">
                            <label>
                                <base-checkbox :value="true" @change="remove(program.id)"/>
                                <span>{{ program.name }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tw-flex-1 tw-pl-2">
                <div class="tw-border" style="height: 300px;">
                    <div class="tw-bg-grey-lightest tw-py-2 tw-px-2">
                        Available Programs
                    </div>
                    <div class="tw-px-2">
                        <div v-if="notSelected.length == 0" class="tw-py-2 tw-text-center">
                            <span>There are no more available programs.</span>
                        </div>
                        <div v-for="program in notSelected" class="tw-py-2">
                            <label>
                                <base-checkbox :value="false" @change="add(program.id)"/>
                                <span>{{ program.name }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div slot="footer">
            <base-button @click="close">Done!</base-button>
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
