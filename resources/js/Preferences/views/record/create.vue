<template>
    <base-dialog :visible="true" @close="close" @open="retrieve">
        <div slot="title">
            Create Record Type
        </div>
    </base-dialog>
</template>
<script>
    export default {
        methods: {
            close() {
                this.$router.push({ path: './' })
            }
        }
    }
</script>
