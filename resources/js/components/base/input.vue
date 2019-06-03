<template>
    <el-input v-bind="$attrs" v-on="$listeners">
        <slot slot="prefix" name="prefix"></slot>
    </el-input>
</template>
<script>
    export default {
        inheritAttrs: false,
    }
</script>
