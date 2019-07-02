<template>
    <div id="sectionDivider">
       <el-form label-position="top" ref="fieldData" :model="fieldData" @submit.native.prevent>
            
            <el-form-item label="Section label">
                <el-input v-model="fieldData.label"></el-input>
            </el-form-item>
            
            <el-form-item>
                <slot :fieldData="fieldData"></slot>
            </el-form-item>
       </el-form>
   </div>
</template>

<script>
export default {
    name: 'sectionDivider',
    data: () => {
        return {
            fieldData: {
                label: '',
                description: '',
                reference: '',
                settings: {
                    required: false,
                    defaultNum: 0,
                    dropdownNum: 0,
                    radioNum: 2,
                    checkboxNum: 2,
                    matrix_questions: 2,
                    matrix_choices: 5,
                    isLimited: false,
                    max: 50,
                    past_only: false,
                    future_only: false,
                    quick_menu: false,
                    include_time: false,
                    date_range: false,
                }
            },
        }
    },
    props: {
        inputData: Object,
    },
    methods: {
        handleChange() {
            console.log('Doing the thing in menu options');
        },

        submitfieldData(fieldData) {
            this.$emit('outputData', this.fieldData);
        }
    }
}
</script>

<style>

</style>
