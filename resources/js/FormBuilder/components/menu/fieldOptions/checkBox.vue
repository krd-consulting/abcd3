<template>
    <div>
        <el-form label-position="top" ref="fieldData" :rules="fieldData.rules" :model="fieldData" @submit.native.prevent>
        
            <el-form-item prop="title">
                <label>
                    Question/Title
                </label>
                <el-col :span="24">
                    <el-input v-model="fieldData.title"></el-input>
                </el-col>
            </el-form-item>
            
            <el-form-item class="tw-mt-8">
                <label>
                    This field is
                </label><br>
                <el-switch v-model="fieldData.settings.required" active-text="Required" inactive-text="Optional" class="tw--mt-6"></el-switch>
            </el-form-item>
            
            <el-form-item>
                <label>
                    Number of choices
                </label>
                <el-input-number v-model="checkboxNum" controls-position="right" :min="1"></el-input-number>
            </el-form-item>
            
            <el-form-item class="tw-relative tw-text-center tw-mt-12">
                <el-button type="success" @click="save('fieldData')" class="tw-w-48">Add it!</el-button>
            </el-form-item>

        </el-form>
   </div>
</template>

<script>
export default {
    name: 'checkBox',
    data: () => {
        return {
            checkboxNum: 2,
            fieldData: {
                type: 'CheckBoxField',
                name: 'check_box',
                title: '',
                settings: {
                    required: false,
                },
                choices: [],
                rules: {
                    title: [
                        { required: true, message: 'Please enter question or title', trigger: 'blur' }
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
            for(let i = 1; i <= this.checkboxNum; i++) {
                this.fieldData.choices.push( 
                    'Choice ' + i
                )
            }
        },

        save(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    this.setChoices();
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

<style scoped>
    /* .el-form-item.label {
        font-size: 20px;
    } */
</style>
