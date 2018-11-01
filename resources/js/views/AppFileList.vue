<template>
    <div>
        <div>
            <h1 class="tw-mb-4">{{ type.name }}</h1>
        </div>
        <file-list
            :files="files"
            :fields="fields"></file-list>
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
                    perPage: 10
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
                this.params.perPage = 10;
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
