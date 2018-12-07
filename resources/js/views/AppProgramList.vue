<template>
    <div class="tw-shadow tw-rounded tw-bg-white">
        <div class="tw-flex tw-items-center tw-justify-between tw-p-4 tw-border-b-2">
            <h2 class="tw-font-bold tw-text-xl">{{ program.name }}</h2>
            <div class="tw-flex-no-wrap">
            </div>
        </div>
    </div>
</template>
<script>
    import ProgramRequest from '../api/ProgramRequest';

    export default {

        data() {
            return {
                program: [],
                request: new ProgramRequest({}),
                params: {
                    ascending: true,
                    /*columnFilters: {
                    },*/
                    sortBy: 'field_1_value',
                    page: 1,
                    perPage: 5
                },
                total: 0,
                type: {
                    name: ''
                },
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
                this.params.page = 1;
                this.params.perPage = 5;
                this.retrieve();
            }
        },

        methods: {
            retrieve() {
                this.request.setFields({
                    params: {...this.params}
                });

                this.request.retrieve(this.$route.params.id).then((response) => {
                    this.program = response;

                    console.log(this.program);
                });
            },
        },

        created() {
            this.retrieve();
        }

    }
</script>
