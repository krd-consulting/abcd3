<template>
    <el-button v-bind="$attrs" :native-type="type" class="tw-text-sm tw-rounded">
        <slot></slot>
    </el-button>
</template>
<script>
    export default {
        props: {
            type: String
        },
        inheritAttrs: false
    }
</script>
