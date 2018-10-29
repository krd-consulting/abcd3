<template>
    <base-menu-item
        v-bind="$attrs"
        :index="index"
        :route="route"
    >
        <slot></slot>
    </base-menu-item>
</template>
<script>
    export default {
        inheritAttrs: false,
        props: {
            index: String,
            title: String,
            options: Boolean,
            route: Object
        },

        methods: {

        }
    }
</script>
