<template>
    <base-menu :router="true" v-bind="$attrs">
        <slot></slot>
    </base-menu>
</template>
<script>
    export default {
        inheritAttrs: false
    }
</script>
