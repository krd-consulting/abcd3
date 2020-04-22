<template>
    <span>{{ data }}</span>
</template>
<script>
    export default {
        props: {
            record: Object,
            fields: Object | Array
        },

        computed: {
            data() {
                return this.group(this.parsedFields);
            },

            parsedFields() {
                let fields = [];

                if(this.fields == null) {
                    return fields;
                }

                if('first_name' in this.fields)
                    fields.push('first_name');

                if('last_name' in this.fields)
                    fields.push('last_name');

                if('business_name' in this.fields)
                    fields.push('business_name');

                return fields;
            },
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
