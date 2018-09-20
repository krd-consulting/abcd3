<template>
    <button v-if="options" v-show="showOptions">
        <base-icon class="tw-text-blue">add_circle_outline</base-icon>
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
