<template>
    <div id="timePicker">
        <el-row>

            <label class="inputLabel">
                <editable-text class="tw-cursor-pointer mouseOver" @input="showField" v-model="field.label">{{ field.label }}</editable-text>
            </label>

            <sup>{{ field.description }}</sup>
            <el-time-picker
                arrow-control
                v-model="timeSelection"
                :picker-options="{selectableRange: '18:30:00 - 20:30:00'}"
                placeholder="Pick a time">
            </el-time-picker>

            <slot></slot>
        </el-row>
    </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    data: () => {
        return {
            timeSelection: '',
            field: [],
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
