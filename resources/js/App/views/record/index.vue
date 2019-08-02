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
            :loading="loading"
            has-add
            has-delete
            :has-list-columns="false"
            @add="createRecord"
            @edit="editRecord"
            @delete="confirmDelete(type.slug, $event)"
            @page-change="retrieve()"
            :total="total">
            <template slot="header-text">{{ type.name }}</template>
            <template slot="options-add-text">Add {{ type.name }}</template>

            <template v-slot:list-item-image="{ item:record }">
                <profile-picture class="tw-mr-2 tw-w-12 tw-h-12 tw-text-base" :record="record" :fields="fields"/>
            </template>

            <template v-slot:list-item-primary-data="{ item:record }">
                <primary-data class="tw-font-semibold" :record="record" :fields="fields"/>
            </template>

             <template v-slot:list-item-secondary-data="{ item:record }">
                <secondary-data class="tw-text-xs tw-text-gray-600" :record="record" :fields="fields"/>
            </template>
        </list>
    </div>
</template>
<script>
    import Request from '@/api/RecordRequest';

    import List from '@/App/components/resourceList';

    import ProfilePicture from '@/App/components/record/profilePicture';
    import PrimaryData from '@/App/components/record/primaryData';
    import SecondaryData from '@/App/components/record/secondaryData';

    import CreateRecord from './create';
    import EditRecord from './edit';

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
                loading: false,
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

        methods: {
            retrieve(recordType = this.$route.params.recordType) {
                this.loading = true;

                this.request.setFields({
                    params: {...this.params}
                });

                this.request.retrieve(recordType).then((response) => {
                    this.fields = response.fields;
                    this.records = response.data;
                    this.total = response.meta.total;
                    this.type = response.record_type;

                    this.loading = false;
                });

            },

            createRecord() {
                this.create.active = true;
            },

            editRecord(record) {
                this.edit.record = record;

                this.edit.active = true;
            },

            confirmDelete(recordType, record) {
                this.$confirm('Are you sure you want to archive this record?', 'Archive Record', {
                    confirmButtonText: 'Archive',
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

        beforeRouteUpdate (to, from, next) {
            this.retrieve(to.params.recordType);
            next();
        }

    }
</script>
