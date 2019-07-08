<template>
    <div>
        <el-form label-position="top" ref="fieldData" :rules="fieldData.rules" :model="fieldData" @submit.native.prevent>
            
            <el-form-item label="Question/Title" prop="label">
                <el-input v-model="fieldData.label"></el-input>
            </el-form-item>
            
            <el-form-item label="This Field is">
                <el-switch v-model="fieldData.required" active-text="Required" inactive-text="Optional"></el-switch>
            </el-form-item>
            
            <el-form-item label="Number of Menu Selections">
                <el-input-number v-model="fieldData.settings.dropdownNum" controls-position="right" :min="2" :max="10"></el-input-number>
            </el-form-item>

            <el-form-item>
                <slot :fieldData="fieldData"></slot>
            </el-form-item>

        </el-form>
    </div>
</template>

<script>
export default {
    name: 'dropdown',
    data: () => {
        return {
            fieldData: {
                type: 'Dropdown',
                label: '',
                settings: {
                    required: false,
                    dropdownNum: 2,
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
        submitfieldData(fieldData) {
            this.$emit('outputData', this.fieldData);
        }
    }
}
</script>

<style>

</style>
