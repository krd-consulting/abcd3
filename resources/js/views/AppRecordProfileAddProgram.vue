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
                <slot name="title">Manage Programs</slot>
            </template>
            <template v-slot:caption>
                <p>Check available records to add them to the program or uncheck current records to remove them from the program.</p>
            </template>
            <template v-slot:current-items-title>
                Current Programs
            </template>
            <template v-slot:available-items-title>
                Available Programs
            </template>
            <template v-slot:current-item-title="{ item }">
                {{ item.name }}
            </template>
            <template v-slot:current-item-subtitle="{ item }">
                {{ item.team.name }}
            </template>
            <template v-slot:available-item-title="{ item }">
                {{ item.name }}
            </template>
            <template v-slot:available-item-subtitle="{ item }">
                {{ item.team.name }}
            </template>
            <template v-slot:empty-available-items>
                No more available programs.
            </template>
    </transfer>
</template>
<script>
    import ProgramRequest from '../api/ProgramsAvailableForRecordRequest';
    import RecordProgramsRequest from '../api/RecordProgramsRequest';

    import Transfer from '../components/AppTransfer';

    export default {
        components: {
            Transfer
        },

        props: {
            active: Boolean,
            assignedPrograms: Array
        },

        data() {
            return {
                programs: [],
                programsRequest: new ProgramRequest({}),
                recordProgramsRequest: new RecordProgramsRequest({}),
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
                this.recordProgramsRequest.setFields({
                    params: this.selectedParams
                });

                this.recordProgramsRequest.retrieve(this.$route.params.recordType, this.$route.params.record).then(response => {
                    this.selected = response.data;
                    this.selectedParams.total = response.meta.total;
                    this.fields = response.fields;
                });
            },

            loadNotSelected() {
                this.programsRequest.setFields({
                    params: this.notSelectedParams
                });

                this.programsRequest.retrieve(this.$route.params.recordType, this.$route.params.record).then(response => {
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
                this.recordProgramsRequest.store(
                    this.$route.params.recordType,
                    this.$route.params.record,
                    id
                ).then((response) => {
                    this.selected.push(_.find(this.programs, {id}));
                }).catch((error) => {
                    this.$message({
                        type: 'error',
                        message: error.message
                    });
                });
            },

            remove(id) {
                this.recordProgramsRequest.destroy(
                    this.$route.params.recordType,
                    this.$route.params.record,
                    id
                ).then((response) => {
                    this.selected = _.reject(this.selected, { id });
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
