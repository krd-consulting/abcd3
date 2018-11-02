<template>
    <div class="file-list-item-secondary-data">
        <span v-if="data == 'email_address'" class="tw-bg-blue-lightest tw-text-blue tw-rounded tw-p-1">
            <base-icon class="tw-text-xs">email</base-icon>
            <slot></slot>
        </span>
        <span v-else-if="data == 'birth_date'" class="tw-bg-blue-lightest tw-text-blue tw-rounded tw-p-1 tw-mr-2">
            <base-icon class="tw-text-xs">calendar_today</base-icon>
            <slot></slot>
        </span>
    </div>
</template>
<script>
    export default {
        props: {
            data: String
        },

        created() {
            console.log(this.data);
        }
    }
</script>
