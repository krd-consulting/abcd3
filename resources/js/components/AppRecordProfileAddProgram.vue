<template>
    <base-dialog title="Add Program" :visible="active" @close="close" @open="open">
    </base-dialog>
</template>
<script>
    import ProgramRequest from '../api/ProgramRequest';

    export default {
        props: {
            active: Boolean,
        },

        data() {
            return {
                programs: [],
                request: new ProgramRequest({})
            }
        },

        methods: {
            close() {
                this.$emit('update:active', false);
            },

            open() {
                this.request.retrieve().then(response => {
                    this.programs = response;
                });
            }
        }
    }
</script>
