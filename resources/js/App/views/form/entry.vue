<template>
    <div>
        {{ form }}
    </div>
</template>
<script>
    import Request from '@/api/FormRequest';

    export default {
        data() {
            return {
                request: new Request({}),
                form: {}
            }
        },

        methods: {
            retrieve(form = this.$route.params.form) {
                this.request.show(form).then((response) => {
                    this.form = response.data;
                });
            },
        },

        created() {
            this.retrieve();
        }
    }
</script>
