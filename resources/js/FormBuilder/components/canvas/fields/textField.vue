<template>
  <div id="Textfield">
    <el-row>
        <el-col :span="10">
            
            <label class="inputLabel">
                <editable-text class="tw-cursor-pointer" @input="showField" v-model="field.label">{{ field.label }}</editable-text>
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
            <slot></slot>
    </el-row>
  </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    name: 'Textfield',
    data() {
        return {
            value: '',
            field: []
        }
    },
    props: {
        fieldData: {
            type: Array | Object,
            default: {
                label: 'Text Field'
            }
        }
    },
    components: {
        EditableText
    },
    created() {
        this.field = _.clone(this.fieldData)
    },
    methods: {
        showField(value){
            return (this.field.label[value] == '' || this.editField == value)
        }
    }
}
</script>

<style>
</style>
