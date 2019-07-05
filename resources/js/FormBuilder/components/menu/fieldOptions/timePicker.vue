<template>
    <div id="timePicker">
       <el-form label-position="top" ref="fieldData" :rules="fieldData.rules" :model="fieldData" @submit.native.prevent>
            
            <el-form-item label="Question/Title" prop="label">
                <el-input v-model="fieldData.label"></el-input>
            </el-form-item>

            <el-form-item label="This Field is">
                <el-switch v-model="fieldData.settings.required" active-text="Required" inactive-text="Optional"></el-switch>
            </el-form-item>

            <el-form-item>
                <slot :fieldData="fieldData"></slot>
            </el-form-item>

       </el-form>
   </div>
</template>

<script>
export default {
    name: 'timePicker',
    data: () => {
        return {
            fieldData: {
                type: 'TimePicker',
                label: '',
                settings: {
                    required: false,
                },
                rules: {
                    label: [
                        { required: true, message: 'Please input Question or Title', trigger: 'blur' }
                    ]
                }
            },
        }
    },
    props: {
        inputData: Object,
    },
    methods: {
        submitfieldData(fieldData) {
            this.$emit('inputData', this.fieldData);
        },
    }
}
</script>

<style>
</style>
