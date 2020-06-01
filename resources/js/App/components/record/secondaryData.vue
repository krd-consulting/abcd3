<template>
    <div>
        {{ data }}
    </div>
</template>
<script>
    export default {
        props: {
            record: Object
        },

        computed: {
            data() {
                if(this.record.field_values == null) {
                    return;
                }

                if('birth_date' in this.record.field_values) {
                    return this.record.field_values['birth_date'];
                }

                if('contact_number' in this.record.field_values) {
                    return this.record.field_values['contact_number'];
                }

                if('email_address' in this.record.field_values) {
                    return this.record.field_values['email_address'];
                }
            },
        },
    }
</script>
