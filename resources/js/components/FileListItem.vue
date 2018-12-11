<template>
    <div class="tw-flex tw-items-center tw-bg-white hover:tw-text-blue">
        <router-link tag="div" class="tw-w-5/6 tw-py-4 tw-pl-4 tw-cursor-pointer" :to="`/files/${fileType}/${file.id}`">
            <span class="tw-mb-2 tw-block tw-font-bold">
                {{ primaryData }}
            </span>
            <secondary-data class="tw-text-sm" v-for="(data, index) in secondaryData" :key="index" :data="data">
                {{ file[data] }}
            </secondary-data>
        </router-link tag="div">
        <div class="tw-w-1/6 tw-py-4 tw-pr-4 tw-text-right">
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
            fileType: String,
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
