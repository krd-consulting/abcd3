<template>
    <div class="tw-flex tw-items-center tw-rounded-full tw-align-middle tw-text-sm">
        <div class="tw-text-center tw-w-full">{{ initials }}</div>
    </div>
</template>
<script>
    export default {
        props: {
            username: String
        },

        computed: {
            initials() {
                return this.username.split(" ").map((n,i,a)=> i === 0 || i+1 === a.length ? n[0] : null).join("");
            }
        }
    }
</script>
