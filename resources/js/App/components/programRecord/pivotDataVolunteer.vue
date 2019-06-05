<template>
	<div class="tw-flex tw-flex-grow">
        <div class="tw-flex-1">
            <div class="tw-uppercase tw-text-sm tw-font-semibold tw-text-green">
                <span># of Hours</span>
            </div>
            <div class="tw-text-sm tw-text-gray">
                <span>HRS</span>
            </div>
        </div>
        <div class="tw-flex-1">
            <div class="tw-uppercase tw-text-sm tw-font-semibold tw-text-green">
                <span># of Hours</span>
            </div>
            <div class="tw-text-sm tw-text-gray">
                <span>HRS</span>
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