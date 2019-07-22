<template>
    <div id="textBox">
        <el-form label-position="top" ref="fieldData" :rules="fieldData.rules" :model="fieldData" @submit.native.prevent>
            
            <el-form-item label="Question/Title" prop="title">
                <el-input v-model="fieldData.title"></el-input>
            </el-form-item>

            <el-form-item label="This Field is">
                <el-switch v-model="fieldData.settings.required" 
                    active-text="Required" 
                    inactive-text="Optional">
                </el-switch>
            </el-form-item>

            <el-form-item label="Set Character Limit">
                <el-switch v-model="fieldData.settings.isLimited" 
                    inactive-text="No Limit" 
                    active-text="Limit">
                </el-switch>
                <el-input-number v-model="fieldData.settings.max"
                    :disabled="!fieldData.settings.isLimited" 
                    :step="5" 
                    step-strictly>
                </el-input-number>
            </el-form-item>

            <el-form-item class="tw-relative tw-text-center tw-mt-12">
                <el-button type="success" @click="save" class="tw-w-48">Set</el-button>
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
                        { required: true, message: 'Please input Question or title', trigger: 'blur' }
                    ]
            }
            }
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
