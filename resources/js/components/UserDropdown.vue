<script>
    export default {
        data(){
            return {
                active: true
            }
        },
        computed: {
            icon() {
                if(this.active == true)
                    return 'arrow_drop_up';

                return 'arrow_drop_down';
            }
        }
    }
</script>
