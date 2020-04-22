<template>
    <div>

    </div>
</template>
<script>

    export default {
        props: {
            entries: {
                type: Array,
                default: [
                    {
                        target: {
                            fields: {},
                            path: ''
                        }
                    }
                ]
            }
        },

        components: {
            ListItem,
            ProfilePicture,
            PrimaryData,
            SecondaryData,
        },
    }
</script>
