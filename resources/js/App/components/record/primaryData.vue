<template>
    <span>{{ data }}</span>
</template>
<script>
    export default {
        props: {
            record: Object,
        },

        computed: {
            data() {
                if(this.record.field_values == null) {
                    return;
                }

                if('first_name' in this.record.field_values && 'last_name' in this.record.field_values) {
                    return `${this.record.field_values['first_name']} ${this.record.field_values['last_name']}`;
                } else {
                    return `${this.record.field_values['name']}`;
                }
            },
        },
    }
</script>
