<template>
    <el-button
        v-bind="$attrs"
        :native-type="type"
        @click="click"
        class="tw-text-sm tw-rounded">
        <slot></slot>
    </el-button>
</template>
<script>
    export default {
        props: {
            type: String
        },
        inheritAttrs: false,
        methods: {
            click(payload) {
                this.$emit('click', payload);
            }
        }
    }
</script>
