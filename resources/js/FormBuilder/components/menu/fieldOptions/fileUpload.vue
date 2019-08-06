<template>
    <div id="fileUpload">
       <el-form label-position="top" ref="fieldData" :rules="fieldData.rules" :model="fieldData" @submit.native.prevent>
            
            <el-form-item prop="title">
            <label>
                Question/Title
            </label>
                <el-input v-model="fieldData.title"></el-input>
            </el-form-item>
            
            <el-form-item>
                <label>
                    This field is
                </label>
                <el-switch v-model="fieldData.settings.required" active-text="Required" inactive-text="Optional"></el-switch>
            </el-form-item>
            
            <el-form-item class="tw-relative tw-text-center tw-mt-12">
                <el-button type="success" @click="save" class="tw-w-48">Add it!</el-button>
            </el-form-item>

       </el-form>
   </div>
</template>

<script>
export default {
    name: 'fileUpload',
    data: () => {
        return {
            fieldData: {
                type: 'FileField',
                name: 'file_upload',
                title: '',
                description: '',
                settings: {
                    required: false,
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
        save() {
            this.$emit('save', this.fieldData);
        }
    }
}
</script>

<style>

</style>
