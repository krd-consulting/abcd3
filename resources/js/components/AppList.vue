<template>
    <div class="tw-shadow tw-rounded tw-bg-white">
        <div class="tw-flex tw-items-center tw-justify-between tw-p-4 tw-border-b-2">
            <h2 class="tw-font-bold tw-text-xl">
                <slot name="header-text"></slot>
            </h2>
            <div class="tw-flex-no-wrap">
                <slot name="options">
                </slot>
            </div>
        </div>
        <slot name="list">
            <div>
                <slot name="list-items"></slot>
            </div>
        </slot>
        <div class="tw-py-2">
            <base-pagination
                :current-page.sync="page"
                @current-change="handlePageChange"
                layout="prev, slot, next"
                :pager-count="5"
                :page-size="perPage"
                :total="total">
                <span class="tw-text-grey-dark">{{ paginationInfo }}</span>
            </base-pagination>
        </div>
    </div>
</template>
<script>
    export default {

        props: {
            page: Number,
            perPage: Number,
            total: Number
        }

        computed: {
            firstItemNo() {
                return (this.params.perPage*(this.params.page-1)) + 1 ;
            },

            lastItemNo() {
                const itemNo = this.params.page*this.params.perPage;

                if(itemNo > this.total)
                    return this.total;

                return itemNo;
            },

            paginationInfo() {
                return `Showing ${ this.firstItemNo }-${ this.lastItemNo } of ${ this.total }`;
            }
        },

    }
</script>
