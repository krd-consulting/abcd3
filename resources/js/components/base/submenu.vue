<template>
    <el-submenu v-bind="$attrs">
        <template slot="title">
            <slot name="title"></slot>
        </template>
        <slot></slot>
    </el-submenu>
</template>
<script>
    export default {
        inheritAttrs: false
    }
</script>
