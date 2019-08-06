<template>
    <div id="fileUpload">
        <slot></slot>
        
        <el-col :span="8">
            <label class="inputLabel">
                <editable-text class="tw-cursor-pointer mouseOver" v-model="fieldLabel">
                    {{ fieldLabel }}
                </editable-text>
                <editable-text class="tw-cursor-pointer tw-text-xs mouseOver" v-model="fieldDescription">
                    {{ fieldDescription }}
                </editable-text>
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
      </el-col>

      <el-switch 
            v-model="field.settings.required" 
            active-text="Required" 
            inactive-text="Optional"
            class="tw-float-right switch-position">
        </el-switch>
    </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    data() {
      return {
        fileList: [],
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
    computed: {
        fieldLabel: {
            get() { return this.field.title; },
            set(title) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.title = title;
                this.field = fieldCopy;
            }
        },

        fieldDescription: {
            get() { return this.field.description; },
            set(description) { 
                console.log('field description edited');

                const fieldCopy = _.clone(this.field);

                fieldCopy.description = description;

                this.field = fieldCopy;
            }
        },

        field: {
            get() { return this.fieldData; },
            set(field) { 
                console.log('field edited');
                this.$emit('update', field); 
            }
        },

        required: {
            get() { return this.field.settings.required; },
            set(required) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.settings.required = required;
                this.field = fieldCopy;
            }
        }
    },
    methods: {
      handleRemove(file, fileList) {
        console.log(file, fileList); // temp methods
      },
      handlePreview(file) {
        console.log(file); // temp methods
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
.switch-position {
    position: absolute;
    bottom: 20px;;
    right: 10px;
}
</style>
