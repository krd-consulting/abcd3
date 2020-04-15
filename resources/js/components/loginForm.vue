<script>
    export default {
        props: {
            oldEmail: {
                type: String,
                default: ''
            },
        },

        data() {
            return {
                forgotPasswordActive: false,
                email: '',
                password: ''
            }
        },

        created() {
            this.email = this.oldEmail;
        }
    }
</script>
