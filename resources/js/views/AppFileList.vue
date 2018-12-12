<template>
    <div class="tw-shadow tw-rounded tw-bg-white">
        <div class="tw-flex tw-items-center tw-justify-between tw-p-4 tw-border-b-2">
            <h2 class="tw-font-bold tw-text-xl">{{ type.name }}</h2>
            <div class="tw-flex-no-wrap">
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
                <base-button @click="create">Create File</base-button>
            </div>
        </div>
        <file-list
            :files="files"
            :file-type="type.slug"
            :fields="fields"/>
        <div class="tw-py-2">
            <base-pagination
                v-bind:current-page.sync="params.page"
                @current-change="retrieve"
                layout="prev, slot, next"
                :pager-count="5"
                :page-size="params.perPage"
                :total="total">
                <span class="tw-text-grey-dark">{{ paginationInfo }}</span>
            </base-pagination>
        </div>
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

                this.request.retrieve(this.$route.params.fileType).then((response) => {
                    this.fields = response.fields;
                    this.files = response.data;
                    this.total = response.meta.total;
                    this.type = response.file_type;
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
