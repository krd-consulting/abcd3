<template>
    <el-dialog v-bind="$attrs" @close="close">
        <slot name="title" slot="title"></slot>
        <slot></slot>
        <slot name="footer" slot="footer"></slot>
    </el-dialog>
</template>
<script>
    export default {
        inheritAttrs: false,

        methods: {
            close() {
                this.$emit('update:visible', false);
                this.$emit('close');
            }
        }
    }
</script>
