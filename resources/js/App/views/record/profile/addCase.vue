<template>
    <transfer
        :active="active"
        :notSelected="notSelected"
        :selected="selected"
        :selectedParams="selectedParams"
        :notSelectedParams="notSelectedParams"
        @selected-page-change="handleSelectedPageChange"
        @not-selected-page-change="handleNotSelectedPageChange"
        @search-selected="searchSelected"
        @search-not-selected="searchNotSelected"
        @add="add"
        @remove="remove"
        @open="open"
        @close="close">
            <template v-slot:title>
                <slot name="title">Manage Cases</slot>
            </template>
            <template v-slot:caption>
                <p>Check available records to add them to the caseload or uncheck current records to remove them from the caseload.</p>
            </template>
            <template v-slot:current-items-title>
                Current Caseload
            </template>
            <template v-slot:available-items-title>
                Available Records
            </template>
            <template v-slot:current-item-title="{ item }">
                <primary-data :record="item" :fields="item.fields"/>
            </template>
            <template v-slot:current-item-subtitle="{ item }">
                <secondary-data class="tw-text-xs" :record="item" :fields="item.fields"/>
            </template>
            <template v-slot:available-item-title="{ item }">
                <primary-data :record="item" :fields="item.fields"/>
            </template>
            <template v-slot:available-item-subtitle="{ item }">
                <secondary-data class="tw-text-xs" :record="item" :fields="item.fields"/>
            </template>
            <template v-slot:empty-available-items>
                No more available records.
            </template>
    </transfer>
</template>
<script>
    import AvailableCasesRequest from '@/api/RecordsAvailableForCaseloadRequest';
    import CasesRequest from '@/api/CasesRequest';

    import Transfer from '@/App/components/transfer';

    import PrimaryData from '@/App/components/record/primaryData';
    import SecondaryData from '@/App/components/record/secondaryData';

    export default {
        components: {
            Transfer,
            PrimaryData,
            SecondaryData
        },

        props: {
            active: Boolean,
            recordId: {
                type: Number | String,
                default: ''
            },
            recordType: {
                type: String,
                default: ''
            },
            programId: {
                type: Number | String,
                default: ''
            }
        },

        computed: {
            record() {
                if(this.recordId === '')
                    return this.$route.params.record;

                return this.recordId;
            },

            type() {
                if(this.recordType === '')
                    return this.$route.params.recordType;

                return this.recordType;
            },

            program() {
                if(this.programId === '')
                    return this.$route.params.program;

                return this.programId;
            }
        },

        data() {
            return {
                casesRequest: new CasesRequest({}),
                availableCasesRequest: new AvailableCasesRequest({}),
                selected: [],
                notSelected: [],
                selectedParams: {
                    ascending: true,
                    sortBy: 'id',
                    page: 1,
                    perPage: 10,
                    total: 0
                },
                notSelectedParams: {
                    ascending: true,
                    sortBy: 'id',
                    page: 1,
                    perPage: 10,
                    total: 0
                }
            }
        },

        methods: {
            close() {
                this.$emit('update:active', false);
                this.$emit('close');
            },

            loadSelected() {
                this.casesRequest.setFields({
                    params: this.selectedParams
                });

                this.casesRequest.retrieve(this.program, this.type, this.record).then(response => {
                    this.selected = response.data;
                    this.selectedParams.total = response.meta.total;
                });
            },

            loadNotSelected() {
                this.availableCasesRequest.setFields({
                    params: this.notSelectedParams
                });

                this.availableCasesRequest.retrieve(this.program, this.type, this.record).then(response => {
                    this.notSelected = response.data;
                    this.notSelectedParams.total = response.meta.total;
                });
            },

            open() {
                this.loadSelected();
                this.loadNotSelected();
            },

            handleSelectedPageChange(page) {
                this.selectedParams.page = page;

                this.loadSelected();
            },

            handleNotSelectedPageChange(page) {
                this.notSelectedParams.page = page;

                this.loadNotSelected();
            },

            searchSelected(search) {
                this.selectedParams.search = search;

                this.loadSelected();
            },

            searchNotSelected(search) {
                this.notSelectedParams.search = search;

                this.loadNotSelected();
            },

            add(id) {
                this.casesRequest.store(
                    this.program,
                    this.type,
                    this.record,
                    id,
                ).then((response) => {
                    this.open();
                }).catch((error) => {
                    this.$message({
                        type: 'error',
                        message: error.message
                    });
                });
            },

            remove(id) {
                this.casesRequest.destroy(
                    this.program,
                    this.type,
                    this.record,
                    id
                ).then((response) => {
                    this.open();
                }).catch((error) => {
                    this.$message({
                        type: 'error',
                        message: error.message
                    });
                });
            }
        },

        created() {

        }
    }
</script>
