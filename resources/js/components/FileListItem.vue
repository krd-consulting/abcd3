<template>
    <list-item :to="`/files/${fileType}/${file.id}`">
        <primary-data :file="file" :fields="fields"/>
        <template slot="secondary-data">
            <secondary-data class="tw-text-sm" :file="file" :fields="fields"/>
        </template>
    </list-item>
</template>
<script>
    import moment from 'moment';
    import ListItem from './AppListItem';
    import PrimaryData from './FilePrimaryData';
    import SecondaryData from './FileSecondaryData';

    export default {
        props: {
            file: Object,
            fileType: String,
            fields: Object|Array
        },

        components: {
            PrimaryData,
            ListItem,
            SecondaryData
        },
    }
</script>
