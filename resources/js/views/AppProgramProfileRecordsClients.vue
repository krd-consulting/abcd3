<template>
    <div>
        <div v-if="records.length > 0"
            class="tw-pt-6 tw-pb-2 tw-pl-4 tw-text-xs tw-text-grey tw-uppercase tw-font-semibold">
            <div class="tw-flex tw-w-4/5">
                <div class="tw-w-1/4 tw-m-0">
                    <span class="tw-tracking-wide">Record</span>
                </div>
                <div class="tw-w-1/4 tw-m-0">
                    <span class="tw-tracking-wide">Status</span>
                </div>
                <div class="tw-w-1/4 tw-m-0">
                    <span class="tw-tracking-wide">Enrollment Date</span>
                </div>
                <div class="tw-w-1/4 tw-m-0">
                    <span class="tw-tracking-wide">Notes</span>
                </div>
            </div>
        </div>
        <list-item
            v-if="records.length > 0"
            :to="`/records/${record.type_slug}/${record.id}`"
            :key="record.id"
            :item="record"
            v-for="record in records"
            class="group tw-pl-4 tw-py-4">
            <template v-slot:primary-data="slotProps">
                <primary-data :record="slotProps.item" :fields="slotProps.item.fields"/>
            </template>
            <template v-slot:secondary-data="slotProps">
                <secondary-data class="tw-text-xs" :record="slotProps.item" :fields="slotProps.item.fields"/>
            </template>
            <template v-slot:tertiary-data="slotProps">
                <div class="tw-flex tw-w-3/5 tw-items-center">
                    <div class="tw-w-1/3">
                        <div class="tw-uppercase tw-text-sm tw-font-semibold tw-text-green">
                            <span>{{ slotProps.item.program_status.status.name }}</span>
                        </div>
                        <div class="tw-text-sm tw-text-grey">
                            <span>{{ slotProps.item.program_status.created_at }}</span>
                        </div>
                    </div>
                    <div class="tw-w-1/3">
                        <span>{{ slotProps.item.enrolled_at }}</span>
                    </div>
                    <div class="tw-w-1/3">
                        <p v-if="slotProps.item.program_status">{{ slotProps.item.program_status.notes }}</p>
                        <base-button v-else class="tw-py-2 tw-px-0 tw-text-grey tw-font-semibold tw-border-none hover:tw-bg-transparent hover:tw-text-blue">
                            <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
                            <span class="tw-text-xs tw-align-middle">Add Note</span>
                        </base-button>
                    </div>
                </div>
            </template>
            <template v-slot:options-container>
                <div class="tw-w-1/5 tw-text-right">
                    <div class="tw-px-4">
                        <base-button class="tw-py-2 tw-px-2 tw-text-grey hover:tw-bg-transparent hover:tw-text-grey-darkest tw-border-none">
                            <base-icon class="tw-text-xs tw-mr-1 tw-align-middle">edit</base-icon>
                            <span class="tw-text-xs tw-align-middle">Edit</span>
                        </base-button>
                        <base-button
                            class="tw-py-2 tw-px-2 tw-text-grey hover:tw-bg-transparent hover:tw-text-red tw-border-none"
                            @click="$emit('remove', record.id)">
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
