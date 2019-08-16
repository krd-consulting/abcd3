<template>
    <div>
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
                <el-switch v-model="fieldData.settings.required" active-text="Required" inactive-text="Optional" class="tw--mt-6"></el-switch>
            </el-form-item>
            
            <el-form-item>
                <label>
                    Calendar Preferences
                </label>
                <el-row class="tw--mt-1 tw-ml-4">
                    <el-switch v-model="fieldData.settings.pastOnly" active-text="Past dates only"></el-switch>
                </el-row>
                <el-row class="tw--mt-1 tw-ml-4">
                    <el-switch v-model="fieldData.settings.futureOnly" active-text="Future dates only"></el-switch>
                </el-row>
                <el-row class="tw--mt-1 tw-ml-4">
                    <el-switch v-model="fieldData.settings.quickMenu" active-text="Include shortcuts"></el-switch>
                </el-row>
                <el-row class="tw--mt-1 tw-ml-4">
                    <el-switch v-model="fieldData.settings.includeTime" active-text="Include time"></el-switch>
                </el-row>
                <el-row class="tw--mt-1 tw-ml-4">
                    <el-switch v-model="fieldData.settings.dateRange" active-text="Set a date range"></el-switch>
                </el-row>
            </el-form-item>

            <el-form-item class="tw-relative tw-text-center tw-mt-12">
                <el-button type="success" @click="save('fieldData')" class="tw-w-48">Add it!</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
export default {
    name: 'datePicker',
    data: () => {
        return {
            fieldData: {
                type: 'DateField',
                name: 'date_picker',
                title: '',
                settings: {
                    required: false,
                    pastOnly: false,
                    futureOnly: false,
                    quickMenu: false,
                    includeTime: false,
                    dateRange: false,
                    dateSelection: '',
                    dateType: 'date',
                    dateOptions: {},
                    datePlaceHolder: 'Pick a day',
                    dateFormat: 'yyyy/MM/dd',
                    rangeSeparator: '',
                    startDate: '',
                    endDate: '',
                },
                rules: {
                    title: [
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
