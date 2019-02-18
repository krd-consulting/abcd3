<template>
    <div>
        <div class="tw-mb-2">
            <div class="tw-text-center tw-py-16 tw-bg-grey-lightest tw-rounded tw-mx-4 tw-my-4" v-if="programs.length == 0">
                <div>
                    <base-button
                        class="tw-py-2 tw-pl-2 tw-pr-4 tw-bg-blue hover:tw-bg-transparent hover:tw-text-blue tw-text-white tw-border-none"
                        @click="addProgram">
                        <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
                        <span class="tw-text-xs tw-align-middle">Add Programs</span>
                    </base-button>
                </div>
            </div>
            <div v-if="programs.length > 0"
                class="tw-pt-6 tw-pb-2 tw-pl-4 tw-text-xs tw-text-grey tw-uppercase tw-font-semibold">
                <div class="tw-flex tw-w-4/5">
                    <div class="tw-w-1/4 tw-m-0">
                        <span class="tw-tracking-wide">Program</span>
                    </div>
                    <div class="tw-w-1/4 tw-m-0">
                        <span class="tw-tracking-wide">Status</span>
                    </div>
                    <div class="tw-w-1/4 tw-m-0">
                        <span class="tw-tracking-wide">Enrollment Date</span>
                    </div>
                    <div class="tw-w-1/4 tw-m-0">
                        <span class="tw-tracking-wide">Notes</span>
                    </div>
                </div>
            </div>
            <list-item
                v-if="programs.length > 0"
                :to="`/programs/${program.id}`"
                :key="program.id"
                v-for="program in programs"
                class="group tw-pl-4 tw-py-4">
                <span class="hover:tw-text-blue">{{ program.name }}</span>
                <template v-slot:secondary-data>
                    <base-icon class="tw-text-grey tw-text-xs tw-text-align-middle">people</base-icon>
                    <span class="tw-text-grey tw-text-sm tw-text-align-middle">{{ program.team.name }}</span>
                </template>
                <template v-slot:tertiary-data>
                    <div class="tw-flex tw-w-3/5 tw-items-center">
                        <div class="tw-w-1/3">
                            <div v-if="program.pivot.status" class="tw-uppercase tw-text-sm tw-font-semibold tw-text-green">
                                <span>{{ program.pivot.status }}</span>
                            </div>
                            <div v-if="program.pivot.status_updated_at" class="tw-text-sm tw-text-grey">
                                <span>Since {{ program.pivot.status_updated_at }}</span>
                            </div>
                        </div>
                        <div class="tw-w-1/3">
                            <span>{{ program.pivot.created_at }}</span>
                        </div>
                        <div class="tw-w-1/3">
                            <p v-if="program.pivot.notes">{{ program.pivot.notes }}</p>
                            <base-button v-else class="tw-py-2 tw-px-0 tw-text-grey tw-font-semibold tw-border-none hover:tw-bg-transparent hover:tw-text-blue">
                                <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
                                <span class="tw-text-xs tw-align-middle">Add Note</span>
                            </base-button>
                        </div>
                    </div>
                </template>
                <template v-slot:options-container>
                    <div class="tw-w-1/5 tw-text-right">
                        <div class="tw-px-4">
                            <base-button class="tw-py-2 tw-px-2 tw-text-grey hover:tw-bg-transparent hover:tw-text-grey-darkest tw-border-none">
                                <base-icon class="tw-text-xs tw-mr-1 tw-align-middle">edit</base-icon>
                                <span class="tw-text-xs tw-align-middle">Edit</span>
                            </base-button>
                            <base-button class="tw-py-2 tw-px-2 tw-text-grey hover:tw-bg-transparent hover:tw-text-red tw-border-none" @click="remove(program.id)">
                                <base-icon class="tw-text-xs tw-mr-1 tw-align-middle">close</base-icon>
                                <span class="tw-text-xs tw-align-middle">Remove</span>
                            </base-button>
                        </div>
                    </div>
                </template>
            </list-item>
        </div>
        <div class="tw-px-4 tw-pb-4">
            <base-button
                v-if="programs.length > 0"
                class="tw-py-2 tw-pl-2 tw-pr-4 hover:tw-bg-transparent hover:tw-text-blue tw-text-grey tw-border-none"
                @click="addProgram">
                <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
                <span class="tw-text-xs tw-align-middle">Manage Programs</span>
            </base-button>
            <add-program
                :active.sync="add.active"
                :assignedPrograms="programs"
                @close="retrieve">
            </add-program>
        </div>
    </div>
</template>
<script>
    import ProgramsRequest from '../api/RecordProgramsRequest';

    import ListItem from '../components/AppListItem';

    import AddProgram from './AppRecordProfileAddProgram';

    export default {
        components: {
            AddProgram,
            ListItem
        },

        data() {
            return {
                add: {
                    active: false
                },
                request: new ProgramsRequest({}),
                programs: []
            }
        },

        methods: {
            remove(id) {
                this.request.destroy(
                    this.$route.params.recordType,
                    this.$route.params.record,
                    id
                ).then((response) => {
                    this.retrieve();
                });
            },

            retrieve() {
                this.request.retrieve(this.$route.params.recordType, this.$route.params.record).then((response) => {
                    this.programs = response;
                });
            },

            addProgram() {
                this.add.active = true;
            }
        },

        created() {
            this.retrieve();
        }
    }
</script>
