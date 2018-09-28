<template>
    <li
        class="tw-block tw-py-2 tw-pl-8 hover:tw-bg-blue-lightest"
        :class="{ 'tw-bg-blue-lightest': active }"
        @mouseover="showOptions = true"
        @mouseout="showOptions = false"
    >
        <span
            class="tw-w-5/6 tw-inline-block"
        >
            <a href="#">{{ title }}</a>
        </span>
        <records-list-item-options
            :options="options"
            :showOptions="showOptions"
        ></records-list-item-options>
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
</style>
