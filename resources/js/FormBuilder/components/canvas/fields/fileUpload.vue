<template>
    <div id="fileUpload">
      <label class="inputLabel">
          <editable-text class="tw-cursor-pointer mouseOver" v-model="field.label">{{ field.label}}</editable-text>
          <editable-text class="tw-cursor-pointer mouseOver tw-text-xs" v-model="field.description">{{ field.description }}</editable-text>
      </label>
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
        <slot></slot>
    </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    data() {
      return {
        fileList: [],
        field: []
      };
    },
    props: {
        fieldData: {
            type: Array | Object,
            default: {}
        }
    },
    components: {
      EditableText
    },
    created() {
        this.field = _.clone(this.fieldData)
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

<style scoped>
.mouseOver:hover {
    color: #409EFF;
    text-decoration: underline;
    font-size: 110%;
}
</style>
