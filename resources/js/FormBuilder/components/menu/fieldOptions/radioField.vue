<template>
    <div>
        <el-form label-position="top" ref="fieldData" :rules="fieldData.rules" :model="fieldData" @submit.native.prevent>
            
            <el-form-item label="Question/Title" prop="label">
                <el-input v-model="fieldData.label"></el-input>
            </el-form-item>
            
            <el-form-item label="This Field is">
                <el-switch v-model="fieldData.settings.required" active-text="Required" inactive-text="Optional"></el-switch>
            </el-form-item>
            
            <el-form-item label="Number of Radio Selections">
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
                type: 'Radio',
                name: 'radio_field',
                label: '',
                settings: {
                    required: false,
                    radioNum: 2,
                },
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
