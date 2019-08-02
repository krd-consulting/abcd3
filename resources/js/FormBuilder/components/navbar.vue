<template>
    <el-menu 
        :default-active="$route.path" 
        class="w-full" 
        background-color="#fff" 
        active-text-color="#409EFF" 
        mode="horizontal" 
        router>
            <el-menu-item default-active 
                index="/forms/create" 
                class="tw-font-bold focus:tw-font-extrabold">
                    Form Builder
            </el-menu-item>
            <el-menu-item index="/forms/create/preview" 
                class="tw-font-bold focus:tw-font-extrabold">
                    Preview Form
            </el-menu-item>
            <el-menu-item
                class="float-right tw-font-bold focus:font-extrabold" 
                @click="buildForm">
                    Finish and Build!
            </el-menu-item>
    </el-menu>
</template>

<script>
export default {
    methods: {
        buildForm() {
            this.$confirm('Are you sure you are ready to build this form?', 'Confirm', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'info'
            }).then(() => {
                this.$message({
                    type: 'success',
                    message: 'Build Successful'
                });
                this.$store.dispatch('submitForm')
                //window.location.href = '/forms/';
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: "Keep doing what you're are doing"
                }).then(() => {
                    this.$message({
                        type: 'warning',
                        message: "Woops, Something went wrong. Please try submitting again"
                    })
                });          
            });
        },
    }
}
</script>

<style scoped>
    .float-right {
        float: right !important;
    }
</style>
