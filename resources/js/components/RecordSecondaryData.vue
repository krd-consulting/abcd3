<template>
    <div class="tw-flex">
        <div v-for="(field, index) in fields">
            <span v-if="index == 'birth_date'" class="tw-text-orange tw-rounded tw-p-1 tw-mr-2">
                <base-icon class="tw-text-xs">calendar_today</base-icon>
                <slot>{{ record[index] }}</slot>
            </span>
            <span v-else-if="index == 'contact_number'" class="tw-text-red tw-rounded tw-p-1 tw-mr-2">
                <base-icon class="tw-text-xs">phone</base-icon>
                <slot>{{ record[index] }}</slot>
            </span>
            <span v-else-if="index == 'email_address'" class="tw-text-purple tw-rounded tw-p-1 tw-mr-2">
                <base-icon class="tw-text-xs">email</base-icon>
                <slot>{{ record[index] }}</slot>
            </span>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            record: Object,
            fields: Object|Array
        }
    }
</script>
