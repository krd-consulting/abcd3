<template>
    <div>
        <div class="tw-mb-2">
            <list-item class="tw-pt-4 tw-pl-4 tw-pb-4" :to="`/programs/${program.id}`" :key="program.id" v-for="program in programs">
                {{ program.name }}

                <template slot="options">
                    <div class="tw-px-4">
                        <base-button class="tw-py-2 tw-px-2 tw-bg-red-lightest tw-text-red-dark tw-border-none" @click="remove(program.id)">
                            <base-icon class="tw-text-xs tw-mr-1 tw-align-middle">close</base-icon>
                            <span class="tw-text-xs tw-align-middle">Remove Program</span>
                        </base-button>
                    </div>
                </template>
            </list-item>
        </div>
        <div class="tw-px-4 tw-pb-4">
            <base-button class="tw-py-2 tw-pl-2 tw-pr-4 tw-bg-blue-lightest tw-text-blue tw-font-bold tw-border-none" @click="addProgram">
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
