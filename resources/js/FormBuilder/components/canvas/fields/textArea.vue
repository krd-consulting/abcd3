<template>
    <div id="Textbox">
        <el-row>
            <el-col :span="10">
                <label class="inputLabel">
                    <editable-text class="tw-cursor-pointer mouseOver" @input="showField" v-model="field.label">{{ field.label }}</editable-text>
                </label>
                <sup>{{ field.description }}</sup>
                <el-input id="textBox" 
                    v-if="field.settings.isLimited" 
                    type="textarea" 
                    :rows="2" 
                    :maxlength="field.settings.max" 
                    show-word-limit 
                    placeholder="Your text here" 
                    v-model="value">
                </el-input>
                <el-input id="textBox" 
                    v-else type="textarea" 
                    :rows="2" 
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
    name: 'Textbox',
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
                label: 'Text Area',
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

<style scoped>
.mouseOver:hover {
    color: #409EFF;
    text-decoration: underline;
    font-size: 110%;
}
</style>
