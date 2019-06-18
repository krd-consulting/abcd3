<template>
    <div id="fileUpload">
      <label for="dropdown" class="inputLabel">{{ inputFieldData.label }}</label><br>
        <sup>{{ inputFieldData.description }}</sup>
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
        <el-collapse>
            <el-collapse-item>
                <template slot="title">
                    <el-button icon="el-icon-edit">Field Options</el-button>
                </template>
                <div class="tw-flex tw-inline-block tw-w-full">
                    <div class="tw-float-left">
                            
                        <el-row class="tw-my-6">
                            <label for="label">Field Label</label>
                            <el-col :span="20">
                                <el-input id="label" v-model="inputFieldData.label"></el-input>
                            </el-col>
                        </el-row>
                        <el-row class="tw-my-6">
                            <el-col :span="20">
                                <label for="description">Field Description</label>
                                <el-input id="description" v-model="inputFieldData.description"></el-input>
                            </el-col>
                        </el-row>
                        <el-row class="tw-my-6">
                            <label for="switch" class="tw-mb-4">This field is</label><br>
                            <el-switch id="switch" v-model="inputFieldData.required" active-text="Required" inactive-text="Optional"></el-switch>
                        </el-row>
                    </div>

                </div>


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
        inputFieldData: []
      };
    },
    props: {
        fieldData: {
            type: Array | Object,
            default: {}
        }
    },
    created() {
        this.inputFieldData = _.clone(this.fieldData)
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
