<template>
    <span>
        <base-icon class="tw-text-xs tw-align-middle">{{ icon }}</base-icon>
        <slot>{{ name }}</slot>
    </span>
</template>
<script>
    export default {
        props: {
            scope: Number
        },

        computed: {
            name() {
                switch(this.scope) {
                    case 1:
                        return 'universal';

                    case 2:
                        return 'team';

                    case 3:
                        return 'program';

                    case 4:
                        return 'case load';

                    case 5:
                        return 'self';
                }
            },

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
                }
            }
        }
    }
</script>
