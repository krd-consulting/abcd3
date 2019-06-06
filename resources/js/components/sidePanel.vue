<!-- 
    This is a Global Component
-->
<template>
    <div id="menu">
        
        
        <slot name="button">
            <el-button type="text" @click="toggle"><slot name="button-text">&#9776; options</slot></el-button>
        </slot>
        

        <transition name="toggle">
            <div v-click-outside="hide" v-show="opened" class="panel lg:w-1/4 w-full">
                <a href="javascript:void(0)" class="close" @click="hide">&times;</a>
                <slot></slot>
            </div>
        </transition>
    </div>
</template>

<script>
import ClickOutside from 'vue-click-outside'

export default {
    name: 'menu',
    data() {
        return {
            opened: false,
            divWidth: 0
        }
    },
    methods: {
        toggle() {
            this.opened = true;
            this.divWidth = 350;
            //document.getElementById("panel-menu").style.width = "350px";
        },
        hide() {
            this.opened = false
            //document.getElementById("panel-menu").style.width = "0";
        }
    },
    mounted() {
        // prevents clicking outside event with open sidepanel
        this.popupItem = this.$el
    },
    directives: {
        ClickOutside
    }
}
</script>

<style>
    .toggle-enter-active {
        transition: 1s ease;
    }
    .toggle-leave-active {
        transition: 1s ease;
        /* cubic-bezier(1.0, 0.5, 0.8, 1.0); */
    }

    .toggle-enter, .toggle-leave-to {
        transform: translateX(100%);
        /* opacity: 0; */
    }

    .panel {
        height: 100%;
        position: fixed;
        z-index: 1;
        top: 0;
        right: 0;
        background-color: #ffffff;
        overflow-x: hidden;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        text-align: left;
        padding-left: 20px;
    }

    .panel a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
        transition: 0.2s;
        text-align: right;
    }

    .sidenav a:hover {
        color: #f1f1f1;
    }

    .sidenav .close {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }

/* Handle differently on smaller screen size */
    @media screen and (max-height: 450px) {
        .sidenav {padding-top: 15px;}
        .sidenav a {font-size: 18px;}
    }
</style>