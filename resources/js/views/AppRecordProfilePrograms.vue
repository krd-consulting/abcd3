<template>
    <div>
        <div class="tw-mb-2">
            <list-item class="tw-pt-2 tw-pb-4" :to="`/programs/${program.id}`" :key="program.id" v-for="program in programs">
                {{ program.name }}

                <template v-if="program.team" slot="secondary-data-text">
                    <span class="tw-text-xs">{{ program.team.name }}</span>
                </template>

                <template slot="options">
                    <base-button class="tw-border-none hover:tw-bg-transparent tw-font-bold hover:tw-text-red">
                        <base-icon class="tw-text-xs tw-align-top">close</base-icon>
                    </base-button>
                </template>
            </list-item>
        </div>
        <div>
            <base-button class="tw-py-2 tw-px-4 tw-bg-blue tw-text-white tw-font-bold tw-border-none">
                <base-icon class="tw-text-sm tw-align-middle">add</base-icon>
                <span class="tw-text-xs tw-align-middle">Programs</span>
            </base-button>
        </div>
    </div>
</template>
<script>
    import ProgramsRequest from '../api/RecordProgramsRequest';

    import ListItem from '../components/AppListItem';

    export default {
        components: {
            ListItem
        },

        data() {
            return {
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
        },

        created() {
            this.retrieve();
        }
    }
</script>
