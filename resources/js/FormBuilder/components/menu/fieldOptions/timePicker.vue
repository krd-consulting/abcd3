<template>
    <div id="timePicker">
       <el-form label-position="top" ref="fieldData" :rules="fieldData.rules" :model="fieldData" @submit.native.prevent>
            
            <el-form-item label="Question/Title" prop="label">
                <el-input v-model="fieldData.label"></el-input>
            </el-form-item>

            <el-form-item label="This Field is">
                <el-switch v-model="fieldData.settings.required" active-text="Required" inactive-text="Optional"></el-switch>
            </el-form-item>

            <el-form-item label="Do you need the exact time?">
                <el-row>
                    <el-switch v-model="fieldData.settings.exact_time" active-text="Exact Time"></el-switch>
                </el-row>
            </el-form-item>

            <el-form-item class="tw-relative tw-text-center tw-mt-12">
                <el-button type="success" @click="save" class="tw-w-48">Set</el-button>
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
                label: '',
                settings: {
                    required: false,
                    exact_time: false
                },
                rules: {
                    label: [{   
                        required: true, 
                        message: 'Please input Question or Title', 
                        trigger: 'blur' 
                    }]
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
        },
    }
}
</script>

<style>
</style>
