<template>
    <div>
        <add-record
            :active.sync="add.active"
            :program-id="$route.params.program"
            :record-type="recordType.slug"
            @close="retrieve">
        </add-record>
        <edit-program-record
            :active.sync="edit.active"
            :enrolledAt="edit.record.enrolled_at"
            :record="edit.record"
            :program-id="$route.params.program"
            :program-status="edit.record.program_status"
            :fields="fields"
            :record-type="recordType"
            @update="retrieve"/>
        <list
            :has-header="true"
            :page.sync="params.page"
            @page-change="retrieve"
            :per-page="params.perPage"
            :total="total">
            <template slot="empty-placeholder">
                 <div class="tw-text-center tw-py-16 tw-bg-grey-lightest tw-rounded tw-mx-4 tw-my-4" v-if="records.length == 0">
                    <div>
                        <base-button
                            class="tw-py-2 tw-pl-2 tw-pr-4 tw-bg-blue hover:tw-bg-transparent hover:tw-text-blue tw-text-white tw-border-none"
                            @click="addRecord">
                            <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
                            <span class="tw-text-xs tw-align-middle">Add Records</span>
                        </base-button>
                    </div>
                </div>
            </template>
            <template slot="header-text">{{ recordType.name }}</template>
            <template slot="options">
                <div class="tw-flex">
                    <base-input
                        v-model="params.search"
                        @input="search"
                        class="tw-no-shrink tw-mr-2"
                        :placeholder="`Search for ${recordType.name}`">
                        <i slot="prefix" class="el-input__icon el-icon-search"></i>
                    </base-input>
                </div>
            </template>
            <clients-list
                v-if="recordType.identity.name == 'Client'"
                :records="records"
                @remove="confirmDelete"
                @edit="editRecord"/>
            <staff-list v-else-if="recordType.identity.name == 'Staff'" :records="records"/>
            <volunteers-list v-else-if="recordType.identity.name == 'Volunteer'" :records="records"/>
            <external-list v-else-if="recordType.identity.name == 'External'" :records="records"/>

            <template slot="footer-options">
                <base-button
                    v-if="records.length > 0"
                    class="tw-py-2 tw-pl-2 tw-pr-4 hover:tw-bg-transparent hover:tw-text-blue tw-text-grey tw-border-none"
                    @click="addRecord">
                    <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
                    <span class="tw-text-xs tw-align-middle">Manage Records</span>
                </base-button>
            </template>
        </list>
    </div>
</template>
<script>
    import List from '../components/AppList';

    import RecordsRequest from '../api/ProgramRecordsRequest';

    import ClientsList from './AppProgramProfileRecordsClients';
    import StaffList from './AppProgramProfileRecordsStaff';
    import VolunteersList from './AppProgramProfileRecordsVolunteers';
    import ExternalList from './AppProgramProfileRecordsExternal';

    import AddRecord from './AppProgramProfileAddRecord';
    import EditProgramRecord from './AppProgramRecordEdit';

    export default {
        components: {
            List,
            AddRecord,
            EditProgramRecord,
            ClientsList,
            VolunteersList,
            ExternalList,
            StaffList
        },

        data() {
            return {
                add: {
                    active: false
                },
                edit: {
                    active: false,
                    record: {

                    }
                },
                request: new RecordsRequest({}),
                records: [],
                fields: [],
                recordType: {
                    name: 'Records',
                    identity: {
                        name: ''
                    }
                },
                params: {
                    ascending: true,
                    sortBy: 'field_1_value',
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
                    this.$route.params.program,
                    this.$route.params.recordType,
                    id
                ).then((response) => {
                    this.retrieve();
                });
            },

            confirmDelete(id) {
                this.$confirm('Are you sure you want to remove this record?', 'Remove Record', {
                    confirmButtonText: 'Remove',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.remove(id)
                        .then(() => {
                            this.$message({
                                type: 'success',
                                message: 'Record was removed.'
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

                this.request.retrieve(this.$route.params.program, this.$route.params.recordType).then((response) => {
                    this.records = response.data;
                    this.recordType = response.record_type;
                    this.fields = response.fields;
                    this.total = response.meta.total;
                });
            },

            search: _.debounce(function() {
                this.params.page = 1;
                this.retrieve();
            }, 300),

            addRecord() {
                this.add.active = true;
            },

            editRecord(record) {
                this.edit.record = record;

                this.edit.active = true;
            },
        },

        created() {
            this.retrieve();
        }
    }
</script>
