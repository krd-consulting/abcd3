<template>
    <div v-if="total == 0" class="tw-shadow tw-rounded tw-bg-white tw-pb-1">
        <slot name="empty-placeholder"></slot>
    </div>
    <div v-else class="tw-shadow tw-rounded tw-bg-white">
        <div v-if="hasHeader" class="tw-flex tw-items-center tw-justify-between tw-p-4 tw-border-b">
            <h2 class="tw-font-bold tw-text-xl tw-w-1/2">
                <slot name="header-text"></slot>
            </h2>
            <div class="tw-flex-no-wrap tw-w-1/2">
                <slot name="options">
                </slot>
            </div>
        </div>
        <slot name="list">
            <div>
                <slot></slot>
            </div>
        </slot>
        <div class="tw-py-2 tw-flex tw-justify-between">
            <slot name="pagination">
                <base-pagination
                    v-show="showPagination"
                    :current-page="page"
                    @current-change="handlePageChange"
                    layout="prev, slot, next"
                    :page-size="perPage"
                    :total="total">
                    <template v-slot:pagination-info="slotProps">
                        <span class="tw-text-grey-dark">{{ slotProps.paginationInfo }}</span>
                    </template>
                </base-pagination>
            </slot>
            <slot name="footer-options">

            </slot>
        </div>
    </div>
</template>
<script>
    export default {

        props: {
            items: Array,
            page: Number,
            perPage: Number,
            total: Number,
            hasHeader: {
                type: Boolean,
                default: false
            },
            showPagination: {
                type: Boolean,
                default: true
            }
        },

        methods: {
            handlePageChange(page) {
                this.$emit('update:page', page);
                this.$emit('page-change', page);
            }
        }

    }
</script>
