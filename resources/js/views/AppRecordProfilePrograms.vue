<template>
    <div>
        <div class="tw-mb-2">
            <list-item class="tw-pt-2 tw-pl-4 tw-pb-2" :to="`/programs/${program.id}`" :key="program.id" v-for="program in programs">
                {{ program.name }}

                <template slot="options">
                    <base-button class="tw-border-none hover:tw-bg-transparent tw-font-bold hover:tw-text-red">
                        <base-icon class="tw-text-xs tw-align-top">close</base-icon>
                    </base-button>
                </template>
            </list-item>
        </div>
        <div class="tw-px-4 tw-pb-4">
            <base-button class="tw-py-2 tw-pl-2 tw-pr-4 tw-bg-blue-lightest tw-text-blue tw-font-bold tw-border-none" @click="addProgram">
                <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
                <span class="tw-text-xs tw-align-middle">Programs</span>
            </base-button>
            <add-program
                :active.sync="add.active"
                @save="retrieve"/>
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
