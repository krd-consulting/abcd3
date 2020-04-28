<template>
    <div class="tw-grid tw-grid-cols-3 tw-p-4 even:tw-bg-gray-100">
        <dd class="tw-text-gray-600">{{ field.title }}</dd>
        <div>
            <dt v-for="(file, index) in files" :index="index">
                <a :href="'/downloads/attachments/' + file.id">{{ file.name }}</a>
            </dt>
        </div>
    </div>

</template>
<script>
    import Request from '@/api/AttachmentRequest';

    export default {

        props: {
            field: {
                type: Array | Object,
                default: {}
            },
            value: '',
        },

        data() {
            return {
                loading: false,
                request: new Request({}),
                files: []
            }
        },

        methods: {
            retrieve() {
                this.value.forEach((file, index) => {
                    this.request.show(file).then((response) => {
                        this.files.push(response.data);
                    })
                });
            },
        },

        created() {
            this.retrieve();
        }
    }
</script>
