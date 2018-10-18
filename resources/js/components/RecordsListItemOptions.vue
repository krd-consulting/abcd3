<template>
    <button v-if="options" v-show="showOptions">
        <base-icon>add_circle_outline</base-icon>
    </button>
</template>
<script>
    export default {
        props: {
            options: Boolean,
            showOptions: Boolean
        }
    }
</script>
<style scoped>
    i {
        @apply tw-text-blue;
    }

    .is-active i {
        @apply tw-text-grey-darkest;
    }
</style>
