<template>    
    <div class="tw-shadow tw-rounded tw-bg-white">
        <div v-if="hasHeader" class="tw-flex tw-items-center tw-justify-between tw-p-4 tw-border-b">
            <slot name="header">
                <h2 class="tw-font-bold tw-text-xl tw-w-1/4">
                    <slot name="header-text"></slot>
                </h2>
                <slot name="options">
                </slot>
            </slot>
        </div>
        <div v-if="total == 0">
            <slot name="empty-placeholder"></slot>
        </div>
        <slot v-else name="list">
            <div>
                <slot></slot>
            </div>
        </slot>
        <div class="tw-flex tw-justify-between">
            <slot v-if="total > 0" name="pagination">
                <base-pagination
                    class="tw-py-2"   
                    v-show="showPagination"
                    :current-page="page"
                    @current-change="handlePageChange"
                    layout="prev, slot, next"
                    :page-size="perPage"
                    :total="total">
                    <template v-slot:pagination-info="slotProps">
                        <span class="tw-text-gray-600">{{ slotProps.paginationInfo }}</span>
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
            //items: Array,
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
