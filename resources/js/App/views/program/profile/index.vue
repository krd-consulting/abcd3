<template>
    <div>
        <edit-program
            :active.sync="edit.active"
            :program-id="program.id"
            @update="retrieve"/>

        <resource-profile
            :extra-information-path="`/teams/${program.team.id}`"
            :record-types="recordTypes"
            :resource="program"
            @edit="editProgram(program)"
            @delete="confirmDelete(program.id)"
            @disable="confirmDisable(program.id)"
            @enable="confirmEnable(program.id)">
            <template v-slot:header>
                {{ program.name }}
            </template>
            <template v-slot:subheader>
                {{ program.description }}
            </template>
            <template v-slot:extra-information-icon>
                people
            </template>
            <template v-slot:extra-information>
                {{ program.team.name }}
            </template>
        </resource-profile>
    </div>
</template>
<script>
    import ProgramRequest from '@/api/ProgramRequest';
    import RecordTypeRequest from '@/api/RecordTypeRequest';

    import methods from '../methods';

    import ResourceProfile from '@/App/components/resourceProfile';
    import EditProgram from '../edit';

    export default {
        components: {
            ResourceProfile,
            EditProgram
        },

        data() {
            return {
                program: {
                    name: '',
                    team: {
                        name: ''
                    }
                },
                edit: {
                    active: false,
                },
                recordTypes: [],
                request: new ProgramRequest({}),
                params: {
                    ascending: true,
                    sortBy: 'field_1_value',
                    page: 1,
                    perPage: 5
                },
                total: 0,
                type: {
                    name: ''
                },
            }
        },

        methods: {
            retrieveRecordTypes() {
                const request = new RecordTypeRequest({});

                request.retrieve().then((response) => {
                    this.recordTypes = response.data;
                });
            },

            ...methods,

            retrieve: methods.profile
        },

        created() {
            this.retrieve(this.$route.params.program);
            this.retrieveRecordTypes();
        },


        beforeRouteUpdate (to, from, next) {
            this.retrieve(to.params.program);
            this.retrieveRecordTypes();
            next();
        }

    }
</script>
