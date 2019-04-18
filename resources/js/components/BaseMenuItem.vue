<template>
    <router-link tag="a" :to="route">
        <el-menu-item v-bind="$attrs">
            <slot></slot>
        </el-menu-item>
    </router-link>
</template>
<script>
    export default {
        inheritAttrs: false,
        props: {
            route: Object
        }
    }
</script>
