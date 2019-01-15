<template>
    <div>
        <record-list-item
            v-for="(record, index) in records"
            :key="index"
            :index="index"
            :record="record"
            :record-type="recordType"
            :fields="fields"></record-list-item>
    </div>
</template>
<script>
    import RecordListItem from './RecordListItem';

    export default {
        props: {
            records: Array,
            recordType: String,
            fields: Object|Array
        },

        components: {
            RecordListItem
        },
    }
</script>
