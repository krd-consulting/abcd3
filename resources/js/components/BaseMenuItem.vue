<template>
    <el-menu-item v-bind="$attrs" :route="route">
        <slot></slot>
    </el-menu-item>
</template>
<script>
    export default {
        inheritAttrs: false,
        props: {
            route: Object
        }
    }
</script>
