<template>
    <div id="numeric">
        <el-col :span="8">
            <label class="inputLabel">
                <editable-text class="tw-cursor-pointer mouseOver" v-model="fieldLabel">
                    {{ fieldLabel }}
                </editable-text>
            </label>
        
        
            <el-input-number id="numfield" v-if="field.settings.isLimited" 
                v-model="field.settings.defaultNum">
            </el-input-number>
            <el-input-number id="numfield" 
                v-else 
                v-model="num">
            </el-input-number>
        </el-col> 

        <el-switch 
            v-model="required" 
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
    name: 'numeric',
    data() {
        return {
            num: 0,
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
