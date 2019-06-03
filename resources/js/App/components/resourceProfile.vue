<template>
    <div>
        <div class="tw-shadow tw-rounded tw-bg-white">
            <div class="tw-flex tw-items-start tw-justify-between tw-p-4 tw-border-b-2">
                <div>
                    <slot name="main-information-container">
                        <h2>
                            <slot name="header"></slot>
                        </h2>
                        <p class="tw-text-grey">
                            <slot name="subheader"></slot>
                        </p>
                    </slot>
                </div>
                <div class="tw-text-right">
                    <slot name="extras">
                        <slot name="extra-information-container">
                            <router-link router-link tag="a" :to="extraInformationPath">
                                <base-icon class="tw-text-grey tw-text-xs tw-text-align-middle">
                                    <slot name="extra-information-icon"></slot>
                                </base-icon>
                                <span class="tw-uppercase tw-text-grey tw-text-xs tw-font-semibold">   
                                    <slot name="extra-information"></slot>
                                </span>
                            </router-link>
                        </slot>
                        <div>
                            <base-button @click="$emit('edit')" class="tw-py-2 tw-px-0 tw-mr-4 tw-text-grey hover:tw-text-grey-darkest hover:tw-bg-transparent tw-border-none">
                                <base-icon class="tw-text-xs tw-mr-1 tw-align-top">edit</base-icon>
                                <span class="tw-text-xs tw-align-middle">Edit</span>
                            </base-button>
                            <base-button @click="$emit('delete')" class="tw-py-2 tw-px-0 tw-text-grey hover:tw-text-red hover:tw-bg-transparent tw-border-none">
                                <base-icon class="tw-text-xs tw-mr-1 tw-align-top">delete</base-icon>
                                <span class="tw-text-xs tw-align-middle">Delete</span>
                            </base-button>
                        </div>
                    </slot>
                </div>
            </div>
            <div class="tw-bg-grey-lightest">
                <slot name="tabs">
                    <resource-profile-tabs :record-types="recordTypes"/>
                </slot>
            </div>
            <div>
                <router-view :record="record" :fields="fields"/>
            </div>
        </div>
    </div>
</template>
<script>
    import ResourceProfileTabs from './resourceProfileTabs';

    export default {
        props: {
            extraInformationPath: {
                type: String,
                default: ''
            },
            record: {
                type: Object,
                default: () => { return {} }
            },
            fields: {
                type: Array | Object,
                default: () => { return [] }
            },
            recordTypes: Array | Object
        },

        components: {
            ResourceProfileTabs
        }
    }
</script>