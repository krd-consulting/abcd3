<template>
	<div class="tw-flex tw-flex-grow">
	    <div class="tw-flex-1">
	        <div class="tw-uppercase tw-text-sm tw-font-semibold tw-text-green">
	            <span>{{ record.program_status.status.name }}</span>
	        </div>
	        <div class="tw-text-sm tw-text-gray">
	            <span>Since {{ record.program_status.created_at }}</span>
	        </div>
	    </div>
	    <div class="tw-flex-1">
	        <span>{{ record.enrolled_at }}</span>
	    </div>
	    <div class="tw-flex-1">
	        <base-button v-if="record.program_status.notes == '' || record.program_status.notes == null" class="tw-py-2 tw-px-0 tw-text-gray-500 tw-font-semibold tw-border-none hover:tw-bg-transparent hover:tw-text-blue">
	            <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
	            <span class="tw-text-xs tw-align-middle">Add Note</span>
	        </base-button>
	        <p v-else>{{ record.program_status.notes }}</p>
	    </div>
	</div>
</template>
<script>
	export default {
		props: {
			record: Array | Object
		}
	}
</script>