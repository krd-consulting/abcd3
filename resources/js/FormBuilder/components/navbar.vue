<template>
<div>
    <el-menu 
        :default-active="$route.path" 
        class="w-full" 
        background-color="#fff" 
        active-text-color="#409EFF" 
        mode="horizontal" 
        router>
            <!-- <el-menu-item default-active 
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
            </el-menu-item> -->
            <router-link to="/forms/create">
                <el-button class="tw-float-left tw-bg-blue-500 tw-text-white">Form Builder</el-button>
            </router-link>
            <el-button class="tw-float-right tw-bg-blue-500 tw-text-white" @click="visible = true">Finish & Build!</el-button>
            <router-link to="/forms/create/preview">
                <el-button class="tw-float-right tw-bg-blue-500 tw-text-white tw-mx-1">Preview</el-button>
            </router-link>

            <el-dialog :visible.sync="visible" width="30%">
                    <div slot="title">
                        <base-icon class="tw-align-middle">done_outline</base-icon> Confirm
                    </div>
                
                <span class="tw-text-sm">Are you sure you are ready to build this form?</span>
                <div slot="footer" class="tw-border-t tw-px-4 tw-py-4 tw-bg-gray-100 tw-rounded-b">
                    <a @click="cancel" class="tw-py-2 tw-pl-4 tw-bg-transparent tw-pr-4 tw-text-gray-700 tw-font-bold tw-border-none hover:tw-bg-transparent hover:tw-text-blue tw-text-xs">
                        Nevermind
                    </a>
                    <base-button 
                        class="tw-py-2 tw-pl-4 tw-pr-4 tw-bg-blue-500 tw-text-white tw-font-bold tw-border-none"
                        @click="submit">
                        <span class="tw-text-xs tw-align-middle">Good to go!</span>
                    </base-button>
                </div>
            </el-dialog>
                
    </el-menu>


</div>
</template>

<script>
export default {
    data() {
        return {
            visible: false
        }
    },
    methods: {
        submit() {
            this.$message({
                    type: 'success',
                    message: 'Build Successful'
            });
            //  redirect to forms
            this.$store.dispatch('submitForm').then((response) => {
                
                // return Promise('') --> Validate whether or not the form is good
            })
            .catch(() => {
                this.$message({
                    type: 'error',
                    message: 'Oops! Something went wrong.'
                });
            });
            this.visible = false;
            window.location.href = '/forms/';
        },
        cancel() {
            this.visible = false;
            this.$message({
                type: 'info',
                message: "Keep doing what you're are doing"
            });
        },

        // buildForm() {
        //     this.$confirm('Are you sure you are ready to build this form?', 'Confirm', {
        //         confirmButtonText: 'OK',
        //         cancelButtonText: 'Cancel',
        //         type: 'info'
        //     }).then(() => {
        //         this.$message({
        //             type: 'success',
        //             message: 'Build Successful'
        //         });
        //         this.$store.dispatch('submitForm').then((response) => {
        //             //  redirect to forms
        //             // return Promise('') --> Validate whether or not the form is good
        //         })
        //         .catch((error) => {
        //             // display error saying some data is incompatable
        //         });
        //         window.location.href = '/forms/';
        //     }).catch(() => {
        //         this.$message({
        //             type: 'info',
        //             message: "Keep doing what you're are doing"
        //         }).then(() => {
        //             this.$message({
        //                 type: 'warning',
        //                 message: "Woops, Something went wrong. Please try submitting again"
        //             })
        //         });          
        //     });
        // },
    }
}
</script>

<style scoped>
    .float-right {
        float: right !important;
    }
</style>
