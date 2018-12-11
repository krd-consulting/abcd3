<template>
    <div class="tw-shadow tw-rounded tw-bg-white">
        <div class="tw-flex tw-items-center tw-justify-between tw-p-4 tw-border-b-2">
            <h2 class="tw-font-bold tw-text-xl">
                {{ file.field_1_value }} {{ file.field_2_value }}
            </h2>
            <h4 class="tw-text-grey"></h4>
        </div>
    </div>
</template>
<script>
    import FileRequest from '../api/FileRequest';

    export default {

        data() {
            return {
                file: [],
                request: new FileRequest({}),
            }
        },

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

        watch: {
            '$route': function() {
                this.show();
            }
        },

        methods: {
            retrieve() {
                this.request.setFields({
                    params: {...this.params}
                });

                this.request.show(this.$route.params.fileType, this.$route.params.file).then((response) => {
                    this.file = response;
                });
            },
        },

        created() {
            this.retrieve();
        }

    }
</script>
