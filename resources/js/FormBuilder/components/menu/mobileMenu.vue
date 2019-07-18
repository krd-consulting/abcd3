<!-- 
    This is a Global Component
-->
<template>
    <div id="menu">
        
        
        <!-- <slot name="button"> -->
            <el-button type="text" size="mini" @click="toggle"><slot name="button-text">Add Field</slot></el-button>
        <!-- </slot> -->
        

        <transition name="toggle">
            <div v-click-outside="hide" v-show="opened" class="panel">
                
                <el-button type="text" class="close hover:tw-text-red-600" @click="hide">Close</el-button>
                
                <br>
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
            this.divWidth = 650;
        },
        hide() {
            this.opened = false
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
    }

    .toggle-enter, .toggle-leave-to {
        transform: translateX(-100%);
    }

    .panel {
        height: screen;
        width: 350px;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #ffffff;
        overflow-x: hidden;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        text-align: left;
        padding-left: 20px;
        z-index: 99999999;
    }

    .panel a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
        transition: 0.2s;
        text-align: left;
    }

    .sidenav a:hover {
        color: #f1f1f1;
    }

    .close {
        position: absolute !important;
        padding-bottom: 50px;
        top: 0;
        right: 15px;
        font-size: 36px;
        font-weight: bold;
    }
</style>