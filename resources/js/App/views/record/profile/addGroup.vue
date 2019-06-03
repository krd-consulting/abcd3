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
                <slot name="title">Manage Groups</slot>
            </template>
            <template v-slot:caption>
                <p>Check available records to add them to the group or uncheck current records to remove them from the group.</p>
            </template>
            <template v-slot:current-items-title>
                Current Groups
            </template>
            <template v-slot:available-items-title>
                Available Groups
            </template>
            <template v-slot:current-item-title="{ item }">
                {{ item.name }}
            </template>
            <template v-slot:current-item-subtitle="{ item }">
                
            </template>
            <template v-slot:available-item-title="{ item }">
                {{ item.name }}
            </template>
            <template v-slot:available-item-subtitle="{ item }">
                
            </template>
            <template v-slot:empty-available-items>
                No more available groups.
            </template>
    </transfer>
</template>
<script>
    import GroupRequest from '@/api/GroupsAvailableForRecordRequest';
    import RecordGroupsRequest from '@/api/RecordGroupsRequest';

    import Transfer from '@/App/components/transfer';

    export default {
        components: {
            Transfer
        },

        props: {
            active: Boolean,
        },

        data() {
            return {
                groupsRequest: new GroupRequest({}),
                recordGroupsRequest: new RecordGroupsRequest({}),
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
                this.recordGroupsRequest.setFields({
                    params: this.selectedParams
                });

                this.recordGroupsRequest.retrieve(this.$route.params.recordType, this.$route.params.record).then(response => {
                    this.selected = response.data;
                    this.selectedParams.total = response.meta.total;
                });
            },

            loadNotSelected() {
                this.groupsRequest.setFields({
                    params: this.notSelectedParams
                });

                this.groupsRequest.retrieve(this.$route.params.recordType, this.$route.params.record).then(response => {
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
                this.recordGroupsRequest.store(
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
                this.recordGroupsRequest.destroy(
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
            }
        },

        created() {

        }
    }
</script>
