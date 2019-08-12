<template>
    <div id="preview" class="preview_top">
        <el-container>

            <el-card id="preview-form" class="sm:tw-w-11/12 tw-w-5/6 xl:tw-w-5/12" shadow="always">
                <nav-bar/>

                <form-template/> 

            </el-card>

            <transition name="fade">
                <el-button 
                    @click="backToTop" 
                    v-if="isVisible"
                    type="primary"
                    transition="toTop"
                    icon="el-icon-caret-top" 
                    class="backToTop"
                    round>
                        Top
                </el-button>
            </transition>
            
        </el-container>
    </div>
</template>

<script>
import FormTemplate from '@/FormBuilder/components/preview/index.vue'

import NavBar from '@/FormBuilder/components/navbar.vue'

export default {
    data: () => {
        return {
            isVisible: false,
        }
    },
    created() {
        window.addEventListener('scroll', this.watchScroll);
    },
    components: {
        NavBar,
        FormTemplate
    },
    methods: {
        watchScroll(event) {
            if(window.scrollY > 10) {
                return this.isVisible = true;
            } else {
                return this.isVisible = false;
            }
        },
        backToTop() {
            window.scrollTo({
                top: 0, 
                behavior: 'smooth'
            });
            
        },
    }
}
</script>

<style scoped>
#preview {
        display: flex;
        position: absolute;
        top: 50;
        left: 0;
        min-height: 85%;
        width: 100%;
}
#preview-form {
    margin: 0 auto;
    width: 1000px;
}
.float-right {
    float: right !important;
}
.backToTop {
    position: fixed;
    bottom: 20px;
    right: 20px;
    
    height: 50px;
}
.fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}

@media (min-width: 768px){
    
}
 
@media (min-width: 1024px){

    
}
 
@media (min-width: 1200px){

 
}
</style>
