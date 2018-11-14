<template>
    <el-pagination
        background
        v-bind="$attrs"
        @current-change="handleCurrentChange">
        <slot></slot>
    </el-pagination>
</template>
<script>
    export default {
        inheritAttrs: false,
        methods: {
            handleCurrentChange(page) {
                this.$emit('update:currentPage', page);
                this.$emit('current-change', page);
            }
        }
    }
</script>
