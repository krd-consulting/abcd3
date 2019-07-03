<template>
    <div id="numeric">
        <label class="inputLabel">
            <editable-text class="tw-cursor-pointer mouseOver" v-model="field.label">{{ field.label}}</editable-text>
        </label>
        <el-input-number id="numfield" v-if="field.settings.isLimited" 
            v-model="field.settings.defaultNum">
        </el-input-number>
        <el-input-number id="numfield" 
            v-else 
            v-model="num">
        </el-input-number>

        <slot></slot>
    </div>
</template>

<script>
import EditableText from '@/components/editableText.vue'

export default {
    name: 'numeric',
    data() {
        return {
            num: 0,
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
}
</script>

<style scoped>
.mouseOver:hover {
    color: #409EFF;
    text-decoration: underline;
    font-size: 110%;
}
</style>
