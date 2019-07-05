<template>
    <div id="sectionDivider">
       <el-form label-position="top" ref="fieldData" :model="fieldData" @submit.native.prevent>
            
            <el-form-item label="Section label">
                <el-input v-model="fieldData.label"></el-input>
            </el-form-item>
            
            <el-form-item>
                <slot :fieldData="fieldData"></slot>
            </el-form-item>
       </el-form>
   </div>
</template>

<script>
export default {
    name: 'sectionDivider',
    data: () => {
        return {
            type: 'SectionDivider',
            fieldData: {
                label: ''
            },
        }
    },
    props: {
        inputData: Object,
    },
    methods: {

        submitfieldData(fieldData) {
            this.$emit('outputData', this.fieldData);
        }
    }
}
</script>

<style>

</style>
