<template>
    <div>
        <create-record
            :active.sync="create.active"
            :fields="fields"
            :record-type="type"
            @save="retrieve"/>

        <edit-record
            :active.sync="edit.active"
            :record="edit.record"
            :fields="fields"
            :record-type="type"
            @update="retrieve"/>


        <list
            :page.sync="params.page"
            @page-change="retrieve"
            :per-page="params.perPage"
            :total="total">
            <template slot="header-text">{{ type.name }}</template>
            <template slot="options">
                <div class="tw-flex">
                    <base-input
                        v-model="params.search"
                        @input="search"
                        class="tw-no-shrink tw-mr-2"
                        :placeholder="`Search for ${type.name}`">
                        <i slot="prefix" class="el-input__icon el-icon-search"></i>
                    </base-input>
                    <base-button class="tw-py-2 tw-px-4 tw-bg-white tw-border-none tw-text-white tw-bg-blue tw-no-shrink" @click="createRecord">
                        <base-icon class="tw-text-base tw-font-bold tw-align-middle">add</base-icon>
                        <span class="tw-align-middle">Add {{type.name}}</span>
                    </base-button>
                </div>
            </template>
            <record-list
                slot="list"
                :records="records"
                :record-type="type.slug"
                :fields="fields"
                @edit="editRecord"
                @delete="retrieve"/>
        </list>
    </div>
</template>
<script>
    import lodash from 'lodash';
    import RecordRequest from '../api/RecordRequest';

    import List from '../components/AppList';
    import CreateRecord from './AppRecordCreate';
    import EditRecord from './AppRecordEdit';

    export default {

        components: {
            List,
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
                    record: {
                        field_1_value: '',
                        field_2_value: '',
                        field_3_value: '',
                    }
                },
                fields: [],
                records: [],
                request: new RecordRequest({}),
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
        },

        created() {
            this.retrieve();
        },

    }
</script>
