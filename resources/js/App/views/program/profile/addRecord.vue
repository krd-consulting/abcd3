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
                <slot name="title">Manage Records</slot>
            </template>
            <template v-slot:caption>
                <p>Check available records to add them to the program or uncheck current records to remove them from the program.</p>
            </template>
            <template v-slot:current-item-title="{ item }">
                <primary-data :record="item" :fields="fields"/>
            </template>
            <template v-slot:current-item-subtitle="{ item }">
                <secondary-data class="tw-text-xs" :record="item" :fields="fields"/>
            </template>
            <template v-slot:available-item-title="{ item }">
                <primary-data :record="item" :fields="fields"/>
            </template>
            <template v-slot:available-item-subtitle="{ item }">
                <secondary-data class="tw-text-xs" :record="item" :fields="fields"/>
            </template>
            <template v-slot:empty-available-items>
                No more available records.
            </template>
            <template v-slot:available-items-footer-options>
                <base-input
                    v-model="enrolledAt"
                    name="enrolled_at"
                    type="date"
                    @keydown.native="request.errors.clear($event.target.name)"/>
            </template>
    </transfer>
</template>
<script>
    import RecordRequest from '@/api/RecordsAvailableForProgramRequest';
    import ProgramRecordsRequest from '@/api/ProgramRecordsRequest';

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
            programId: String|Number,
            recordType: String
        },

        data() {
            return {
                records: [],
                fields: [],
                recordsRequest: new RecordRequest({}),
                programRecordsRequest: new ProgramRecordsRequest({}),
                selected: [],
                notSelected: [],
                selectedParams: {
                    ascending: true,
                    sortBy: 'field_1_value',
                    page: 1,
                    perPage: 10,
                    total: 0
                },
                notSelectedParams: {
                    ascending: true,
                    sortBy: 'field_1_value',
                    page: 1,
                    perPage: 10,
                    total: 0
                },
                enrolledAt: ''
            }
        },

        methods: {
            close() {
                this.$emit('update:active', false);
                this.$emit('close');
            },

            loadSelected() {
                this.programRecordsRequest.setFields({
                    params: this.selectedParams
                });

                this.programRecordsRequest.retrieve(this.programId, this.recordType).then(response => {
                    this.selected = response.data;
                    this.selectedParams.total = response.meta.total;
                    this.selected.total = this.selectedParams.total;
                    this.fields = response.fields;
                });
            },

            loadNotSelected() {
                this.recordsRequest.setFields({
                    params: this.notSelectedParams
                });

                this.recordsRequest.retrieve(this.programId, this.recordType).then(response => {
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
                const request = new ProgramRecordsRequest({
                    enrolled_at: this.enrolledAt
                });

                request.store(
                    this.programId,
                    this.recordType,
                    id
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
                this.programRecordsRequest.destroy(
                    this.programId,
                    this.recordType,
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
