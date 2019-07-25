<template>
    <div id="formCreator">
        <el-container>
            <el-card id="menu-container"> 
                <form-menu id="menu"/>
            </el-card>

            <el-card id="canvas-container">
                <el-header>
                    <nav-bar/>
                </el-header>   

                <form-canvas :fields="fields" id="canvas"/>
            
            </el-card>
            
        </el-container>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import FormCanvas from '@/FormBuilder/components/canvas/index.vue'
    import FormMenu from '@/FormBuilder/components/menu/index.vue'
    import MenuPanel from '@/FormBuilder/components/menu/mobileMenu.vue'
    import NavBar from '@/FormBuilder/components/navbar.vue'

    export default {
        name: 'Form',
        data: () => {
            return {
                activeIndex: '1',
                fields: [],
            }
        },

        components: {
            FormCanvas,
            FormMenu,
            draggable,
            MenuPanel,
            NavBar
        },
        /* test method used when examining responsive behavior */
        // computed: {
        //     screenWidth: {
        //         get() { return window.innerWidth },
        //         set(screenWidth) {
        //             this.screenWidth = window.innerWidth
        //         }
        //     } 
        // },
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

/* Tablet/Reduced Screen View */
@media (min-width: 500px){

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

/* Desktop View */
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
        min-width: 300px;
        max-width: 450px;
        max-height: 900px; 
    }
    .float-right {
        float: right !important;
    }
}

</style>

