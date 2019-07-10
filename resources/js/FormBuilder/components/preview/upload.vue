<template>
    <div id="fileUpload" class="tw-my-8">
      <el-row>
        <el-col :span="6">
          <label for="dropdown" class="inputLabel">{{ field.label }}</label><br>
              <sup>{{ field.fieldDescription }}</sup>
        </el-col>

        <el-col :span="10">
          <el-upload disabled
              action="https://jsonplaceholder.typicode.com/posts/"
              :on-preview="handlePreview"
              :on-remove="handleRemove"
              :before-remove="beforeRemove"
              multiple
              :limit="3"
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
export default {
    data: () => {
        return {
            fileList: [],
        }
    },
    props: { 
        field: Object
    },
    methods: {
      handleRemove(file, fileList) {
        console.log(file, fileList);
      },
      handlePreview(file) {
        console.log(file);
      },
      handleExceed(files, fileList) {
        this.$message.warning(`The limit is 3, you selected ${files.length} files this time, add up to ${files.length + fileList.length} totally`);
      },
      beforeRemove(file, fileList) {
        return this.$confirm(`Cancel the transfer of ${ file.name } ?`);
      }
    }
}
</script>

<style>

</style>
