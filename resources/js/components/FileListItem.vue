<template>
    <div class="tw-flex tw-items-center tw-p-4 tw-bg-white hover:tw-bg-blue-lightest hover:tw-text-blue">
        <div class="tw-w-5/6">
            <span class="tw-mb-2 tw-block tw-font-bold tw-text-lg">
                {{ primaryData }}
            </span>
            <secondary-data v-for="(data, index) in secondaryData" :key="index" :data="data">
                {{ file[data] }}
            </secondary-data>
        </div>
        <div class="tw-w-1/6 tw-text-right">
            <base-icon class="tw-text-base">edit</base-icon>
            <base-icon class="tw-text-base">delete</base-icon>
        </div>
    </div>
</template>
<script>
    import moment from 'moment';
    import SecondaryData from './FileListItemSecondaryData';

    export default {
        props: {
            file: Object,
            primaryFields: Array,
            secondaryFields: Array
        },

        components: {
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
