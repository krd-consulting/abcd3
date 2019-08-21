<template>
    <div id="fileUpload">
        <slot></slot>
        
        <div class="tw-inline-flex tw-my-1">
            <label class="tw-flex-1 tw-mt-1">
                <editable-text 
                    class="tw-cursor-pointer mouseOver tw-mr-1" 
                    v-model="fieldLabel"
                    @edit="tempValue(fieldLabel)">
                    {{ fieldLabel }}
                </editable-text>
            </label>
        
      
        <el-upload disabled
            action=""
            :http-request="handleUpload">
            <el-button size="small" type="primary">Click to upload</el-button>
            <div slot="tip" class="el-upload__tip">jpg/png files with a size less than 500kb</div>
        </el-upload>
      </div>

      <el-switch 
            v-model="field.settings.required" 
            active-text="Required" 
            inactive-text="Optional"
            class="tw-float-right switch-position">
        </el-switch>

        <el-alert
            v-if="isEmpty"
            title="Woops! Your question/title cannot be empty. Lets try that again."
            type="error">
        </el-alert>
    </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    data() {
        return {
            fileList: [],
            isEmpty: false,
            temp: ''
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
                if(title === ''){
                    title = this.temp;
                    return this.isEmpty = true;
                }

                const fieldCopy = _.clone(this.field);
                fieldCopy.title = title;
                this.field = fieldCopy;
                this.isEmpty = false;
            }
        },

        fieldDescription: {
            get() { return this.field.description; },
            set(description) { 

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
        handleUpload() {
            console.log('disabled')
        },

        tempValue(value) {
            this.temp = value;
        },
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
    position: relative;
    top: 15px;
    right: 40px;
}
</style>
