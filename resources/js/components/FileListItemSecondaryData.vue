<template>
    <span v-if="data == 'birth_date'" class="tw-bg-orange-lightest tw-text-orange tw-rounded tw-p-1 tw-mr-2">
        <base-icon class="tw-text-xs">calendar_today</base-icon>
        <slot></slot>
    </span>
    <span v-else-if="data == 'contact_number'" class="tw-bg-red-lightest tw-text-red tw-rounded tw-p-1 tw-mr-2">
        <base-icon class="tw-text-xs">phone</base-icon>
        <slot></slot>
    </span>
    <span v-else-if="data == 'email_address'" class="tw-bg-purple-lightest tw-text-purple tw-rounded tw-p-1 tw-mr-2">
        <base-icon class="tw-text-xs">email</base-icon>
        <slot></slot>
    </span>
</template>
<script>
    export default {
        props: {
            data: String
        }
    }
</script>
