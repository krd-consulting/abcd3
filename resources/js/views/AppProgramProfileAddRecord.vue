<template>
    <transfer
        :active="active"
        :items="records"
        :selected="selected"
        @add="add"
        @remove="remove"
        @open="open"
        @close="close">
            <template v-slot:title>
                <slot name="title">Manage Records</slot>
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
    import RecordRequest from '../api/RecordRequest';
    import ProgramRecordsRequest from '../api/ProgramRecordsRequest';

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
            assignedRecords: Array,
            recordType: String
        },

        data() {
            return {
                records: [],
                fields: [],
                recordsRequest: new RecordRequest({}),
                programRecordsRequest: new ProgramRecordsRequest({}),
                selected: [],
            }
        },

        computed: {
            notSelected() {
                return _.differenceBy(this.records, this.selected, 'id');
            }
        },

        methods: {
            close() {
                this.$emit('update:active', false);
                this.$emit('close');
            },

            open() {
                this.selected = _.cloneDeep(this.assignedRecords);

                this.recordsRequest.retrieve(this.recordType).then(response => {
                    this.records = response.data;
                    this.fields = response.fields;
                });
            },

            add(id) {
                this.programRecordsRequest.store(
                    this.$route.params.program,
                    this.$route.params.recordType,
                    id
                ).then((response) => {
                    this.selected.push(_.find(this.records, {id}));
                }).catch((error) => {
                    this.$message({
                        type: 'error',
                        message: error.message
                    });
                });
            },

            remove(id) {
                this.programRecordsRequest.destroy(
                    this.$route.params.program,
                    this.$route.params.recordType,
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
