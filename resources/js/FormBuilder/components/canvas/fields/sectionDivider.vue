<template>
    <div>
        <el-divider>

            <span>
                <editable-text class="tw-cursor-pointer" @input="showField" v-model="field.label">{{ field.label}}</editable-text>
            </span>

        </el-divider>

        <slot></slot>
    </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    data() {
        return {
            field: []
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

<style>

</style>

