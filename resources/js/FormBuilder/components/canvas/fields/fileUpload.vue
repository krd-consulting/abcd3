<template>
    <div id="fileUpload">
      <span class="inputLabel">{{ myOptions.title }}</span><br>
      <el-upload
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
        <el-collapse>
            <el-collapse-item>
                <template slot="title">
                    <el-button type="text" icon="el-icon-edit">Edit Field</el-button>
                </template>
                 <el-form label-position="top" ref="myOptions" :model="options" @submit.native.prevent>
                    <el-form-item label="Field Label">
                        <el-input v-model="myOptions.title"></el-input>
                    </el-form-item>
                    <el-form-item label="This Field is">
                      <el-switch v-model="myOptions.required" active-text="Required" inactive-text="Optional"></el-switch>
                    </el-form-item>
                </el-form>
                <slot></slot>
            </el-collapse-item>
        </el-collapse>
    </div>
</template>

<script>
export default {
    data() {
      return {
        fileList: [],
        myOptions: [],
      };
    },
    props: {
        options: {
            type: Array | Object,
            default: {}
        }
    },
    created() {
        this.myOptions = _.clone(this.options)
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
