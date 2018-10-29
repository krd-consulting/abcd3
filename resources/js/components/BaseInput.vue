<template>
    <el-input v-bind="$attrs">
        <slot slot="prefix" name="prefix">sadad</slot>
    </el-input>
</template>
<script>
    export default {
        inheritAttrs: false
    }
</script>
