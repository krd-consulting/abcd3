<script>
    export default {
        data(){
            return {
                active: false
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
