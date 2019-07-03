<template>
    <div>
        <el-form label-position="top" ref="fieldData" :rules="fieldData.rules" :model="fieldData" @submit.native.prevent>
            
            <el-form-item label="Question/Title" prop="label">
                <el-input v-model="fieldData.label"></el-input>
            </el-form-item>

            <el-form-item label="This Field is">
                <el-switch v-model="fieldData.settings.required" active-text="Required" inactive-text="Optional"></el-switch>
            </el-form-item>

            <el-form-item label="Set Default Value">
                <el-switch v-model="fieldData.settings.isLimited" inactive-text="No Default" active-text="Set Default"></el-switch>
                <el-input-number :disabled="!fieldData.settings.isLimited" v-model="fieldData.settings.defaultNum"></el-input-number>
            </el-form-item>

            <el-form-item>
                <slot :fieldData="fieldData"></slot>
            </el-form-item>

        </el-form>
   </div>
</template>

<script>
export default {
name: 'Numeric',
    data: () => {
        return {
            fieldData: {
                label: '',
                description: '',
                reference: '',
                settings: {
                    required: false,
                    defaultNum: 0,
                    dropdownNum: 0,
                    radioNum: 2,
                    checkboxNum: 2,
                    matrix_questions: 2,
                    matrix_choices: 5,
                    isLimited: false,
                    max: 50,
                    past_only: false,
                    future_only: false,
                    quick_menu: false,
                    include_time: false,
                    date_range: false,
                },
                rules: {
                    label: [
                        { required: true, message: 'Please input Question or title', trigger: 'blur' }
                    ]
                }
            },
        }
    },
    props: {
        inputData: Object,
    },
    methods: {
        handleChange() {
            console.log('Doing the thing in menu options');
        },
        submitfieldData(fieldData) {
            this.$emit('inputData', this.fieldData);
        }
    }
}
</script>

<style>

</style>
