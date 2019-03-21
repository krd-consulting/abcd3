<template>
    <list-item :to="`/records/${recordType}/${record.id}`" class="tw-py-4 tw-px-4">
        <template slot="image">
            <profile-picture class="tw-mr-2 tw-w-12 tw-h-12 tw-text-base" :record="record" :fields="fields" />
        </template>
        <primary-data :record="record" :fields="fields"/>
        <template slot="secondary-data">
            <secondary-data class="tw-text-xs" :record="record" :fields="fields"/>
        </template>
        <template slot="options">
            <base-button class="tw-py-2 tw-px-2 tw-text-grey hover:tw-text-grey-darkest hover:tw-bg-transparent tw-border-none">
                <base-icon class="tw-text-xs tw-mr-1 tw-align-top">edit</base-icon>
                <span class="tw-text-xs tw-align-middle">Edit</span>
            </base-button>
            <base-button class="tw-py-2 tw-px-2 tw-text-grey hover:tw-text-red hover:tw-bg-transparent tw-border-none" @click="confirm(record)">
                <base-icon class="tw-text-xs tw-mr-1 tw-align-top">delete</base-icon>
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

    import Request from '../api/RecordRequest';

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

        methods: {
            confirm(record) {
                this.$confirm('Are you sure you want to delete this record?', 'Delete Record', {
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Wait, no!',
                    type: 'warning'
                }).then(() => {
                    this.deleteRecord(record)
                        .then(() => {
                            this.$emit('delete', record);

                            this.$message({
                                type: 'success',
                                message: 'Record was deleted.'
                            });
                        })
                        .catch(() => {
                            this.$message({
                                type: 'error',
                                message: 'Oops! Something went wrong.'
                            });
                        });
                })
            },

            deleteRecord(record) {
                let request = new Request(record);

                return request.destroy(record.id).then((response) => {
                    this.$emit('delete', record);
                });
            }
        }
    }
</script>
