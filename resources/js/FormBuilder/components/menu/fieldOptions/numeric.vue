<template>
    <div>
        <el-form label-position="top" ref="fieldData" :rules="fieldData.rules" :model="fieldData" @submit.native.prevent>
            
            <el-form-item label="Question/Title" prop="title">
                <el-input v-model="fieldData.title"></el-input>
            </el-form-item>

            <el-form-item label="This field is">
                <el-switch v-model="fieldData.settings.required" active-text="Required" inactive-text="Optional"></el-switch>
            </el-form-item>

            <el-form-item label="Set Default Value">
                <el-switch v-model="fieldData.settings.isLimited" inactive-text="No Default" active-text="Set Default"></el-switch><br>
                <el-input-number :disabled="!fieldData.settings.isLimited" v-model="fieldData.settings.defaultNum"></el-input-number>
            </el-form-item>

            <el-form-item class="tw-relative tw-text-center tw-mt-12">
                <el-button type="success" @click="save" class="tw-w-48">Add it!</el-button>
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
                type: 'NumberField',
                name: 'numeric_field',
                title: '',
                settings: {
                    required: false,
                    defaultNum: 5,
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
