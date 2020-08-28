<template>
    <el-link v-bind="$attrs" v-on="$listeners"><slot></slot></el-link>
</template>
<script>
    export default {
        inheritAttrs: false
    }
</script>
