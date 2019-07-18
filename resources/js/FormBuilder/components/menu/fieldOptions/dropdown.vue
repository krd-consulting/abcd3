<template>
    <div>
        <el-form label-position="top" ref="fieldData" :rules="fieldData.rules" :model="fieldData" @submit.native.prevent>
            
            <el-form-item label="Question/Title" prop="label">
                <el-input v-model="fieldData.label"></el-input>
            </el-form-item>
            
            <el-form-item label="This Field is">
                <el-switch v-model="fieldData.settings.required" active-text="Required" inactive-text="Optional"></el-switch>
            </el-form-item>
            
            <!-- <el-form-item label="Number of Menu Selections">
                <el-input-number v-model="fieldData.settings.dropdownNum" controls-position="right" :min="2" :max="10"></el-input-number>
            </el-form-item> -->

            <el-form-item class="tw-relative tw-text-center tw-mt-12">
                <el-button type="success" @click="save" class="tw-w-48">Set</el-button>
            </el-form-item>

        </el-form>
    </div>
</template>

<script>
export default {
    name: 'dropdown',
    data: () => {
        return {
            fieldData: {
                type: 'Dropdown',
                name: 'dropdown',
                label: '',
                settings: {
                    required: false,
                    // dropdownNum: 2,
                    nextChoice: 0
                },
                choices: [],
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

        setChoices() {
            for(let i = 1; i <= this.fieldData.settings.dropdownNum; i++) {
                this.fieldData.choices.push({
                    id: this.fieldData.settings.nextChoice++, value: 'Item ' + this.fieldData.settings.nextChoice
                })
            }
        },

        save() {
            this.setChoices();

            this.$emit('save', this.fieldData);
        }
    }
}
</script>

<style>

</style>
