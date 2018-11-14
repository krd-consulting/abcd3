<template>
    <div>
        <div class="tw-flex tw-justify-between">
            <h1 class="tw-mb-4">{{ type.name }}</h1>
            <div class="tw-flex-no-wrap">
                <span>
                    Sort By:
                    <el-select v-model="params.sortBy" @change="retrieve">
                        <el-option
                            v-for="(field, index) in fields"
                            :key="field"
                            :label="index"
                            :value="field">
                        </el-option>
                    </el-select>
                </span>
                <base-pagination
                    v-bind:current-page.sync="params.page"
                    @current-change="retrieve"
                    layout="prev, slot, next"
                    :pager-count="5"
                    :page-size="params.perPage"
                    :total="total">
                    <span>{{ paginationInfo }}</span>
                </base-pagination>
            </div>
        </div>
        <file-list
            :files="files"
            :fields="fields"/>
    </div>
</template>
<script>
    import FileRequest from '../api/FileRequest';

    export default {

        data() {
            return {
                fields: [],
                files: [],
                request: new FileRequest({}),
                params: {
                    ascending: true,
                    /*columnFilters: {
                    },*/
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

        computed: {
            firstItemNo() {
                return (this.params.perPage*(this.params.page-1)) + 1 ;
            },

            lastItemNo() {
                const itemNo = this.params.page*this.params.perPage;

                if(itemNo > this.total)
                    return this.total;

                return itemNo;
            },

            paginationInfo() {
                return `Showing ${ this.firstItemNo }-${ this.lastItemNo } of ${ this.total }`;
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

                this.request.retrieve(this.$route.params.id).then((response) => {
                    this.fields = response.fields;
                    this.files = response.data;
                    this.total = response.total;
                    this.type = response.file_type;

                    console.log(response);
                });
            },
        },

        created() {
            this.retrieve();
        }

    }
</script>
