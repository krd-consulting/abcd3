<template>
    <div class="tw-flex tw-items-center tw-bg-white tw-border-b">
        <router-link tag="div" class="tw-flex tw-w-1/3 tw-items-top tw-cursor-pointer" :to="to">
            <div>
                <slot name="image">
                </slot>
            </div>
            <div>
                <slot name="primary-data" :item="item">
                    <span class="tw-block">
                        <slot>{{ primaryData }}</slot>
                    </span>
                </slot>
                <slot name="secondary-data" :item="item">
                    <span class="tw-text-sm">
                        <slot name="secondary-data-text">{{ secondaryData }}</slot>
                    </span>
                </slot>
            </div>
        </router-link tag="div">
        <div class="tw-flex tw-flex-grow tw-justify-between">
            <slot name="tertiary-data" :item="item">
            </slot>
            <slot name="options-container" :item="item">
                <div class="tw-text-right">
                    <slot name="options">
                    </slot>
                </div>
            </slot>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            to: {
                type: String | Object,
                default: ''
            },
            primaryData: String,
            secondaryData: String,
            item: Array | Object
        }
    }
</script>
