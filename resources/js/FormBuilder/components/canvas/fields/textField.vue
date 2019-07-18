<template>
  <div>
    <el-row>
        <el-col :span="10">
            
            <label class="inputLabel">   
                <editable-text class="tw-cursor-pointer mouseOver" v-model="fieldLabel">
                    {{ fieldLabel }}
                </editable-text>
            </label>    

            <el-input v-if="field.settings.isLimited"
                id="input"
                type="text" 
                :maxlength="field.settings.max" 
                placeholder="Your text here" 
                v-model="value" 
                show-word-limit>
            </el-input>
            <el-input v-else 
                id="input"
                type="text" 
                placeholder="Your text here" 
                v-model="value">
            </el-input>

        </el-col>
    </el-row>

    <el-switch 
        v-model="field.settings.required" 
        active-text="Required" 
        inactive-text="Optional"
        class="tw-float-right tw-mr-48 button-top">
    </el-switch>

    <div class="footer">
        <slot></slot>
    </div>
    
  </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    name: 'Textfield',
    data() {
        return {
            value: ''
        }
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
            get() { return this.field.label; },
            set(label) { 
                const fieldCopy = _.clone(this.field);
                fieldCopy.label = label;
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
    },
}
</script>

<style scoped>
.mouseOver:hover {
    color: #409EFF;
    text-decoration: underline;
    font-size: 110%;
}
.button-top {
    position: absolute;
    top: 30px;;
    right: 10px;
}
.footer{
    position: absolute;
    bottom: 0;
    right: 10px;
}
</style>
