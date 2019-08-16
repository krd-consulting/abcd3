<template>
    <div id="textBox">
        <el-form label-position="top" ref="fieldData" :rules="fieldData.rules" :model="fieldData" @submit.native.prevent>
            
            <el-form-item prop="title">
                <label>
                    Question/Title
                </label>
                <el-input v-model="fieldData.title"></el-input>
            </el-form-item>

            <el-form-item class="tw-mt-8">
                <label>
                    This field is
                </label><br>
                <el-switch v-model="fieldData.settings.required" 
                    active-text="Required" 
                    inactive-text="Optional"
                    class="tw--mt-6">
                </el-switch>
            </el-form-item>

            <el-form-item>
                <label>
                    Set character limit
                </label>
                <el-switch v-model="fieldData.settings.isLimited" 
                    inactive-text="No Limit" 
                    active-text="Limit"
                    class="tw--mt-6">
                </el-switch>
                <el-input-number v-model="fieldData.settings.max"
                    :disabled="!fieldData.settings.isLimited" 
                    :step="5" 
                    step-strictly
                    class="tw--mt-8 tw-ml-2">
                </el-input-number>
            </el-form-item>

            <el-form-item class="tw-relative tw-text-center tw-mt-12">
                <el-button type="success" @click="save('fieldData')" class="tw-w-48">Add it!</el-button>
            </el-form-item>

        </el-form>
    </div>
</template>

<script>
export default {
    name: 'textBox',
    data: () => {
        return {
            fieldData: {
                type: 'TextBox',
                name: 'text_box',
                title: '',
                settings: {
                    required: false,
                    isLimited: false,
                    max: 50,
                },
                rules: {
                    title: [
                        { required: true, message: 'Please input question title', trigger: 'blur' }
                    ]
            }
            }
        }
    },
    props: {
        inputData: Object,
    },
    methods: {
        save(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    this.$emit('save', this.fieldData);
                } else {
                    this.$message.error('Oops, You forgot to enter a Question/Title for this field.');
                    return false;
                }
            })
        },
    }
}
</script>

<style>

</style>
