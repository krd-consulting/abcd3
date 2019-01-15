<template>
    <span v-if="field == 'birth_date'" class="tw-bg-orange-lightest tw-text-orange tw-rounded tw-p-1 tw-mr-2">
        <base-icon class="tw-text-xs">calendar_today</base-icon>
        <slot>{{ record[field] }}</slot>
    </span>
    <span v-else-if="field == 'contact_number'" class="tw-bg-red-lightest tw-text-red tw-rounded tw-p-1 tw-mr-2">
        <base-icon class="tw-text-xs">phone</base-icon>
        <slot>{{ record[field] }}</slot>
    </span>
    <span v-else-if="field == 'email_address'" class="tw-bg-purple-lightest tw-text-purple tw-rounded tw-p-1 tw-mr-2">
        <base-icon class="tw-text-xs">email</base-icon>
        <slot>{{ record[field] }}</slot>
    </span>
</template>
<script>
    export default {
        props: {
            record: Object,
            fields: Object|Array
        },

        computed: {
            field() {
                let fields = [];

                if('contact_number' in this.fields)
                    return 'contact_number';

                if('email_address' in this.fields)
                    return 'email_address';

                if('birth_date' in this.fields)
                    return 'birth_date';
            }
        }
    }
</script>
