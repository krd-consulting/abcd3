<template>
    <list-item :to="`/records/${recordType}/${record.id}`">
        <primary-data :record="record" :fields="fields"/>
        <template slot="secondary-data">
            <secondary-data class="tw-text-sm" :record="record" :fields="fields"/>
        </template>
    </list-item>
</template>
<script>
    import moment from 'moment';
    import ListItem from './AppListItem';
    import PrimaryData from './RecordPrimaryData';
    import SecondaryData from './RecordSecondaryData';

    export default {
        props: {
            record: Object,
            recordType: String,
            fields: Object|Array
        },

        components: {
            PrimaryData,
            ListItem,
            SecondaryData
        },
    }
</script>
