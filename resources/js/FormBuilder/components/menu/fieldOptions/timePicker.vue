<template>
    <div id="timePicker">
       <el-form label-position="top" ref="fieldData" :rules="fieldData.rules" :model="fieldData" @submit.native.prevent>
            
            <el-form-item label="Question/Title" prop="title">
                <el-input v-model="fieldData.title"></el-input>
            </el-form-item>

            <el-form-item label="This field is">
                <el-switch v-model="fieldData.settings.required" active-text="Required" inactive-text="Optional"></el-switch>
            </el-form-item>

            <!--<el-form-item label="Do you need the exact time?">
                <el-row>
                    <el-switch v-model="fieldData.settings.exact_time" active-text="Exact Time"></el-switch>
                </el-row>
            </el-form-item>-->

            <el-form-item class="tw-relative tw-text-center tw-mt-12">
                <el-button type="success" @click="save('fieldData')" class="tw-w-48">Add it!</el-button>
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
                type: 'TimeField',
                name: 'time_picker',
                title: '',
                settings: {
                    required: false,
                    exact_time: false
                },
                rules: {
                    title: [
                        { required: true, message: 'Please input question title', trigger: 'blur' }
                    ]
                }
            },
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
