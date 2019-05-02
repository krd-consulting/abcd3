<template>
    <div>
        <add-program
            :active.sync="add.active"
            @close="retrieve">
        </add-program>
        <edit-program-record
            :active.sync="edit.active"
            :enrolledAt="edit.program.enrolled_at"
            :record="record"
            :program-id="edit.program.id"
            :program-status="edit.program.program_status"
            :fields="fields"
            :record-type="record.type"
            @update="retrieve"/>
        <list
            :page.sync="params.page"
            @page-change="retrieve"
            :per-page="params.perPage"
            :total="total">

            <template slot="empty-placeholder">
                <div class="tw-text-center tw-py-16 tw-bg-grey-lightest tw-rounded tw-mx-4 tw-my-4">
                    <div>
                        <base-button
                            class="tw-py-2 tw-pl-2 tw-pr-4 tw-bg-blue hover:tw-bg-transparent hover:tw-text-blue tw-text-white tw-border-none"
                            @click="addProgram">
                            <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
                            <span class="tw-text-xs tw-align-middle">Add Programs</span>
                        </base-button>
                    </div>
                </div>
            </template>

            <client-programs-list
                v-if="record.type.identity == 'Client'"
                :programs="programs"
                @edit="editProgram"
                @remove="confirmDelete"/>
            <staff-programs-list
                v-else-if="record.type.identity == 'Staff'"
                :programs="programs"
                @remove="confirmDelete"/>
            <volunteer-programs-list
                v-else-if="record.type.identity == 'Volunteer'"
                :programs="programs"
                @remove="confirmDelete"/>
            <external-programs-list
                v-else-if="record.type.identity == 'External'"
                :programs="programs"
                @remove="confirmDelete"/>

            <template slot="footer-options">
                <base-button
                    v-if="programs.length > 0"
                    class="tw-py-2 tw-pl-2 tw-pr-4 hover:tw-bg-transparent hover:tw-text-blue tw-text-grey tw-border-none"
                    @click="addProgram">
                    <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
                    <span class="tw-text-xs tw-align-middle">Manage Programs</span>
                </base-button>
            </template>
        </list>
    </div>
</template>
<script>
    import List from '../components/AppList';

    import ProgramsRequest from '../api/RecordProgramsRequest';

    import AddProgram from './AppRecordProfileAddProgram';
    import EditProgramRecord from './AppProgramRecordEdit';

    import ClientProgramsList from './AppRecordProfileProgramsClients';
    import StaffProgramsList from './AppRecordProfileProgramsStaff';
    import VolunteerProgramsList from './AppRecordProfileProgramsVolunteer';
    import ExternalProgramsList from './AppRecordProfileProgramsExternal';

    export default {
        components: {
            List,
            AddProgram,
            EditProgramRecord,
            ClientProgramsList,
            StaffProgramsList,
            VolunteerProgramsList,
            ExternalProgramsList
        },

        props: {
            record: Object,
            fields: Array|Object
        },

        data() {
            return {
                add: {
                    active: false
                },
                edit: {
                    active: false,
                    program: {
                        id: ''
                    }
                },
                request: new ProgramsRequest({}),
                programs: [],
                params: {
                    ascending: true,
                    sortBy: 'id',
                    page: 1,
                    perPage: 10,
                    search: ''
                },
                total: 0,
            }
        },

        methods: {
            remove(id) {
                return this.request.destroy(
                    this.$route.params.recordType,
                    this.$route.params.record,
                    id
                ).then((response) => {
                    this.retrieve();
                });
            },

            confirmDelete(id) {
                this.$confirm('Are you sure you want to remove this program?', 'Remove Program', {
                    confirmButtonText: 'Remove',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.remove(id)
                        .then(() => {
                            this.$message({
                                type: 'success',
                                message: 'Program was removed.'
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

            retrieve() {
                this.request.setFields({
                    params: {...this.params}
                });

                this.request.retrieve(this.$route.params.recordType, this.$route.params.record).then((response) => {
                    this.programs = response.data;
                    this.total = response.data.length;
                    this.params.perPage = this.total;
                });
            },

            addProgram() {
                this.add.active = true;
            },

            editProgram(program) {
                this.edit.program = program;

                this.edit.active = true;
            },
        },

        created() {
            this.retrieve();
        }
    }
</script>
