<template>
    <div>
        <el-form label-position="top" ref="fieldData" :rules="fieldData.rules" :model="fieldData" @submit.native.prevent>
            
            <el-form-item label="Question/Title" prop="label">
                <el-input v-model="fieldData.label"></el-input>
            </el-form-item>
            
            <el-form-item label="This Field is">
                <el-switch v-model="fieldData.required" active-text="Required" inactive-text="Optional"></el-switch>
            </el-form-item>
            
            <el-form-item>
                <el-input-number v-model="fieldData.settings.radioNum" controls-position="right" @change="handleChange" :min="1" :max="10"></el-input-number>
            </el-form-item>
            
            <el-form-item>
                <slot :fieldData="fieldData"></slot>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
export default {
    name: 'radioField',
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
            this.$emit('outputData', this.fieldData);
        }
    }
}
</script>

<style>

</style>
