<template>
    <div id="formCreator">
        <el-container>

                <el-card id="menu-container" class="abcd-sticky"> 
                    <el-aside class="aside">
                        <form-menu @add="addField"/>
                    </el-aside>
                </el-card>
            
        <el-card id="canvas">
            <el-header>
                <el-menu :default-active="$route.path" 
                    background-color="#fff" 
                    active-text-color="#409EFF" 
                    mode="horizontal" 
                    @select="handleSelect" 
                    router>
                        <el-menu-item default-active index="/forms/create" class="tw-font-bold tw-focus:font-extrabold">Form Builder</el-menu-item>
                        <el-menu-item index="/forms/create/preview" class="tw-font-bold tw-focus:font-extrabold">Preview Form</el-menu-item>
                        <el-menu-item index="/forms" @click="buildForm" class="tw-float-right tw-font-bold tw-focus:font-extrabold">Finish &#38; Build!</el-menu-item>
                </el-menu>
            </el-header>   

            <el-main>
                <form-Canvas :fields="fields" @inputOptions="setOptions"/>
            </el-main>
        </el-card>

    </el-container>
        
    </div>
</template>

<script>
import draggable from 'vuedraggable'
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
            // append to fields arrays
            this.fields.push(field);
            // this.$store.dispatch('addField', field)
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
                    alert('One day, this form will persist to the database. but alas, tis not this day.')
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: "Keep doing what you're are doing"
                    });          
                });
        }
    }
}
</script>

<style scoped>
    #formCreator {
        display: flex;
        flex-direction: row;
        /* align-items: center; */
        /* align-items: flex-start; */
        justify-content: center;
        align-items: center;
    }
    .el-header{
        /* display: flex; */
    }
    .aside{
        padding-top: 60px;
        margin: 0 auto;
    }
    #canvas {
        flex: 60%;
        margin-left: 10px;
        margin-right: 10%;
    }
    .dock_right{
        float: right;
    }
    #menu-container {
        flex: 20%;
        margin-left: 10%;
        min-width: 240px;
        max-height: 900px;
        position: -webkit-sticky !important;
        position: sticky !important;
        top: 0 !important;
        /* z-index: 289; */
    }
    /* #canvas-container {
        margin-right: 200px;
        max-width: 100%;
        min-width: 50%;
        
    } */
</style>

