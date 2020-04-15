<template>
    <el-checkbox v-bind="$attrs" v-on="$listeners"><slot></slot></el-checkbox>
</template>
<script>
    export default {
        inheritAttrs: false
    }
</script>
