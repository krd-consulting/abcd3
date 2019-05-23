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
                <slot name="title">Manage Teams</slot>
            </template>
            <template v-slot:caption>
                <p>Check available records to add them to the team or uncheck current records to remove them from the team.</p>
            </template>
            <template v-slot:current-items-title>
                Current Teams
            </template>
            <template v-slot:available-items-title>
                Available Teams
            </template>
            <template v-slot:current-item-title="{ item }">
                {{ item.name }}
            </template>
            <template v-slot:available-item-title="{ item }">
                {{ item.name }}
            </template>
            <template v-slot:empty-available-items>
                No more available teams.
            </template>
    </transfer>
</template>
<script>
    import TeamRequest from '../api/TeamsAvailableForRecordRequest';
    import RecordTeamsRequest from '../api/RecordTeamsRequest';

    import Transfer from '../components/AppTransfer';

    export default {
        components: {
            Transfer
        },

        props: {
            active: Boolean,
        },

        data() {
            return {
                teamsRequest: new TeamRequest({}),
                recordTeamsRequest: new RecordTeamsRequest({}),
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
                this.recordTeamsRequest.setFields({
                    params: this.selectedParams
                });

                this.recordTeamsRequest.retrieve(this.$route.params.recordType, this.$route.params.record).then(response => {
                    this.selected = response.data;
                    this.selectedParams.total = response.meta.total;
                    this.fields = response.fields;
                });
            },

            loadNotSelected() {
                this.teamsRequest.setFields({
                    params: this.notSelectedParams
                });

                this.teamsRequest.retrieve(this.$route.params.recordType, this.$route.params.record).then(response => {
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
                this.recordTeamsRequest.store(
                    this.$route.params.recordType,
                    this.$route.params.record,
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
                this.recordTeamsRequest.destroy(
                    this.$route.params.recordType,
                    this.$route.params.record,
                    id
                ).then((response) => {
                    this.open()
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
