<template>
    <div class="tw-shadow tw-rounded-lg">
        <file-list-item
            v-for="(file, index) in files"
            :key="index"
            :file="file"
            :primaryFields="primaryFields"
            :secondaryFields="secondaryFields"
            class="file-list-item"></file-list-item>
    </div>
</template>
<script>
    import FileListItem from './FileListItem';

    export default {
        props: {
            files: Array,
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

                if('email' in this.fields)
                    fields.push('email');

                if('birth_date' in this.fields)
                    fields.push('birth_date');

                return fields;
            }
        }
    }
</script>
<style scoped>
    .file-list-item {
        @apply tw-border-t;
    }

    .file-list-item:first-child {
        @apply tw-border-none;
        border-top-right-radius: .5em;
        border-top-left-radius: .5em
    }

    .file-list-item:last-child {
        border-bottom-right-radius: .5em;
        border-bottom-left-radius: .5em
    }
</style>
