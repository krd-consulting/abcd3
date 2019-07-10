<template>
    <div id="sectionDivider">
       <el-form label-position="top" ref="fieldData" :model="fieldData" @submit.native.prevent>
            
            <el-form-item label="Section label">
                <el-input v-model="fieldData.label"></el-input>
            </el-form-item>
            
            <el-form-item>
                <el-button type="success" @click="save">Set</el-button>
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
            name: 'section_divider',
            fieldData: {
                label: ''
            },
        }
    },
    props: {
        inputData: Object,
    },
    methods: {

        save() {
            this.$emit('save', this.fieldData);
        }
    }
}
</script>

<style>

</style>
