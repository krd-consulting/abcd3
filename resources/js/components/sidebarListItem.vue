<template>
    <base-menu-item
        v-bind="$attrs"
        :index="index"
    >
        <slot></slot>
        <slot name="title"></slot>
    </base-menu-item>
</template>
<script>
    export default {
        inheritAttrs: false,
        props: {
            index: String,
            title: String,
            options: Boolean,
        },

        methods: {

        }
    }
</script>
