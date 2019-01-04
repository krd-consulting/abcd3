<template>
    <list-item :to="`/files/${fileType}/${file.id}`">
        <template slot="primary-data-text">{{ primaryData }}</template>
        <template slot="secondary-data">
            <secondary-data class="tw-text-sm" v-for="(data, index) in secondaryData" :key="index" :data="data">
                {{ file[data] }}
            </secondary-data>
        </template>
    </list-item>
</template>
<script>
    import moment from 'moment';
    import ListItem from './AppListItem';
    import SecondaryData from './FileListItemSecondaryData';

    export default {
        props: {
            file: Object,
            fileType: String,
            primaryFields: Array,
            secondaryFields: Array
        },

        components: {
            ListItem,
            SecondaryData
        },

        computed: {
            primaryData() {
                return this.groupFieldData(this.primaryFields);
            },
            secondaryData() {
                return this.secondaryFields;
            }
        },

        methods: {
            formatBirthDate(date) {
                return moment(date).format('MMMM D, YYYY');
            },

            groupFieldData(fields) {
                let data = '';

                fields.forEach(field => {
                    data += this.file[field] + ' ';
                });

                return data;
            }
        }
    }
</script>
