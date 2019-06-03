<template>
    <el-menu class="base-menu" v-bind="$attrs" :router="router">
        <slot></slot>
    </el-menu>
</template>
<script>
    export default {
        inheritAttrs: false,
        props: {
            router: Boolean
        }
    }
</script>
<style scoped>
    .base-menu {
        @apply tw-border-none;
    }
</style>
