<template>
    <list-item :to="`/records/${recordType}/${record.id}`" class="tw-py-4 tw-px-4">
        <template slot="image">
            <profile-picture class="tw-mr-2 tw-w-10 tw-h-10" :record="record" :fields="fields" />
        </template>
        <primary-data :record="record" :fields="fields"/>
        <template slot="secondary-data">
            <secondary-data class="tw-text-sm" :record="record" :fields="fields"/>
        </template>
        <template slot="options">
            <base-button class="tw-py-2 tw-px-4 tw-bg-green-lightest tw-text-green-dark tw-border-none">
                <base-icon class="tw-text-xs tw-align-top">edit</base-icon>
                <span class="tw-text-xs tw-align-middle">Edit</span>
            </base-button>
            <base-button class="tw-py-2 tw-px-2 tw-bg-red-lightest tw-text-red-dark tw-border-none">
                <base-icon class="tw-text-xs tw-align-top">delete</base-icon>
                <span class="tw-text-xs tw-align-middle">Delete</span>
            </base-button>
        </template>
    </list-item>
</template>
<script>
    import moment from 'moment';
    import ListItem from './AppListItem';
    import ProfilePicture from './RecordProfilePicture';
    import PrimaryData from './RecordPrimaryData';
    import SecondaryData from './RecordSecondaryData';

    export default {
        props: {
            record: Object,
            recordType: String,
            fields: Object|Array
        },

        components: {
            ProfilePicture,
            PrimaryData,
            ListItem,
            SecondaryData
        },
    }
</script>
