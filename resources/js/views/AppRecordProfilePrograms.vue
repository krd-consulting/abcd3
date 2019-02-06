<template>
    <div>
        <div class="tw-mb-2">
            <div class="tw-pt-6 tw-pb-2 tw-pl-4 tw-text-xs tw-text-grey tw-uppercase tw-font-semibold">
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
            <list-item class="tw-pl-4 tw-py-4" :to="`/programs/${program.id}`" :key="program.id" v-for="program in programs">
                {{ program.name }}
                <template slot="secondary-data">
                    <base-icon class="tw-text-grey tw-text-xs tw-text-align-middle">people</base-icon>
                    <span class="tw-text-grey tw-text-sm tw-text-align-middle">{{ program.team.name }}</span>
                </template>
                <div slot="tertiary-data" class="tw-flex tw-w-3/5 tw-items-center">
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
                        <base-button v-else class="tw-py-2 tw-px-0 tw-text-orange tw-font-semibold tw-border-none hover:tw-bg-transparent hover:tw-text-blue">
                            <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
                            <span class="tw-text-xs tw-align-middle">Add Note</span>
                        </base-button>
                    </div>
                </div>
                <div slot="options-container" class="tw-w-1/5 tw-text-right">
                    <div class="tw-px-4">
                        <base-button class="tw-py-2 tw-px-2 tw-text-red-dark tw-border-none" @click="remove(program.id)">
                            <base-icon class="tw-text-xs tw-mr-1 tw-align-middle">close</base-icon>
                            <span class="tw-text-xs tw-align-middle">Remove Program</span>
                        </base-button>
                    </div>
                </div>
            </list-item>
        </div>
        <div class="tw-px-4 tw-pb-4">
            <base-button class="tw-py-2 tw-pl-2 tw-pr-4 tw-text-blue tw-font-bold tw-border-none" @click="addProgram">
                <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
                <span class="tw-text-xs tw-align-middle">Manage Programs</span>
            </base-button>
            <add-program
                :active.sync="add.active"
                :assignedPrograms="programs"
                @close="retrieve"/>
        </div>
    </div>
</template>
<script>
    import ProgramsRequest from '../api/RecordProgramsRequest';

    import ListItem from '../components/AppListItem';

    import AddProgram from '../components/AppRecordProfileAddProgram';

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
