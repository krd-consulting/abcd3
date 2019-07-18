<template>
    <div id="formCreator">
        <el-container>

            <el-card id="menu-container"> 
                <form-menu id="menu"/>
            </el-card>

            <el-card id="canvas-container">
                <el-header>
                    
                    <el-menu :default-active="$route.path" 
                        background-color="#fff" 
                        active-text-color="#409EFF" 
                        mode="horizontal" 
                        router>
                        
                        <!-- <el-menu-item > -->
                            <menu-panel class="mobile-menu tw-float-left">
                                <form-menu id="menu"/>
                            </menu-panel>
                        <!-- </el-menu-item> -->

                            <el-menu-item default-active 
                                index="/forms/create" 
                                class="tw-font-bold tw-focus:font-extrabold">
                                    Form Builder
                            </el-menu-item>
                            <el-menu-item 
                                index="/forms/create/preview" 
                                class="tw-font-bold tw-focus:font-extrabold">
                                    Preview Form
                            </el-menu-item>
                            <el-menu-item 
                                @click="buildForm" 
                                class="float-right tw-font-bold tw-focus:font-extrabold">
                                    Finish &#38; Build!
                            </el-menu-item>
                    </el-menu>
                </el-header>   

                <form-Canvas :fields="fields" id="canvas"/>
            
            </el-card>
            
        </el-container>
    </div>
</template>

<script>
    
    import draggable from 'vuedraggable'
    import FormCanvas from '@/FormBuilder/components/canvas/index.vue'
    import FormMenu from '@/FormBuilder/components/menu/index.vue'
    import menuPanel from '@/FormBuilder/components/menu/mobileMenu.vue'

    export default {
        name: 'Form',
        
        data: () => {
            return {
                activeIndex: '1',
                fields: []
            }
        },

        components: {
            FormCanvas,
            FormMenu,
            draggable,
            menuPanel
        },

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
                        // alert('One day, this form will persist to the database. but alas, tis maybe this day?')
                        this.$store.dispatch('submitForm')
                    }).catch(() => {
                        this.$message({
                            type: 'info',
                            message: "Keep doing what you're are doing"
                        });          
                    });
            }
        },
    }
</script>

<style scoped>

#formCreator {
    display: flex;
    flex-direction: row;
    align-items: center;
}
#canvas {
    width: 100%;
    padding-right: 15px;
}
 
@media (min-width: 768px){

    #canvas-container {
        flex: 100%;
        margin-left: 1%;
        margin-right: 1%;
        min-width: 500px;
    }
    .mobile-menu {
        display: inherit;
        margin: 0 auto;
        margin-top: 10px;
    }
    #menu-container {
        display: none;
    } 
}

/* Standard Desktop View */
@media (min-width: 1024px){
    #canvas-container {
        flex: 80%;
        margin-left: 10px;
        margin-right: 5%;
        min-width: 500px;
    }
    
    .el-header {
        min-width: 500px;
    }
    .mobile-menu {
        display: none;
    }
    #menu-container {
        flex: 22%;
        display: block;
        padding-top: 60px;
        padding-bottom: 10px;
        margin: 0 auto;
        margin-left: 5%;
        max-width: 450px;
        max-height: 900px; 
    }

    .float-right {
        float: right !important;
    }
}
 
@media (min-width: 1200px){

 
}

</style>

