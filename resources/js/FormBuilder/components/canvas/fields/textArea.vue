<template>
    <div id="Textbox">
        <slot></slot>
        
        <div class="tw-inline-flex tw-my-1">
            <label class="tw-flex-1">   
                <editable-text 
                    class="tw-cursor-pointer mouseOver" 
                    v-model="fieldLabel"
                    @edit="tempValue(fieldLabel)">
                    {{ fieldLabel }}
                </editable-text>
            </label> 
            <div class="tw-flex-none tw-w-64">
                <el-col :span="24">
                <el-input id="textBox" 
                    v-if="field.settings.isLimited" 
                    type="textarea" 
                    :rows="2" 
                    :maxlength="field.settings.max" 
                    show-word-limit 
                    placeholder=" ">
                </el-input>
                <el-input id="textBox" 
                    type="textarea" 
                    v-else
                    :rows="2" 
                    placeholder=" " >
                </el-input>
                </el-col>
            </div>
        </div>

        <el-switch 
            v-model="required" 
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
    name: 'Textbox',
    data() {
        return {
            isEmpty: false,
            temp: ''
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
