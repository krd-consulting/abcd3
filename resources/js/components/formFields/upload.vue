<template>
    <div id="fileUpload" class="tw-my-8">
      <el-row>
        <el-col :span="6">
          <label for="dropdown" class="tw-block tw-text-right tw-mr-1">{{ field.title }}</label><br>
              <sup>{{ field.description }}</sup>
        </el-col>

        <el-col :span="10">
            <el-upload
                action="/api/attachments"
                :headers="{ 'X-CSRF-TOKEN': this.token }"
                :on-success="handleSuccess"
                :on-remove="handleRemove"
                :before-remove="beforeRemove"
                :limit="field.settings.limit"
                :on-exceed="handleExceed"
                :file-list="fileList">
            <el-button size="small" type="primary">Click to upload</el-button>
            <div slot="tip" class="el-upload__tip">jpg/png files with a size less than 500kb</div>
          </el-upload>
        </el-col>
      </el-row>
    </div>
</template>

<script>
    import Request from '@/api/AttachmentRequest';

    export default {
        data: () => {
            return {
                request: new Request({}),
                fileList: [],
                token: window.axios.defaults.headers.common['X-CSRF-TOKEN']
            }
        },
        props: {
            field: Object
        },
        methods: {
            handleSuccess(response, file, fileList) {
                this.$emit('change', { column_name: this.field.column_name  , value: [...fileList]});
            },
            handleRemove(file, fileList) {
                this.request.destroy(file.response.data.id)
                    .then((response) => {
                        this.$message({
                            type: 'success',
                            message: 'Attachment removed.'
                        });

                        this.$emit('change', { column_name: this.field.column_name  , value: [...fileList]});
                    });
            },
            handleExceed(files, fileList) {
                this.$message.warning(`The limit is ${this.field.settings.limit}, you selected ${files.length} files this time.`);
            },
            beforeRemove(file, fileList) {
                return this.$confirm(`Cancel the transfer of ${ file.name } ?`);
            },
        }
    }
</script>
