<template>
    <div class="tw-shadow tw-rounded tw-bg-white">
        <div class="tw-flex tw-items-center tw-justify-between tw-p-4 tw-border-b">
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
        <div class="tw-py-2">
            <slot name="pagination">
                <base-pagination
                    :current-page="page"
                    @current-change="handlePageChange"
                    layout="prev, slot, next"
                    :page-size="perPage"
                    :total="total">
                    <span class="tw-text-grey-dark">{{ paginationInfo }}</span>
                </base-pagination>
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
            total: Number
        },

        computed: {
            firstItemNo() {
                return (this.perPage*(this.page-1)) + 1 ;
            },

            lastItemNo() {
                const itemNo = this.page*this.perPage;

                if(itemNo > this.total)
                    return this.total;

                return itemNo;
            },

            paginationInfo() {
                if(this.total == 0)
                    return `Nothing to show`;

                return `Showing ${ this.firstItemNo }-${ this.lastItemNo } of ${ this.total }`;
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
