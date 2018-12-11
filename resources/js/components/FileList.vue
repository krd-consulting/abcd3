<template>
    <div>
        <file-list-item
            v-for="(file, index) in files"
            :key="index"
            index="index"
            :file="file"
            :file-type="fileType"
            :primary-fields="primaryFields"
            :secondary-fields="secondaryFields"
            class="file-list-item"></file-list-item>
    </div>
</template>
<script>
    import FileListItem from './FileListItem';

    export default {
        props: {
            files: Array,
            fileType: String,
            fields: Object|Array
        },

        components: {
            FileListItem
        },

        computed: {
            primaryFields() {
                let fields = [];

                if('first_name' in this.fields)
                    fields.push('first_name');

                if('last_name' in this.fields)
                    fields.push('last_name');

                if('business_name' in this.fields)
                    fields.push('business_name');

                return fields;
            },

            secondaryFields() {
                let fields = [];

                if('contact_number' in this.fields)
                    fields.push('contact_number');

                if('email_address' in this.fields)
                    fields.push('email_address');

                if('birth_date' in this.fields)
                    fields.push('birth_date');

                return fields;
            }
        }
    }
</script>
<style scoped>
    .file-list-item {
        @apply tw-border-b;
    }
</style>
