<template>
    <base-menu-item
        v-bind="$attrs"
        :index="index"
        :class="{ active }"
        :route="route"
    >
        <slot :class="{ active }"></slot>
    </base-menu-item>
</template>
<script>
    export default {
        inheritAttrs: false,
        props: {
            active: Boolean,
            index: String,
            title: String,
            options: Boolean,
            route: Object
        },

        methods: {

        }
    }
</script>
