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
                <el-button type="success" @click="save">Set</el-button>
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
                type: 'Numeric',
                name: 'numeric_field',
                label: '',
                settings: {
                    required: false,
                    defaultNum: 5,
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
        save() {
            this.$emit('save', this.fieldData);
        }
    }
}
</script>

<style>

</style>
