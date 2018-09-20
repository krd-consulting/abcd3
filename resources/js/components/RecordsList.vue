<template>
    <section>
        <h1 class="tw-text-base tw-py-2 tw-pl-8 tw-pr-4">Records</h1>
        <ul class="tw-list-reset">
            <records-list-item
                v-for="(record, index) in records"
                :key="record.id"
                :active="record.active"
                :title="record.title"
                :options="record.options"
            ></records-list-item>
        </ul>
    </section>
</template>
<script>
    export default {
        data() {
            return {
                records: [
                    { id: 1, title: 'Record 1', active: true},
                    { id: 2, title: 'Record 2', options: true },
                    { id: 3, title: 'Record 3' },
                    { id: 4, title: 'Record 4', options: true },
                    { id: 5, title: 'Record 5' }
                ]
            }
        }
    }
</script>
