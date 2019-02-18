<template>
    <base-dialog title="Manage Programs" :visible="active" @close="close" @open="open">
        <div class="tw-flex tw-text-grey-darkest">
            <div class="tw-flex-1 tw-pr-2">
                <div class="tw-border tw-border-blue-lighter tw-rounded tw-overflow-y-auto" style="max-height: 300px;">
                    <div class="tw-bg-blue-lightest tw-text-blue-dark tw-py-2 tw-px-2 tw-rounded-t">
                        <slot name="current-items-title">Current Items</slot>
                    </div>
                    <div class="tw-h-64 tw-overflow-y-auto">
                        <div v-if="selected.length == 0" class="tw-py-24 tw-text-center">
                            <span>Nothing here, yet.</span>
                        </div>
                        <div v-for="item in selected" class="tw-py-2 tw-px-2 tw-border-b tw-border-blue-lighter">
                            <label class="tw-flex">
                                <div class="tw-flex-initial">
                                    <base-checkbox :value="true" @change="remove(item.id)"/>
                                </div>
                                <div class="tw-flex-1 tw-pl-2">
                                    <div>
                                        <span class="tw-text-base">
                                            <slot name="current-item-title" :item="item"></slot>
                                        </span>
                                    </div>
                                    <div>
                                        <span class="tw-text-xs tw-text-grey">
                                            <slot name="current-item-subtitle" :item="item"></slot>
                                        </span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tw-flex-1 tw-pl-2">
                <div class="tw-rounded tw-border tw-overflow-y-auto" style="max-height: 300px;">
                    <div class="tw-bg-grey-lightest tw-py-2 tw-px-2 tw-rounded-t">
                        <slot name="available-items-title">
                            Available Items
                        </slot>
                    </div>
                    <div class="tw-h-64 tw-overflow-y-auto">
                        <div v-if="notSelected.length == 0" class="tw-py-24 tw-text-center">
                            <span>There are no more available items.</span>
                        </div>
                        <div v-for="item in notSelected" class="tw-py-2 tw-px-2 tw-border-b">
                            <label class="tw-flex">
                                <div class="tw-flex-initial">
                                    <base-checkbox :value="false" @change="add(item.id)"/>
                                </div>
                                <div class="tw-flex-1 tw-pl-2">
                                    <div>
                                        <span class="tw-text-base">
                                            <slot name="available-item-title" :item="item"></slot>
                                        </span>
                                    </div>
                                    <div>
                                        <span class="tw-text-xs tw-text-grey">
                                            <slot name="available-item-subtitle" :item="item"></slot>
                                        </span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div slot="footer" class="tw-border-t tw-px-4 tw-py-4 tw-bg-grey-lightest tw-rounded-b">
            <slot name="footer">
                <base-button class="tw-py-2 tw-pl-4 tw-pr-4 tw-bg-blue tw-text-white tw-font-bold tw-border-none" @click="close">
                    <span class="tw-text-xs tw-align-middle">Good to go!</span>
                </base-button>
            </slot>
        </div>
    </base-dialog>
</template>
<script>
    export default {
        props: {
            active: Boolean,
            items: Array,
            selected: Array
        },

        computed: {
            notSelected() {
                return _.differenceBy(this.items, this.selected, 'id');
            }
        },

        methods: {
            open() {
                this.$emit('update:active', true);
                this.$emit('open');
            },

            close() {
                this.$emit('update:active', false);
                this.$emit('close');
            },

            add(id) {
                this.$emit('add', id);
            },

            remove(id) {
                this.$emit('remove', id);
            }
        }
    }
</script>
