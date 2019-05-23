<template>
    <div>
        <add-program
            :active.sync="add.active"
            @close="retrieve()">
        </add-program>
        <edit-program-record
            :active.sync="edit.active"
            :record-id="$route.params.record"
            :program-id="edit.program"
            :record-type="$route.params.recordType"
            @update="retrieve()"/>

        <list
            :items="programs"
            :page.sync="params.page"
            :per-page="params.perPage"
            :search-terms.sync="params.search"
            :tertiary-columns="tertiaryDataColumns"
            :total="total"
            has-add
            has-remove
            has-list-columns
            :has-edit="recordType.identity == 'Client'"
            @add="addProgram"
            @edit="editProgram"
            @remove="confirmDelete($event)"
            @page-change="retrieve()"
            @search="retrieve()">
            <template slot="header-text">Programs</template>
            <template slot="options-add-text">Add Programs</template>

            <template slot="list-column-primary-data">Program</template>

            <template v-slot:list-item-primary-data="{ item:program }">
                {{ program.name }}
            </template>

            <template v-slot:list-item-secondary-data="{ item:program }">
                {{ program.team.name }}
            </template>

            <template v-slot:list-item-tertiary-data="{ item:program }">
                <tertiary-data :record-type="recordType" :record="program"/>
            </template>
        </list>
    </div>
</template>
<script>
    import List from '../components/AppResourceList';

    import ProgramsRequest from '../api/RecordProgramsRequest';

    import AddProgram from './AppRecordProfileAddProgram';
    import EditProgramRecord from './AppProgramRecordEdit';

    import TertiaryData from '../components/ProgramRecordPivotData';

    export default {
        components: {
            List,
            AddProgram,
            EditProgramRecord,
            TertiaryData
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

        computed: {
            tertiaryDataColumns() {
                switch(this.recordType.identity) {
                    case 'Client':
                        return [ 'Status', 'Enrollment Date', 'Notes' ];
                        break;

                    case 'Staff':
                        return [ 'Caseload', 'Groups'];
                        break;

                    case 'Volunteer':
                        return [ 'Hours Per Month', 'Hours Per Year'];
                        break;

                    default: 
                        return [];
                }
            },

            recordType() {
                return this.record.type;
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
                    this.total = response.meta.total;
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
