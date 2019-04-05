<template>
    <div>
        <div class="tw-mb-2">
            <div class="tw-text-center tw-py-16 tw-bg-grey-lightest tw-rounded tw-mx-4 tw-my-4" v-if="records.length == 0">
                <div>
                    <base-button
                        class="tw-py-2 tw-pl-2 tw-pr-4 tw-bg-blue hover:tw-bg-transparent hover:tw-text-blue tw-text-white tw-border-none"
                        @click="addRecord">
                        <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
                        <span class="tw-text-xs tw-align-middle">Add {{ recordType.name }}</span>
                    </base-button>
                </div>
            </div>
            <clients-list v-if="recordType.identity.name == 'Client'" :records="records"/>
            <staff-list v-else-if="recordType.identity.name == 'Staff'" :records="records"/>
            <volunteers-list v-else-if="recordType.identity.name == 'Volunteer'" :records="records"/>
            <external-list v-else-if="recordType.identity.name == 'External'" :records="records"/>
        </div>
        <div class="tw-px-4 tw-pb-4">
            <base-button
                v-if="records.length > 0"
                class="tw-py-2 tw-pl-2 tw-pr-4 hover:tw-bg-transparent hover:tw-text-blue tw-text-grey tw-border-none"
                @click="addRecord">
                <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
                <span class="tw-text-xs tw-align-middle">Manage Records</span>
            </base-button>
            <add-record
                :active.sync="add.active"
                :assigned-records="records"
                :record-type="recordType.slug"
                @close="retrieve">
            </add-record>
        </div>
    </div>
</template>
<script>
    import RecordsRequest from '../api/ProgramRecordsRequest';

    import ClientsList from './AppProgramProfileRecordsClients';
    import StaffList from './AppProgramProfileRecordsStaff';
    import VolunteersList from './AppProgramProfileRecordsVolunteers';
    import ExternalList from './AppProgramProfileRecordsExternal';
    import AddRecord from './AppProgramProfileAddRecord';

    export default {
        components: {
            AddRecord,
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
                request: new RecordsRequest({}),
                records: [],
                recordType: {
                    name: 'Records',
                    identity: {
                        name: ''
                    }
                }
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

            confirm(id) {
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
                this.request.retrieve(this.$route.params.program, this.$route.params.recordType).then((response) => {
                    this.records = response.data;
                    this.recordType = response.record_type;
                });
            },

            addRecord() {
                this.add.active = true;
            }
        },

        created() {
            this.retrieve();
        }
    }
</script>
