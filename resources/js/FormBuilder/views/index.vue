<template>
    <div class="formCreate">
        <el-container class="create-container">
            
            <el-aside class="abcd-sticky">
                <div id="logo">
                     ABCD
                </div>
                <form-menu @add="addField"/>
            </el-aside>

            <el-container class="abcd-sticky">
                <el-header class="abcd-sticky">
                    <el-menu :default-active="$route.path" 
                        class="w-full" background-color="#eef1f6" active-text-color="#409EFF" 
                        mode="horizontal" @select="handleSelect" router>
                        <el-menu-item default-active index="/forms/create" class="font-bold focus:font-extrabold">Form Builder</el-menu-item>
                        <el-menu-item index="/forms/create/preview" class="font-bold focus:font-extrabold">Preview Form</el-menu-item>
                        <el-menu-item index="/forms" class="dock-right font-bold focus:font-extrabold">Finish and Build!</el-menu-item>
                    </el-menu>
                </el-header>
    
                <el-main>
                    <FormCanvas :fields="fields" @inputOptions="setOptions"/>
                </el-main>
            </el-container>
        </el-container>
    </div>
</template>

<script>
import draggable from 'vuedraggable';
import FormCanvas from '@/FormBuilder/components/canvas/index.vue'
import FormMenu from '@/FormBuilder/components/menu/index.vue'

export default {
    name: 'Form',
    components: {
        FormCanvas,
        FormMenu,
        draggable
    },
    data: () => {
        return {
            // image: image,
            activeIndex: '1',
            inputOptions: {},
            fields: []
        }
    },
    methods: {
        handleSelect(key, keyPath) {
            console.log(key, keyPath);
        },
        addField(field) {
            // append to fields
            this.fields.push(field);
        },
        setOptions(options) {
            this.inputOptions.push(options)
            console.log(this.inputOptions.title);
            // this.$emit()
        },
        updateCanvas(data) {
            this.canvasInput = data.input;
            this.inputOptions = data.options;
        },
        // buildForm() {
        //     this.$confirm('Are you sure you are ready to build this form?', 'Confirm', {
        //             confirmButtonText: 'OK',
        //             cancelButtonText: 'Cancel',
        //             type: 'info'
        //         }).then(() => {
        //             this.$message({
        //                 type: 'success',
        //                 message: 'Build Successful'
        //             });
        //         }).catch(() => {
        //             this.$message({
        //                 type: 'info',
        //                 message: "Keep doing what you're are doing"
        //             });          
        //         });
        // }
    }
}
</script>

<style scoped>
    .create-container {
        height: 100%; 
        flex-shrink: inherit;
        border: 1px solid #eee;
        position: -webkit-sticky;
        position: sticky;
        top: 0;
    }
    .abcd-sticky {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
    }
    .create-header {
        background-color: rgb(238, 241, 246);
        color: #333;
        line-height: 50px;
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        z-index: 1;
    }
    .el-aside {
        color: #333;
        background-color: rgb(238, 241, 246);
        flex-shrink: inherit;
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        min-width: 180px;
        max-width: 320px;
        max-height: 960px;
        padding-right: 5px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    .el-menu--horizontal > .el-menu-item.dock-right {
        float: right;
        margin: 0 auto;
    }
    #logo {
        height: 60px;
    }
    img {
        height: 50px;
        margin-top: 5px;
        margin-left: 15px;
    }
</style>

