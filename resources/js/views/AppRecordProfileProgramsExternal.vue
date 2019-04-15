<template>
    <div>
        <div v-if="programs.length > 0"
            class="tw-pt-6 tw-pb-2 tw-pl-4 tw-text-xs tw-text-grey tw-uppercase tw-font-semibold">
            <div class="tw-flex tw-w-4/5">
                <div class="tw-w-2/5 tw-m-0">
                    <span class="tw-tracking-wide">Progrram</span>
                </div>
            </div>
        </div>
        <list-item
            v-if="programs.length > 0"
            :to="`/programs/${program.id}`"
            :key="program.id"
            :item="program"
            v-for="program in programs"
            class="group tw-pl-4 tw-py-4">
            <template v-slot:primary-data="slotProps">
                <div>
                    <span class="hover:tw-text-blue">{{ slotProps.item.name }}</span>
                </div>
            </template>
            <template v-slot:secondary-data="slotProps">
                <base-icon class="tw-text-grey tw-text-xs tw-text-align-middle">people</base-icon>
                <span class="tw-text-grey tw-text-sm tw-text-align-middle">{{ slotProps.item.team.name }}</span>
            </template>
            <template v-slot:options-container="slotProps">
                <div class="tw-w-1/5 tw-text-right">
                    <div class="tw-px-4">
                        <base-button
                            class="tw-py-2 tw-px-2 tw-text-grey hover:tw-bg-transparent hover:tw-text-red tw-border-none"
                            @click="$emit('remove', slotProps.item.id)">
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

    export default {
        components: {
            ListItem,
        },

        props: {
            programs: Array
        }
    }
</script>
