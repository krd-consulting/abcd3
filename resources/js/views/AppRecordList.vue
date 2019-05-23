<template>
    <div>
        <create-record
            :active.sync="create.active"
            :fields="fields"
            :record-type="type"
            @save="retrieve()"/>

        <edit-record
            :active.sync="edit.active"
            :record-id="edit.record"
            @update="retrieve()"/>


        <list
            :items="records"
            :page.sync="params.page"
            :per-page="params.perPage"
            :search-terms.sync="params.search"
            has-add
            has-delete
            :has-list-columns="false"
            @add="createRecord"
            @edit="editRecord"
            @delete="confirmDelete(type.slug, $event)"
            @page-change="retrieve()"
            @search="retrieve()"
            :total="total">
            <template slot="header-text">{{ type.name }}</template>
            <template slot="options-add-text">Add {{ type.name }}</template>

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
    import lodash from 'lodash';
    import Request from '../api/RecordRequest';

    import List from '../components/AppResourceList';

    import ProfilePicture from '../components/RecordProfilePicture';
    import PrimaryData from '../components/RecordPrimaryData';
    import SecondaryData from '../components/RecordSecondaryData';

    import CreateRecord from './AppRecordCreate';
    import EditRecord from './AppRecordEdit';

    export default {

        components: {
            List,
            ProfilePicture,
            PrimaryData,
            SecondaryData,
            CreateRecord,
            EditRecord
        },

        data() {
            return {
                create: {
                    active: false
                },
                edit: {
                    active: false,
                    record: ''
                },
                fields: [],
                records: [],
                request: new Request({}),
                params: {
                    ascending: true,
                    sortBy: 'field_1_value',
                    page: 1,
                    perPage: 10,
                    search: ''
                },
                total: 0,
                type: {
                    name: ''
                }
            }
        },

        watch: {
            '$route': function() {
                this.params.page = 1;
                this.params.perPage = 10;
                this.retrieve();
            }
        },

        methods: {
            retrieve() {
                this.request.setFields({
                    params: {...this.params}
                });

                this.request.retrieve(this.$route.params.recordType).then((response) => {
                    this.fields = response.fields;
                    this.records = response.data;
                    this.total = response.meta.total;
                    this.type = response.record_type;
                });

            },

            search: _.debounce(function() {
                this.params.page = 1;
                this.retrieve();
            }, 300),

            createRecord() {
                this.create.active = true;
            },

            editRecord(record) {
                this.edit.record = record;

                this.edit.active = true;
            },

            confirmDelete(recordType, record) {
                this.$confirm('Are you sure you want to delete this record?', 'Delete Record', {
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.deleteRecord(recordType, record)
                        .then(() => {
                            this.retrieve();

                            this.$message({
                                type: 'success',
                                message: 'Record was deleted.'
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

            deleteRecord(recordType, record) {
                let request = new Request({});

                return request.destroy(recordType, record);
            },
        },

        created() {
            this.retrieve();
        },

    }
</script>
