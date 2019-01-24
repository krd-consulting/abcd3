<template>
    <profile-picture :username="username" :class="classes"/>
</template>
<script>
    import ProfilePicture from './ProfilePicture';

    export default {
        props: {
            record: Object,
            fields: Object|Array
        },

        components: {
            ProfilePicture
        },

        computed: {
            username() {
                return this.group(this.parsedFields);
            },

            parsedFields() {
                let fields = [];

                if('first_name' in this.fields)
                    fields.push('first_name');

                if('last_name' in this.fields)
                    fields.push('last_name');

                if('business_name' in this.fields)
                    fields.push('business_name');

                return fields;
            },

            classes() {
                let fields = [];

                if('email_address' in this.fields)
                    return 'tw-bg-purple tw-text-white';

                if('contact_number' in this.fields)
                    return 'tw-bg-red tw-text-white';

                if('birth_date' in this.fields)
                    return 'tw-bg-orange tw-text-white';
            }
        },

        methods: {
            group(fields) {
                let data = '';

                fields.forEach(field => {
                    data += this.record[field] + ' ';
                });

                return data.trim();
            }
        }
    }
</script>
