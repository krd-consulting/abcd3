<template>
    <div>
        <add-record
            :active.sync="add.active"
            :group-id="$route.params.group"
            :record-type="recordType.slug"
            @close="retrieve()">
        </add-record>

        <list
            :items="records"
            :page.sync="params.page"
            :per-page="params.perPage"
            :search-terms.sync="params.search"
            :total="total"
            has-add
            has-remove
            :has-list-columns="false"
            :has-edit="false"
            @add="addRecord"
            @edit="editRecord"
            @remove="confirmDelete($event)"
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
        </list>
    </div>
</template>
<script>
    import RecordsRequest from '@/api/GroupRecordsRequest';

    import List from '@/App/components/resourceList';
    import ProfilePicture from '@/App/components/record/profilePicture';
    import PrimaryData from '@/App/components/record/primaryData';
    import SecondaryData from '@/App/components/record/secondaryData';

    import AddRecord from './addRecord';

    export default {
        components: {
            List,
            ProfilePicture,
            PrimaryData,
            SecondaryData,
            AddRecord,
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

            retrieve(group = this.$route.params.group, recordType = this.$route.params.recordType) {
                this.request.setFields({
                    params: {...this.params}
                });

                this.request.retrieve(group, recordType).then((response) => {
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
            this.retrieve(to.params.group, to.params.recordType);
            next();
        }
    }
</script>
