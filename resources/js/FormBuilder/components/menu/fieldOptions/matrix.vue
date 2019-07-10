<template>
    <div>
        <el-form label-position="top" ref="fieldData" :rules="fieldData.rules" :model="fieldData" @submit.native.prevent>
            
            <el-form-item label="Question/Title" prop="label">
                <el-input v-model="fieldData.label"></el-input>
            </el-form-item>
            
            <el-form-item label="Additional Title Information">
                <el-input v-model="fieldData.description"></el-input>
            </el-form-item>
            
            <el-form-item label="This Field is">
                <el-switch v-model="fieldData.settings.required" active-text="Required" inactive-text="Optional"></el-switch>
            </el-form-item>
            
            <el-form-item label="Number of Questions" >
                <el-input-number v-model="fieldData.settings.matrix_questions"
                    controls-position="right" 
                    :min="1">
                </el-input-number>
            </el-form-item>
            
            <el-form-item label="Number of Choices Per Question">
                <el-input-number v-model="fieldData.settings.matrix_choices"
                    controls-position="right"  
                    :min="1" :max="10">
                </el-input-number>
            </el-form-item>
            
            <el-form-item>
                <slot :fieldData="fieldData"></slot>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
export default {
    name: 'matrix',
    data: () => {
        return {
            fieldData: {
                type: 'Matrix',
                name: 'matrix_field',
                label: '',
                description: '',
                settings: {
                    required: false,
                    matrix_questions: 2,
                    matrix_choices: 5,
                },
                questions: [],
                choices: [],
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
        submitfieldData(fieldData) {
            this.$emit('inputData', this.fieldData);
        }
    }
}
</script>

<style>

</style>
