<template>
    <div class="tw-shadow tw-rounded tw-bg-white">
        <div class="tw-flex tw-items-center tw-justify-between tw-p-4 tw-border-b-2">
            <div>
                <primary-data class="tw-mb-2 tw-block tw-font-bold" :record="record" :fields="fields"/>
                <secondary-data class="tw-text-sm" :record="record" :fields="fields"></secondary-data>
            </div>
        </div>
    </div>
</template>
<script>
    import RecordRequest from '../api/RecordRequest';

    import PrimaryData from '../components/RecordPrimaryData';
    import SecondaryData from '../components/RecordSecondaryData';

    export default {

        components: {
            PrimaryData,
            SecondaryData
        },

        data() {
            return {
                fields: [],
                record: {},
                request: new RecordRequest({}),
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

                this.request.show(this.$route.params.recordType, this.$route.params.record).then((response) => {


                    this.record = response.data;
                    this.fields = response.data.fields;
                });
            },
        },

        created() {
            this.retrieve();
        }

    }
</script>
