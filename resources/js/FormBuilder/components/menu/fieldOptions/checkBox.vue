<template>
    <div>
        <el-form label-position="top" ref="fieldData" :rules="fieldData.rules" :model="fieldData" @submit.native.prevent>
        
            <el-form-item label="Question/Title:" prop="title">
                <el-col :span="24">
                    <el-input v-model="fieldData.title"></el-input>
                </el-col>
            </el-form-item>
            
            <el-form-item label="This field is:">
                <el-switch v-model="fieldData.settings.required" active-text="Required" inactive-text="Optional"></el-switch>
            </el-form-item>
            
            <el-form-item label="Number of choices:">
                <el-input-number v-model="fieldData.settings.checkboxNum" controls-position="right" :min="1" :max="10"></el-input-number>
            </el-form-item>
            
            <el-form-item class="tw-relative tw-text-center tw-mt-12">
                <el-button type="success" @click="save" class="tw-w-48">Add it!</el-button>
            </el-form-item>

        </el-form>
   </div>
</template>

<script>
export default {
    name: 'checkBox',
    data: () => {
        return {
            fieldData: {
                type: 'CheckBoxField',
                name: 'check_box',
                title: '',
                settings: {
                    required: false,
                    checkboxNum: 2,
                    nextChoice: 0,
                },
                choices: [],
                rules: {
                    title: [
                        { required: true, message: 'Please enter question title', trigger: 'blur' }
                    ]
                }
            },
        }
    },
    props: {
        inputData: Object,
    },
    methods: {

        setChoices() {
            for(let i = 1; i <= this.fieldData.settings.checkboxNum; i++) {
                this.fieldData.choices.push({
                    id: this.fieldData.settings.nextChoice++, value: 'Item ' + this.fieldData.settings.nextChoice
                })
            }
        },

        save() {
            this.setChoices();
            this.$emit('save', this.fieldData);
        },
    }
}
</script>

<style>

</style>
