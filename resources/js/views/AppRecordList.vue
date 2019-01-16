<template>
    <list
        :page.sync="params.page"
        @page-change="retrieve"
        :per-page="params.perPage"
        :total="total">
        <template slot="header-text">{{ type.name }}</template>
        <template slot="options">
            <div class="tw-flex">
                <base-input
                    class="tw-no-grow tw-mr-2"
                    :placeholder="`Search for ${type.name}`">
                    <i slot="prefix" class="el-input__icon el-icon-search"></i>
                </base-input>
                <base-button class="tw-py-2 tw-px-4 tw-bg-white tw-border-none tw-text-white tw-bg-blue tw-no-shrink" @click="create">
                    <base-icon class="tw-text-base tw-font-bold">add</base-icon>
                </base-button>
            </div>
        </template>
        <record-list
            slot="list"
            :records="records"
            :record-type="type.slug"
            :fields="fields"/>
    </list>
</template>
<script>
    import RecordRequest from '../api/RecordRequest';

    import List from '../components/AppList';

    export default {

        components: {
            List
        },

        data() {
            return {
                fields: [],
                records: [],
                request: new RecordRequest({}),
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

        watch: {
            '$route': function() {
                this.params.page = 1;
                this.params.perPage = 5;
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

            create() {
                this.request.create();
            }
        },

        created() {
            this.retrieve();
        }

    }
</script>
