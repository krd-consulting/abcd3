<template>
    <list
        :page.sync="params.page"
        @page-change="retrieve"
        :per-page="params.perPage"
        :total="total">
        <template slot="header-text">{{ type.name }}</template>
        <template slot="options">
            <el-select
                v-model="params.sortBy"
                placeholder="Sort By"
                @change="retrieve"
                clearable
                size="small">
                <el-option
                    v-for="(field, index) in fields"
                    :key="field"
                    :label="index"
                    :value="field">
                </el-option>
            </el-select>
            <base-button @click="create">Create Record</base-button>
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
