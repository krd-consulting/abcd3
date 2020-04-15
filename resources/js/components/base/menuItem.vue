<template>
    <el-menu-item v-bind="$attrs">
        <slot></slot>
    </el-menu-item>
</template>
<script>
    export default {
        inheritAttrs: false,
    }
</script>


