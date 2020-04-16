<template>
    <span>
        <base-icon class="tw-text-xs tw-align-middle">{{ icon }}</base-icon>
        <slot></slot>
    </span>
</template>
<script>
    export default {
        props: {
            scope: Number
        },

        computed: {
            icon() {

                switch(this.scope) {
                    case 1:
                        return 'star';

                    case 2:
                        return 'people';

                    case 3:
                        return 'assignment';

                    case 4:
                        return 'assignment_ind';

                    case 5:
                        return 'person';
                    
                    case 6:
                        return 'star';
                }
            }
        }
    }
</script>
