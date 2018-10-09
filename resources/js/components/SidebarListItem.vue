<template>
    <li
        class="tw-block tw-py-2 hover:tw-bg-blue-lightest"
        :class="{ active }"
        @mouseover="showOptions = true"
        @mouseout="showOptions = false"
    >
        <slot></slot>
        <slot name="options" :options="options" :showOptions="showOptions"></slot>
    </li>
</template>
<script>
    export default {
        props: {
            active: Boolean,
            title: String,
            options: Boolean
        },

        data() {
            return {
                showOptions: false
            }
        },

        methods: {

        }
    }
</script>
<style scoped>
    a:hover{
        text-decoration: none;
    }

    li {
        border-top-right-radius: 999px;
        border-bottom-right-radius: 999px;
    }

    li.active {
        @apply tw-bg-blue-lighter;
    }
</style>
