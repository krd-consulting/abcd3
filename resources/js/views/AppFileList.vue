<template>
    <div>
        <h2>{{ type.name }}</h2>
        <vue-good-table
            :columns="prettyColumns"
            max-height="500px"
            :fixed-header="true"
            mode="remote"
            :pagination-options="{
                enabled: true
            }"
            @on-per-page-change="onPerPageChange"
            @on-page-change="onPageChange"
            @on-sort-change="onSortChange"
            :rows="files"
            :totalRows="total"/>
    </div>
</template>
<script>
    import FileRequest from '../api/FileRequest';

    export default {

        data() {
            return {
                columns: [],
                files: [],
                request: new FileRequest({}),
                params: {
                    ascending: true,
                    /*columnFilters: {
                    },*/
                    sortBy: 'field_1_value',
                    page: 1,
                    perPage: 10
                },
                total: 0,
                type: {
                    name: ''
                },
            }
        },

        computed: {
            prettyColumns() {
                let columns = this.columns;

                return columns.map((column) => {
                    return {
                        field: column.field,
                        label: _.startCase(column.label.split('_').join(' '))
                    }
                });
            },
        },

        watch: {
            '$route': function() {
                this.params.page = 1;
                this.params.perPage = 10;
                this.retrieve();
            }
        },

        methods: {
            onPageChange(params) {
                this.params.page = params.currentPage;
                this.retrieve();
            },
            onPerPageChange(params) {
                this.params.perPage = params.currentPerPage;
                this.retrieve();
            },
            onSortChange(params) {
                this.params.sortBy = this.columns[params.columnIndex].field;
                this.params.ascending = params.sortType == 'asc' ? true : false;
                this.retrieve();
            },
            retrieve() {
                this.request.setFields({
                    params: {...this.params}
                });

                this.request.retrieve(this.$route.params.id).then((response) => {
                    this.columns = response.fields;
                    this.files = response.data;
                    this.total = response.total;
                    this.type = response.file_type;
                });
            },
        },

        created() {
            this.retrieve();
        }

    }
</script>
