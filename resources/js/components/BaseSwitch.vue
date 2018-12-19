<template>
    <el-switch
        v-bind="$attrs"
        :value="on"
        @change="handleChange"
    />
</template>
<script>
    export default {
        props: {
            on: Boolean,
        },

        inheritAttrs: false,

        methods: {
            handleChange(payload) {
                this.$emit('change', payload);
            }
        }
    }
</script>
