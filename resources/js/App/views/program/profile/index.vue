<template>
    <div>
        <edit-program
            :active.sync="edit.active"
            :program-id="program.id"
            @update="retrieve"/>

        <resource-profile 
            :extra-information-path="`/teams/${program.team.id}`"
            :record-types="recordTypes"
            @edit="editProgram(program)" 
            @delete="confirmDelete(program)">
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
            retrieve(program = this.$route.params.program) {
                this.request.setFields({
                    params: {...this.params}
                });

                this.request.show(program).then((response) => {
                    this.program = response.data;
                });
            },

            retrieveRecordTypes() {
                const request = new RecordTypeRequest({});

                request.retrieve().then((response) => {
                    this.recordTypes = response;
                });
            },

            confirmDelete(program) {
                this.$confirm('Are you sure you want to delete this program?', 'Delete Program', {
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.deleteProgram(program)
                        .then(() => {
                            this.$router.push('/programs');

                            this.$message({
                                type: 'success',
                                message: 'Program was deleted.'
                            });
                        })
                        .catch((error) => {
                            this.$message({
                                type: 'error',
                                message: error.message
                            });
                        });
                })
            },

            editProgram(program) {
                this.edit.program = program;

                this.edit.active = true;
            },

            deleteProgram(program) {
                let request = new ProgramRequest({});

                return request.destroy(program.id);
            },
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
