<template>
    <div class="tw-flex tw-items-center tw-bg-white hover:tw-text-blue">
        <router-link tag="div" class="tw-w-5/6 tw-py-4 tw-pl-4 tw-cursor-pointer" :to="to">
            <slot name="primary-data">
                <span class="tw-mb-2 tw-block tw-font-bold">
                    <slot name="primary-data-text">{{ primaryData }}</slot>
                </span>
            </slot>
            <slot name="secondary-data"> {{ secondaryData }}</slot>
        </router-link tag="div">
        <slot name="options-container">
            <div class="tw-w-1/6 tw-py-4 tw-pr-4 tw-text-right">
                <slot name="options">
                    <base-icon class="tw-text-base">edit</base-icon>
                    <base-icon class="tw-text-base">delete</base-icon>
                </slot>
            </div>
        </slot>
    </div>
</template>
<script>
    export default {
        props: {
            to: String | Object,
            primaryData: String,
            secondaryData: String
        }
    }
</script>
