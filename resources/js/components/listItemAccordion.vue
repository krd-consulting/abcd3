<template>
    <div class="tw-bg-white tw-border-b" @click="open = !open">
        <div class="tw-flex tw-items-center tw-p-4 hover:tw-bg-gray-100">
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
                <div class="tw-flex-grow"></div>
                <slot name="options-container" :item="item">
                    <div class="tw-text-right">
                        <div class="tw-flex tw-flex-grow"></div>
                        <slot name="options">
                            <button
                                class="tw-py-2 tw-px-4 tw-text-gray-600 hover:tw-text-blue-500 tw-bg-transparent tw-border-none">
                                <base-icon class="tw-text-xs tw-align-middle">
                                    <slot name="options-delete-icon">expand_more</slot>
                                </base-icon>
                            </button>
                        </slot>
                    </div>
                </slot>
            </div>
        </div>
        <div v-if="open" class="tw-border-t">
            <slot name="bellows"></slot>
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
            item: Array | Object,
        },

        data() {
            return {
                open: false
            }
        }
    }
</script>
