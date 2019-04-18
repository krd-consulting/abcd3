<template>
    <div>
        <add-record
            :active.sync="add.active"
            :group-id="$route.params.group"
            :record-type="recordType.slug"
            @close="retrieve">
        </add-record>
        <!--<edit-group-record
            :active.sync="edit.active"
            :enrolledAt="edit.record.enrolled_at"
            :record="edit.record"
            :group-id="$route.params.group"
            :group-status="edit.record.group_status"
            :fields="fields"
            :record-type="recordType"
            @update="retrieve"/>-->
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
            <div>
        <div v-if="records.length > 0"
            class="tw-pt-6 tw-pb-2 tw-pl-4 tw-text-xs tw-text-grey tw-uppercase tw-font-semibold">
            <div class="tw-flex tw-w-4/5">
                <div class="tw-w-1/4 tw-m-0">
                    <span class="tw-tracking-wide">Program</span>
                </div>
                <div class="tw-w-1/4 tw-m-0">
                    <span class="tw-tracking-wide">Enrollment Date</span>
                </div>
                <div v-if="recordType.identity.name == 'Client'" class="tw-w-1/4 tw-m-0">
                    <span class="tw-tracking-wide">End At</span>
                </div>
            </div>
        </div>
        <list-item
            v-if="records.length > 0"
            :to="`/records/${record.id}`"
            :key="record.id"
            :item="record"
            v-for="record in records"
            class="record tw-pl-4 tw-py-4">
            <template v-slot:primary-data="slotProps">
                <primary-data :record="slotProps.item" :fields="slotProps.item.fields"/>
            </template>
            <template v-slot:secondary-data="slotProps">
                <secondary-data class="tw-text-xs" :record="slotProps.item" :fields="slotProps.item.fields"/>
            </template>
            <template v-slot:tertiary-data="slotProps">
                <div class="tw-flex tw-w-3/5 tw-items-center">
                    <div class="tw-w-1/3">
                        <span>{{ slotProps.item.pivot.enrolled_at }}</span>
                    </div>
                    <div class="tw-w-1/3">
                        <span>{{ slotProps.item.pivot.end_at }}</span>
                    </div>
                </div>
            </template>
            <template v-slot:options-container="slotProps">
                <div class="tw-w-1/5 tw-text-right">
                    <div class="tw-px-4">
                        <base-button
                            class="tw-py-2 tw-px-2 tw-text-grey hover:tw-bg-transparent hover:tw-text-grey-darkest tw-border-none"
                            @click="$emit('edit', slotProps.item)">
                            <base-icon class="tw-text-xs tw-mr-1 tw-align-middle">edit</base-icon>
                            <span class="tw-text-xs tw-align-middle">Edit</span>
                        </base-button>
                        <base-button
                            class="tw-py-2 tw-px-2 tw-text-grey hover:tw-bg-transparent hover:tw-text-red tw-border-none"
                            @click="$emit('remove', slotProps.item.id)">
                            <base-icon class="tw-text-xs tw-mr-1 tw-align-middle">close</base-icon>
                            <span class="tw-text-xs tw-align-middle">Remove</span>
                        </base-button>
                    </div>
                </div>
            </template>
        </list-item>
    </div>
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
    import ListItem from '../components/AppListItem';
    import ProfilePicture from '../components/RecordProfilePicture';
    import PrimaryData from '../components/RecordPrimaryData';
    import SecondaryData from '../components/RecordSecondaryData';

    import RecordsRequest from '../api/GroupRecordsRequest';

    // import ClientsList from './AppGroupProfileRecordsClients';
    // import StaffList from './AppGroupProfileRecordsStaff';
    // import VolunteersList from './AppGroupProfileRecordsVolunteers';
    // import ExternalList from './AppGroupProfileRecordsExternal';

     import AddRecord from './AppGroupProfileAddRecord';
    // import EditGroupRecord from './AppGroupRecordEdit';

    export default {
        components: {
            List,
            ListItem,
            ProfilePicture,
            PrimaryData,
            SecondaryData,
            AddRecord,
            // EditGroupRecord,
            // ClientsList,
            // VolunteersList,
            // ExternalList,
            // StaffList
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
                    this.$route.params.group,
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

                this.request.retrieve(this.$route.params.group, this.$route.params.recordType).then((response) => {
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
