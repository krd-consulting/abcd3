<template>
    <base-dialog :visible="active" @close="close" @open="open">
        <div slot="title">
            <slot name="title">
                Transfer Items
            </slot>
        </div>
        <div class="tw-mb-4">
            <slot name="caption">
                <p>Click on current/available items to add/remove them.</p>
            </slot>
        </div>
        <div class="tw-flex tw-text-gray-800">
            <div class="tw-flex-1 tw-pr-2">
                <div class="tw-border tw-border-blue-lighter tw-rounded tw-overflow-y-hidden">
                    <div>
                      <slot name="current-items-options">
                          <base-input
                              v-model="selectedParams.search"
                              class="transfer-search"
                              @input="searchSelected(selectedParams.search)"
                              placeholder="Search">
                              <i slot="prefix" class="el-input__icon el-icon-search"></i>
                          </base-input>
                      </slot>
                    </div>
                    <div class="tw-flex tw-justify-between tw-items-center tw-px-2 tw-rounded-t">
                        <slot name="current-items-title">
                            <span>Your List ({{ selectedParams.total }})</span>
                        </slot>
                    </div>
                    <div class="tw-h-64 tw-overflow-y-auto">
                        <div v-if="selected.length == 0" class="tw-py-24 tw-text-center">
                            <span>Nothing here, yet.</span>
                        </div>
                        <div v-for="item in selected" class="tw-py-2 tw-px-2 tw-border-b tw-border-blue-lighter">
                            <label class="tw-flex">
                                <div class="tw-flex-1 tw-pl-2">
                                    <div>
                                        <span class="tw-text-base">
                                            <slot name="current-item-title" :item="item"></slot>
                                        </span>
                                    </div>
                                    <div>
                                        <span class="tw-text-xs tw-text-gray">
                                            <slot name="current-item-subtitle" :item="item"></slot>
                                        </span>
                                    </div>
                                </div>
                                <div class="tw-flex-initial">
                                    <base-checkbox :value="true" @change="remove(item.id)"/>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <div>
                    <base-pagination
                        :current-page.sync="selectedParams.page"
                        @current-change="handleSelectedPageChange"
                        layout="prev, slot, next"
                        :page-size="selectedParams.perPage"
                        :total="selectedParams.total">
                        <template v-slot:pagination-info="slotProps">
                            <span class="tw-text-gray-600">{{ slotProps.paginationInfo }}</span>
                        </template>
                    </base-pagination>
                </div>
            </div>
            <div class="tw-flex-1 tw-pl-2">
                <div class="tw-rounded tw-border tw-overflow-y-hidden" style="max-height: 300px;">
                    <div>
                      <slot name="available-items-options">
                          <base-input
                              v-model="notSelectedParams.search"
                              @input="searchNotSelected(notSelectedParams.search)"
                              class="transfer-search"
                              placeholder="Search">
                              <i slot="prefix" class="el-input__icon el-icon-search"></i>
                          </base-input>
                      </slot>
                    </div>
                    <div class="tw-flex tw-justify-between tw-items-center tw-py-2 tw-px-2 tw-rounded-t">
                        <slot name="available-items-title">
                            <span>Available Options ({{ notSelectedParams.total }})</span>
                        </slot>
                    </div>
                    <div class="tw-h-64 tw-overflow-y-auto">
                        <div v-if="notSelected.length == 0" class="tw-py-24 tw-text-center">
                            <slot name="empty-available-items">
                                <span>There are no more available items.</span>
                            </slot>
                        </div>
                        <div v-for="item in notSelected" class="tw-py-2 tw-px-2 tw-border-b">
                            <label class="tw-flex">
                                <div class="tw-flex-1 tw-pl-2">
                                    <div>
                                        <span class="tw-text-base">
                                            <slot name="available-item-title" :item="item"></slot>
                                        </span>
                                    </div>
                                    <div>
                                        <span class="tw-text-xs tw-text-gray">
                                            <slot name="available-item-subtitle" :item="item"></slot>
                                        </span>
                                    </div>
                                </div>
                                <div class="tw-flex-initial">
                                    <base-checkbox :value="false" @change="add(item.id)"/>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="tw-flex tw-flex-items-center tw-justify-between">
                    <slot name="available-items-footer-options"></slot>
                    <base-pagination
                        :current-page.sync="notSelectedParams.page"
                        @current-change="handleNotSelectedPageChange"
                        layout="prev, slot, next"
                        :page-size="notSelectedParams.perPage"
                        :total="notSelectedParams.total">
                        <template v-slot:pagination-info="slotProps">
                            <span class="tw-text-gray-600">{{ slotProps.paginationInfo }}</span>
                        </template>
                    </base-pagination>
                </div>
            </div>
        </div>
        <div slot="footer" class="tw-border-t tw-px-4 tw-py-4 tw-bg-gray-100 tw-rounded-b">
            <slot name="footer">
                <base-button class="tw-py-2 tw-pl-4 tw-pr-4 tw-bg-blue-500 tw-text-white tw-font-bold tw-border-none" @click="close">
                    <span class="tw-text-xs tw-align-middle">OK</span>
                </base-button>
            </slot>
        </div>
    </base-dialog>
</template>
<script>
    export default {
        props: {
            active: Boolean,
            notSelected: Array,
            selected: Array,
            selectedParams: Array|Object,
            notSelectedParams: Array|Object,
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
            },

            handleSelectedPageChange(page) {
                this.$emit('selected-page-change', page);
            },

            handleNotSelectedPageChange(page) {
                this.$emit('not-selected-page-change', page);
            },

            searchSelected(search) {
                this.handleSelectedPageChange(1);
                this.$emit('search-selected', search);
            },

            searchNotSelected(search) {
                this.handleNotSelectedPageChange(1);
                this.$emit('search-not-selected', search);
            }
        }
    }
</script>
<!-- Not really working: -->
<style scoped>
    .el-dialog__header,
    .el-message-box__header {
      @apply tw-bg-indigo-darker tw-text-white tw-text-lg tw-py-5 tw-text-left;
    }

    .el-switch.is-checked .el-switch__core {
        @apply tw-bg-indigo-base tw-border-indigo-base;
    }

    .transfer-search .el-input__inner {
      @apply tw-border-transparent;
    }
</style>
