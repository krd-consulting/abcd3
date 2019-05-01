<template>
    <div>
        <edit-program
            :active.sync="edit.active"
            :program="edit.program"
            @update="retrieve"/>

        <div class="tw-shadow tw-rounded tw-bg-white">
            <div class="tw-flex tw-items-start tw-justify-between tw-p-4 tw-border-b-2">
                <div>
                    <h2>{{ program.name }}</h2>
                    <p class="tw-text-grey">{{ program.description }}</p>
                </div>
                <div class="tw-text-right">
                    <router-link router-link tag="a" :to="`/teams/${program.team.id}`">
                        <base-icon class="tw-text-grey tw-text-xs tw-text-align-middle">people</base-icon>
                        <span class="tw-uppercase tw-text-grey tw-text-xs tw-font-semibold">   
                            {{ program.team.name }}
                        </span>
                    </router-link>
                    <div>
                        <base-button @click="editProgram(program)" class="tw-py-2 tw-px-0 tw-mr-4 tw-text-grey hover:tw-text-grey-darkest hover:tw-bg-transparent tw-border-none">
                            <base-icon class="tw-text-xs tw-mr-1 tw-align-top">edit</base-icon>
                            <span class="tw-text-xs tw-align-middle">Edit</span>
                        </base-button>
                        <base-button @click="confirmDelete(record)" class="tw-py-2 tw-px-0 tw-text-grey hover:tw-text-red hover:tw-bg-transparent tw-border-none">
                            <base-icon class="tw-text-xs tw-mr-1 tw-align-top">delete</base-icon>
                            <span class="tw-text-xs tw-align-middle">Delete</span>
                        </base-button>
                    </div>
                </div>
            </div>
            <div class="tw-bg-grey-lightest">
                <el-tabs  @tab-click="handleClick">
                    <el-tab-pane name="program_profile_summary" label="Summary">
                    </el-tab-pane>
                    <el-tab-pane name="program_profile_groups">
                        <template slot="label">
                            <base-icon class="tw-align-middle tw-text-sm">assignment</base-icon>
                            Groups
                        </template>
                    </el-tab-pane>
                    <el-tab-pane v-for="(type, key) in recordTypes" :name="`program_profile_records_${type.slug}`" :key="key" label="Summary">
                        <template slot="label">
                            <base-icon class="tw-align-middle tw-text-sm">insert_drive_file</base-icon>
                            {{ type.name }}
                        </template>
                    </el-tab-pane>
                </el-tabs>
            </div>
            <div>
                <router-view/>
            </div>
        </div>
    </div>
</template>
<script>
    import ProgramRequest from '../api/ProgramRequest';
    import RecordTypeRequest from '../api/RecordTypeRequest';

    import EditProgram from './AppProgramEdit';

    export default {
        components: {
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
                    program: {
                        field_1_value: '',
                        field_2_value: '',
                        field_3_value: '',
                        team_id: ''
                    }
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

        computed: {
            firstItemNo() {
                return (this.params.perPage*(this.params.page-1)) + 1 ;
            },

            lastItemNo() {
                const itemNo = this.params.page*this.params.perPage;

                if(itemNo > this.total)
                    return this.total;

                return itemNo;
            },

            paginationInfo() {
                return `Showing ${ this.firstItemNo }-${ this.lastItemNo } of ${ this.total }`;
            }
        },

        watch: {
            '$route': function() {
                this.params.page = 1;
                this.params.perPage = 5;
                this.retrieve();
            }
        },

        methods: {
            handleClick(tab, event) {
                if(tab.name.includes('program_profile_records_'))
                    return this.handleRecordTabClick(tab.name.replace('program_profile_records_', ''));

                this.$router.push({ name: `${tab.name}`});
            },

            handleRecordTabClick(recordType) {
                this.$router.push({ name: 'program_profile_records', params:  {recordType}});
            },

            retrieve() {
                this.request.setFields({
                    params: {...this.params}
                });

                this.request.show(this.$route.params.program).then((response) => {
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
            this.retrieve();
            this.retrieveRecordTypes();
        }

    }
</script>
