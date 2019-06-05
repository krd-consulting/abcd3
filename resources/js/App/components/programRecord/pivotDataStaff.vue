<template>
	<div class="tw-flex tw-flex-grow">
	    <div class="tw-flex-1">
	        <div class="tw-uppercase tw-text-sm tw-font-semibold tw-text-green-500">
	            <span># of Cases</span>
	        </div>
	        <div>
	            <base-button
	                class="tw-py-2 tw-px-0 hover:tw-bg-transparent hover:tw-text-blue-500 tw-text-gray-500 tw-border-none"
	                @click="">
	                <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
	                <span class="tw-text-xs tw-align-middle">Manage Cases</span>
	            </base-button>
	        </div>
	    </div>
	    <div class="tw-flex-1">
	        <div class="tw-uppercase tw-text-sm tw-font-semibold tw-text-green-500">
	            <span># of Groups</span>
	        </div>
	        <div>
	            <base-button
	                class="tw-py-2 tw-px-0 hover:tw-bg-transparent hover:tw-text-blue-500 tw-text-gray-500 tw-border-none"
	                @click="">
	                <base-icon class="tw-text-sm tw-align-middle tw-mr-1">add</base-icon>
	                <span class="tw-text-xs tw-align-middle">Manage Groups</span>
	            </base-button>
	        </div>
	    </div>
	    <div class="tw-flex-1">
	        <span>{{ record.enrolled_at }}</span>
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