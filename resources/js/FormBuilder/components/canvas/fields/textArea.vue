<template>
    <div id="Textbox" class="tw-mb-4">
        <slot></slot>
        
        <el-row>
            <el-col :span="10">

                <label class="inputLabel">   
                    <editable-text class="tw-cursor-pointer mouseOver" v-model="fieldLabel">
                        {{ fieldLabel }}
                    </editable-text>
                </label> 

                <el-input id="textBox" 
                    v-if="field.settings.isLimited" 
                    type="textarea" 
                    :rows="2" 
                    :maxlength="field.settings.max" 
                    show-word-limit 
                    placeholder="Your text here">
                </el-input>
                <el-input id="textBox" 
                    type="textarea" 
                    v-else
                    :rows="2" 
                    placeholder="Your text here" >
                </el-input>
            </el-col>
        </el-row>

            <el-switch 
                v-model="required" 
                active-text="Required" 
                inactive-text="Optional"
                class="tw-float-right switch-position">
            </el-switch>
        
    </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    name: 'Textbox',
    data() {
        return {
            value: '',
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
            get() { return this.field.title; },
            set(title) { 
                console.log('field label edited');

                const fieldCopy = _.clone(this.field);

                fieldCopy.title = title;

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
