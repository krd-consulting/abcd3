<template>
    <div class="tw-flex tw-items-center tw-bg-white tw-border-b">
        <router-link tag="div" class="tw-flex tw-flex-1 tw-items-top tw-cursor-pointer" :to="to">
            <div>
                <slot name="image">
                </slot>
            </div>
            <div>
                <slot name="primary-data">
                    <span class="tw-mb-2 tw-block tw-font-semibold">
                        <slot>{{ primaryData }}</slot>
                    </span>
                </slot>
                <slot name="secondary-data">
                    <span class="tw-text-sm">
                        <slot name="secondary-data-text">{{ secondaryData }}</slot>
                    </span>
                </slot>
            </div>
        </router-link tag="div">
        <slot name="tertiary-data">
        </slot>
        <slot name="options-container">
            <div class="tw-w-2/5 tw-text-right">
                <slot name="options">
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
