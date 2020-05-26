<template>
    <div>
        <div class="tw-grid tw-grid-cols-2 tw-border">
            <div>
                <span class="tw-border">Showing {{ meta.total }} record types</span>
            </div>
            <div>
                <router-link :to="{ path: './create' }">Create New Record Type</router-link>
            </div>
        </div>
        <div>
            <div class="tw-grid tw-grid-cols-4 tw-border">
                <span>Record Type</span>
                <span>Status</span>
                <span>Type</span>
                <span>&nbsp;</span>
            </div>
            <div v-for="item in recordTypes" class="tw-grid tw-grid-cols-4 tw-border">
                <div>{{ item.name }}</div>
                <div>
                    <base-switch v-model="item.active"></base-switch>
                    Enabled
                </div>
                <div>{{ item.identity }}</div>
            </div>
        </div>
        <router-view></router-view>
    </div>
</template>
<script>
    import RecordTypeRequest from '@/api/RecordTypeRequest';

    export default {

        data() {
            return {
                recordTypes: [],
                meta: {
                    total: 0
                },
                links: {}
            }
        },

        methods: {
            retrieve() {
                let request = new RecordTypeRequest({});

                request.retrieve().then((response) => {
                    this.recordTypes = response.data;
                    this.meta = response.meta;
                    this.links = response.links;
                });
            }
        },

        created() {
            this.retrieve();
        }

    }
</script>
