<template>
    <div id="sectionDivider">
       <el-form label-position="top" ref="fieldData" :model="fieldData" @submit.native.prevent>
            
            <el-form-item>
                <label>
                    Section Title
                </label>
                <el-input v-model="fieldData.title"></el-input>
            </el-form-item>
            
            <el-form-item class="tw-relative tw-text-center tw-mt-12">
                <el-button type="success" @click="save" class="tw-w-48">Add it!</el-button>
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
                type: 'SectionDivider',
                name: 'section_divider',
                title: '',
                // settings: {
                //     required: false,
                // },
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
