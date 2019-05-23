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
                <p>Check available records to add them to the team or uncheck current records to remove them from the team.</p>
            </template>
            <template v-slot:current-items-title>
                Current Records
            </template>
            <template v-slot:available-items-title>
                Available Records
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
    </transfer>
</template>
<script>
    import RecordRequest from '../api/RecordsAvailableForTeamRequest';
    import TeamRecordsRequest from '../api/TeamRecordsRequest';

    import Transfer from '../components/AppTransfer';

    import PrimaryData from '../components/RecordPrimaryData';
    import SecondaryData from '../components/RecordSecondaryData';

    export default {
        components: {
            Transfer,
            PrimaryData,
            SecondaryData
        },

        props: {
            active: Boolean,
            teamId: String|Number,
            recordType: String
        },

        data() {
            return {
                records: [],
                fields: [],
                recordsRequest: new RecordRequest({}),
                teamRecordsRequest: new TeamRecordsRequest({}),
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
                this.teamRecordsRequest.setFields({
                    params: this.selectedParams
                });

                this.teamRecordsRequest.retrieve(this.teamId, this.recordType).then(response => {
                    this.selected = response.data;
                    this.selectedParams.total = response.meta.total;
                    this.fields = response.fields;
                });
            },

            loadNotSelected() {
                this.recordsRequest.setFields({
                    params: this.notSelectedParams
                });

                this.recordsRequest.retrieve(this.teamId, this.recordType).then(response => {
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
                const request = new TeamRecordsRequest({
                    enrolled_at: this.enrolledAt
                });

                request.store(
                    this.$route.params.team,
                    this.$route.params.recordType,
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
                this.teamRecordsRequest.destroy(
                    this.$route.params.team,
                    this.$route.params.recordType,
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
