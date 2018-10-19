<template>
    <div>
        <h1>File {{ fileId }}</h1>
        <el-table :data="files" class="tw-w-full">
            <el-table-column
                label="Field 1"
                prop="field_1_value"
            ></el-table-column>
            <el-table-column
                label="Field 2"
                prop="field_2_value"
            ></el-table-column>
            <el-table-column
                label="Field 3"
                prop="field_3_value"
            ></el-table-column>
        </el-table>
    </div>
</template>
<script>
    import FileRequest from '../api/FileRequest';

    export default {

        data() {
            return {
                files: [],
                request: new FileRequest({})
            }
        },

        computed: {
            fileId() {
                return this.$route.params.id;
            },

            fileType() {

            }
        },

        watch: {
            // call again the method if the route changes
            '$route': 'retrieve'
          },

        methods: {
            retrieve() {
                this.request.retrieve(this.$route.params.id).then((response) => {
                    this.files = response.data;
                });
            }
        },

        created() {
            this.retrieve();
        }

    }
</script>
