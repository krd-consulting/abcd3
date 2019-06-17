<template>
    <div class="formCreate">
      
        <el-container> 
            <el-card> 
                <el-aside class="menu-container">
                    <form-menu @add="addField" class="abcd-sticky"/>
                </el-aside>
            </el-card>

        <el-container id="canvas-container">
        <el-card id="canvas">
            <el-header class="abcd-header">
                <el-menu :default-active="$route.path" 
                    background-color="#fff" active-text-color="#409EFF" 
                    mode="horizontal" @select="handleSelect" router>
                        <el-menu-item default-active index="/forms/create" class="tw-font-bold tw-focus:font-extrabold">Form Builder</el-menu-item>
                        <el-menu-item index="/forms/create/preview" class="tw-font-bold tw-focus:font-extrabold">Preview Form</el-menu-item>
                        <el-menu-item index="/forms" class="dock-right tw-font-bold tw-focus:font-extrabold">Finish and Build!</el-menu-item>
                </el-menu>
            </el-header>   

            <el-main>
                <FormCanvas :fields="fields" @inputOptions="setOptions"/>
            </el-main>
        </el-card>

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
    .abcd-header {
        background-color: #fff;
    }
    .dock-right {
        float: right;
    }
    .menu-container{
        margin-top: 60px;
    }
    #canvas {
        width: 100%;
    }
    #canvas-container {
        margin-left: 5px;
    }
    .abcd-sticky {
        position: -webkit-sticky !important;
        position: -moz-sticky !important;
        position: -ms-sticky !important;
        position: -o-sticky !important;
        position: sticky !important;
        top: -1px !important;
        z-index: 1;
    }
</style>

