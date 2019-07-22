<template>
    <div>
        <add-record
            :active.sync="add.active"
            :program-id="$route.params.program"
            :record-type="recordType.slug"
            @close="retrieve()">
        </add-record>
        <edit-program-record
            :active.sync="edit.active"
            :record-id="edit.record"
            :program-id="$route.params.program"
            :record-type="recordType.slug"
            @update="retrieve()"/>

        <list
            :items="records"
            :page.sync="params.page"
            :per-page="params.perPage"
            :search-terms.sync="params.search"
            :tertiary-columns="tertiaryDataColumns"
            :total="total"
            has-add
            has-remove
            has-list-columns
            :has-edit="recordType.identity == 'Client'"
            @add="addRecord"
            @edit="editRecord"
            @remove="confirmDelete(recordType.slug, $event)"
            @page-change="retrieve()">
            <template slot="header-text">{{ recordType.name }}</template>
            <template slot="options-add-text">Add {{ recordType.name }}</template>

            <template slot="list-column-primary-data">Record</template>

            <template v-slot:list-item-image="{ item:record }">
                <profile-picture class="tw-mr-2 tw-w-12 tw-h-12 tw-text-base" :record="record" :fields="fields" />
            </template>

            <template v-slot:list-item-primary-data="{ item:record }">
                <primary-data :record="record" :fields="fields"/>
            </template>

            <template v-slot:list-item-secondary-data="{ item:record }">
                <secondary-data class="tw-text-xs" :record="record" :fields="fields"/>
            </template>

            <template v-slot:list-item-tertiary-data="{ item:record }">
                <tertiary-data :record-type="recordType" :record="record"/>
            </template>
        </list>
    </div>
</template>
<script>
    import List from '@/App/components/resourceList';

    import ProfilePicture from '@/App/components/record/profilePicture';
    import PrimaryData from '@/App/components/record/primaryData';
    import SecondaryData from '@/App/components/record/secondaryData';
    import TertiaryData from '@/App/components/programRecord/pivotData';

    import RecordsRequest from '@/api/ProgramRecordsRequest';

    import AddRecord from './addRecord';
    import EditProgramRecord from '@/App/views/programRecord/edit';

    export default {
        components: {
            List,
            ProfilePicture,
            PrimaryData,
            SecondaryData,
            TertiaryData,
            AddRecord,
            EditProgramRecord
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
                    name: '',
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

        computed: {
            tertiaryDataColumns() {
                switch(this.recordType.identity) {
                    case 'Client':
                        return [ 'Status', 'Enrollment Date', 'Notes'];
                        break;

                    case 'Staff':
                        return [ 'Caseload', 'Groups', 'Enrollment Date'];
                        break;

                    case 'Volunteer':
                        return [ 'Hours Per Month', 'Hours Per Year', 'Enrollment Date'];
                        break;

                    default:
                        return ['Enrollment Date'];
                }
            },
        },

        methods: {
            remove(record) {
                return this.request.destroy(
                    this.$route.params.program,
                    this.$route.params.recordType,
                    record
                ).then((response) => {
                    this.retrieve();
                });
            },

            confirmDelete(recordType, record) {
                this.$confirm('Are you sure you want to remove this record?', 'Remove Record', {
                    confirmButtonText: 'Remove',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.remove(record)
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

            retrieve(program = this.$route.params.program, recordType = this.$route.params.recordType) {
                this.request.setFields({
                    params: {...this.params}
                });

                this.request.retrieve(program, recordType).then((response) => {
                    this.records = response.data;
                    this.recordType = response.record_type;
                    this.fields = response.fields;
                    this.total = response.meta.total;
                });
            },

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
        },

        beforeRouteUpdate (to, from, next) {
            this.retrieve(to.params.program, to.params.recordType);
            next();
        }
    }
</script>
