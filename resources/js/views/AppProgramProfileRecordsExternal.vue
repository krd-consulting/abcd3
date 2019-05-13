<template>
    <div>
        <div v-if="records.length > 0"
            class="tw-pt-6 tw-pb-2 tw-pl-4 tw-text-xs tw-text-grey tw-uppercase tw-font-semibold">
            <div class="tw-flex tw-w-4/5">
                <div class="tw-w-2/5 tw-m-0">
                    <span class="tw-tracking-wide">Record</span>
                </div>
            </div>
        </div>
        <list-item
            v-if="records.length > 0"
            :to="`/records/${record.type_slug}/${record.id}`"
            :key="record.id"
            v-for="record in records"
            class="group tw-pl-4 tw-py-4">
            <primary-data :record="record" :fields="record.fields"/>
            <template v-slot:secondary-data>
                <secondary-data class="tw-text-xs" :record="record" :fields="record.fields"/>
            </template>
            <template v-slot:options-container="slotProps">
                <div class="tw-w-1/5 tw-text-right">
                    <div class="tw-px-4">
                        <base-button class="tw-py-2 tw-px-2 tw-text-grey hover:tw-bg-transparent hover:tw-text-red tw-border-none" @click="$emit('remove', slotProps.item.id)">
                            <base-icon class="tw-text-xs tw-mr-1 tw-align-middle">close</base-icon>
                            <span class="tw-text-xs tw-align-middle">Remove</span>
                        </base-button>
                    </div>
                </div>
            </template>
        </list-item>
    </div>
</template>
<script>
    import ListItem from '../components/AppListItem';
    import ProfilePicture from '../components/RecordProfilePicture';
    import PrimaryData from '../components/RecordPrimaryData';
    import SecondaryData from '../components/RecordSecondaryData';

    export default {
        components: {
            ListItem,
            ProfilePicture,
            PrimaryData,
            SecondaryData,
        },

        props: {
            records: Array
        }
    }
</script>
